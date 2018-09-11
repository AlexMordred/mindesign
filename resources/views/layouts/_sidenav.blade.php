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