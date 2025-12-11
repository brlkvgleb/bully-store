@extends('layouts.app')

@section('title', 'Создать товар')

@section('content')
    <div class="container">

        <div class="form-box">
            <h1>Создать товар</h1>

            @if ($errors->any())
                <div class="error-box">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.products.store') }}"
                method="POST"
                enctype="multipart/form-data">

                @csrf

                <div class="form-group" style="margin-bottom:18px;">
                    <label>Название</label>
                    <input type="text" name="name" value="{{ old('name') }}">
                </div>

                <div class="form-group" style="margin-bottom:18px;">
                    <label>Описание</label>
                    <textarea name="description">{{ old('description') }}</textarea>
                </div>

                <div class="form-group" style="margin-bottom:18px;">
                    <label>Цена</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price') }}">
                </div>

                <div class="form-group" style="margin-bottom:18px;">
                    <label>Категория</label>
                    <select name="category_id">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @if(old('category_id') == $category->id) selected @endif>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group" style="margin-bottom:18px;">
                    <label>Изображения</label>
                    <input type="file" name="images[]" accept="image/*" multiple id="imagesInput">

                    <div id="preview" class="preview-container"></div>
                </div>

                <button type="submit" class="btn">Сохранить</button>
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
            ← Вернуться к списку

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
