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

### Trên prd
(Giả định đã tạo, config hoàn thiện EC2, RDS, Elasticache Redis, S3 bucket, Cognito) /n
Sau khi clone prj về,  cd vào thư mục gốc của dự án, rồi chạy lần lượt các command sau:
- docker build -t storeabc:v1 .
- docker run -d -p 8080:80 --name storeabc storeabc:v1
- docker exec -it storeabc bash
- vào sửa file .env
- php artisan key:generate
- php artisan migrate
- php artisan db:seed
- php artisan storage:link
