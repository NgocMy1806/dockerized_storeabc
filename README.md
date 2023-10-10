### Trên local
Sau khi clone prj về, cd vào thư mục gốc của dự án, rồi chạy lần lượt các command sau:
- docker-compose up
- docker exec -it app-container-id bash
- composer update
- cp .env.example .env
- php artisan key:generate
- php artisan migrate
- php artisan db:seed
- php artisan storage:link

Sau đó, truy cập vào localhost để kiểm tra kết quả.
URL login vào admin: http://localhost/admin/login
Acc admin default: mymy /12345678