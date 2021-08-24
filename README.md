# ALT-STUDIO-TEST-TASK
Установить Docker и Docker-compose.
  Билдим контейнеры
1. docker-compose -f docker/docker-compose.yml up -d 
2. docker-compose -f docker/docker-compose.yml exec app bash
  Работаем в контейнере
3. cp .env.example .env
4. composer install
5. php artisan key:generate
6. php artisan migrate
7. php passport:install
