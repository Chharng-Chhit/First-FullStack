# Docker Tips

## Start MySQL and phpMyAdmin

From the root folder:

```bash
docker compose up -d
```

## Stop Containers

```bash
docker compose down
```

## Stop and Remove Data

Warning: this deletes the MySQL data volume.

```bash
docker compose down -v
```

## Check Containers

```bash
docker ps
```

## View Logs

```bash
docker logs task_app_mysql
```

## Laravel `.env` for Docker MySQL

When Laravel runs on your host machine:

```env
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_app
DB_USERNAME=task_user
DB_PASSWORD=secret
```
