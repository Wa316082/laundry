@extends('layouts.auth.body')
@section('title', '| roles | assign')
@section('content')
    <section class="container-fluid mt-5 ">
        <div class="card table-responsive mb-4">
            <div class="card-header d-flex justify-content-between">
                <div><i class="fas fa-table me-1"></i>
                    Role assign</div>
                <div>
                    <a class="btn btn-info btn-sm" href="{{ route('roles') }}">Back</a>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-3 fs-5">
                    Role Name: {{ $role->name }}
                </div>
                <form action="{{ route('role.permission.store', $role->id) }}" method="POST" class="row">
                    @csrf
                    @foreach ($permissions as $permission)
                        <div class="col-xl-4 col-6 mb-4">
                            <input type="checkbox" value="{{ $permission->name }}" id="{{ $permission->name }}" name="permission[]" {{ ($permission->permitted == 1)? 'checked' : '' }}>
                            <label for="{{ $permission->name }}">{{ $permission->name }}</label>
                        </div>
                    @endforeach
                    <div>
                        <button type="submit" class="btn btn-sm btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
