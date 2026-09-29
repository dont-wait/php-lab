@extends('layouts.app')

@section('title', 'Tạo sinh viên')

@section('content')
<h2>Tạo sinh viên mới</h2>

<x-card title="Thông tin sinh viên">
    <form method="post" action="{{ route('students.store') }}">
        @csrf
        <div>
            <label for="name">Họ tên</label><br>
            <input id="name" name="name" value="{{ old('name') }}" required maxlength="255">
            @error('name')<p role="alert">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="email">Email</label><br>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required maxlength="255">
            @error('email')<p role="alert">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="age">Tuổi</label><br>
            <input id="age" name="age" type="number" min="16" value="{{ old('age') }}">
            @error('age')<p role="alert">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="gender">Giới tính</label><br>
            <select id="gender" name="gender" required>
                <option value="">Chọn giới tính</option>
                <option value="male" @selected(old('gender') === 'male')>Nam</option>
                <option value="female" @selected(old('gender') === 'female')>Nữ</option>
            </select>
            @error('gender')<p role="alert">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="class_name">Lớp</label><br>
            <input id="class_name" name="class_name" value="{{ old('class_name') }}" maxlength="255">
            @error('class_name')<p role="alert">{{ $message }}</p>@enderror
        </div>
        <button type="submit">Lưu sinh viên</button>
    </form>
</x-card>
@endsection
