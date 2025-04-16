@extends('layout.adm')

@section('content')
<h3>Danh sách tin nhắn</h3>
<ul>
    @foreach($users as $u)
    <li><a href="{{ route('admin.chat.show', $u->id) }}">{{ $u->full_name }}: Xem tin nhắn</a></li>
    @endforeach
</ul>



@endsection