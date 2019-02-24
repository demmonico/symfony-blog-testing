### First run

1. Correct app folder name at the `docker-compose.yml`

2. Insert `.env.local` file at the `infra/local`

3. Build and Run containers

```
docker-compose up -d --build --force-recreate
```

4. Run migrations

```
docker exec -ti symfblog_app_php_1 bash -c "bin/console doctrine:migrations:migrate"
```
