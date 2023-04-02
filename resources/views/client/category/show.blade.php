@extends('client.layouts.app')
@section('title')
    {{ $category->getName() }} - @lang('app.app-name')
@endsection
@section('content')
    <div class="container-xl mt-5 pt-5">
        <div class="fs-4 fw-semibold mb-3">
            <a href="{{ route('home') }}" class="text-decoration-none text-dark">@lang('app.product')</a> - {{ $category->getName() }}
        </div>
        <div class="row g-3 mb-3">
            @foreach($products as $product)
                <div class="col-6 col-sm-4 col-lg-3 mb-2 p-3">
                    @include('client.app.product')
                </div>
            @endforeach
        </div>
        {{ $products->links() }}
    </div>
@endsection