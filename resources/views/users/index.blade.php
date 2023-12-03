@extends('layouts.auth.body')
@section('title', '| users')
@section('content')
<section class="container-fluid mt-5 ">
    <div class="card table-responsive mb-4">
        <div class="card-header d-flex justify-content-between">
            <div><i class="fas fa-table me-1"></i>
                User Table</div>
                <div>
                    <a class="btn btn-info btn-sm" href="{{ route('user.create') }}">Add user</a>
                </div>
        </div>
        <div class="card-body">
            <table class="table table-striped userTable" >
                <thead>
                    <tr>
                        {{-- <th>ID</th> --}}
                        <th>Name</th>
                        <th>Email</th>+
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
                <tfoot>
                    <th>Name</th>
                    <th>Email</th>
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
    var table = $('.userTable').DataTable({
        serverSide: false,
        processing: false,
        ajax: "{{ route('user') }}",
        columns: [
            { data: 'name' },
            { data: 'email' },
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
