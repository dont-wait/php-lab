@extends('layouts.app')

@section('title','Danh sách sinh viên (DB)')

@section('content')
<h2>Danh sách sinh viên – Nguồn: CSDL (Eloquent)</h2>

@if (session('success'))
  <p role="status">{{ session('success') }}</p>
@endif

<x-card title="Lọc và quản lý sinh viên">
  <form method="get" action="{{ route('students.db') }}" style="margin-bottom:12px">
    <label for="gender">Lọc giới tính:</label>
    <select id="gender" name="gender" onchange="this.form.submit()">
      <option value="" @selected(empty($gender))>Tất cả</option>
      <option value="male" @selected(($gender ?? '') === 'male')>Nam</option>
      <option value="female" @selected(($gender ?? '') === 'female')>Nữ</option>
    </select>
  </form>
  <a href="{{ route('students.create') }}">Tạo sinh viên mới</a>
</x-card>

<table>
  <thead>
    <tr>
      <th>STT</th>
      <th>Họ tên</th>
      <th>Tuổi</th>
      <th>Giới tính</th>
      <th>Email</th>
      <th>Lớp</th>
      <th>Nhãn tuổi</th>
    </tr>
  </thead>
  <tbody>
    @foreach($students as $s)
      <tr>
      <td>{{ $loop->iteration + ($students->currentPage()-1)*$students->perPage() }}</td>
        <td>{{ $s->name }}</td>
        <td @class(['adult' => ($s->age ?? 0) >= 18])>{{ $s->age }}</td>
        <td>{{ $s->gender }}</td>
        <td>{{ $s->email }}</td>
        <td>{{ $s->class_name }}</td>
        <td><x-badge :age="$s->age" /></td>
      </tr>
    @endforeach
  </tbody>
</table>

<div style="margin-top:12px">
  {{ $students->links() }}
</div>
@endsection
