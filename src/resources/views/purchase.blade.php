@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')

<div class="purchase-page">
    <form class="purchase-form" action="/item/{{ $item->id }}/purchase" method="POST">
        @csrf
        <div class="purchase-form__content">
            {{-- 商品情報 --}}
            <section class="purchase-item">
                <div class="purchase-item__content">
                    <div class="purchase-item__image">
                        <img src="{{ asset('images/sample.png')}}" alt="商品画像">
                    </div>
                    <div class="purchase-item__info">
                        <h2 class="purchase-item__name">
                            {{ $item->name }}
                        </h2>
                        <p class="purchase-item__price">
                            ￥{{ number_format($item->price) }}
                        </p>
                    </div>
                </div>
            </section>
            {{-- 支払い方法 --}}
            <section class="purchase-payment">
                <h3 class="purchase-section__title">
                    支払い方法
                </h3>
                <div class="purchase-payment__select">
                    <select name="payment_method">
                        <option value="">
                            選択してください
                        </option>
                        <option value="convenience">
                            コンビニ払い
                        </option>
                        <option value="card">
                            カード払い
                        </option>
                    </select>
                </div>
            </section>
            {{-- 配送先 --}}
            <section class="purchase-address">
                <div class="purchase-address__header">
                    <h3 class="purchase-section__title">
                        配送先
                    </h3>
                    <a class="purchase-address__change" href="/purchase/address/{{ $item->id }}">
                        変更する
                    </a>
                </div>
                <div class="purchase-address__content">
                    <p class="purchase-address__postcode">
                        〒{{ Auth::user()->postal_code }}
                    </p>
                    <p class="purchase-address__text">
                        {{ Auth::user()->address }}
                    </p>
                    <p class="purchase-address__building">
                        {{ Auth::user()->building }}
                    </p>
                </div>
            </section>
        </div>
        {{-- 購入内容画面 --}}
        <aside class="purchase-summary">
            <div class="purchase-summary__group">
                <div class="purchase-summary__row">
                    <p>商品代金</p>
                    <p>￥{{ number_format($item->price) }}</p>
                </div>
                <div class="purchase-summary__row">
                    <p>支払い方法</p>
                    <p>カード払い</p>
                </div>
            </div>
            <button class="purchase-summary__button" type="submit">
                購入する
            </button>
        </aside>
    </form>
</div>

@endsection