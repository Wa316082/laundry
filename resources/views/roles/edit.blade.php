@extends('layouts.auth.body')
@section('title', '| roles | edit')
@section('content')
    <section class="container-fluid mt-5 ">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between">
                <div><i class="fas fa-table me-1"></i>Role Edit</div>
            </div>
            <div class="card-body">
                <form action="{{ route('role.update', $role->id) }}" method="POST" class="row">
                    @csrf
                    @method('PUT')
                    <div class="col-6 mb-4">
                        <input type="text" name="name" class="form-control" placeholder="Role name" value="{{ old('name', $role->name) }}"
                            aria-label="First name">
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
