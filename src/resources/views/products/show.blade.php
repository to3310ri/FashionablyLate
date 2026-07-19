<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >
    <title>商品詳細</title>

    <link
        rel="stylesheet"
        href="{{ asset('css/products.css') }}"
    >
</head>

<body>
    <header class="header">
        <a
            class="header__logo"
            href="{{ route('products.index') }}"
        >
            mogitate
        </a>
    </header>

    <main class="main">
        <div class="detail-page">
            <div class="breadcrumb">
                <a href="{{ route('products.index') }}">
                    商品一覧
                </a>

                <span>＞</span>

                <span>{{ $product->name }}</span>
            </div>

            @if (session('success'))
                <div class="success-message">
                    {{ session('success') }}
                </div>
            @endif

            <form
                class="detail-form"
                action="{{ route('products.update', $product) }}"
                method="POST"
                enctype="multipart/form-data"
                novalidate
            >
                @csrf
                @method('PATCH')

                <div class="detail-form__top">
                    <div class="detail-form__image-area">
                        <img
                            class="detail-form__image"
                            src="{{ asset($product->image) }}"
                            alt="{{ $product->name }}"
                            id="image-preview"
                        >

                        <div class="detail-form__file">
                            <label
                                class="file-button"
                                for="image-input"
                            >
                                ファイルを選択
                            </label>

                            <input
                                class="file-input"
                                type="file"
                                name="image"
                                id="image-input"
                                accept=".png,.jpg,.jpeg"
                            >

                            <span
                                class="detail-form__filename"
                                id="file-name"
                            >
                                {{ basename($product->image) }}
                            </span>
                        </div>

                        @error('image')
                            <p class="form-error">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="detail-form__information">
                        <div class="form-group">
                            <label
                                class="form-group__label"
                                for="name"
                            >
                                商品名
                                <span class="required-label">
                                    必須
                                </span>
                            </label>

                            <input
                                class="form-group__input @error('name') form-group__input--error @enderror"
                                type="text"
                                name="name"
                                id="name"
                                value="{{ old('name', $product->name) }}"
                            >

                            @error('name')
                                <p class="form-error">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label
                                class="form-group__label"
                                for="price"
                            >
                                値段
                                <span class="required-label">
                                    必須
                                </span>
                            </label>

                            <input
                                class="form-group__input @error('price') form-group__input--error @enderror"
                                type="text"
                                name="price"
                                id="price"
                                value="{{ old('price', $product->price) }}"
                            >

                            @error('price')
                                <p class="form-error">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <span class="form-group__label">
                                季節
                                <span class="required-label">
                                    必須
                                </span>

                                <span class="selection-note">
                                    複数選択可
                                </span>
                            </span>

                            <div class="season-list">
                                @foreach (['春', '夏', '秋', '冬'] as $seasonName)
                                    <label class="season-item">
                                        <input
                                            class="season-item__input"
                                            type="checkbox"
                                            name="seasons[]"
                                            value="{{ $seasonName }}"
                                            @checked(
                                                in_array(
                                                    $seasonName,
                                                    old(
                                                        'seasons',
                                                        $product->seasons
                                                            ->pluck('name')
                                                            ->toArray()
                                                    )
                                                )
                                            )
                                        >

                                        <span class="season-item__circle"></span>

                                        <span class="season-item__name">
                                            {{ $seasonName }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>

                            @error('seasons')
                                <p class="form-error">
                                    {{ $message }}
                                </p>
                            @enderror

                            @error('seasons.*')
                                <p class="form-error">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group detail-form__description">
                    <label
                        class="form-group__label"
                        for="description"
                    >
                        商品説明
                        <span class="required-label">
                            必須
                        </span>
                    </label>

                    <textarea
                        class="form-group__textarea @error('description') form-group__input--error @enderror"
                        name="description"
                        id="description"
                    >{{ old('description', $product->description) }}</textarea>

                    @error('description')
                        <p class="form-error">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="detail-form__actions">
                    <a
                        class="button button--back"
                        href="{{ route('products.index') }}"
                    >
                        戻る
                    </a>

                    <button
                        class="button button--save"
                        type="submit"
                    >
                        変更を保存
                    </button>

                    <button
                        class="button button--delete"
                        type="submit"
                        form="delete-form"
                        aria-label="商品を削除"
                        onclick="return confirm('この商品を削除しますか？');"
                    >
                        <svg
                            class="delete-icon"
                            viewBox="0 0 24 24"
                            aria-hidden="true"
                        >
                            <path
                                d="M9 3h6l1 2h4v2H4V5h4l1-2Zm-2 6h10l-.8 11H7.8L7 9Zm3 2v7h2v-7h-2Zm4 0v7h2v-7h-2Z"
                            />
                        </svg>
                    </button>
                </div>
            </form>

            <form
                id="delete-form"
                action="{{ route('products.destroy', $product) }}"
                method="POST"
            >
                @csrf
                @method('DELETE')
            </form>
        </div>
    </main>

    <script>
        const imageInput = document.getElementById('image-input');
        const imagePreview = document.getElementById('image-preview');
        const fileName = document.getElementById('file-name');

        imageInput.addEventListener('change', (event) => {
            const file = event.target.files[0];

            if (!file) {
                return;
            }

            imagePreview.src = URL.createObjectURL(file);
            fileName.textContent = file.name;
        });
    </script>
</body>

</html>