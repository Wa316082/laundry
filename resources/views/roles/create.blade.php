@extends('layouts.auth.body')
@section('title', '| roles | create')
@section('content')
<section class="container-fluid mt-5 ">
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between">
            <div><i class="fas fa-table me-1"></i>Role Create</div>
            <div>
                <a class="btn btn-info btn-sm" href="{{ route('roles') }}">Roles</a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('role.store') }}" method="POST" class="row">
                @csrf
                <div class="col-6 mb-4">
                  <input type="text" name="name" class="form-control" placeholder="Role name" aria-label="First name">
                  @error('name')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>
                <div>
                    <button type="submit" class="btn btn-sm btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
