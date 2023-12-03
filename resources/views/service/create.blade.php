@extends('layouts.auth.body')
@section('title', '| users')
@section('content')
<section class="container-fluid mt-5 ">
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between">
            <div><i class="fas fa-table me-1"></i>
                Service Create
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('service.store') }}" method="POST" class="row" enctype="multipart/form-data">
                @csrf
                <div class="col-md-6 col-12 mb-4">
                    <label for="name"> Name</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Service name"
                        value="{{ old('name') }}">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6 col-12 mb-4">
                    <label for="details">Details</label>
                    <input type="details" id="details" name="details" class="form-control"
                        placeholder="Service details"value="{{ old('details') }}">
                    @error('details')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6 col-12 mb-4">
                    <label for="price">Price</label>
                    <input type="number" step="any" id="price" value="{{ old('price') }}" name="price" class="form-control" placeholder="price">
                    @error('price')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-6 col-12 mb-4">
                    <label for="image">image</label>
                    <input type="file" id="image" name="image" class="form-control" placeholder="image">
                    @error('image')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-6 col-12 mb-4">
                    <label for="category_id">Category</label>
                    <select class="form-control" name="category_id" id="category_id">
                        <option value="">Select One</option>
                        @foreach ($categories as $category)
                            <option {{ old('category_id') == $category->id  ? "selected" : "" }} value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
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
