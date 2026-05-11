# Full Stack Web Development Teaching Code

Stack:
- Frontend: Vue.js 3 + Vite + Axios
- Backend: Laravel API
- Database: MySQL or PostgreSQL
- Project: Task Manager CRUD

This ZIP is for teaching. It does not include `vendor/` or `node_modules/` because those folders are large. Students install dependencies after extracting.

## Folder Structure

```txt
fullstack-vue-laravel-teaching-code/
├── laravel-task-api/      # Laravel backend API sample code
├── vue-task-frontend/     # Vue.js frontend sample code
├── docker-compose.yml     # Optional local database setup
├── git-cheatsheet.md
└── lesson-flow.md
```

## Official Install URLs

- Node.js: https://nodejs.org
- Vue.js Quick Start: https://vuejs.org/guide/quick-start.html
- PHP: https://www.php.net/downloads.php
- Composer: https://getcomposer.org/download/
- Laravel Installation: https://laravel.com/docs/installation
- Git: https://git-scm.com/downloads
- Docker: https://docs.docker.com/engine/install/

## Run Backend

```bash
cd laravel-task-api
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

Backend URL:

```txt
http://127.0.0.1:8000
```

API URL:

```txt
http://127.0.0.1:8000/api/tasks
```

## Run Frontend

```bash
cd vue-task-frontend
npm install
npm run dev
```

Frontend URL:

```txt
http://localhost:5173
```

## Optional: Run Database with Docker

```bash
docker compose up -d
```

MySQL:

```txt
Host: 127.0.0.1
Port: 3306
Database: task_app
Username: task_user
Password: secret
```

## API Endpoints

| Method | URL | Description |
|---|---|---|
| GET | /api/tasks | Get all tasks |
| POST | /api/tasks | Create task |
| GET | /api/tasks/{id} | Get one task |
| PUT/PATCH | /api/tasks/{id} | Update task |
| DELETE | /api/tasks/{id} | Delete task |

## Learning Goal

Students should understand this flow:

```txt
Vue UI → Axios Request → Laravel API Route → Controller → Model/Eloquent → Database → JSON Response → Vue UI Update
```
