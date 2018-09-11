<div>
    <p>
        <b>Поиск товаров</b>
    </p>

    <p>
        @if (isset($searchQuery))
            <v-search-form data-query="{{ $searchQuery }}"></v-search-form>
        @else
            <v-search-form></v-search-form>
        @endif
    </p>
</div>

<div>
    <p>
        <b>Меню</b>
    </p>

    <p>
        <a href="{{ route('home') }}">Главная</a>
    </p>

    <b>Категории</b>

    @foreach ($categories as $category)
        <p class="category">
            <a href="{{ route('products', $category) }}"
                class="{{ isset($selectedCategory) && $selectedCategory->id == $category->id ? 'active' : '' }}"
            >
                {{ $category->title }}
            </a>

            @foreach ($category->children as $child)
                <p class="subcategory">
                    <a href="{{ route('products', $child) }}" class="{{ isset($selectedCategory) && $selectedCategory->id == $child->id ? 'active' : '' }}">
                        {{ $child->title }}
                    </a>
                </p>
            @endforeach
        </p>
    @endforeach
</div>