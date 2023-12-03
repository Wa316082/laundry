@extends('layouts.auth.body')
@section('title', '| Reports')
@section('content')
    <section class="container-fluid mt-5 ">
        <div class="card table-responsive mb-4">
            <div class="card-header d-flex justify-content-between">
                <div><i class="fas fa-table me-1"></i>
                    Orders Reports</div>
            </div>
            <div class="card-body">
                <div class="row row-cols-md-3">
                    <div class="col form-group">
                        <label for="">Search With Status</label>
                        <select class="form-control" name="status" id="status">
                            <option value="">Select One</option>
                            <option value="Order Initialized">Order Initialized</option>
                            <option value="Order Prepairing">Order Prepairing</option>
                            <option value="Ready to Deliver">Ready to Deliver</option>
                            <option value="Delivered">Delivered</option>
                        </select>
                    </div>
                    <div class="col form-group">
                        <label for="">Date Range</label>
                        <div id="reportrange" class="form-control"
                            style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                            <i class="fa fa-calendar"></i>&nbsp;
                            <span></span> <i class="fa fa-caret-down"></i>
                            <input type="hidden" id="date">
                        </div>
                    </div>
                </div>
                <table class="table table-striped text-black" id="order_report">
                    <thead>
                        <tr>
                            <th>Order Info</th>
                            <th>Customer Info</th>
                            <th>Order Amount</th>
                            <th>Paying Status</th>
                            <th>Status</th>
                            <th>Payment Info</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <th>Order Info</th>
                        <th>Customer Info</th>
                        <th>Order Amount</th>
                        <th>Paying Status</th>
                        <th>Status</th>
                        <th>Payment Info</th>
                    </tfoot>
                </table>

            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade status_change_modal" id="status_change" data-bs-backdrop="static" role="dialog"
        data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    </div>
    <!-- Modal -->
    <div class="modal fade payment_model" id="payment_model" data-bs-backdrop="static" role="dialog"
        data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            var table = $('#order_report').DataTable({
                serverSide: false,
                processing: false,
                ordering: false,
                columns: [{
                        data: 'order_info'
                    },
                    {
                        data: 'customer_info'
                    },
                    {
                        data: 'total_payable'
                    },
                    {
                        data: 'paying_status'
                    },
                    {
                        data: 'order_status'
                    },
                    {
                        data: 'payment_info'
                    },
                ],
                buttons: [
                    'copy', // Copy to clipboard
                    'excel', // Export to Excel
                    'csv', // Export to CSV
                    'pdf' // Export to PDF
                ]
            });

            new $.fn.dataTable.Buttons(table, {
                buttons: [
                    'copy',
                    'excel',
                    'csv',
                    'pdf'
                ]
            });
            table.buttons().container().appendTo($('.dataTables_wrapper .col-md-6:eq(0)'));


            $('#status').on('change', function() {
                var date = $('#date').val()
                ajaxCall(date)
            })

            function ajaxCall(date) {
                $.ajax({
                    url: "{{ route('order.report') }}",
                    method: 'GET',
                    data: {
                        status: $('#status option:selected').val(),
                        date: date
                    },
                    success: function(data) {
                        // Replace the DataTable data with the new data from the server
                        table.clear().rows.add(data.data).draw();
                    },
                    error: function(xhr, status, error) {
                        console.error("Error:", error);
                    }
                });
            }
            $(function() {
                var start = moment();
                var end = moment();

                function cb(start, end) {
                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format(
                        'MMMM D, YYYY'));
                    var date = (start.format('YYYY-MM-D') + ' - ' + end.format('YYYY-MM-D'));
                    $('#date').val(date)
                    ajaxCall(date)
                }

                $('#reportrange').daterangepicker({
                    startDate: start,
                    endDate: end,
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment()
                            .subtract(1, 'month').endOf('month')
                        ]
                    }
                }, cb);
                cb(start, end);
            });
        });
    </script>
@endsection
