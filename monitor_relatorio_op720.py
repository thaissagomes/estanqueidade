"""
monitor_relatorio_op720.py

O que faz:
- Abre a página http://10.251.78.60:3000 em modo headless
- Seleciona OP720 no dropdown (tenta selecionar por texto)
- Clica em "Atualizar" e depois em "Download"
- Aguarda o arquivo rel02_YYYYMMDD_HHMM.(csv|xlsx) aparecer na pasta de downloads configurada
- Processa o arquivo com pandas, filtra apenas linhas relacionadas à OP720
- Insere no MySQL evitando duplicatas
- Pode ser agendado (cron / task scheduler)
"""

import os
import time
import glob
import shutil
from datetime import datetime, timedelta
from dateutil import parser

import pandas as pd
import mysql.connector

from selenium.webdriver import Chrome
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC

from webdriver_manager.chrome import ChromeDriverManager

# ====== CONFIG ======
BASE_URL = "http://10.251.78.60:3000/relatorioRastreio2"
DOWNLOAD_DIR = os.path.abspath("./downloads_relatorio")  # pasta onde Chrome salvará o CSV
PROCESSED_DIR = os.path.join(DOWNLOAD_DIR, "processed")
POLL_INTERVAL_SECONDS = 300   # tempo entre execuções completas (5 min) -> ajustar conforme necessário
DOWNLOAD_WAIT_SECONDS = 90    # tempo máximo pra esperar o download finalizar

DB_CONFIG = {
    "host": "localhost",
    "user": "seu_usuario",
    "password": "sua_senha",
    "database": "estanqueidade"
}
OP_TARGET = "OP720"
# ====================

os.makedirs(DOWNLOAD_DIR, exist_ok=True)
os.makedirs(PROCESSED_DIR, exist_ok=True)

def criar_driver(download_dir):
    chrome_options = Options()
    chrome_options.add_argument("--headless=new")
    chrome_options.add_argument("--no-sandbox")
    chrome_options.add_argument("--disable-gpu")
    chrome_options.add_argument("--disable-dev-shm-usage")
    # pref de download
    prefs = {
        "download.default_directory": download_dir,
        "download.prompt_for_download": False,
        "profile.default_content_settings.popups": 0,
        "safebrowsing.enabled": True
    }
    chrome_options.add_experimental_option("prefs", prefs)
    driver = Chrome(ChromeDriverManager().install(), options=chrome_options)
    return driver

