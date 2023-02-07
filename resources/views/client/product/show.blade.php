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
                        @if($product->isOwner())
                            <a href="{{ route('products.edit', $product->id) }}" class="link-success"><i class="bi-pencil-square"></i></a>
                            <a href="#" class="link-secondary" data-bs-toggle="modal" data-bs-target="#delete-{{ $product->id }}"><i class="bi-trash"></i></a>
                            <div class="modal fade" id="delete-{{ $product->id }}" tabindex="-1" aria-labelledby="delete-{{ $product->id }}-label" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <div class="modal-title fw-semibold" id="delete-{{ $product->id }}-label">@lang('app.delete')</div>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">{{ $product->getFullName() }}</div>
                                        <div class="modal-footer">
                                            <form action="{{ route('products.delete', $product->id) }}" method="post">
                                                @method('DELETE')
                                                @csrf
                                                <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">@lang('app.close')</button>
                                                <button type="submit" class="btn btn-dark btn-sm"><i class="bi-trash"></i> @lang('app.delete')</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <a href="{{ route('cart.add', $product->id) }}" class="btn btn-sm mb-3">
                            <i class="bi-cart-plus-fill h4 text-danger"></i>
                        </a>
                    @endauth
                </div>
                @if($product->brand->image)
                    <div class="my-3">
                        <img src="{{ Storage::url('brands/' . $product->brand->image) }}" alt="{{ $product->brand->getName() }}" class="img-fluid bg-dark rounded shadow p-2">
                    </div>
                @endif
                <div class="fs-4 fw-semibold text-primary mb-2">
                    {{ number_format($product->price, 2, '.', ' ') }}
                    <small>TMT</small>
                </div>
                @if($product->description)
                    <div class="mb-2">
                        {{ $product->description }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection