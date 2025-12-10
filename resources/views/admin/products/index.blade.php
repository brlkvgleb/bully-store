@extends('layouts.app')

@section('title', 'Админка — Товары')

@section('content')

    <h1>Управление товарами</h1>

    <a href="{{ route('admin.products.create') }}" class="btn">Добавить товар</a>

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

                <p style="color:#555; margin-top:8px; text-overflow: ellipsis;">
                    {{ $product->description }}
                </p>

                <div>
                    <a href="{{ route('admin.products.show', $product->id) }}" class="btn">Просмотр</a>

                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn " >Редактировать</a>

                    <form action="{{ route('admin.products.destroy', $product->id) }}"
                          method="POST"
                          style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-btn">Удалить</button>
                    </form>
                </div>

            </div>
        @endforeach
    </div>

    <div style="margin-top:20px;">
        {{ $products->links() }}
    </div>

@endsection
