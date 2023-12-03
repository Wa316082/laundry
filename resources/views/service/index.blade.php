@extends('layouts.auth.body')
@section('title', '| Services')
@section('content')
<section class="container-fluid mt-5 ">
    <div class="card table-responsive mb-4">
        <div class="card-header d-flex justify-content-between">
            <div><i class="fas fa-table me-1"></i>
                Service Table</div>
                <div>
                    <a class="btn btn-info btn-sm" href="{{ route('service.create') }}">Add Services</a>
                    {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#service_category">
                        Add Category
                    </button> --}}
                </div>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="serviceTable" >
                <thead>
                    <tr>
                        {{-- <th>ID</th> --}}
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Details</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
                <tfoot>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Details</th>
                    <th>Actions</th>
                </tfoot>
            </table>

        </div>
    </div>
</section>


@endsection
@section('script')
<script>

$(document).ready(function () {
    var table = $('#serviceTable').DataTable({
        serverSide: false,
        processing: false,
        ajax: "{{ route('service') }}",
        columns: [
            { data: 'name' },
            { data: 'category' },
            { data: 'price' },
            { data: 'details' },
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
