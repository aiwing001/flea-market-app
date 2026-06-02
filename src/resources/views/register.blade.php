@extends('layouts.auth')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')

<div class="register__title">
    <h1 class="page-title">
        会員登録
    </h1>
</div>

<form class="register-form" action="/register" method="POST">
    @csrf
    {{-- ユーザー名 --}}
    <div class="register-form__group">
        <div class="register-form__title">
            ユーザー名
        </div>
        <div class="register-form__content">
            <div class="register-form__input">
                <input type="text" name="name" value="{{ old('name') }}">
            </div>
            @error('name')
                <p class="register-form__error">
                    {{ $message }}
                </p>
            @enderror
        </div>
    </div>
    {{-- メールアドレス --}}
    <div class="register-form__group">
        <div class="register-form__title">
            メールアドレス
        </div>
        <div class="register-form__content">
            <div class="register-form__input">
                <input type="text" name="email" value="{{ old('email') }}">
            </div>
            @error('email')
                <p class="register-form__error">
                    {{ $message }}
                </p>
            @enderror
        </div>
    </div>
    {{-- パスワード --}}
    <div class="register-form__group">
        <div class="register-form__title">
            パスワード
        </div>
        <div class="register-form__content">
            <div class="register-form__input">
                <input type="password" name="password">
            </div>
            @error('password')
                <p class="register-form__error">
                    {{ $message }}
                </p>
            @enderror
        </div>
    </div>
    {{-- 確認用 --}}
    <div class="register-form__group">
        <div class="register-form__title">
            確認用パスワード
        </div>
        <div class="register-form__content">
            <div class="register-form__input">
                <input type="password" name="password_confirmation">
            </div>
            @error('password_confirmation')
                <p class="register-form__error">
                    {{ $message }}
                </p>
            @enderror
        </div>
    </div>
    {{-- 登録ボタン --}}
    <div class="register-form__button">
        <button class="register-form__button-submit" type="submit">
            登録する
        </button>
    </div>
</form>
<div class="register-form__link">
    <a class="register-form__link-login" href="/login">
    ログインはこちら
    </a>
</div>

@endsection