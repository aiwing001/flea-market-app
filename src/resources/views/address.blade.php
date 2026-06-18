@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/address.css') }}">
@endsection

@section('content')

<div class="address-update__title">
    <h1 class="page-title">
        住所の変更
    </h1>
</div>

<form class="address-form" action="/purchase/address/{{ $item_id }}" method="POST">
    @csrf
    <input type="hidden" name="payment_method" value="{{ request('payment_method') }}">
    <div class="address-form__group">
        <div class="address-form__title">
            郵便番号
        </div>
        <div class="address-form__input">
            <input type="text" name="postal_code" value="{{ old('postal_code', Auth::user()->postal_code) }}">
        </div>
        @error('postal_code')
            <p class="error-message">{{ $message }}</p>
        @enderror
    </div>
    <div class="address-form__group">
        <div class="address-form__title">
            住所
        </div>
        <div class="address-form__input">
            <input type="text" name="address" value="{{ old('address', Auth::user()->address) }}">
        </div>
        @error('address')
            <p class="error-message">{{ $message }}</p>
        @enderror
    </div>
    <div class="address-form__group">
        <div class="address-form__title">
            建物名
        </div>
        <div class="address-form__input">
            <input type="text" name="building" value="{{ old('building', Auth::user()->building) }}">
        </div>
    </div>
    <div class="address-form__button">
        <button class="address-form__button--submit" type="submit">
            更新する
        </button>
    </div>
</form>

@endsection