@extends('layouts.app')

@section('title','Danh sách sinh viên (Mảng)')

@section('content')
<h2>Danh sách sinh viên – Nguồn: Mảng tĩnh</h2>
<p>Đang hiển thị {{ count($students) }} sinh viên từ mảng tĩnh.</p>
<nav aria-label="Nguồn dữ liệu">
  <a href="{{ route('students.static') }}" aria-current="page">Tĩnh (Array)</a> |
  <a href="{{ route('students.combined', ['source' => 'db']) }}">CSDL (Eloquent)</a>
</nav>

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
        <td>{{ $loop->iteration }}</td>
        <td>{{ $s['name'] }}</td>
           <td @class(['adult' => ($s['age'] ?? 0) >= 18])>{{ $s['age'] }}</td>
        <td>{{ $s['gender'] }}</td>
        <td>{{ $s['email'] }}</td>
        <td>{{ $s['class_name'] }}</td>
        <td><x-badge :age="$s['age']" /></td>
      </tr>
    @endforeach
  </tbody>
</table>

@endsection
