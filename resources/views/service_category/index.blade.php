@extends('layouts.auth.body')
@section('title', '| Service Category')
@section('content')
<section class="container-fluid mt-5 ">
    <div class="card table-responsive mb-4">
        <div class="card-header d-flex justify-content-between">
            <div><i class="fas fa-table me-1"></i>
                Service Category Table</div>
                <div>
                    <a class="btn btn-info btn-sm" href="{{ route('service_category.create') }}">Add Category</a>
                    {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#service_category">
                        Add Category
                    </button> --}}
                </div>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="serviceCategory" >
                <thead>
                    <tr>
                        {{-- <th>ID</th> --}}
                        <th>Name</th>
                        <th>Details</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
                <tfoot>
                    <th>Name</th>
                    <th>Details</th>
                    <th>Actions</th>
                </tfoot>
            </table>

        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="service_category" data-bs-backdrop="static" role="dialog" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            ...
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Understood</button>
          </div>
        </div>
      </div>
</div>
@endsection
@section('script')
<script>

$(document).ready(function () {
    var table = $('#serviceCategory').DataTable({
        serverSide: false,
        processing: false,
        ajax: "{{ route('service_category') }}",
        columns: [
            { data: 'name' },
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
