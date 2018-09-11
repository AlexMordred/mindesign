<b>Категории</b>

@foreach ($categories as $category)

    <p>
        <a href="#">{{ $category->title }}</a>

        @foreach ($category->children as $child)
            <p class="subcategory">
                <a href="">{{ $child->title }}</a>
            </p>
        @endforeach
    </p>

@endforeach