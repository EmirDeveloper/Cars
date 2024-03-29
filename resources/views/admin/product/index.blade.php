@extends('admin.layouts.app')
@section('title')
    @lang('app.products')
@endsection
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="h4 mb-0 text-primary">
            <i class="bi-box-fill text-primary me-1"></i>
            @lang('app.products')
        </div>
        <div>
            @include('admin.product.filter')
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Image</th>
                <th scope="col" width="15%">Brand & Category</th>
                <th scope="col" width="20%">Full Name</th>
                <th scope="col">Price</th>
                <th scope="col">Viewed</th>
                <th scope="col"><i class="bi-gear-fill"></i></th>
            </tr>
            </thead>
            <tbody>
            @forelse($objs as $obj)
                <tr class="">
                    <td>{{ $obj->id }}</td>
                    <td>
                        <img src="{{ $obj->getImage() }}" alt="{{ $obj->image }}" class="img-fluid rounded"
                             style="max-height:5rem;">
                    </td>
                    <td>
                        <div>
                            <i class="bi-github text-danger me-1"></i>
                            {{ $obj->brand->name }}
                        </div>

                        <div>
                            <i class="bi-grid-fill text-danger me-1"></i>
                            @if($obj->category->parent_id)
                                <span class="text-secondary">{{ $obj->category->parent->getName() }},</span>
                            @endif
                            {{ $obj->category->getName() }}
                        </div>
                    </td>
                    <td>
                        <div class="mb-1">
                            <img src="{{ asset('img/flag/tm.png') }}" alt="Türkmen" width="25" height="15"
                                 class="mb-1">
                            {{ $obj->full_name_tm }}
                        </div>
                        <div class="small">
                            <img src="{{ asset('img/flag/eng.png') }}" alt="English" width="25" height="15"
                                 class="mb-1">
                            {{ $obj->full_name_tm }}
                        </div>
                    </td>
                    <td>
                        <div>
                            {{ $obj->price }}<span class="fw-bold">TMT</span>
                        </div>
                    </td>
                    <td>
                        <!-- <div>
                            <i class="bi-bag-check-fill text-success"></i>
                            {{ $obj->sold }} 
                        </div> -->
                        <div>
                            <i class="bi-binoculars-fill text-danger"></i>
                            {{ $obj->viewed }}
                        </div>
                    </td>
                    <td>
                        <a href="{{ route('admin.products.edit', $obj->id) }}" class="btn btn-success btn-sm my-1">
                            <i class="bi-pencil"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr class="">
                    <td colspan="10" class="text-center">
                        @lang('app.productNotFound')!
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="mb-3">
        {{ $objs->links() }}
    </div>
@endsection
