# Деплой

```bash
$ cp .env.example .env
$ docker-compose up -d --build
```
#### Далее нужно настроить crontab
```bash
$ crontab -e
```
#### В редакторе добавить:
```cron
* * * * * docker exec hismith_test-queue php artisan schedule:run 
```
