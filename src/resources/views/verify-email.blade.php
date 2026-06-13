@extends('layouts.auth')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/verify-email.css') }}">
@endsection

@section('content')
<div class="verify-email">
    <p class="verify-email__message">
        登録していただいたメールアドレスに認証メールを送信しました。<br>
        メール認証を完了してください。
    </p>

    <a class="verify-email__button" href="http://localhost:8025" target="_blank">
        認証はこちらから
    </a>

    <form class="verify-email__resend" method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button class="verify-email__resend-link" type="submit">
            認証メールを再送する
        </button>
    </form>
</div>

@endsection