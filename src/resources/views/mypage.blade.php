@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')

<div class="mypage">
    <div class="mypage__profile">
        <div class="mypage__image">
            <img
                src="{{ Auth::user()->image_url ?
                    asset('storage/' . Auth::user()->image_url) :
                    asset('images/default-icon.png') }}"
                alt="プロフィール画像"
            >
        </div>
        <p class="mypage__name">
            {{ Auth::user()->name }}
        </p>
        <a class="mypage__edit-button" href="/mypage/profile">
            プロフィールを編集
        </a>
    </div>
</div>

<div class="mypage__tab">
    <a
        class="mypage__tab-link {{ $page === 'sell' ? 'mypage__tab-link--active' : '' }}"
        href="/mypage?page=sell"
    >
        出品した商品
    </a>

    <a
        class="mypage__tab-link {{ $page === 'buy' ? 'mypage__tab-link--active' : '' }}"
        href="/mypage?page=buy"
    >
        購入した商品
    </a>
</div>

<div class="mypage">
    <div class="mypage__content">
        @foreach($items as $item)
        <a class="item-card" href="/item/{{ $item->id }}">
            <div class="item-card__image">
                <img src="{{ asset($item->image) }}" alt="商品画像">
            </div>
            <div class="item-card__name">
                {{ $item->name }}
            </div>
        </a>
        @endforeach
    </div>
</div>

@endsection