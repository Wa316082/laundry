@extends('layouts.auth.body')
@section('title', '| Expense')
@section('content')
<section class="container-fluid mt-5 ">
    <div class="card table-responsive mb-4">
        <div class="card-header d-flex justify-content-between">
            <div><i class="fas fa-table me-1"></i>
                Expense Table</div>
                <div>
                    <a class="btn btn-info btn-sm" href="{{ route('expenseCategory.create') }}">Add Expense Category</a>
                </div>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="customerTable" >
                <thead>
                    <tr>
                        {{-- <th>ID</th> --}}
                        <th>Category Name</th>
                        <th>Details</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
                <tfoot>
                    <tr>
                        {{-- <th>ID</th> --}}
                        <th>Category Name</th>
                        <th>Details</th>
                        <th class="text-center">Action</th>
                    </tr>
                </tfoot>
            </table>

        </div>
    </div>
</section>
@endsection
@section('script')
<script>

$(document).ready(function () {
    var table = $('#customerTable').DataTable({
        serverSide: false,
        processing: false,
        ajax: "{{ route('expenseCategory') }}",
        columns: [
            { data: 'name'},
            { data: 'details'},
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
});
</script>
@endsection
