@extends('layouts.app')

@section('title','So sánh nguồn dữ liệu')

@section('content')
<h2>So sánh nguồn dữ liệu: Mảng tĩnh vs CSDL (Eloquent)</h2>
<x-card title="Chọn nguồn dữ liệu">

<nav style="margin-bottom:12px">
  <a href="{{ route('students.combined', ['source' => 'array']) }}">Tab: Tĩnh (Array)</a> |
  <a href="{{ route('students.combined', ['source' => 'db']) }}">Tab: CSDL (Eloquent)</a>
</nav>
</x-card>

@if($source === 'array')
  <h3>Nguồn: Mảng tĩnh — {{ count($static) }} sinh viên</h3>
  <table>
    <thead>
      <tr><th>STT</th><th>Họ tên</th><th>Tuổi</th><th>Giới tính</th><th>Email</th><th>Lớp</th><th>Nhãn tuổi</th></tr>
    </thead>
    <tbody>
      @foreach($static as $s)
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
@else
  <h3>Nguồn: CSDL (Eloquent) — {{ $db->total() }} sinh viên, trang {{ $db->currentPage() }}</h3>
  <table>
    <thead>
      <tr><th>STT</th><th>Họ tên</th><th>Tuổi</th><th>Giới tính</th><th>Email</th><th>Lớp</th><th>Nhãn tuổi</th></tr>
    </thead>
    <tbody>
      @foreach($db as $s)
      <tr>
        <td>{{ $loop->iteration + ($db->currentPage()-1)*$db->perPage()
}}</td>
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
    {{ $db->appends(['source' => 'db'])->links() }}
  </div>
@endif
@endsection
