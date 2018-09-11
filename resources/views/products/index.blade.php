@extends('layouts.app')

@section('content')
    <h1>Товары в категории {{ $selectedCategory->title }}</h1>

    @foreach ($products as $product)
        <div class="product-card">
            @if ($product->image)
                <div class="product-card-image">
                    <img src="{{ $product->image }}" alt="{{ $product->title }}">
                </div>
            @endif

            <div>
                <h4>{{ $product->title }}</h4>

                {{ $product->description }}
                
                <p>Цена: {{ $product->price }} руб.</p>
            </div>
        </div>
    @endforeach

    {{ $products->links() }}
@endsection