@extends('client.layouts.app')
@section('title')
    {{ $category->getName() }} - @lang('app.app-name')
@endsection
@section('content')
    <div class="container-xl mt-5 pt-5">
        <div class="fs-4 fw-semibold mb-3">
            <a href="{{ route('home') }}" class="text-decoration-none text-light">@lang('app.product')</a> - {{ $category->getName() }}
        </div>
        <div class="row g-3 mb-3">
            @foreach($products as $products)
                <div class="col-6 col-sm-4 col-lg-2 mb-2 p-3">
                    <a href="{{ route('product', $product->slug}}">
                        <img src="{{ asset('img/seasons/season.jpg') }}" alt="{{ $product->name }}" class="img-fluid rounded-4 p-2">
                    </a>
                </div>
            @endforeach
        </div>
        {{ $category->links() }}
    </div>
@endsection