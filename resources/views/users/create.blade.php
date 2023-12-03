@extends('layouts.auth.body')
@section('title', '| users')
@section('content')
<section class="container-fluid mt-5 ">
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between">
            <div><i class="fas fa-table me-1"></i>
                User Create
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('user.store') }}" method="POST" class="row">
                @csrf
                <div class="col-md-6 col-12 mb-4">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="User name"
                        value="{{ old('name') }}">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6 col-12 mb-4">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control"
                        placeholder="User email"value="{{ old('email') }}">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6 col-12 mb-4">
                    <label for="Password">Password</label>
                    <input type="password" id="passwoed" name="password" class="form-control" placeholder="Password">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6 col-12 mb-4">
                    <label for="Confirm Password">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control"
                        placeholder="Password Confirmation">
                </div>
                <div class="col-md-6 col-12 mb-4">
                    <label for="assign_role">Assign Role</label>
                    <select class="form-control" name="assign_role" id="assign_role">
                        <option value="">Select Role</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                    @error('assign_role')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6 col-12 mb-4">
                    <label for="business">Business</label>
                    <select class="form-control" name="business" id="business">
                        <option value="">Select Business</option>
                        @foreach ($businesses as $business)
                            <option value="{{ $business->id }}">{{ $business->business_name }}</option>
                        @endforeach
                    </select>
                    @error('business')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="my-auto pt-2 ">
                    <button type="submit" class="btn btn-sm btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
