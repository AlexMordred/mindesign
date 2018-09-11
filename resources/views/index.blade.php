@extends('layouts.app')

@section('content')
<div class="content">
    <div class="flex-1 sidenav">
        <b>Категории</b>
    </div>

    <div class="flex-3">
        <h1>20 самых популярных товаров</h1>

        @foreach ($popular as $product)
            <div>
                {{ $loop->index + 1 }}. <b>(id = {{ $product->id }})</b> {{ $product->title }} - <b>{{ $product->popularity }} продаж</b>
            </div>
        @endforeach
    </div>
</div>
@endsection