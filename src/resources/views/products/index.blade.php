<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >
    <title>商品一覧</title>

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
        @if (session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        <div class="page-heading">
            <h1 class="page-heading__title">
                @if (request('keyword'))
                    “{{ request('keyword') }}”の商品一覧
                @else
                    商品一覧
                @endif
            </h1>

            <a
                class="page-heading__add"
                href="{{ route('products.create') }}"
            >
                ＋ 商品を追加
            </a>
        </div>

        <div class="products-layout">
            <aside class="sidebar">
                <form
                    class="search-form"
                    action="{{ route('products.index') }}"
                    method="GET"
                >
                    <input
                        class="search-form__input"
                        type="text"
                        name="keyword"
                        value="{{ request('keyword') }}"
                        placeholder="商品名で検索"
                    >

                    <button
                        class="search-form__button"
                        type="submit"
                    >
                        検索
                    </button>

                    <div class="sort-area">
                        <h2 class="sort-area__title">
                            価格順で表示
                        </h2>

                        <select
                            class="sort-area__select"
                            name="sort"
                            onchange="this.form.submit()"
                        >
                            <option value="">
                                価格で並べ替え
                            </option>

                            <option
                                value="high"
                                @selected(request('sort') === 'high')
                            >
                                高い順に表示
                            </option>

                            <option
                                value="low"
                                @selected(request('sort') === 'low')
                            >
                                低い順に表示
                            </option>
                        </select>

                        @if (request('sort'))
                            <div class="sort-tag">
                                <span>
                                    {{ request('sort') === 'high'
                                        ? '高い順に表示'
                                        : '低い順に表示' }}
                                </span>

                                <a
                                    class="sort-tag__remove"
                                    href="{{ route(
                                        'products.index',
                                        request()->except('sort', 'page')
                                    ) }}"
                                    aria-label="並び替えを解除"
                                >
                                    ×
                                </a>
                            </div>
                        @endif
                    </div>
                </form>
            </aside>

            <section class="products">
                @if ($products->count())
                    <div class="product-grid">
                        @foreach ($products as $product)
                            <a
                                class="product-card"
                                href="{{ route('products.show', $product) }}"
                            >
                                <img
                                    class="product-card__image"
                                    src="{{ asset($product->image) }}"
                                    alt="{{ $product->name }}"
                                >

                                <div class="product-card__body">
                                    <h2 class="product-card__name">
                                        {{ $product->name }}
                                    </h2>

                                    <p class="product-card__price">
                                        ¥{{ number_format($product->price) }}
                                    </p>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <div class="pagination">
                        {{ $products->links() }}
                    </div>
                @else
                    <p class="products__empty">
                        該当する商品はありません。
                    </p>
                @endif
            </section>
        </div>
    </main>
</body>

</html>