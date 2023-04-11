@extends('client.layouts.app')
@section('title')
    {{ $product->getName() }} - @lang('app.app-name')
@endsection
@section('content')
    <div class="container-xl py-4">
        <div class="row g-4 mb-4">
            <div class="col-10 col-sm-8 col-md-6 col-lg-4">
                <div class="d-flex">
                    <img src="{{  $product->image ? Storage::url('products/' . $product->image) : asset('img/product.jpg') }}"
                        alt="{{ $product->getFullName() }}" class="img-fluid border rounded">
                </div>
            </div>
            <div class="col">
                <div class="mb-2">
                    <span class="fs-5 fw-semibold">{{ $product->getFullName() }}</span>
                    @auth
                        <a href="" class="link-success"><i class="bi-pencil-square"></i></a>
                        <a href="#" class="link-secondary" data-bs-toggle="modal" data-bs-target="#delete-{{ $product->id }}"><i class="bi-trash"></i></a>
                        <div class="modal fade" id="delete-{{ $product->id }}" tabindex="-1" aria-labelledby="delete-{{ $product->id }}-label" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <div class="modal-title fw-semibold" id="delete-{{ $product->id }}-label">@lang('app.delete')</div>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">{{ $product->getFullName() }}</div>
                                </div>
                            </div>
                        </div>
                    @endauth
                </div>
                <div>
                    @if($product->location)
                        <div class="fs-4 fw-semibold">
                            <span class="text-primary mb-2">Ýeri: </span> {{ $product->location->getName() }}
                        </div>
                    @endif
                    @if($product->category)
                        <div class="fs-4 fw-semibold">
                            <span class="text-primary mb-2">Kategoriýa: </span> {{ $product->category->getName() }}
                        </div>
                    @endif
                </div>
                <div class="fs-4 fw-semibold">
                    <span class="text-primary mb-2">Bahasy: </span> {{ number_format($product->price, 2, '.', ' ') }}
                    <small>TMT</small>
                </div>
                <div>
                    @if($product->phone)
                        <div class="mb-2">
                            <span class="fs-4 fw-semibold text-primary mb-2">Telefony: </span><span class="fs-4 fw-semibold">+993 {{ $product->phone }}</span>
                        </div>
                    @endif
                </div>
                <div>
                    @if($product->motor)
                        <div class="mb-2">
                            <span class="fs-4 fw-semibold text-primary">Motory: </span> <span class="fs-4 fw-semibold">{{ $product->motor->name_tm }}</span> 
                        </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col-2">
                        @if($product->credit)
                            <div class="m-2">
                                <span class="d-inline-block small text-bg-success bg-opacity-75 rounded py-1 px-2">
                                    <i class="bi-check-circle-fill"></i> @lang('app.credit')
                                </span>
                            </div>
                        @else
                            <div class="m-2">
                                <span class="d-inline-block small text-bg-danger bg-opacity-75 rounded py-1 px-2">
                                    <i class="bi-x-square"></i> @lang('app.credit')
                                </span>
                            </div>
                        @endif
                    </div>
                    <div class="col-3">
                        @if($product->swap)
                            <div class="m-2">
                                <span class="d-inline-block small text-bg-success bg-opacity-75 rounded py-1 px-2">
                                    <i class="bi-check-circle-fill"></i> @lang('app.swap')
                                </span>
                            </div>
                        @else
                        <div class="m-2">
                                <span class="d-inline-block small text-bg-danger bg-opacity-75 rounded py-1 px-2">
                                    <i class="bi-x-square"></i> @lang('app.swap')
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
                <div>
                    @if($product->viewed)
                        <i class="bi-eye fs-4 fw-semibold text-primary mb-2">{{ $product->viewed }}</i>
                    @endif
                </div>
                <div>
                    @if($product->description)
                        <div class="mb-2">
                            <span class="h6 fw-bold">@lang('app.description'): </span>{{ $product->description }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @if($products->count() > 0)
            @include('client.product.products')
        @endif
    </div>
@endsection