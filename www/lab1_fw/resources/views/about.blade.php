@extends('layouts.app')

@section('title', 'Giới thiệu học phần')

@section('content')
<x-card title="Mục tiêu học phần">
    <p>Trang bị kiến thức và kỹ năng xây dựng ứng dụng web với PHP, MySQL và các công cụ mã nguồn mở; biết tổ chức ứng dụng theo mô hình MVC và áp dụng framework trong phát triển phần mềm.</p>
</x-card>

<x-card title="Lịch 7 buổi thực hành">
    <ol>
        <li>Ôn tập PHP cơ bản, biểu mẫu và xử lý dữ liệu.</li>
        <li>Lập trình hướng đối tượng với PHP.</li>
        <li>Kết nối MySQL và thao tác dữ liệu.</li>
        <li>Xây dựng ứng dụng web với PHP và cơ sở dữ liệu.</li>
        <li>Làm quen Laravel, cấu hình và cấu trúc dự án.</li>
        <li>Routing, Controller, Blade, Migration và Eloquent.</li>
        <li>Hoàn thiện ứng dụng, kiểm tra và trình bày sản phẩm.</li>
    </ol>
</x-card>

<x-card title="Chuẩn đầu ra mong đợi">
    <ul>
        <li>Viết được chương trình PHP có cấu trúc và áp dụng lập trình hướng đối tượng.</li>
        <li>Thiết kế cơ sở dữ liệu MySQL và thao tác dữ liệu an toàn.</li>
        <li>Xây dựng ứng dụng Laravel theo MVC với route, controller, Blade và Eloquent.</li>
        <li>Biết kiểm tra, sửa lỗi và triển khai các chức năng web cơ bản.</li>
    </ul>
</x-card>
@endsection
