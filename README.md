# CRUD Client - Sistema de Gerenciamento

Sistema completo de CRUD com backend Laravel e frontend Vue.js, utilizando Docker para facilitar o desenvolvimento e deploy.

## 📋 Pré-requisitos

- Docker
- Docker Compose
- Git

## 🚀 Configuração e Instalação

### 1. Clone o repositório

```bash
git clone https://github.com/pedroinnovano/crud-client.git
cd crud-client
```

### 2. Configuração dos arquivos de ambiente

#### Backend (.env)

Copie o arquivo de exemplo e configure as variáveis:

```bash
cp backend/.env.example backend/.env
```

O arquivo `backend/.env` já está configurado com as seguintes variáveis principais:

```env
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:/gVp+3MDenND4n1pFR/UBo4mMhNblCqvcpAdcipKvC4=
APP_DEBUG=true
APP_URL=http://localhost:8081

# Database
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=myapp
DB_USERNAME=myapp
DB_PASSWORD=secret

# Redis
REDIS_CLIENT=phpredis
REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379

# Cache e Session
QUEUE_CONNECTION=redis
CACHE_STORE=redis
SESSION_DRIVER=redis

# Swagger
L5_SWAGGER_CONST_HOST=http://localhost:8081
```

#### Frontend (.env)

Copie o arquivo de exemplo e configure:

```bash
cp frontend/.env.example frontend/.env
```

Configure as variáveis do frontend:

```env
VITE_API_BASE_URL=http://localhost:8081/api


```

#### Docker (.env na raiz)

O arquivo `.env` na raiz já está configurado com:

```env
UID=1000
GID=1000
```

**Nota para Windows:** Ajuste os valores de UID e GID conforme necessário para seu sistema.

### 3. Executar o projeto

#### Subir todos os serviços

```bash
docker-compose up -d
```

#### Instalar dependências do backend

```bash
docker-compose exec app composer install
```

#### Executar migrações do banco de dados

```bash
docker-compose exec app php artisan migrate
```

#### (Opcional) Executar seeders

```bash
docker-compose exec app php artisan db:seed
```

#### Gerar chave da aplicação Laravel (se necessário)

```bash
docker-compose exec app php artisan key:generate
```

## 🌐 Acessos

- **Frontend (Vue.js)**: http://localhost:5174
- **Backend (Laravel)**: http://localhost:8081
- **API Documentation (Swagger)**: http://localhost:8081/api/documentation
- **MySQL**: localhost:3369
- **Redis**: localhost:6969

## 🐳 Serviços Docker

O projeto utiliza os seguintes serviços:

- **app**: Backend Laravel (PHP 8.2)
- **nginx**: Servidor web
- **mysql**: Banco de dados MySQL 8
- **redis**: Cache e sessões
- **frontend**: Frontend Vue.js (Node.js 20.19.0)

## 📁 Estrutura do Projeto

```
crud-client/
├── backend/          # Aplicação Laravel
├── frontend/         # Aplicação Vue.js
├── docker/           # Configurações Docker
│   ├── nginx/        # Configuração Nginx
│   └── php/          # Dockerfile e configurações PHP
├── docker-compose.yml
└── README.md
```

## 🛠️ Comandos Úteis

### Backend (Laravel)

```bash
# Acessar container do backend
docker-compose exec app bash

# Executar comandos Artisan
docker-compose exec app php artisan <comando>

# Instalar dependências
docker-compose exec app composer install

# Executar testes
docker-compose exec app php artisan test

# Limpar cache
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan route:clear
```

### Frontend (Vue.js)

```bash
# Acessar container do frontend
docker-compose exec frontend sh

# Instalar dependências
docker-compose exec frontend npm install

# Build para produção
docker-compose exec frontend npm run build
```

### Docker

```bash
# Parar todos os serviços
docker-compose down

# Rebuild dos containers
docker-compose up --build

# Ver logs
docker-compose logs -f [nome-do-serviço]

# Remover volumes (cuidado: apaga dados do banco)
docker-compose down -v
```

## 🔧 Desenvolvimento

### Hot Reload

- O frontend está configurado com hot reload automático
- O backend utiliza volumes para refletir mudanças automaticamente

### Banco de Dados

- MySQL rodando na porta 3369
- Credenciais padrão:
  - Host: localhost
  - Porta: 3369
  - Database: myapp
  - Username: myapp
  - Password: secret
  - Root Password: root

## 🚨 Troubleshooting

### Problemas comuns:

1. **Erro de permissão**: Ajuste UID e GID no arquivo `.env`
2. **Porta ocupada**: Verifique se as portas 8081, 5174, 3369, 6969 estão livres
3. **Erro de conexão com banco**: Aguarde alguns segundos para o MySQL inicializar completamente

### Logs:

```bash
# Ver logs de todos os serviços
docker-compose logs -f

# Ver logs de um serviço específico
docker-compose logs -f app
docker-compose logs -f mysql
docker-compose logs -f frontend
```

## 📝 Notas

- O projeto utiliza Tailwind CSS no frontend
- Backend configurado com Swagger para documentação da API
- Redis configurado para cache e sessões
- Configuração pronta para integração com Twilio

## 🤝 Contribuição

1. Faça um fork do projeto
2. Crie uma branch para sua feature (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Push para a branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request

## 📄 Licença

Este projeto está sob a licença MIT. Veja o arquivo `LICENSE` para mais detalhes.