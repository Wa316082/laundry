@extends('layouts.auth.body')
@section('title', '| Businesses')
@section('content')
<section class="container-fluid mt-5 ">
    <div class="card table-responsive mb-4">
        <div class="card-header d-flex justify-content-between">
            <div><i class="fas fa-table me-1"></i>
                Business Table</div>
                @can('Business Create')
                <div>
                    <a class="btn btn-info btn-sm" href="{{ route('business.create') }}">Add Business</a>
                </div>
                @endcan
        </div>
        <div class="card-body">
            <table class="table table-striped" id="business" >
                <thead>
                    <tr>
                        {{-- <th>ID</th> --}}
                        <th>Business Name</th>
                        <th>Business Address</th>
                        <th>Business Contact</th>
                        <th>Business Email</th>
                        <th>Business Detail1</th>
                        <th>Business Detail2</th>
                        <th>Business Detail3</th>
                        <th>bBusiness Extra1</th>
                        <th>bBusiness Extra2</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
                <tfoot>
                    <th>Business Name</th>
                    <th>Business Address</th>
                    <th>Business Contact</th>
                    <th>Business Email</th>
                    <th>Business Detail1</th>
                    <th>Business Detail2</th>
                    <th>Business Detail3</th>
                    <th>bBusiness Extra1</th>
                    <th>bBusiness Extra2</th>
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
    var table = $('#business').DataTable({
        serverSide: false,
        processing: false,
        ajax: "{{ route('business') }}",
        columns: [
            { data: 'business_name' },
            { data: 'business_address' },
            { data: 'business_contact' },
            { data: 'business_email' },
            { data: 'business_detail1' },
            { data: 'business_detail2' },
            { data: 'business_detail3' },
            { data: 'business_extra1' },
            { data: 'business_extra2' },
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
