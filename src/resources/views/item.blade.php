@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/item.css') }}">
@endsection

@section('content')

<div class="item-page">
    <div class="item-page__content">
        <div class="item-page__image">
            <img src="{{ asset($item->image) }}" alt="商品画像">
        </div>
        <div class="item-page__detail">
            <h1 class="item-page__name">
                {{ $item->name }}
            </h1>
            <p class="item-page__brand">
                {{ $item->brand }}
            </p>
            <p class="item-page__price">
                ￥{{ number_format($item->price) }}
            </p>
            <div class="item-page__meta">
                <div class="item-page__meta-item">
                    @if($isLiked)
                        <form action="/like/{{ $item->id }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="item-page__like-button" type="submit">♥</button>
                        </form>
                    @else
                        <form action="/like/{{ $item->id }}" method="POST">
                            @csrf
                            <button class="item-page__like-button" type="submit">♡</button>
                        </form>
                    @endif
                    <span>{{ $item->likes->count() }}</span>
                </div>
                <div class="item-page__meta-item">
                    💬
                    <span>{{ $item->comments->count() }}</span>
                </div>
            </div>
            <div class="item-page__purchase">
                <a class="item-page__purchase-button" href="/item/{{ $item->id }}/purchase">
                    購入手続きへ
                </a>
            </div>
            <div class="item-page__description">
                <h2 class="item-page__section-title">
                    商品説明
                </h2>
                <p>
                    {{ $item->description }}
                </p>
            </div>
            <div class="item-page__info">
                <h2 class="item-page__section-title">
                    商品情報
                </h2>
                <p>
                    カテゴリ:
                    @foreach($item->categories as $category)
                        <span>{{ $category->name }}</span>
                    @endforeach
                </p>
                <p>
                    商品状態:{{ $item->condition }}
                </p>
            </div>
            <div class="item-page__comments">
                <h2 class="item-page__section-title">
                    コメント ({{ $item->comments->count() }})
                </h2>
                @foreach($item->comments as $comment)
                    <div class="comment">
                        <div class="comment__user">
                            <img
                                src="{{ $comment->user->image_url
                                    ? asset('storage/' . $comment->user->image_url)
                                    : asset('images/default-icon.png') }}"
                                alt="ユーザー画像"
                            >
                            <p class="comment__user-name">
                                {{ $comment->user->name }}
                            </p>
                        </div>
                        <p class="comment__text">
                            {{ $comment->content }}
                        </p>
                    </div>
                @endforeach
                <div class="item-page__comment-form">
                    <h2 class="item-page__section-title">
                        商品へのコメント
                    </h2>
                    <form action="/comment/{{ $item->id }}" method="POST">
                        @csrf
                        <textarea class="comment-form__textarea" name="content"></textarea>
                            @error('content')
                                <p class="comment-form__error">
                                    {{ $message }}
                                </p>
                            @enderror
                        <button class="comment-form__button" type="submit">コメントを送信する</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection