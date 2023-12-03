@extends('layouts.auth.body')
@section('title', '| Orders')
@section('content')
    <section class="container-fluid mt-5 ">
        <div class="card table-responsive mb-4">
            <div class="card-header d-flex justify-content-between">
                <div><i class="fas fa-table me-1"></i>
                    Orders</div>
                <div>
                    <a class="btn btn-info btn-sm" href="{{ route('order.create') }}">Add Order</a>
                    {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#service_category">
                        Add Category
                    </button> --}}
                </div>
            </div>
            <div class="card-body">
                <table class="table table-striped text-black" id="order_list_table">
                    <thead>
                        <tr>
                            {{-- <th>ID</th> --}}
                            <th>Order Info</th>
                            <th>Customer Info</th>
                            <th>Order Amount</th>
                            <th>Paying Status</th>
                            <th>Status</th>
                            <th>Payment Info</th>
                            <th>Actions</th>
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
                        <th>Actions</th>
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
            var table = $('#order_list_table').DataTable({
                serverSide: false,
                processing: false,
                ordering: false,
                ajax: "{{ route('order') }}",
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
                    {
                        data: 'action'
                    }
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

            $(document).on('click', 'button.status_change', function(e) {
                e.preventDefault();
                let id = $(this).data('data');
                $.ajax({
                    method: "GET",
                    url: 'order/change_status/' + id,
                    success: function(res) {
                        $('div.status_change_modal').html(res)
                        $('div.status_change_modal').modal('toggle');
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

            $(document).on('submit', 'form#status_change_form', function(e) {
                e.preventDefault();
                let url = $(this).attr('action');
                let data = $(this).serialize();
                $.ajax({
                    method: "POST",
                    url: url,
                    data: data,
                    success: function(res) {
                        table.ajax.reload()
                        $('div.status_change_modal').modal('hide');
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

            $(document).on('click', 'button.print_pack_slip', function(e) {
                e.preventDefault();
                let id = $(this).data('data');
                $.ajax({
                    method: "GET",
                    url: 'order/print_slip/' + id,
                    success: function(res) {
                        let order_date = res.transaction.transaction_date;
                        order_date = new Date(order_date)
                        order_date = (order_date.toLocaleString('default', {
                                month: 'short'
                            })) + ' - ' + order_date.getDate() + ' - ' + order_date
                            .getFullYear()
                        let delivery_date = res.transaction.estimate_delivery_date
                        delivery_date = new Date(delivery_date)
                        delivery_date = (delivery_date.toLocaleString('default', {
                                month: 'short'
                            })) + ' - ' + delivery_date.getDate() + ' - ' + delivery_date
                            .getFullYear()
                        var image = new Image();
                        image.src = res.barcodeUrl;
                        image.onload = () => {
                            var html = `<div style="text-align: center; width: 100%">
                            <h4>Packing Slip</h4>
                        </div>
                        <div style="max-width: 100vw; display: flex; justify-content: space-between">
                            <div style="text-align: left; width: 50%">
                                <p><strong>Invoice No:</strong> ${ res.transaction.invoice_number}
                                    <br>
                                    <span><strong>Customer Info</strong></span>
                                    <br>
                                    <span><strong>Name:</strong> ${ res.transaction.customer.name}</span>
                                    <br>
                                    <span><strong>Address:</strong> ${res.transaction.customer.address }</span>
                                    <br>
                                    <span><strong>Phone:</strong> ${res.transaction.customer.contact }</span>
                                    {{-- <br>
                                    <span><strong>Email:</strong> ${ res.transaction.customer.email }}</span> --}}
                                    </P>
                            </div>
                            <div style="text-align: right; width: 50%">
                                <p class="text-end">
                                    {{-- <span><strong>Ref No: </strong>${ res.transaction.ref_no }</span>
                                    <br> --}}
                                    <span><strong>Booking Date:</strong> ${ order_date }</span>
                                    <br>
                                    <span><strong>Delivery Date:</strong> ${ delivery_date }</span>
                                    <br>
                                    <span><strong>Prepared By:</strong> ${ res.transaction.user.name}</span>
                                    <br>
                                    <span>
                                </p>
                            </div>

                        </div>
                        <div style="text-align: center; width: 100%">
                            <p>Total Amount: ${ res.transaction.total_payable}</p>
                            <img style="text-align: center; max-width: 50%" src="${ res.barcodeUrl }" alt="">
                            <br/>
                            <span>${ res.transaction.invoice_number}</span>
                        </div>`
                            w = window.open();
                            w.document.write(html);
                            w.print();
                            w.close();
                        }
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
