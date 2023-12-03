@extends('layouts.auth.body')
@section('title', '| Reports')
@section('content')
    <section class="container-fluid mt-5 bg-white py-4">
        <div class="card table-responsive mb-4">
            <div class="card-header d-flex justify-content-between">
                <div><i class="fas fa-table me-1"></i>
                    Profit Loss Report</div>
            </div>
            <div class="card-body">
                <div class="row row-cols-md-3">
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
            </div>
        </div>
        <div class=" d-md-flex justify-content-center gap-3 ">
            <div class="card col-md-4 text-warning col-12 mb-md-0 mb-2 shadow-lg" style="background-color: #2c0eb3">
                <div class="card-header" style="background-color: #09817b">
                    Total Sales
                </div>
                <div class=" card-body">
                    <h4 class="text-center">Total Sales: <span id="tolat_sales"></span></h4>
                </div>
            </div>
            <div class="card col-md-4 col-12 text-warning shadow-lg" style="background-color: #2c0eb3">
                <div class="card-header" style="background-color: #09817b">
                    Total Expenses
                </div>
                <div class=" card-body">
                    <h4 class="text-center">Total Expense: <span id="tolat_expense"></span></h4>
                </div>
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
            function ajaxCall(date) {
                $('#tolat_sales').html('<i class="fa-solid fa-rotate"></i>')
                $('#tolat_expense').html('<i class="fa-solid fa-rotate"></i>')
                $.ajax({
                    url: "{{ route('profit_loss.report') }}",
                    method: 'GET',
                    data: {
                        date: date
                    },
                    success: function(data) {
                        $('#tolat_sales').html(parseFloat(data.totalSaleSum).toFixed(2))
                        $('#tolat_expense').html(parseFloat(data.totalExpenseSum).toFixed(2))
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
