# Laravel Task API

This is the backend API for the 6-hour Full Stack Web Development training.

## Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

## API

```txt
GET     /api/tasks
POST    /api/tasks
GET     /api/tasks/{task}
PUT     /api/tasks/{task}
PATCH   /api/tasks/{task}
DELETE  /api/tasks/{task}
```

## Example POST Body

```json
{
  "title": "Learn Vue.js",
  "description": "Build frontend UI",
  "status": "pending"
}
```
