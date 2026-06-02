@extends('layouts.auth')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')

<div class="login__title">
    <h1 class="page-title">
        ログイン
    </h1>
</div>

<form class="login-form" action="/login" method="POST">
    @csrf
    <div class="login-form__group">
        <div class="login-form__title">
            メールアドレス
        </div>
        <div class="login-form__input">
            <input type="text" name="email" value="{{ old('email') }}">
            @error('email')
                <p class="login-form__error">
                    {{ $message }}
                </p>
            @enderror
        </div>
    </div>
    <div class="login-form__group">
        <div class="login-form__title">
            パスワード
        </div>
        <div class="login-form__input">
            <input type="password" name="password">
            @error('password')
                <p class="login-form__error">
                    {{ $message }}
                </p>
            @enderror
        </div>
    </div>
    <div class="login-form__button">
        <button class="login-form__button-submit" type="submit">
            ログインする
        </button>
    </div>
</form>
<div class="login-form__link">
    <a class="login-form__link-register" href="/register">
        会員登録はこちら
    </a>
</div>

@endsection