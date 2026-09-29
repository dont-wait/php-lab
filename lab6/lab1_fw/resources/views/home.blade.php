@extends('layouts.app')

@section('title', 'Laravel Framework – Lab 6')

@section('content')
<x-card title="Laravel Framework – Bài thực hành">
    <p>Ứng dụng minh họa routing, controller, Blade, Eloquent và migration.</p>
    <ul>
        <li><a href="{{ route('students.static') }}">Danh sách sinh viên tĩnh</a></li>
        <li><a href="{{ route('students.db') }}">Danh sách sinh viên từ cơ sở dữ liệu</a></li>
        <li><a href="{{ route('students.create') }}">Tạo sinh viên mới</a></li>
        <li><a href="{{ route('students.combined', ['source' => 'array']) }}">So sánh nguồn dữ liệu</a></li>
        <li><a href="{{ route('about') }}">Giới thiệu học phần</a></li>
    </ul>
</x-card>
@endsection
