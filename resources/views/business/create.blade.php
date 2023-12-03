@extends('layouts.auth.body')
@section('title', '| Buseness')
@section('content')
<section class="container-fluid mt-5 ">
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between">
            <div><i class="fas fa-table me-1"></i>
                Business Create
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('business.store') }}" method="POST" class="row" enctype="multipart/form-data">
                @csrf
                <div class="col-md-6 col-12 mb-4">
                    <label for="business_name">Business Name</label>
                    <input type="text" id="business_name" name="business_name" class="form-control" placeholder="Business Name"
                        value="{{ old('business_name') }}">
                    @error('business_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6 col-12 mb-4">
                    <label for="business_contact">Business Contact</label>
                    <input type="number" step="any" id="business_contact" name="business_contact" class="form-control"
                        placeholder="Business Contact"value="{{ old('business_contact') }}">
                    @error('business_contact')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6 col-12 mb-4">
                    <label for="business_email">Business Email</label>
                    <input type="business_email" id="business_email" name="business_email" class="form-control"
                        placeholder="Business email"value="{{ old('business_email') }}">
                    @error('business_email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6 col-12 mb-4">
                    <label for="business_address">Business Address</label>
                    <input type="text" id="business_address" name="business_address" class="form-control"
                        placeholder="Business Address"value="{{ old('business_address') }}">
                    @error('business_address')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-6 col-12 mb-4">
                    <label for="business_logo">Business Logo</label>
                    <input type="file" id="business_logo" name="business_logo" class="form-control"
                        placeholder="Business Address"value="{{ old('business_logo') }}">
                    @error('business_logo')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6 col-12 mb-4">
                    <label for="business_detail1">Business Detail line 1</label>
                    <input type="text" id="business_detail1" name="business_detail1" class="form-control"
                        placeholder="Business Detail Line 1"value="{{ old('business_detail1') }}">
                    @error('business_detail1')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-6 col-12 mb-4">
                    <label for="business_detail2">Business Detail Line 2</label>
                    <input type="text" id="business_detail2" name="business_detail2" class="form-control"
                        placeholder="Business Detail line 2"value="{{ old('business_detail2') }}">
                    @error('business_detail2')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-6 col-12 mb-4">
                    <label for="business_detail3">Business Detail Line 3</label>
                    <input type="text" id="business_detail3" name="business_detail3" class="form-control"
                        placeholder="Business Detail3"value="{{ old('business_detail3') }}">
                    @error('business_detail Line 3')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-6 col-12 mb-4">
                    <label for="business_extra1">Business Extra Line 1</label>
                    <input type="text" id="business_extra1" name="business_extra1" class="form-control"
                        placeholder="Business Extra Line 1"value="{{ old('business_extra1') }}">
                    @error('business_extra1')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-6 col-12 mb-4">
                    <label for="business_extra2">Business Extra Line 2</label>
                    <input type="text" id="business_extra2" name="business_extra2" class="form-control"
                        placeholder="Business Extra Line 2"value="{{ old('business_extra2') }}">
                    @error('business_extra2')
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
