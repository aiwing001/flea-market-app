@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')

<div class="index-page__tab">
    <a
        class=
        "index-page__tab-link {{ $tab !== 'mylist' ? 'index-page__tab-link--active' : ''}}"
        href="/?keyword={{ request('keyword') }}">
        おすすめ
    </a>
    <a
        class=
        "index-page__tab-link {{ $tab === 'mylist' ? 'index-page__tab-link--active' : ''}}"
        href="/?tab=mylist&keyword={{ request('keyword') }}">
        マイリスト
    </a>
</div>

<div class="index-page__content">
    @foreach($items as $item)
    <a class="item-card" href="/item/{{ $item->id }}">
        <div class="item-card__image">
            <img src="{{ asset($item->image) }}" alt="商品画像">
            @if($item->status === 2)
                <div class="item-card__sold">
                    SOLD
                </div>
            @endif
        </div>
        <div class="item-card__name">
            {{ $item->name}}
        </div>
    </a>
    @endforeach
</div>

@endsection