def clicar_atualizar_e_download(driver, wait_seconds=10):
    driver.get(BASE_URL)
    wait = WebDriverWait(driver, 15)

    # 1) Tentar selecionar OP720 no dropdown. Usamos vários métodos tolerantes.
    try:
        # tenta encontrar <select> e escolher pelo texto
        select = wait.until(EC.presence_of_element_located((By.TAG_NAME, "select")))
        # abrir opções e escolher via JS (caso select custom)
        driver.execute_script("""
        for (const s of document.querySelectorAll('select')) {
            for (const o of s.options) {
                if (o.text.trim().includes(arguments[0])) { o.selected = true; s.dispatchEvent(new Event('change')); return; }
            }
        }
        """, OP_TARGET)
    except Exception:
        # se falhar, apenas continua (talvez o OP já esteja selecionado)
        pass

    time.sleep(1)

    # 2) Tenta clicar no botão "Atualizar" — procuramos por botão com texto 'Atualizar'
    try:
        btn_atualizar = None
        # procura por botões que contenham o texto "Atualizar"
        buttons = driver.find_elements(By.XPATH, "//button[contains(translate(normalize-space(.), 'ABCDEFGHIJKLMNOPQRSTUVWXYZ','abcdefghijklmnopqrstuvwxyz'), 'atualizar') or contains(., 'Atualizar')]")
        if buttons:
            btn_atualizar = buttons[0]
        else:
            # outra tentativa: botões com class 'atualizar' ou input[type=button] com value
            candidates = driver.find_elements(By.CSS_SELECTOR, "button, input[type='button'], input[type='submit']")
            for c in candidates:
                text = (c.text or c.get_attribute('value') or "").strip().lower()
                if "atualizar" in text:
                    btn_atualizar = c
                    break
        if btn_atualizar:
            btn_atualizar.click()
        else:
            print("[WARN] Botão 'Atualizar' não encontrado automaticamente. Continuando...")
    except Exception as e:
        print("[ERRO] ao clicar atualizar:", e)

    # 3) aguardar que a tabela seja carregada (espera por elemento de tabela)
    try:
        wait.until(EC.presence_of_element_located((By.CSS_SELECTOR, "table")) )
    except Exception:
        # pode ser que a tabela use divs — damos um pequeno delay extra
        time.sleep(3)

    time.sleep(1)

    # 4) Clicar no botão Download (procura por texto 'Download' ou 'Baixar')
    try:
        btn_download = None
        buttons = driver.find_elements(By.XPATH, "//button[contains(translate(normalize-space(.), 'ABCDEFGHIJKLMNOPQRSTUVWXYZ','abcdefghijklmnopqrstuvwxyz'), 'download') or contains(translate(normalize-space(.), 'ABCDEFGHIJKLMNOPQRSTUVWXYZ','abcdefghijklmnopqrstuvwxyz'), 'baixar')]")
        if buttons:
            btn_download = buttons[0]
        else:
            # procurar por links que façam download
            links = driver.find_elements(By.TAG_NAME, "a")
            for a in links:
                txt = (a.text or "").strip().lower()
                href = a.get_attribute("href") or ""
                if "download" in txt or "rel02_" in href:
                    btn_download = a
                    break
        if btn_download:
            # clique que normalmente inicia o download
            btn_download.click()
            print("[INFO] Clique em Download enviado.")
        else:
            print("[WARN] Botão/Link de Download não encontrado automaticamente.")
            return False
    except Exception as e:
        print("[ERRO] ao clicar download:", e)
        return False

    return True

def esperar_por_arquivo(download_dir, timeout=DOWNLOAD_WAIT_SECONDS):
    """
    Observa a pasta download_dir por um novo arquivo rel02_*.csv ou .xlsx
    Retorna o caminho completo do arquivo assim que existir e finalizado (não estar em .crdownload)
    """
    deadline = time.time() + timeout
    pattern = os.path.join(download_dir, "rel02_*")
    initial = set(glob.glob(pattern))
    # aguarda novo arquivo aparecer
    while time.time() < deadline:
        found = set(glob.glob(pattern))
        new = found - initial
        if new:
            # pegar o arquivo mais novo
            candidate = sorted(list(new), key=os.path.getmtime)[-1]
            # aguardar finalização (não ter extensão temporária)
            waited = 0
            while waited < timeout:
                if not any(candidate.endswith(ext) for ext in [".crdownload", ".part"]):
                    # checar tamanho estável por 2s
                    size1 = os.path.getsize(candidate)
                    time.sleep(1)
                    size2 = os.path.getsize(candidate)
                    if size1 == size2:
                        return candidate
                time.sleep(1)
                waited += 1
            return candidate
        time.sleep(1)
    return None

