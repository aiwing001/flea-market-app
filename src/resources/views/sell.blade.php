@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('content')
<div class="sell">
    <div class="sell__title">
        <h1 class="page-title">
            商品の出品
        </h1>
    </div>

    <form class="sell-form" action="/sell" method="POST" enctype="multipart/form-data">
        @csrf
        {{-- 商品画像 --}}
        <div class="sell-form__group">
            <div class="sell-form__title">
                商品画像
            </div>
                @error('image')
                    <p class="sell-form__error">
                        {{ $message }}
                    </p>
                @enderror
            <label class="sell-form__image-button">
                画像を選択する
                <input type="file" name="image" hidden>
            </label>
        </div>
        {{-- 商品の詳細 --}}
        <div class="sell-form__section">
            <h2 class="sell-form__section-title">
                商品の詳細
            </h2>
            <div class="sell-form__group">
                <div class="sell-form__title">
                    カテゴリー
                </div>
                <div class="sell-form__categories">
                    @foreach($categories as $category)
                    <label>
                        <input type="checkbox" name="categories[]" value="{{ $category->id }}">
                        {{ $category->name }}
                    </label>
                    @endforeach
                </div>
                @error('categories')
                    <p class="sell-form__error">
                        {{ $message }}
                    </p>
                @enderror
            </div>
            {{-- 商品の状態 --}}
            <div class="sell-form__group">
                <div class="sell-form__title">
                    商品の状態
                </div>
                <select name="condition">
                    <option value="">選択してください</option>
                    <option value="1">良好</option>
                    <option value="2">目立った傷や汚れなし</option>
                    <option value="3">やや傷や汚れあり</option>
                    <option value="4">状態が悪い</option>
                </select>
                @error('condition')
                    <p class="sell-form__error">
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>
        {{-- 商品名と説明 --}}
        <div class="sell-form__section">
            <h2 class="sell-form__section-title">
                商品名と説明
            </h2>
            <div class="sell-form__group">
                <div class="sell-form__title">商品名</div>
                <input type="text" name="name">
                @error('name')
                    <p class="sell-form__error">
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div class="sell-form__group">
                <div class="sell-form__title">ブランド名</div>
                <input type="text" name="brand">
                @error('brand')
                    <p class="sell-form__error">
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div class="sell-form__group">
                <div class="sell-form__title">商品の説明</div>
                <textarea name="description"></textarea>
                @error('description')
                    <p class="sell-form__error">
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div class="sell-form__group">
                <div class="sell-form__title">販売価格</div>
                <div class="sell-form__price">
                    <span>￥</span>
                    <input type="text" name="price">
                </div>
                @error('price')
                    <p class="sell-form__error">
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>
        {{-- ボタン --}}
        <div class="sell-form__button">
            <button class="sell-form__button-submit" type="submit">
                出品する
            </button>
        </div>
    </form>
</div>

@endsection