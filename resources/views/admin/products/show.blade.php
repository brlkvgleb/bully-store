@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <div class="container">

        <div class="product-show-box no-hover"
             style="
                background:#fff;
                border-radius:14px;
                padding:25px;
                border:1px solid #cfcfcf;
                box-shadow:0 2px 8px rgba(0,0,0,0.06);
             ">

            @if($product->images->count())
                @php
                    $firstImage = asset('storage/' . $product->images->first()->path);
                @endphp

                <div style="margin-bottom:20px;">

                    <img id="mainImage"
                         src="{{ $firstImage }}"
                         alt="{{ $product->name }}"
                         style="
                             width:100%;
                             max-height:420px;
                             object-fit:contain;
                             border-radius:12px;
                             border:1px solid #ddd;
                             margin-bottom:12px;
                         ">

                    <div style="
                        display:flex;
                        gap:12px;
                        overflow-x:auto;
                        padding-bottom:5px;
                    ">
                        @foreach($product->images as $img)
                            <img src="{{ asset('storage/' . $img->path) }}"
                                 onclick="document.getElementById('mainImage').src=this.src"
                                 style="
                                     width:80px;
                                     height:80px;
                                     object-fit:cover;
                                     border-radius:8px;
                                     border:2px solid #ccc;
                                     cursor:pointer;
                                     transition:0.2s;
                                 "
                                 onmouseover="this.style.borderColor='#409cff'"
                                 onmouseout="this.style.borderColor='#ccc'">
                        @endforeach
                    </div>

                </div>
            @endif

            <h1 style="margin-bottom:10px;">
                {{ $product->name }}
            </h1>

            <h2 style="margin-bottom:10px; font-size:20px; font-weight: bold;">
            Категория - {{ $product->category->name }}
            </h2>

            <p>{{ $product->description }}</p>

            <div style="
                display:flex;
                justify-content:space-between;
                align-items:center;
                margin-top:25px;
            ">

                <span style="font-size:20px; font-weight:700; color:var(--primary);">
                    {{ number_format($product->price, 2, '.', ' ') }} ₸
                </span>

                <div style="display:flex; gap:10px;">

                    <a href="{{ route('admin.products.edit', $product->id) }}"
                       class="btn btn-green">
                        Редактировать
                    </a>

                    <form action="{{ route('admin.products.destroy', $product->id) }}"
                          method="POST"
                          onsubmit="return confirm('Удалить этот товар?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-btn">
                            Удалить
                        </button>
                    </form>

                </div>

            </div>
        </div>

        <a href="{{ route('admin.products.index') }}"
           style="
               display:block;
               margin-top:20px;
               color:var(--primary);
               font-weight:600;
               text-decoration:none;
           ">
            ← Вернуться к списку
        </a>

    </div>

@endsection