def processar_e_inserir(caminho_arquivo):
    # Lê o arquivo (CSV ou XLSX)
    print(f"[INFO] Processando arquivo: {caminho_arquivo}")
    try:
        if caminho_arquivo.lower().endswith(".csv"):
            # tenta detect delimiter ';' ou ','
            df = pd.read_csv(caminho_arquivo, sep=None, engine="python", encoding="latin1")
        else:
            df = pd.read_excel(caminho_arquivo)
    except Exception as e:
        print("[ERRO] ao ler arquivo com pandas:", e)
        return

    # normaliza nomes de colunas
    df.columns = [str(c).strip().lower().replace(" ", "_") for c in df.columns]
    print("[INFO] Colunas detectadas:", df.columns.tolist())

    # tentar filtrar linhas referentes à OP720:
    # tentamos buscar por coluna com 'op720' no nome, ou por coluna sequencial_op720, ou ainda procurar 'op720' em qualquer célula
    df_filtrado = pd.DataFrame()
    # 1) coluna explícita 'sequencial_op720'
    if 'sequencial_op720' in df.columns:
        df_filtrado = df[df['sequencial_op720'].notna()]
    else:
        # 2) procura em todas as colunas por valor que contenha OP720 (case-insensitive)
        mask = df.apply(lambda row: row.astype(str).str.contains(OP_TARGET, case=False, na=False).any(), axis=1)
        df_filtrado = df[mask]

    print(f"[INFO] Linhas totais: {len(df)}, após filtro OP720: {len(df_filtrado)}")
    if len(df_filtrado) == 0:
        print("[WARN] Nenhuma linha encontrada para OP720 neste arquivo.")
        return

    # cria tabela simples (adapte colunas conforme necessidade)
    conn = mysql.connector.connect(**DB_CONFIG)
    cur = conn.cursor()
    cur.execute("""
    CREATE TABLE IF NOT EXISTS pressao_op720 (
        id BIGINT AUTO_INCREMENT PRIMARY KEY,
        codigo_2d VARCHAR(80),
        tipo_cabecote VARCHAR(80),
        codigo_bruto VARCHAR(80),
        codigo_finalizado VARCHAR(80),
        sequencial_op720 VARCHAR(80),
        ultimo_posto_sem_pronto VARCHAR(80),
        ultimo_posto_com_pronto VARCHAR(80),
        qualidade_peca VARCHAR(40),
        numero_pallet VARCHAR(40),
        fonte_arquivo VARCHAR(255),
        criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        UNIQUE KEY ux_codigo_seq (codigo_2d, sequencial_op720)
    ) ENGINE=InnoDB;
    """)
    insert_sql = """
    INSERT IGNORE INTO pressao_op720
    (codigo_2d, tipo_cabecote, codigo_bruto, codigo_finalizado, sequencial_op720,
     ultimo_posto_sem_pronto, ultimo_posto_com_pronto, qualidade_peca, numero_pallet, fonte_arquivo)
    VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)
    """
    for _, row in df_filtrado.iterrows():
        vals = (
            row.get('codigo_2d'),
            row.get('tipo_cabecote'),
            row.get('codigo_bruto'),
            row.get('codigo_finalizado'),
            row.get('sequencial_op720') or row.get('sequencial') or None,
            row.get('ultimo_posto_sem_pronto'),
            row.get('ultimo_posto_com_pronto'),
            row.get('qualidade_da_peca') or row.get('qualidade_peca'),
            row.get('número_pallet') or row.get('numero_pallet') or row.get('numero_pallet'),
            os.path.basename(caminho_arquivo)
        )
        try:
            cur.execute(insert_sql, vals)
        except Exception as e:
            print("[ERRO] Inserindo linha:", e)
    conn.commit()
    cur.close()
    conn.close()
    print("[INFO] Inserção finalizada.")

def mover_para_processed(caminho):
    destino = os.path.join(PROCESSED_DIR, os.path.basename(caminho))
    shutil.move(caminho, destino)
    print(f"[INFO] Arquivo movido para processed: {destino}")

def job_once():
    driver = criar_driver(DOWNLOAD_DIR)
    try:
        ok = clicar_atualizar_e_download(driver)
        if not ok:
            print("[WARN] Não foi possível iniciar download automaticamente.")
            driver.quit()
            return
        arquivo = esperar_por_arquivo(DOWNLOAD_DIR, timeout=DOWNLOAD_WAIT_SECONDS)
        if arquivo:
            processar_e_inserir(arquivo)
            mover_para_processed(arquivo)
        else:
            print("[WARN] Nenhum novo arquivo detectado dentro do timeout.")
    finally:
        driver.quit()

if __name__ == "__main__":
    # loop contínuo simples: roda job_once() a cada POLL_INTERVAL_SECONDS
    print("[START] Monitor OP720 iniciado.")
    while True:
        try:
            job_once()
        except Exception as e:
            print("[ERRO geral no job]:", e)
        print(f"[SLEEP] Aguardando {POLL_INTERVAL_SECONDS} segundos...")
        time.sleep(POLL_INTERVAL_SECONDS)
