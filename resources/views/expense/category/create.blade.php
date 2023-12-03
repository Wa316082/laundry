
@extends('layouts.auth.body')
@section('title', '| Service Category')
@section('content')
<section class="container-fluid mt-5 ">
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between">
            <div><i class="fas fa-table me-1"></i>
                Category Create
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('expenseCategory.store') }}" method="POST" class="row">
                @csrf
                <div class="col-md-6 col-12 mb-4">
                    <label for="name"> Name</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Category name"
                        value="{{ old('name') }}">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6 col-12 mb-4">
                    <label for="details">Details</label>
                    <input type="details" id="details" name="details" class="form-control"
                        placeholder="Category details"value="{{ old('details') }}">
                    @error('details')
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
