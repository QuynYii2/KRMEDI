<!-- resources/views/check-custom-scheme.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checking...</title>
    <script type="text/javascript">
        // Tạo một hàm để kiểm tra custom scheme
        function openCustomScheme() {
            var start = Date.now();
            var timeout;

            // Thử mở custom scheme
            window.location.href = 'krmedi://krmedi.vn/home-screen?hospitalId={{ $id }}';

            // Nếu không phản hồi trong 2 giây, chuyển hướng đến URL dự phòng
            timeout = setTimeout(function () {
                var elapsed = Date.now() - start;
                if (elapsed < 2000) {
                    // Nếu thời gian trôi qua ít hơn 2 giây, có thể custom scheme không mở được
                    window.location.href = 'https://krmedi.vn/home-screen';
                }
            }, 1500);
        }

        // Gọi hàm khi tải trang
        window.onload = openCustomScheme;
    </script>
</head>
<body>
<p>Đang kiểm tra...</p>
</body>
</html>
