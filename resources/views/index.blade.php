@extends('layouts.app')

@section('content')
    <h1>20 самых популярных товаров</h1>

    @foreach ($popular as $product)
    <div>
        <div class="product-card">
            @if ($product->image)
                <div class="product-card-image">
                    <img src="{{ $product->image }}" alt="{{ $product->title }}">
                </div>
            @endif
        
            <div>
                <h4>{{ $loop->index + 1 }}. {{ $product->title }} ({{ $product->popularity }} продаж)</h4>
        
                {{ $product->description }}
        
                <p>Цена: {{ $product->price }} руб.</p>
            </div>
        </div>
    </div>
    @endforeach
@endsection