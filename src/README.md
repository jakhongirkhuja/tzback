
.env
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=userdb
DB_USERNAME=user1
DB_PASSWORD=changeme

docker-compose up -d
docker-compose exec php composer install
docker-compose exec php php artisan key:generate
docker-compose exec php php artisan optimize
docker-compose exec php php artisan migrate
docker-compose exec php php artisan optimize:clear