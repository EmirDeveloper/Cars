@extends('client.layouts.app')
@section('title') @lang('app.app-description') @endsection
@section('content')
    <div class="bg-dark bg-opacity-10">
        <div class="justify-content-center align-items-center">
            @include('client.app.slider')
        </div>
        <div class="container-lg">
            @if($new->count() > 0)
                @include('client.home.new')
            @endif
        </div>
    </div>
@endsection