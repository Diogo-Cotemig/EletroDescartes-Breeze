const express = require('express');
const bodyParser = require('body-parser');
const sqlite3 = require('sqlite3').verbose();

const app = express();
app.use(bodyParser.json());

const db = new sqlite3.Database('cadastros.db');

db.run(`CREATE TABLE IF NOT EXISTS usuarios (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  nome TEXT,
  email TEXT,
  senha TEXT
)`);

app.post('/cadastro', (req, res) => {
  const { nome, email, senha } = req.body;
  db.run('INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)', [nome, email, senha], function(err) {
    if (err) return res.status(500).send('Erro ao cadastrar');
    res.send('Cadastro realizado com sucesso!');
  });
});

app.listen(3000, () => console.log('Servidor rodando na porta 3000'));