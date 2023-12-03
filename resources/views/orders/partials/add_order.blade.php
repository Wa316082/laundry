@extends('layouts.auth.body')
@section('title', '| Orders')
@section('content')
    <section class="container-fluid">
        <div class="row ">
            <div class="col-md-5 col-12 card border-4 border-primary shadow p-3"style="min-height: 60vh">
                <div class="row">
                    <div class=" col-8 input-group  mb-3 ">
                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-magnifying-glass"></i></span>
                        <input type="text" class="form-control" id="search_term" placeholder="Search.."
                            aria-label="Search.." aria-describedby="basic-addon1">
                    </div>
                    <div class="form-group col-4">
                        <select class="form-control" name="category" id="category">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>

                    </div>
                </div>
                {{-- services inclides --}}
                <div class="" id="services">
                </div>
            </div>

            <div class="col-md-7 col-12 mt-2 mb-mt-0">
                <form class="card shadow" action="{{ route('order.store') }}" method="POST" id="order_place">
                    @csrf
                    <div class="card-header d-flex justify-content-between flex-wrap ">
                        <div class="col-12 border-bottom mb-1">
                            Edit Order Cart
                        </div>

                        <div class="form-group col-6">
                            <label for="">Select Customer</label>
                            <div class="input-group mb-3">
                                <select class="form-select" required name="customer_id" id="inputGroupSelect02">
                                    <option value="">Select Customer</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                    @endforeach
                                </select>
                                <button class="btn btn-info" data-bs-toggle="modal"
                                data-bs-target="#add_customer" type="button">+</button>
                              </div>

                        </div>

                        <div class="form-group col-6">
                            <label for="">Order Date <span class="text-danger">*</span></label>
                            <input type="text" class="form-control date" id="date" autocomplete="off" name="order_date">
                        </div>
                        <div class="form-group col-6">
                            <label for="">Delivery Date <span class="text-danger">*</span></label>
                            <input type="text" class="form-control date" id="date" autocomplete="off" name="delivery_date">
                        </div>
                        <div class="form-group col-6">
                            <label for="">Ref No </label>
                            <input type="text" class="form-control " name="ref_no">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive  overflow-auto" style="height: 20rem">
                            <table class="table text-dark text-center overflow-auto" id="service_cart_table">
                                <thead>
                                    <tr>
                                        <th>Img</th>
                                        <th>service</th>
                                        <th>Unit Price</th>
                                        <th>QTy</th>
                                        <th>Total</th>
                                        <th>Remove</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <input type="hidden" name="row_count" id="row_count" value="0">

                                </tbody>
                            </table>
                        </div>

                        <div class="bg-warning rounded p-2">
                            <div class="border-bottom border-top d-flex justify-content-between mb-2">
                                <div class="my-auto">
                                    {{-- <button class="btn btn-sm btn-secondary">Discount</button> --}}
                                </div>
                                <div class="text-black text-center fw-semibold p-2">
                                    <label for="">Total Payable</label>
                                    <input type="text" readonly name="total_payable" id="total_payable"
                                        class="form-control" value="0.00">
                                </div>
                            </div>
                            <div class="d-flex justify-content-center gap-2  ">

                                <button type="button" class="btn btn-sm btn-info bookOrder" data-bs-toggle="modal"
                                    data-bs-target="#place_order">Book Order</button>
                                <button type="submit" class="btn btn-sm btn-success
                                "
                                    id="cash_on_order">Cash On
                                    Order</button>
                            </div>

                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="place_order" data-bs-backdrop="static" role="dialog"
                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog ">
                            <div class="modal-content bg-success">
                                <div class="modal-header">
                                    <h5 class="modal-title text-white" id="staticBackdropLabel">Partials Pay</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body row">
                                    <div class="form-group col-6">
                                        <label for="paying_amount">Amount</label>
                                        <input type="text" name="paying_amount" id="paying_amount"
                                            class="form-control">
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="remaining_due">Remainging Due</label>
                                        <input type="text" name="remaining_due" id="remaining_due"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" id="confirm_order">Confirm
                                        Order</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </section>

    <div class="modal fade" id="add_customer" data-bs-backdrop="static" role="dialog"
        data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" action="{{ route('customer.store') }}" method="POST" id="customer_form">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title text-white" id="staticBackdropLabel">Partials Pay</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body row">
                    <div class="col-md-6 col-12 mb-4">
                        <label for="name"> Name</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Customer name"
                            value="{{ old('name') }}">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 col-12 mb-4">
                        <label for="contact">Contact</label>
                        <input type="contact" id="contact" name="contact" class="form-control"
                            placeholder="Customer contact"value="{{ old('contact') }}">
                        @error('contact')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 col-12 mb-4">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control"
                            placeholder="Customer email"value="{{ old('email') }}">
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 col-12 mb-4">
                        <label for="address">Address</label>
                        <input type="address" id="address" name="address" class="form-control"
                            placeholder="Customer Address"value="{{ old('address') }}">
                        @error('address')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="">Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script>
        // get all services
        $(document).ready(function() {
            $('#services').html('Loading...');
            var services = $.ajax({
                type: 'GET',
                url: "{{ route('order.create') }}",
                data: {
                    term: $('#search_term').val(),
                    category: $('#category option:selected').val()
                },
                success: function(res) {
                    $('#services').html(res);
                }
            })
            $('#search_term').on('keydown', function() {
                ajax_call()
            })
            $('#category').on('change', function() {
                ajax_call()
            })
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                let page = $(this).attr('href').split('page=')[1];
                pagination(page);
            });

            function pagination(page) {
                $('#services').html('Loading...');
                $.ajax({
                    type: 'GET',
                    url: "{{ route('order.pagination') }}" + '??page=' + page,
                    data: {
                        term: $('#search_term').val(),
                        category: $('#category option:selected').val()
                    },
                    success: function(res) {
                        $('#services').html(res);
                    }
                })
            }

        });

        function ajax_call() {
            $('#services').html('Loading...');
            $.ajax({
                type: 'GET',
                url: "{{ route('order.create') }}",
                data: {
                    term: $('#search_term').val(),
                    category: $('#category option:selected').val()
                },
                success: function(res) {
                    $('#services').html(res);
                }
            })
        }
        // services search ends

        //add to cart the srives

        window.addEventListener('load', function() {
            // Clear localStorage if it contains data
            localStorage.clear();
        });
        var service_ids = []
        $(document).on('click', '.service-cart', function(e) {
            e.preventDefault();
            let service_id = $(this).find('.service_id').val();
            var storedIds = JSON.parse(localStorage.getItem("service_ids"));
            if (storedIds != null && storedIds.includes(service_id)) {
                let tr = $('#service_id_' + service_id).closest('tr')
                let qty = parseInt(tr.find('input.qty').val())
                qty = qty + 1
                tr.find('input.qty').val(qty)
                updateTotals(tr, qty)

            } else {
                service_ids.push(service_id);
                localStorage.setItem("service_ids", JSON.stringify(service_ids));
                $.ajax({
                    type: 'GET',
                    url: "add-to-cart/" + service_id,
                    data: {
                        row_count: $('#row_count').val()
                    },
                    success: function(res) {
                        $('#service_cart_table tbody').prepend(res);
                        let row_count = parseInt($('#row_count').val());
                        row_count = row_count + 1;

                        $('#row_count').val(row_count);
                        updatePayble()
                    }
                })
            }
        });

        $(document).on('click', '.decrease-qty', function(e) {
            e.preventDefault();
            var tr = $(this).closest('tr');
            var qty = tr.find('input.qty').val()
            qty = parseInt(qty);
            if (qty > 1) {
                qty = qty - 1;
            }
            tr.find('input.qty').val(qty)
            updateTotals(tr, qty)
        })

        $(document).on('click', '.increase-qty', function(e) {
            e.preventDefault();
            let tr = $(this).closest('tr');
            let qty = tr.find('input.qty').val()
            qty = parseInt(qty);
            qty = qty + 1;
            tr.find('input.qty').val(qty)
            updateTotals(tr, qty)
        })

        $(document).on('change', '.unit_price, .qty', function(e) {
            e.preventDefault();
            let tr = $(this).closest('tr');
            let qty = tr.find('input.qty').val()
            tr.find('input.qty').val(qty)
            updateTotals(tr, qty)
        })

        $(document).on('click', '.delete-row', function(e) {
            e.preventDefault();
            let tr = $(this).closest('tr')
            Swal.fire({
                title: `Are you sure ?`,
                text: "If you remove this, It will be gone forever.",
                icon: "question"
                    // ,position:'top'
                    ,
                background: 'rgba(255, 255, 255,1)',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#06E66F',
                confirmButtonText: ' Remove ',
                iconColor: '#d33',
            })
            .then((result) => {
                if (result.isConfirmed) {
                    var serivceIds = JSON.parse(localStorage.getItem("service_ids"));
                    var service_id = tr.find('input.service_id').val()
                    var indexToRemove = serivceIds.indexOf(service_id);
                    if (indexToRemove !== -1) {
                        serivceIds.splice(indexToRemove, 1); // Remove the value
                        localStorage.setItem("service_ids", JSON.stringify(serivceIds));
                    }
                    tr.remove();
                    updatePayble()
                } else {
                    Swal.fire(
                        'Cancelled', 'Your imaginary file is safe', 'success'
                    )
                }
            });
        })

        function updateTotals(tr, qty) {
            let unit_price = tr.find('input.unit_price').val();
            unit_price = unit_price * qty;
            let line_total = tr.find('input.line_total').val(unit_price);
            updatePayble()

        }

        function updatePayble() {
            let total_payable = 0;
            $('#service_cart_table tbody tr').each(function() {
                total_payable += parseFloat($(this).find('input.line_total').val());
            });
            total_payable = total_payable.toFixed(2);
            $('#total_payable').val(total_payable);
        }


        // order place functions
        $(document).on('submit', 'form#order_place', function(e) {
            e.preventDefault()
            let fromData = $(this).serialize()
            let url = $(this).attr('action');
            $.ajax({
                type: 'POST',
                url: url,
                data: fromData,
                success: function(res) {
                    if (res.success) {
                        w = window.open();
                        w.document.write(res.invoice);
                        w.print();
                        w.close();
                        window.location.href = '/order/create';
                    }

                },
                error: function(error) {
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true
                    }
                    toastr.error(error.responseJSON.message);
                }

            });
        })


        $(document).on('click', '.bookOrder', function() {
            let total = parseFloat($('#total_payable').val());
            total = total.toFixed(2);
            $('#remaining_due').val(total)
            $('#paying_amount').val('0.00')
        })

        $(document).on('change', '#paying_amount', function() {
            let total = parseFloat($('#total_payable').val());
            let paying = $(this).val()
            total = total - paying;

            if (total < 0) {
                total = 0
            }
            total = total.toFixed(2);
            $('#remaining_due').val(total)
        })


        $(document).on('submit', '#customer_form', function(e){
            e.preventDefault();
            let fromData = $(this).serialize()
            let url = $(this).attr('action');

            $.ajax({
                type: 'POST',
                url: url,
                data: fromData,
                success: function(res) {
                    $('div#add_customer').modal('hide');
                    window.location.href = '/order/create'
                },
                error: function(error) {
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true
                    }
                    toastr.error(error.responseJSON.message);
                }

            });
        })
    </script>

@endsection
