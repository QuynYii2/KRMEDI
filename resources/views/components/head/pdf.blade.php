<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đơn thuốc</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
    </style>
</head>
<body>

<p style="font-size: 24px;font-weight: bold">Thông tin đơn thuốc</p>
<div>
    <p>Bác sĩ: {{$doctor}}</p>
    <p>Bệnh nhân: {{$user_name}}</p>
</div>
<table class="table table-bordered" style="border: 1px solid #cccccc">
    <tr>
        <th>STT</th>
        <th>Tên thuốc</th>
        <th>Số lượng</th>
        <th>Số ngày sử dụng</th>
        <th>Lưu ý</th>
    </tr>
    @foreach($data as $key => $item)
        <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $item['medicine_name'] }}</td>
            <td>{{ $item['quantity'] }}</td>
            <td>{{ $item['treatment_days'] }}</td>
            <td>{{ $item['note'] }}</td>
        </tr>
    @endforeach
</table>

</body>
</html>
