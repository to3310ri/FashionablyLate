<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >
    <title>商品登録</title>

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

                <span>商品登録</span>
            </div>

            <h1 class="register-title">
                商品登録
            </h1>

            <form
                class="detail-form"
                action="{{ route('products.store') }}"
                method="POST"
                enctype="multipart/form-data"
                novalidate
            >
                @csrf

                <div class="detail-form__top">
                    <div class="detail-form__image-area">
                        <div
                            class="detail-form__image"
                            id="image-placeholder"
                            style="
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                color: #999;
                                background: #eeeeee;
                            "
                        >
                            画像を選択してください
                        </div>

                        <img
                            class="detail-form__image"
                            src=""
                            alt="選択した商品画像"
                            id="image-preview"
                            style="display: none;"
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
                                選択されていません
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
                                value="{{ old('name') }}"
                                placeholder="商品名を入力"
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
                                value="{{ old('price') }}"
                                placeholder="値段を入力"
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
                                @foreach ($seasons as $season)
                                    <label class="season-item">
                                        <input
                                            class="season-item__input"
                                            type="checkbox"
                                            name="seasons[]"
                                            value="{{ $season->name }}"
                                            @checked(
                                                in_array(
                                                    $season->name,
                                                    old('seasons', [])
                                                )
                                            )
                                        >

                                        <span class="season-item__circle"></span>

                                        <span class="season-item__name">
                                            {{ $season->name }}
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
                        placeholder="商品の説明を入力"
                    >{{ old('description') }}</textarea>

                    @error('description')
                        <p class="form-error">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="detail-form__actions register-actions">
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
                        登録
                    </button>
                </div>
            </form>
        </div>
    </main>

    <script>
        const imageInput = document.getElementById('image-input');
        const imagePreview = document.getElementById('image-preview');
        const imagePlaceholder = document.getElementById('image-placeholder');
        const fileName = document.getElementById('file-name');

        imageInput.addEventListener('change', (event) => {
            const file = event.target.files[0];

            if (!file) {
                imagePreview.src = '';
                imagePreview.style.display = 'none';
                imagePlaceholder.style.display = 'flex';
                fileName.textContent = '選択されていません';

                return;
            }

            imagePreview.src = URL.createObjectURL(file);
            imagePreview.style.display = 'block';
            imagePlaceholder.style.display = 'none';
            fileName.textContent = file.name;
        });
    </script>
</body>

</html>