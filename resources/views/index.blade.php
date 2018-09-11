@extends('layouts.app')

@section('content')
    <h1>20 самых популярных товаров</h1>

    @foreach ($popular as $product)
    <div>
        {{ $loop->index + 1 }}. <b>(id = {{ $product->id }})</b> {{ $product->title }} - <b>{{ $product->popularity }} продаж</b>
    </div>
    @endforeach
@endsection