# Laravel SB Admin 2

SB Admin 2 for Laravel.

| Laravel Version | Branch | Support     |
|-----------------|--------|-------------|
| 10.0            | main   |             |
| 9.0             | v9.0   |             |
| 8.0             | v8.0   | End of life |
| 7.0             | v7.0   | End of life |
| 6.0             | v6.0   | End of life |
| 5.8             | v5.8   | End of life |

## Requirements

- PHP >= 8.1
- Ctype PHP Extension
- cURL PHP Extension
- DOM PHP Extension
- Fileinfo PHP Extension
- Filter PHP Extension
- Hash PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PCRE PHP Extension
- PDO PHP Extension
- Session PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension

## Installation

- Run `composer i` or `composer u`
- Run `cp .env.example .env`
- Create schema `tdoctor` in database
- Run `php artisan migrate`
- Run `php artisan key:generate`
- Run `php artisan serve`

## Note

Recommend to install this preset on a project that you are starting from scratch, otherwise your project's design might break.

If you found this project useful, then please consider giving it a :star:

## Conventional commits

eg: <type>[optional scope]: <description>

[optional body]

[optional footer(s)]

- **feat**: Những thay đổi cho tính năng mới.
- **fix**: Những thay đổi liên quan đến sửa lỗi trong ứng dụng, hệ thống.
- **docs**: Những thay đổi liên quan đến sửa đổi document trong repo.
- **style**: Những thay đổi không làm thay đổi ý nghĩa của code như căn hàng, xuống dòng ở cuối file…
- **refactor**: Tối ưu source code, có thể liên quan logic. Ví dụ như xoá code thừa, tối giản code, đổi tên biến …
- **perf**: Thay đổi giúp tăng hiệu năng.
- **test**: Thêm hoặc sửa các testcase trong hệ thống.
- **build**: Thay đổi liên quan đến hệ thống hoặc các thư viên bên ngoài (Ảnh hưởng đến tiến trình build)
- **ci**: Thay đổi liên quan đến cấu hình CI…
- **chore**: Những sửa đổi nhỏ nhặt không liên quan tới code.
- **BREAKING CHANGE**: Những commit mới footer là BREAKING CHANGE thể hiện những thay đổi gây ảnh hướng lớn đến source code ví dụ thay đổi kiểu dữ liệu, cách lấy dữ liệu… => Qua đó cảnh báo mọi người để tránh phát sinh các vấn đề.

## License

Licensed under the [MIT](LICENSE) license.
