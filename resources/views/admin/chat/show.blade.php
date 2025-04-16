@extends('layout.adm')

@section('content')
<h2>Đoạn chat với {{ $user->full_name }}</h2>

<div class="chat-box">
    @foreach ($messages as $msg)
    <div class="{{ $msg->from_user_id == auth()->id() ? 'admin-message' : 'user-message' }}">
        <strong>{{ $msg->from_user_id == $adminId ? 'Bạn (Admin)' : $msg->sender->full_name }}:</strong>


        {{ $msg->message }}
    </div>
    @endforeach
</div>

<form action="{{ route('admin.chat.reply', $user->id) }}" method="POST">
    @csrf
    <textarea name="message" required></textarea>
    <button type="submit">Gửi</button>
</form>
@endsection