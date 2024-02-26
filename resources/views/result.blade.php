<!-- resources/views/result.blade.php -->
<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <!-- Thêm các cột khác tùy thuộc vào cơ sở dữ liệu của bạn -->
    </tr>
    </thead>
    <tbody>
    @foreach($result as $item)
        <tr>
            <td>{{ $item->id }}</td>
            <td>{{ $item->name }}</td>
            <!-- Thêm các cột khác tùy thuộc vào cơ sở dữ liệu của bạn -->
        </tr>
    @endforeach
    </tbody>
</table>
