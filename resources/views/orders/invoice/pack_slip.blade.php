

        <div style="text-align: center; width: 100%">
            <h4>Packing Slip</h4>
        </div>
        <div style="max-width: 100vw; display: flex; justify-content: space-between">
            <div style="text-align: left; width: 50%">
                <p><strong>Invoice No:</strong> {{ $transaction->invoice_number }}
                    <br>
                    <span><strong>Customer Info</strong></span>
                    <br>
                    <span><strong>Name:</strong> {{ $transaction->customer->name }}</span>
                    <br>
                    <span><strong>Address:</strong> {{ $transaction->customer->address }}</span>
                    <br>
                    <span><strong>Phone:</strong> {{ $transaction->customer->contact }}</span>
                    {{-- <br>
                    <span><strong>Email:</strong> {{ $transaction->customer->email }}</span> --}}
                    </P>

            </div>
            <div style="text-align: right; width: 50%">
                <p class="text-end">
                    {{-- <span><strong>Ref No: </strong>{{ $transaction->ref_no }}</span>
                    <br> --}}
                    <span><strong>Booking Date:</strong> {{ date('d-m-Y', strtotime($transaction->transaction_date)); }}</span>
                    <br>
                    <span><strong>Delivery Date:</strong> {{ date('d-m-Y', strtotime($transaction->estimate_delivery_date)); }}</span>
                    <br>
                    <span><strong>Prepared By:</strong> {{ $transaction->user->name }}</span>
                    <br>
                    <span>
                </p>
            </div>

        </div>
        <div style="text-align: center; width: 100%">
            <p>Total Amount: {{ $transaction->total_payable }}</p>
            <img style="text-align: center" src="{{ $barcodeUrl }}" alt="">
            <span style="font-weight:100">{{ $transaction->invoice_number }}</span>
        </div>

