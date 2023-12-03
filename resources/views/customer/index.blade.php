@extends('layouts.auth.body')
@section('title', '| customers')
@section('content')
<section class="container-fluid mt-5 ">
    <div class="card table-responsive mb-4">
        <div class="card-header d-flex justify-content-between">
            <div><i class="fas fa-table me-1"></i>
                Customers Table</div>
                <div>
                    <a class="btn btn-info btn-sm" href="{{ route('customer.create') }}">Add Customer</a>
                </div>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="customerTable" >
                <thead>
                    <tr>
                        {{-- <th>ID</th> --}}
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
                <tfoot>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Action</th>
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
        ajax: "{{ route('customer') }}",
        columns: [
            { data: 'name' },
            { data: 'contact' },
            { data: 'email' },
            { data: 'address' },
            { data: 'action' }
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
