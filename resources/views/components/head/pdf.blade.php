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
        <th>Số ngày bắt đầu</th>
        <th>Số ngày kết thúc</th>
        <th>Lưu ý</th>
    </tr>
    @foreach($data as $key => $item)
        <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $item['medicine_name'] }}</td>
            <td>{{ $item['quantity'] }}</td>
            <td>{{ $item['date_start'] }}</td>
            <td>{{ $item['date_end'] }}</td>
            <td>@foreach($item['note_date'] as $key => $items)
                @if($items[$key] == 1)
                    Uống trước ăn sáng,
                    @elseif($items[$key] == 2)
                    Uống sau ăn sáng
                    @elseif($items[$key] == 3)
                        Uống trước ăn trưa
                    @elseif($items[$key] == 4)
                        Uống sau ăn trưa
                    @elseif($items[$key] == 5)
                        Uống trước ăn tối
                    @elseif($items[$key] == 6)
                        Uống sau ăn tối
                    @endif
                @endforeach</td>
        </tr>
    @endforeach
</table>

</body>
</html>
