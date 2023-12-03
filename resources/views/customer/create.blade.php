@extends('layouts.auth.body')
@section('title', '| customers')
@section('content')
<section class="container-fluid mt-5 ">
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between">
            <div><i class="fas fa-table me-1"></i>
                Customer Create
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('customer.store') }}" method="POST" class="row">
                @csrf
                <div class="col-md-6 col-12 mb-4">
                    <label for="name"> Name</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Customer name"
                        value="{{ old('name') }}">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6 col-12 mb-4">
                    <label for="contact">Contact</label>
                    <input type="contact" id="contact" name="contact" class="form-control"
                        placeholder="Customer contact"value="{{ old('contact') }}">
                    @error('contact')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6 col-12 mb-4">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control"
                        placeholder="Customer email"value="{{ old('email') }}">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6 col-12 mb-4">
                    <label for="address">Address</label>
                    <input type="address" id="address" name="address" class="form-control"
                        placeholder="Customer Address"value="{{ old('address') }}">
                    @error('address')
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
