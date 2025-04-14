<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="row" style="height:300px; max-width: 500px; margin: auto;padding: 10px;">
        <div class="column">
            <div class="login-form">
                @if (session('message'))
                <div style="color: red; text-align: center;">
                    {{ session('message') }}
                </div>
                @endif
                <form action="{{ route('postInputEmail') }}" method="POST">
                    @csrf
                    <h1>Reset mật khẩu</h1>
                    <div class="input-box">
                        <i></i>
                        <input name="txtEmail" type="text" placeholder="Nhập địa chỉ email của bạn để nhận mật khẩu mới" value="{{ old('txtEmail') }}">
                        @error('txtEmail')
                        <span class="error" style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="btn-box">
                        <input type="submit" value="Nhận mật khẩu" name="btnGetPassword" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>