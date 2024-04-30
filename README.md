Điều kiện tiền đề: máy đã cài docker, docker-compose, git.
- Cách install docker trên amz linux 2: https://www.cyberciti.biz/faq/how-to-install-docker-on-amazon-linux-2/ 

### Trên local
Sau khi clone prj về, cd vào thư mục gốc của dự án, rồi chạy lần lượt các command sau:
- docker-compose up -d
- docker exec -it storeabc bash
- composer update
- vào sửa file .env
- php artisan key:generate
- php artisan migrate
- php artisan db:seed
- php artisan storage:link

Sau đó, truy cập vào localhost để kiểm tra kết quả.
URL login vào admin: http://localhost/admin/login
Acc admin default: mymy /12345678

Update 2024040: đã cho hết các lệnh migrate, key gen, seeder, storage link vào file script start.sh trong entry point của dockerfile, lệnh composer install cũng đã chạy khi build image luôn rồi => khi run container, file script sẽ auto run => ko cần chạy tay nữa => chỉ cần docker compose up -d để bật local

### Trên prd
(Giả định đã tạo, config hoàn thiện EC2, RDS, Elasticache Redis, S3 bucket, Cognito) 

Sau khi clone prj về,  cd vào thư mục gốc của dự án, rồi chạy lần lượt các command sau:
- docker build -t storeabc:v1 .
- docker run -d -p 8080:80 --name storeabc storeabc:v1
- docker exec -it storeabc bash
- vào sửa file .env
- php artisan key:generate
- php artisan migrate
- php artisan db:seed
- php artisan storage:link
