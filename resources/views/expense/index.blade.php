@extends('layouts.auth.body')
@section('title', '| Expense')
@section('content')
<section class="container-fluid mt-5 ">
    <div class="card table-responsive mb-4">
        <div class="card-header d-flex justify-content-between">
            <div><i class="fas fa-table me-1"></i>
                Expense Table</div>
                <div>
                    <a class="btn btn-info btn-sm" href="{{ route('expense.create') }}">Add Expense</a>
                </div>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="expenseTable" >
                <thead>
                    <tr>
                        {{-- <th>ID</th> --}}
                        <th>Expense Title</th>
                        <th>Expense Category Name</th>
                        <th>Paying status</th>
                        <th>Transaction date</th>
                        <th>payment_info</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
                <tfoot>
                    <tr>
                        {{-- <th>ID</th> --}}
                        <th>Expense Title</th>
                        <th>Expense Category Name</th>
                        <th>Paying status</th>
                        <th>Transaction date</th>
                        <th>payment_info</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>

        </div>
    </div>
    <div class="modal fade payment_model" id="payment_model" data-bs-backdrop="static" role="dialog"
        data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    </div>
</section>
@endsection
@section('script')
<script>

$(document).ready(function () {
    var table = $('#expenseTable').DataTable({
        serverSide: false,
        processing: false,
        ajax: "{{ route('expense') }}",
        columns: [
            { data: 'expense_title'},
            { data: 'expense_category_name'},
            { data: 'paying_status'},
            { data: 'transaction_date'},
            { data: 'payment_info'},
            { data: 'action'}
        ],
        buttons: [
            'copy', // Copy to clipboard
            'excel', // Export to Excel
            'csv',   // Export to CSV
            'pdf'   // Export to PDF
              // Print button
        ]
    });

    // Add the export buttons to the DataTable's button container
    new $.fn.dataTable.Buttons(table, {
        buttons: [
            'copy',
            'excel',
            'csv',
            'pdf'
        ]
    });

    table.buttons().container().appendTo($('.dataTables_wrapper .col-md-6:eq(0)'));


    $(document).on('click', 'button.pay_term', function(e) {
                e.preventDefault();
                let id = $(this).data('data');
                $.ajax({
                    method: "GET",
                    url: 'order/pay_term/' + id,
                    success: function(res) {
                        $('div.payment_model').html(res)
                        $('div.payment_model').modal('toggle');
                    },
                    error: function(error) {
                        toastr.options = {
                            "closeButton": true,
                            "progressBar": true
                        }
                        toastr.error('Some thing Went Wrong');
                    }
                });
            });


            $(document).on('submit', 'form#update_payment', function(e) {
                e.preventDefault();
                let url = $(this).attr('action');
                let data = $(this).serialize();
                $.ajax({
                    method: "POST",
                    url: url,
                    data: data,
                    success: function(res) {
                        table.ajax.reload()
                        $('div.payment_model').modal('hide');
                        toastr.options = {
                            "closeButton": true,
                            "progressBar": true
                        }
                        toastr.success(res.message);
                    },
                    error: function(error) {
                        toastr.options = {
                            "closeButton": true,
                            "progressBar": true
                        }
                        toastr.error('Some thing Went Wrong');
                    }
                });
            });
});


</script>
@endsection
