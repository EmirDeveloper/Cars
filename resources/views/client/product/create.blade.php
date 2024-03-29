@extends('client.layouts.app')
@section('title')
    @lang('app.products')
@endsection
@section('content')
    <div class="container-lg mt-5">
        <div class="h4 mb-3">
            <a href="{{ route('product.index') }}" class="text-decoration-none">
                @lang('app.products')
            </a>
            <i class="bi-chevron-right small"></i>
            @lang('app.add')
        </div>

        <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
        @method('POST')
        @csrf
            <div class="row mb-3 pe-4">
                @csrf
                <div class="col-10 col-sm-8 col-md-6 col-lg-4">
                    <div class="mb-3">
                        <label for="brand" class="form-label fw-semibold">
                            Brand
                            <span class="text-danger">*</span>
                        </label>
                        <select class="form-select @error('brand') is-invalid @enderror" name="brand" id="brand" required
                                autofocus>
                            <option value>-</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->getName() }}</option>
                            @endforeach
                        </select>
                        @error('brand')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="category" class="form-label fw-semibold">
                            Category
                            <span class="text-danger">*</span>
                        </label>
                        <select class="form-select @error('category') is-invalid @enderror" name="category" id="category"
                                required>
                            <option value>-</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->getName() }}</option>
                            @endforeach
                        </select>
                        @error('category')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="location" class="form-label fw-semibold">
                            Location
                            <span class="text-danger">*</span>
                        </label>
                        <select class="form-select @error('location') is-invalid @enderror" name="location" id="location"
                                required>
                            <option value>-</option>
                            @foreach($locations as $location)
                                <option value="{{ $location->id }}">{{ $location->getName() }}</option>
                            @endforeach
                        </select>
                        @error('location')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="location" class="form-label fw-semibold">
                            Year
                            <span class="text-danger">*</span>
                        </label>
                        <select class="form-select @error('year') is-invalid @enderror" name="year" id="year"
                                required>
                            <option value>-</option>
                            @foreach($years as $year)
                                <option value="{{ $category->id }}">{{ $year->getName() }}</option>
                            @endforeach
                        </select>
                        @error('year')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label fw-semibold">
                            @lang('app.image')
                        </label>
                        <div class="input-group mb-3">
                            <input type="file" accept="image/jpeg"
                                class="form-control @error('image') is-invalid @enderror"
                                name="images[]" id="image" multiple>
                            <label class="input-group-text" for="image">Upload</label>
                        </div>
                        @error('image')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-10 col-sm-8 col-md-6 col-lg-4">
                    <div class="mb-3">
                        <label for="name_tm" class="form-label fw-semibold">
                            <img src="{{ asset('img/flag/tm.png') }}" alt="Türkmen" height="15" class="mb-1">
                            @lang('app.name')
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('name_tm') is-invalid @enderror" name="name_tm"
                            id="name_tm" value="{{ old('name_tm') }}" required>
                        @error('name_tm')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="name_en" class="form-label fw-semibold">
                            <img src="{{ asset('img/flag/eng.png') }}" alt="English" height="15" class="mb-1">
                            @lang('app.name')
                        </label>
                        <input type="text" class="form-control @error('name_en') is-invalid @enderror" name="name_en"
                            id="name_en" value="{{ old('name_en') }}">
                        @error('name_en')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label fw-semibold">
                            @lang('app.price')
                            <span class="text-danger">*</span>
                        </label>
                        <div class="input-group mb-3">
                            <input type="number" min="0" class="form-control @error('price') is-invalid @enderror"
                                name="price" id="price" value="0" step="0.1" required>
                            <span class="input-group-text">TMT</span>
                        </div>
                        @error('price')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label fw-semibold">
                            @lang('app.phone')
                            <span class="text-danger">*</span>
                        </label>
                        <div class="input-group mb-3">
                        <span class="input-group-text">+993</span>
                            <input type="number" min="60000000" max="65999999" class="form-control @error('phone') is-invalid @enderror"
                                name="phone" id="phone" required>
                        </div>
                        @error('price')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
                <div class="col-10 col-sm-8 col-md-6 col-lg-4">
                    @foreach($attributes as $attribute)
                        <div class="mb-3">
                            <label for="{{ strtolower($attribute->name_en) }}" class="form-label fw-semibold">
                                {{ $attribute->getName() }}
                            </label>
                            <select class="form-select @error('{{ strtolower($attribute->name_en) }}') is-invalid @enderror"
                                    name="{{ strtolower($attribute->name_en) }}"
                                    id="{{ strtolower($attribute->name_en) }}">
                                <option value>-</option>
                                @foreach($attribute->values as $attributeValue)
                                    <option value="{{$attributeValue->id}}">{{ $attributeValue->getName() }}</option>
                                @endforeach
                            </select>
                            @error('{{ strtolower($attribute->name_en) }}')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    @endforeach
                    <div class="mb-3">
                        <label for="price" class="form-label fw-semibold">
                            @lang('app.description')
                            <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                            name="description" id="description">
                        </textarea>
                        @error('description')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-3 mt-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="credit" id="credit" value="1">
                                <label class="form-check-label" for="credit">
                                    @lang('app.credit')
                                </label>
                                @error('credit')
                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3 mt-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="swap" id="swap" value="1">
                                <label class="form-check-label" for="swap">
                                    @lang('app.swap')
                                </label>
                                @error('swap')
                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div> 
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">
                    @lang('app.add')
                </button>
            </div>
        </form>
    </div>
@endsection