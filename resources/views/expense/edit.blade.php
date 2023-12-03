@extends('layouts.auth.body')
@section('title', '| Expense')
@section('content')
<section class="container-fluid mt-5 ">
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between">
            <div><i class="fas fa-table me-1"></i>
                Expense Edit
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('expense.update',$transaction->id ) }}" method="POST" class="row">
                @csrf
                <div class="col-md-6 col-12 mb-4">
                    <label for="expense_title"> Expense Title</label>
                    <input type="text" id="expense_title" name="expense_title" class="form-control" placeholder="Expense Title"
                        value="{{ old('expense_title', $transaction->expense_title ) }}">
                    @error('expense_title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6 col-12 mb-4">
                    <label for="expense_category">Expense Category</label>
                   <select name="expense_category" id="" class="form-control">
                    <option value="">Select Customer</option>
                    @foreach ($expense_categories as $expense_category )
                        <option {{ old('expense_category', $transaction->expense_category_id ) == $expense_category->id  ? "selected" : "" }} value="{{ $expense_category->id }}">{{ $expense_category->name }}</option>
                    @endforeach
                   </select>
                    @error('expense_category')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6 col-12 mb-4">
                    <label for="total_payable">Total payable</label>
                    <input type="number" step="any" id="total_payable" name="total_payable" class="form-control"
                        placeholder="Expense total_payable"value="{{ old('total_payable', $transaction->total_payable) }}">
                    @error('total_payable')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6 col-12 mb-4">
                    <label for="paying_amount">Paying Amount</label>
                    <input type="number" step="any" id="paying_amount" name="paying_amount" class="form-control"
                        placeholder="Expense paying amount"value="{{ old('paying_amount', $transaction->amount) }}">
                    @error('paying_amount')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6 col-12 mb-4">
                    <label for="expense_details">Expense Details</label>
                    <input type="text" id="expense_details" name="expense_details" class="form-control"
                        placeholder="Expense Details"value="{{ old('expense_details', $transaction->expense_details) }}">
                    @error('expense_details')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6 col-12 mb-4">
                    <label for="transaction_date">Paying Date</label>
                <input type="text" id="transaction_date" name="transaction_date" class="form-control date" id="date"
                        placeholder="Expense Details"value="{{ old('transaction_date', $transaction->transaction_date) }}">
                    @error('transaction_date')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="my-auto pt-2">
                    <button type="submit" class="btn btn-sm btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
