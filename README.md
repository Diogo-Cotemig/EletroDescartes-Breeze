Eletro-Descarte
Realizado por :
Gabriel Henrique - 12302961
Pedro Henrique Moreira - 12303020
Marco Antônio - 12302260
Diogo Rodrigues - 12302678
Turma 3E1

Realizações:
- [x] Tela Inicial para usuarios não Cadastrados
- [x] Tela de Cadastro de usuários
- [x] Tela de Login
- [x] Tela de Esqueceu a senha
- [x] Aréa para Administradores
- [x] Aréa para Contato com a nossa empreso pelo Email
- [x] Tela de Histórico do usuário
- [x] Aréa para monitoramento de atividades do Site
- [x] Tela de pagamento
- [x] Aréa para resgate de pontos (serviços)
- [x] Aréa para criação de produtos (Em Admin)
- [x] Modelo de informação eficiente
- [x] Pontos de descarte em formato de maps
- [x] Sistema de maps
- [x] Aréa para o usuario editar informações
- [x] Aréa para o Administrador editar informações
- [x] Assistência tecnica
- [x] Aréa para o Administrador responder ao usuario sobre: Assistência tecnica
- [x] Acompanhamento do descarte com o carreteiro
- [x] Assistente Virtual
- [x] Descartes concluidos
- [x] Configuracao de Notificacoes
- [x] Redes sociais da Empresa

#Nome do Projeto
##Eletro-Descarte

## Descrição
<Eletro-Descarte é uma empresa com o intuito de combater a poluição da terra devido ao descarte indevido do Lixo eletrônico, nossa empresa acolhe, separa e entrega a matéria prima de volta á empresas que vão reutilizar-las, tudo isso afim de diminuir o consumo excessivo de matéria prima em mineradoras (Ferro, Litio, cobre, ouro) e incentivar ás pessoas a cuidar do futuro da geração, jogando o lixo no local correto>

## Integrantes

*Diogo Rodriguês* – Direção; Back-End e Front-End  
Matricula: 12302678  

*Marco Antônio Mendes* – Planejamento; Back-End e Planilhas  
Matricula: 12302260  

*Pedro Henrique Moreira* – Organização; Planilhas e Front-End  
Matricula: 12303020  

*Gabriel Henrique* – Controle de Qualidade; Back-End e Front-End  
Matricula: 12302961 

## Estrutura de Diretórios

<!--Fim da Controller do Cliente-->

EletroDescarte/
├── .vite/
├── app/
│   ├── Http/
│   ├── Models/
│   ├── Providers/
│   └── View/
├── bootstrap/
│   └── cache/
├── config/
│   ├── app.php
│   ├── auth.php
│   ├── cache.php
│   ├── database.php
│   ├── filesystems.php
│   ├── logging.php
│   ├── mail.php
│   ├── queue.php
│   ├── services.php
│   └── session.php
├── database/
│   ├── factories/
│   ├── migrations/
│   ├── seeders/
│   ├── database.sqlite
│   └── eletrodescartesbanco.sql
├── node_modules/
├── public/
│   ├── backend/
│   │   └── assets/
│   │       ├── css/
│   │       ├── fonts/
│   │       ├── img/
│   │       ├── js/
│   │       └── modules/
│   ├── build/
│   ├── img/
│   ├── .htaccess
│   ├── favicon.ico
│   ├── index.php
│   └── robots.txt
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
│       ├── admin/
│       ├── admin-template/
│       ├── auth/
│       ├── components/
│       ├── layouts/
│       ├── profile/
│       └── tasks/
├── routes/
│   ├── auth.php
│   ├── console.php
│   └── web.php
├── storage/
│   ├── app/
│   ├── framework/
│   └── logs/
└── README.md


## Como Executar o Projeto

### 1. Pré-requisitos
<!-- Liste os requisitos necessários, como linguagens, frameworks, bibliotecas, banco de dados, etc. -->
- XAMPP (ou Laragon/WAMP)
- PHP 8.1+ 
- Composer
- MySQL (ativo no XAMPP)

# Clone o repositório
git clone https://diogo-cotemig.github.io/EletroDescarte/

1. Acesse *http://localhost/phpmyadmin*
2. Clique em Novo
3. Crie um banco de dados com o nome: eletrodescartesbanco
4. Vá em *Importar*
5. Clique em *Escolher arquivo*
6. Selecione o arquivo que está dentro de EletroDescarte/Database (eletrodescartesbanco.sql)
7. Clique em *Executar*

# Acesse a pasta do projeto
cd Tasks/Index.Blaze.php


### 2. Instalação
# Instale as dependências
comando-de-instalação:
composer install
php artisan key:generate
npm install

### 3. Execução
<!-- Explique como rodar o projeto -->
bash
# Execute o projeto
comando-de-execucao
php artisan serve
npm run dev
### 4. Acesso

<!-- Informe como acessar a aplicação (por exemplo, URL local ou credenciais de teste) -->
URL local: http://localhost:3000  
Usuarios já pre-cadastrados: 
Database/Seeders/UserSeeder.php
USUARIO COMUM
'name' => 'Gleison Brito'
'email' => 'user@gmail.com.br'
'password' => bcrypt('password123')
ADMINISTRADORES
'name' => 'Diogo Rodrigues',
'email' => 'Admin@gmail.com.br',
'password' => bcrypt('123456789')
-----------------------
'name' => 'Pedro Henrique',
'email' => 'Pedro@outlook.com.br',
'password' => bcrypt('PXingu1234'),
----------------------
'name' => 'Gabriel Henrique',
'email' => 'Zion@gmail.com.br',
'password' => bcrypt('12345678'),
---------------------
'name' => 'Marco Antônio',
'email' => 'Tarzan@hotmail.com.br',
'password' => bcrypt('87654321'),
---
