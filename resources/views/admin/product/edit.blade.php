@extends('admin.layouts.app')
@section('title')
    @lang('app.products')
@endsection
@section('content')
    <div class="h4 mb-3">
        <a href="{{ route('admin.products.index') }}" class="text-decoration-none">
            @lang('app.products')
        </a>
        <i class="bi-chevron-right small"></i>
        @lang('app.edit')
    </div>
@endsection