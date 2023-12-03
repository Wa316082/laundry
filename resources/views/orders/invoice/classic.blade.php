
<head>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #777777;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
</head>

<div style="width: 100vw">
    <div style="width: 100%">
        <h4 style="text-align: center">{{ $transaction->user->business->business_name }}</h4>

        <p style="text-align: center"><span>Address: {{ $transaction->user->business->business_address }}</span>
            <br>
            <span>Phone: {{ $transaction->user->business->business_contact }}</span>
            <br>
            <span>Email: {{ $transaction->user->business->business_email }}</span>
        </p>

    </div>
    <div style="width: 100%; display: flex; justify-content: space-between">
        <div style="width: 50%">
            <p style="text-align: left"><strong>Invoice No:</strong> {{ $transaction->invoice_number }}</p>

            <p><strong>Customer Info</strong></p>
            <p>
                <span><strong>Name:</strong> {{ $transaction->customer->name }}</span>
                <br>
                <span><strong>Address:</strong> {{ $transaction->customer->address }}</span>
                <br>
                <span><strong>Phone:</strong> {{ $transaction->customer->contact }}</span>
                {{-- <br>
                        <span><strong>Email:</strong> {{ $transaction->customer->email }}</span> --}}
            </P>

        </div>
        <div style="width: 50%; text-align: right">
            <p style="text-align: right">
                {{-- <span><strong>Ref No: </strong>{{ $transaction->ref_no }}</span>
                        <br> --}}
                <span><strong>Booking Date:</strong>
                    {{ date('d-m-Y', strtotime($transaction->transaction_date)) }}</span>
                <br>
                <span><strong>Delivery Date:</strong>
                    {{ date('d-m-Y', strtotime($transaction->estimate_delivery_date)) }}</span>
                <br>
                <span><strong>Prepared By:</strong> {{ $transaction->user->name }}</span>
                <br>
                <span>
            </p>
        </div>
    </div>
    <div style="width: 100%">
        <p style="text-align: center;">Booking Token</p>
    </div>
    <div style="width: 100%; border-bottom: 1px solid black">
        <table style="">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Item</th>
                    <th>Service</th>
                    <th>QTY</th>
                    <th>Unit Price</th>
                    <th>Line Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order_lines as $line)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $line->service->name }}</td>
                        <td>{{ $line->service->category->name }}</td>
                        <td>{{ $line->service_quantity }}</td>
                        <td>{{ $line->unit_price }}</td>
                        <td>{{ $line->unit_price * $line->service_quantity }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div style="width: 100%; display: flex; justify-content: space-between">
        <div style="width: 50%">

        </div>
        <div style="width: 50%; text-align: right; margin-top: 4%; margin-right: 2%; ">

            <div style="border-top: 1px, solid, black">
                <div>
                    <div>
                        <th><strong>Total Payable:</strong></th>
                        <td><strong>{{ $transaction->total_payable }}</strong></td>
                    </div>
                    <div style="border-bottom: 1px solid rgb(7, 7, 7)">
                        <th><strong>Total Paid:</strong></th>
                        <td><strong>{{ $transaction->amount }}</strong></td>
                    </div>

                    <tr >
                        <th><strong>Total Due:</strong></th>
                        <td><strong>{{ $transaction->total_payable - $transaction->amount }}</strong></td>
                    </tr>
                </div>
            </div>
        </div>
    </div>
</div>
