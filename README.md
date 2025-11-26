# Eletro-Descarte

Sistema completo para gerenciamento e coleta de lixo eletrônico, visando sustentabilidade, logística reversa e interação entre usuários e administradores.

---

## Descrição

Eletro-Descarte é uma plataforma desenvolvida para combater os danos causados pelo descarte inadequado de lixo eletrônico.  
A empresa coleta, separa e devolve matéria-prima para empresas responsáveis pela reutilização, reduzindo a necessidade de mineração de metais como ferro, lítio, cobre e ouro.

Objetivos principais:
- Reduzir impactos ambientais  
- Incentivar o descarte correto  
- Facilitar a comunicação entre usuários e a empresa  
- Automatizar processos de coleta, resgate e monitoramento  

---

## Integrantes

| Nome | Função | Matrícula |
|------|--------|-----------|
| Diogo Rodrigues | Direção; Back-End e Front-End | 12302678 |
| Marco Antônio Mendes | Planejamento; Back-End e Planilhas | 12302260 |
| Pedro Henrique Moreira | Organização; Planilhas e Front-End | 12303020 |
| Gabriel Henrique | Controle de Qualidade; Back-End e Front-End | 12302961 |

---

## Funcionalidades Implementadas

### Acesso e Autenticação
- [x] Tela inicial para usuários não cadastrados  
- [x] Cadastro de usuários  
- [x] Login  
- [x] Recuperação de senha  

### Área do Usuário
- [x] Histórico de descartes  
- [x] Editar informações  
- [x] Assistência técnica  
- [x] Assistente virtual  
- [x] Resgate de pontos  
- [x] Compra de produtos com pontos de coleta  

### Administração
- [x] Área administrativa completa  
- [x] Criação e edição de produtos  
- [x] Monitoramento de atividades  
- [x] Gerenciamento de usuários  
- [x] Respostas de assistência técnica  
- [x] Tela de pagamentos  

### Mapas e Localização
- [x] Pontos de descarte no mapa  
- [x] Sistema completo de Maps  

### Comunicação
- [x] Contato com a empresa via e-mail  
- [x] Redes sociais integradas  

---

## Estrutura de Diretórios

EletroDescarte/
├── .vite/
├── app/
│ ├── Http/
│ ├── Models/
│ ├── Providers/
│ └── View/
├── bootstrap/
│ └── cache/
├── config/
├── database/
│ ├── migrations/
│ ├── seeders/
│ └── eletrodescartesbanco.sql
├── public/
│ ├── backend/
│ ├── build/
│ ├── img/
│ ├── index.php
│ └── .htaccess
├── resources/
│ ├── css/
│ ├── js/
│ └── views/
├── routes/
│ ├── auth.php
│ ├── console.php
│ └── web.php
├── storage/
└── README.md

## Como Executar o Projeto

### 1. Pré-requisitos
- XAMPP, WAMP ou Laragon  
- PHP 8.1+  
- Composer  
- MySQL ativo  
- Node.js + NPM  

### 2. Clonar o Repositório
git clone https://DiogoRodriguesActivity.github.io/EletroDescartes-Breeze/

### 3. Importar o Banco de Dados

1. Acesse: http://localhost/phpmyadmin  
2. Clique em "Novo"  
3. Crie o banco: **eletrodescartesbanco**  
4. Vá em "Importar"  
5. Selecione o arquivo `eletrodescartesbanco.sql` (localizado em /database)  
6. Clique em "Executar"

Criar o arquivo `.env`:
- Copie o arquivo localizado em `public/salvar`
- Cole na raiz como `.env`

### 4. Instalar Dependências

composer install
php artisan key:generate
npm install

php artisan migrate
php artisan db:seed

### 5. Executar o Projeto

php artisan serve
npm run dev
