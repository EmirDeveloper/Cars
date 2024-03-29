@extends('client.layouts.app')
@section('title')
    @lang('app.login') - @lang('app.app-name')
@endsection
@section('content')
    <div class="container-xl py-4">
        <div class="row justify-content-center">
            <div class="col-10 col-sm-6 col-md-4 col-lg-3 col-xxl-2">
                <div class="bg-light text-white rounded-3 p-3" style="--bs-bg-opacity: 0.15;">
                    <form action="{{ route('login') }}" method="post">
                        @csrf

                        <div class="mb-3">
                            <label for="phone" class="form-label fw-semibold text-dark">
                                @lang('app.phone')
                                <span class="text-danger">*</span>
                            </label>
                            <input type="number" min="60000000" max="65999999" class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone" value="{{ $phone }}" required>
                            @error('phone')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="code" class="form-label fw-semibold text-dark">
                                @lang('app.code')
                                <span class="text-danger">*</span>
                            </label>
                            <input type="number" min="10000" max="99999" class="form-control @error('code') is-invalid @enderror" name="code" id="code" value="{{ old('code') }}" required autofocus>
                            @error('code')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            @lang('app.login')
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection