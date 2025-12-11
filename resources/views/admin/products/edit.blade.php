@extends('layouts.app')

@section('title', 'Редактировать — ' . $product->name)

@section('content')
    <div class="container">

        <div class="form-box">
            <h1>Редактировать товар</h1>

            @if ($errors->any())
                <div class="error-box">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.products.update', $product->id) }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="form-group" style="margin-bottom:18px;">
                    <label>Название</label>
                    <input type="text"
                           name="name"
                           value="{{ old('name', $product->name) }}">
                </div>

                <div class="form-group" style="margin-bottom:18px;">
                    <label>Описание</label>
                    <textarea name="description">{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="form-group" style="margin-bottom:18px;">
                    <label>Цена</label>
                    <input type="number"
                           step="0.01"
                           name="price"
                           value="{{ old('price', $product->price) }}">
                </div>

                <div class="form-group" style="margin-bottom:18px;">
                    <label>Категория</label>
                    <select name="category_id">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <h3 style="margin: 25px 0 10px;">Текущие изображения</h3>

                @if($product->images->count())
                    <div style="
                        display:flex;
                        gap:14px;
                        flex-wrap:wrap;
                        margin-bottom:20px;
                    ">
                        <style>
                            .img-wrap {
                                position: relative;
                                width: 120px;
                                height: 120px;
                            }

                            .img-wrap img {
                                width: 100%;
                                height: 100%;
                                object-fit: cover;
                                border-radius: 10px;
                                border: 1px solid #ddd;
                            }

                            .img-delete-btn {
                                position: absolute;
                                top: 6px;
                                right: 6px;
                                background: rgba(0, 0, 0, 0.55);
                                color: #fff;
                                width: 22px;
                                height: 22px;
                                border-radius: 50%;
                                font-size: 16px;
                                line-height: 22px;
                                text-align: center;
                                cursor: pointer;
                                opacity: 0;
                                transition: 0.25s;
                            }

                            .img-wrap:hover .img-delete-btn {
                                opacity: 1;
                            }

                            .img-delete-btn.active {
                                background: #d63031;
                            }
                        </style>

                        <div style="
                            display:flex;
                            gap:14px;
                            flex-wrap:wrap;
                            margin-bottom:20px;
                        ">
                            @foreach($product->images as $img)
                                <div class="img-wrap">
                                    <img src="{{ asset('storage/' . $img->path) }}" alt="img">

                                    <div class="img-delete-btn" onclick="toggleDelete({{ $img->id }}, this)">×</div>
                                    <input type="checkbox" name="delete_images[]" value="{{ $img->id }}" id="delete_{{ $img->id }}" style="display:none;">

                                    <div style="position:absolute; bottom:6px; left:6px; background: rgba(255,255,255,0.8); padding:2px 6px; border-radius:4px;">
                                        <label style="cursor:pointer;">
                                            <input type="radio" name="main_image" value="{{ $img->id }}" {{ $img->is_main ? 'checked' : '' }}>
                                            Главное
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <script>
                            function toggleDelete(id, el) {
                                const checkbox = document.getElementById('delete_' + id);

                                checkbox.checked = !checkbox.checked;
                                el.classList.toggle('active');
                            }
                        </script>

                    </div>
                @else
                    <p>Изображений пока нет.</p>
                @endif

                <div class="form-group" style="margin-bottom:18px;">
                    <label>Добавить новые изображения</label>
                    <input type="file" name="images[]" accept="image/*" multiple id="imagesInput">

                    <div id="preview" class="preview-container"></div>
                </div>

                <button type="submit" class="btn">Сохранить изменения</button>
            </form>
        </div>

        <a href="{{ route('admin.products.index') }}"
           style="
               display:block;
               margin-top:20px;
               color:var(--primary);
               font-weight:600;
               text-decoration:none;
           ">
            ← Назад к списку
        </a>

    </div>

    <script>
        document.getElementById('imagesInput').addEventListener('change', function (event) {
            const preview = document.getElementById('preview');
            preview.innerHTML = "";
            [...event.target.files].forEach(file => {
                const reader = new FileReader();
                reader.onload = e => {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('preview-img');
                    preview.appendChild(img);
                };
                reader.readAsDataURL(file);
            });
        });
    </script>
@endsection
