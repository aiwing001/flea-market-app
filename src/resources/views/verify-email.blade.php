@extends('layouts.auth')

@section('content')
<div class="verify-email">
    <h2>メール認証</h2>

    <p>
        登録していただいたメールアドレスに認証メールを送信しました。
        メールに記載されている認証リンクをクリックして、認証を完了してください。
    </p>

    <form method="POST" action="/email/verification-notification">
    @csrf
        <button type="submit">
            認証メールを再送する
        </button>
    </form>
</div>

@endsection