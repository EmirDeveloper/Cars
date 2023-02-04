@extends('admin.layouts.app')
@section('title')
    @lang('app.verifications')
@endsection
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="h4 mb-0 text-primary">
            <i class="bi-shield-fill-check text-primary me-1"></i>
            @lang('app.verifications')
        </div>
        <div>
            @include('admin.verification.filter')
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-striped">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Phone</th>
                <th scope="col">Code</th>
                <th scope="col">Status</th>
                <th scope="col">Created at</th>
                <th scope="col">Updated at</th>
            </tr>
            </thead>
            <tbody>
            @foreach($objs as $obj)
                <tr>
                    <td>{{ $obj->id }}</td>
                    <td>
                        <div>
                            <i class="bi-telephone-fill text-success"></i>
                            <a href="tel:+993{{ $obj->phone }}" class="text-decoration-none">
                                +993 {{ $obj->phone }}
                            </a>
                        </div>
                    </td>
                    <td>
                        <div>
                            <div class="fw-fs-6">
                                {{ $obj->code }}
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="mb-1">
                            <span class="badge text-bg-{{ $obj->statusColor() }}">{{ $obj->status() }}</span>
                        </div>
                    </td>
                    <td>
                        <div>
                            <div class="fs-6">
                                {{ $obj->created_at }}
                            </div>
                        </div>
                    </td>
                    <td>
                        <div>
                            <div class="fs-6">
                                {{ $obj->updated_at }}
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection