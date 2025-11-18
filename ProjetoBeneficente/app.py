from flask import Flask, render_template, request, redirect, url_for, session, flash
import mysql.connector

app = Flask(__name__)
app.secret_key = 'chave_secreta_do_sos_sul'

# --- 1. CONEXÃO COM O BANCO DE DADOS ---
def conectar():
    return mysql.connector.connect(
        host="localhost",
        user="root",
        password="",    # Senha vazia do XAMPP
        database="sos"  # Nome do banco
    )

# --- 2. ROTAS DO SISTEMA ---

# Rota Inicial (Login)
@app.route('/')
def index():
    if 'nome' in session:
        return redirect(url_for('menu'))
    return render_template('login.html')

# Rota para ir ao Cadastro
@app.route('/cadastro')
def cadastro():
    return render_template('cadastro.html')

# Rota que Salva o Novo Usuário no Banco
@app.route('/salvar', methods=['POST'])
def salvar():
    nome = request.form['nome']
    email = request.form['email']
    senha = request.form['senha']

    conn = conectar()
    cursor = conn.cursor()

    try:
        # Verifica se o e-mail já existe
        cursor.execute("SELECT id FROM usuarios WHERE email = %s", (email,))
        if cursor.fetchone():
            flash('Erro: Este e-mail já está cadastrado!')
            return redirect(url_for('cadastro'))

        # Insere o usuário
        sql = "INSERT INTO usuarios (nome, email, senha) VALUES (%s, %s, %s)"
        cursor.execute(sql, (nome, email, senha))
        conn.commit()
        
        flash('Conta criada! Faça login.')
        return redirect(url_for('index'))
        
    except Exception as e:
        flash(f"Erro no banco: {e}")
        return redirect(url_for('cadastro'))
    finally:
        conn.close()

# Rota que Valida o Login
@app.route('/login', methods=['POST'])
def login():
    email = request.form['email']
    senha = request.form['senha']

    conn = conectar()
    cursor = conn.cursor(dictionary=True)
    
    cursor.execute("SELECT * FROM usuarios WHERE email = %s AND senha = %s", (email, senha))
    usuario = cursor.fetchone()
    conn.close()

    if usuario:
        session['nome'] = usuario['nome']
        session['id'] = usuario['id'] # Guarda o ID para usar na doação
        return redirect(url_for('menu'))
    else:
        flash('E-mail ou senha incorretos!')
        return redirect(url_for('index'))

# --- PARTE NOVA: TELA DE DOAÇÃO ---
@app.route('/tela_doacao')
def tela_doacao():
    if 'nome' not in session:
        return redirect(url_for('index'))
    return render_template('doar.html')

# --- PARTE NOVA: PROCESSAR A DOAÇÃO ---
@app.route('/processar_doacao', methods=['POST'])
def processar_doacao():
    if 'nome' not in session:
        return redirect(url_for('index'))
    
    valor = request.form['valor']
    forma = request.form['forma']
    id_usuario = session['id']

    conn = conectar()
    cursor = conn.cursor()
    
    try:
        sql = "INSERT INTO doacoes (id_usuario, valor, forma_pagamento) VALUES (%s, %s, %s)"
        cursor.execute(sql, (id_usuario, valor, forma))
        conn.commit()
        flash('Doação realizada com sucesso!')
        return redirect(url_for('menu'))
    except Exception as e:
        flash(f"Erro ao doar: {e}")
        return redirect(url_for('tela_doacao'))
    finally:
        conn.close()

# --- MENU PRINCIPAL (ATUALIZADO) ---
@app.route('/menu')
def menu():
    if 'nome' not in session:
        return redirect(url_for('index'))
    
    conn = conectar()
    cursor = conn.cursor(dictionary=True)
    
    # Pega as doações do banco
    sql_doacoes = "SELECT *, DATE_FORMAT(data_doacao, '%d/%m/%Y') as data_formatada FROM doacoes WHERE id_usuario = %s"
    cursor.execute(sql_doacoes, (session['id'],))
    minhas_doacoes = cursor.fetchall()
    
    # Soma o total doado
    sql_total = "SELECT SUM(valor) as total FROM doacoes WHERE id_usuario = %s"
    cursor.execute(sql_total, (session['id'],))
    resultado = cursor.fetchone()
    total = resultado['total'] if resultado['total'] else 0
    
    conn.close()
    
    # Envia para o HTML (Atenção ao nome do arquivo menuUser.html)
    return render_template('menuUser.html', 
                           nome_usuario=session['nome'], 
                           lista_doacoes=minhas_doacoes,
                           total_doado=total)

# Rota de Sair
@app.route('/logout')
def logout():
    session.clear()
    return redirect(url_for('index'))

if __name__ == '__main__':
    app.run(debug=True)