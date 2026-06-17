<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>FleaMarket</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <a class="header__logo" href="/">
                <img src="{{ asset('images/header/COACHTECHヘッダーロゴ.png') }}" alt="ロゴ">
            </a>
            {{-- 検索 --}}
            <div class="header__content">
                <form class="search-form" action="/" method="GET">
                    <input
                        class="search-form__input"
                        type="text"
                        name="keyword"
                        value="{{ request('keyword') }}"
                        placeholder="何をお探しですか？">
                        <input type="hidden" name="tab" value="{{ $tab ?? request('tab', '') }}">
                </form>
                <nav class="header-nav">
                @auth
                    <form action="/logout" method="POST">
                        @csrf
                        <button class="header-nav__link" type="submit">
                            ログアウト
                        </button>
                    </form>
                @else
                    <a class="header-nav__link" href="/login">
                        ログイン
                    </a>
                @endauth
                    <a class="header-nav__link" href="/mypage">マイページ</a>
                    <a class="header-nav__button" href="/sell">出品</a>
                </nav>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>
</body>

</html>