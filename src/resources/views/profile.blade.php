@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')


<div class="profile__title">
    <h1 class="page-title">
        プロフィール設定
    </h1>
</div>

<form class="profile-form" action="/mypage/profile" method="POST" enctype="multipart/form-data">
    @csrf
    {{-- 画像 --}}
    <div class="profile-form__group">
        <div class="profile-form__image">
            <img
                class="profile-form__image--preview"
                src="{{ asset('images/default-icon.png') }}"
                >
            <label class="profile-form__image--button">
                画像を選択する
                <input type="file" name="image" hidden>
            </label>
            @error('image')
                <p class="profile-form__error">
                    {{ $message }}
                </p>
            @enderror
        </div>
    </div>
    {{-- ユーザー名 --}}
    <div class="profile-form__group">
        <div class="profile-form__title">
            ユーザー名
        </div>
        <div class="profile-form__input">
            <input type="text" name="name"
                value="{{ old('name', auth()->user()->name) }}">
            @error('name')
                <p class="profile-form__error">
                    {{ $message }}
                </p>
            @enderror
        </div>
    </div>
    {{-- 郵便番号 --}}
    <div class="profile-form__group">
        <div class="profile-form__title">
            郵便番号
        </div>
        <div class="profile-form__input">
            <input type="text" name="postal_code"
                value="{{ old('postal_code', auth()->user()->postal_code )}}">
            @error('postal_code')
                <p class="profile-form__error">
                    {{ $message }}
                </p>
            @enderror
        </div>
    </div>
    {{-- 住所 --}}
    <div class="profile-form__group">
        <div class="profile-form__title">
            住所
        </div>
        <div class="profile-form__input">
            <input type="text" name="address"
                value="{{ old('address', auth()->user()->address) }}">
            @error('address')
                <p class="profile-form__error">
                    {{ $message }}
                </p>
            @enderror
        </div>
    </div>
    {{-- 建物名 --}}
    <div class="profile-form__group">
        <div class="profile-form__title">
            建物名
        </div>
        <div class="profile-form__input">
            <input type="text" name="building"
                value="{{ old('building', auth()->user()->building) }}">
        </div>
    </div>
    <div class="profile-form__button">
        <button class="profile-form__button-submit" type="submit">
            更新する
        </button>
    </div>
</form>

@endsection