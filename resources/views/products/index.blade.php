@extends('layouts.app')

@section('title', 'Товары')

@section('content')

    <h1>Каталог товаров</h1>

    <div class="card-grid">
        @foreach($products as $product)
            <div class="card">

                @php
                    $mainImage = $product->images->firstWhere('is_main', true);
                @endphp

                @if($mainImage)
                    <img src="{{ asset('storage/' . $mainImage->path) }}" alt="{{ $product->name }}">
                @else
                    <img src="https://via.placeholder.com/300x200?text=No+Image" alt="Нет изображения">
                @endif

                <h2>{{ $product->name }}</h2>

                <p class="price">{{ number_format($product->price, 2, '.', ' ') }} ₸</p>

                <p class="desc">
                    {{ Str::limit($product->description, 120) }}
                </p>

                <div>
                    <a href="{{ route('products.show', $product->id) }}" class="btn">
                        Подробнее
                    </a>
                </div>

            </div>
        @endforeach
    </div>

    <div style="margin-top:20px;">
        {{ $products->links() }}
    </div>

@endsection
