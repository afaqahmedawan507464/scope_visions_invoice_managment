<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="theme-color" content="#ffffff">
    <script src="/themes/public/assets/js/config.js"></script>
    <script src="/themes/public/vendors/overlayscrollbars/OverlayScrollbars.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
        integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap"
        rel="stylesheet">
    <link href="/themes/public/vendors/overlayscrollbars/OverlayScrollbars.min.css" rel="stylesheet">
    <link href="/themes/public/assets/css/theme-rtl.min.css" rel="stylesheet" id="style-rtl">
    <link href="/themes/public/assets/css/theme.min.css" rel="stylesheet" id="style-default">
    <link href="/themes/public/assets/css/user-rtl.min.css" rel="stylesheet" id="user-style-rtl">
    <link href="/themes/public/assets/css/user.min.css" rel="stylesheet" id="user-style-default">
    <title>Scope Visions | New Balance Related Client</title>
</head>

<body>
    <div class="container mt-2">

        @if (Session::has('error_message'))
            <script>
                swal("Error Message", "{{ Session::get('error_message') }}", "error", {
                    button: "Close",
                });
            </script>
        @endif
        @if (Session::has('success_message'))
            <script>
                swal("Success Message", "{{ Session::get('success_message') }}", "success", {
                    button: "Close",
                });
            </script>
        @endif
        @if ($errors->any())
            <script>
                var errorMessages = '';
                @foreach ($errors->all() as $error)
                    errorMessages += '{{ $error }}\n';
                @endforeach
                swal("Info Message", errorMessages, "info", {
                    button: "Close",
                });
            </script>
        @endif
        <div class="card">
            <div class="card-header">
                <div class="col-12">
                    <div class="row">
                        {{-- <div class="col-6">
                            <a href="{{ route('clientNameList') }}" class="btn btn-outline-primary"><i class="fas fa-angle-left me-2"></i>Back</a>
                        </div> --}}
                        <div class="col-6">

                        </div>
                    </div>
                </div>
            </div>
            @foreach ($selectInvoices as $selectInvoicess)
            @endforeach
            <div class="card-body">
                {{--  --}}
                @if ($selectInvoicess->invoice_scope_model == '')
                    @if ($selectInvoicess->invoice_item_disposible_batchNo == '')
                        {{--  --}}
                        {{-- system items wala --}}
                        <form action="{{ route('createOperationAccountHistorySystemOperation') }}" method="post"
                            class="row" enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-10 py-2 px-2">
                                <div class="row px-2 py-2">
                                    <h3 class="text-start d-none d-md-block">For System</h5>
                                        <h3 class="text-center d-md-none ">For System</h5>
                                            <div class="col-12 d-none">
                                                <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                                    <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline"
                                                        for="" style="width:300px;">Client ID:</label>
                                                    <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                                        for="">Client
                                                        ID
                                                        :</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Ex, demo client" name="clientId"
                                                        value="{{ $selectInvoicess->invoice_client_id }}">
                                                </div>
                                            </div>
                                            {{--  --}}
                                            <div class="col-12 d-none">
                                                <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                                    <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline"
                                                        for="" style="width:300px;">Invoice Id:</label>
                                                    <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                                        for="">Invoice Id
                                                        :</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Ex, abc@abc.com" name="invoiceId"
                                                        value="{{ $selectInvoicess->id }}">
                                                </div>
                                            </div>
                                            {{--  --}}

                                            {{--  --}}
                                            @php
                                                $quotation_item_srNumber = isset(
                                                    $selectInvoicess->invoice_item_srNumber,
                                                )
                                                    ? json_decode($selectInvoicess->invoice_item_srNumber, true)
                                                    : [];
                                                $quotation_item_description = isset(
                                                    $selectInvoicess->invoice_item_decription,
                                                )
                                                    ? json_decode($selectInvoicess->invoice_item_decription, true)
                                                    : [];
                                                $quotation_total_price = isset($selectInvoicess->invoice_total_price)
                                                    ? json_decode($selectInvoicess->invoice_total_price, true)
                                                    : [];
                                            @endphp
                                            {{--  --}}
                                            @foreach ($quotation_item_srNumber as $key => $quotation_item_srNumbers)
                                                <div id="add_form">
                                                    <div id="show_items">
                                                        <div class="row px-2 py-2">

                                                            <div class="col-12">
                                                                <div
                                                                    class="d-md-flex flex-md-row align-items-md-start py-2">
                                                                    <label
                                                                        class="lable1 text-end mx-2 mt-1 d-none d-md-inline"
                                                                        for="" style="width:300px;">Serial
                                                                        Number:</label>
                                                                    <label
                                                                        class="lable2 text-start mx-2 mt-1  d-md-none "
                                                                        for="">Serial Number
                                                                        :</label>
                                                                    <input type="number" class="form-control"
                                                                        placeholder="Ex, 132"
                                                                        name="quotationItemSrNumber[]"
                                                                        value="{{ $quotation_item_srNumbers }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div
                                                                    class="d-md-flex flex-md-row align-items-md-start py-2">
                                                                    <label
                                                                        class="lable1 text-end mx-2 mt-1 d-none d-md-inline"
                                                                        for=""
                                                                        style="width:300px;">Description:</label>
                                                                    <label
                                                                        class="lable2 text-start mx-2 mt-1  d-md-none "
                                                                        for="">Description
                                                                        :</label>
                                                                    {{-- <textarea name="quotationItemDescription[]" id="quotationItemDescription" class="form-control" placeholder="Ex, Description" cols="30" rows="2">{{ $quotation_item_description[$key] }}</textarea> --}}
                                                                    <select name="quotationItemDescription[]"
                                                                        id="quotationItemDescription"
                                                                        class="form-control">
                                                                        @if (isset($quotation_item_description[$key]))
                                                                            @php
                                                                                $item = DB::table('stock_records')
                                                                                    ->where(
                                                                                        'id',
                                                                                        $quotation_item_description[
                                                                                            $key
                                                                                        ],
                                                                                    )
                                                                                    ->first();
                                                                            @endphp
                                                                        @endif
                                                                        <option
                                                                            value="{{ $quotation_item_description[$key] }}">
                                                                            {{ $item ? $item->item_name : '' }}
                                                                        </option>
                                                                        @if ($selectStock->isEmpty())
                                                                        @else
                                                                            @foreach ($selectStock as $selectStocks)
                                                                                <option value="{{ $selectStocks->id }}">
                                                                                    {{ $selectStocks->item_name }}
                                                                                </option>
                                                                            @endforeach
                                                                        @endif

                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div
                                                                    class="d-md-flex flex-md-row align-items-md-start py-2">
                                                                    <label
                                                                        class="lable1 text-end mx-2 mt-1 d-none d-md-inline"
                                                                        for=""
                                                                        style="width:300px;">Amount/Rate:</label>
                                                                    <label
                                                                        class="lable2 text-start mx-2 mt-1  d-md-none "
                                                                        for="">Amount/Rate
                                                                        :</label>
                                                                    <input type="number" class="form-control"
                                                                        placeholder="Ex, 132"
                                                                        name="quotationItemAmount[]"
                                                                        value="{{ $quotation_total_price[$key] }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                            {{--  --}}
                                            @php
                                                $totalAmount = 0;
                                                $quotation_total_price = isset($selectInvoicess->invoice_total_price)
                                                    ? json_decode($selectInvoicess->invoice_total_price, true)
                                                    : [];

                                                foreach ($quotation_total_price as $key => $invoice_total_prices) {
                                                    $totalAmount += $invoice_total_prices;
                                                }
                                            @endphp

                                            {{--  --}}
                                            <div class="col-12">
                                                <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                                    <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline"
                                                        for="" style="width:300px;">Total Amount:</label>
                                                    <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                                        for="">Total Amount
                                                        :</label>
                                                    <input type="number" class="form-control" placeholder="Ex, 132"
                                                        name="totalAmount" value="{{ $totalAmount }}">
                                                </div>
                                            </div>
                                            {{--  --}}
                                            <div class="col-12">
                                                <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                                    <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline"
                                                        for="" style="width:300px;">Payment Type:</label>
                                                    <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                                        for="">Payment Type
                                                        :</label>
                                                    {{-- <input type="text" class="form-control" placeholder="Ex, 123abc" name="companyNTNNumber"> --}}
                                                    <select name="clientPayementType" id="clientPayementType"
                                                        class="form-control">
                                                        <option value="">Select Payment Type</option>
                                                        <option value="0">Payment Pending</option>
                                                        <option value="1">Payment Received</option>
                                                    </select>
                                                </div>
                                            </div>
                                            {{--  --}}
                                            <div class="col-12">
                                                <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                                    <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline"
                                                        for="" style="width:300px;">Notes:</label>
                                                    <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                                        for="">Notes
                                                        :</label>
                                                    <textarea name="clientNotes" id="clientNotes" cols="30" rows="5" class="form-control"
                                                        placeholder="Ex, Taxila punjab pakistan"></textarea>
                                                </div>
                                            </div>
                                            {{--  --}}
                                            @php
                                                // Retrieve data from client_account_historys table based on invoice_client_id
                                                $tableDataCount = \DB::table('client_account_historys')
                                                    ->where('account_name', '=', $selectInvoicess->invoice_client_id)
                                                    ->get();

                                                $totalQtv = 0;
                                                $price = 0;
                                                $grandTotalAmount = 0;
                                                $amount = 0;

                                                if ($tableDataCount->isNotEmpty()) {
                                                    // Extract the last record from retrieved data
                                                    $lastRecord = $tableDataCount->last();
                                                    $previousAmount = $lastRecord->Previous_amount;
                                                    $preAmount = $previousAmount;
                                                    $totalAmounts = 0;

                                                    // Extract total amount from invoice_total_price
                                                    // $quotation_total_price = isset($selectInvoicess->invoice_total_price) ? json_decode($selectInvoicess->invoice_total_price, true) : [];
                                                    // foreach ($quotation_total_price as $key => $invoice_total_prices) {
                                                    //     $totalAmounts += $invoice_total_prices;
                                                    // }
                                                    $totalAmounts = $lastRecord->invoice_grant_total_amount;

                                                    // Calculate price based on payment type and GST text
                                                    if ($lastRecord->payment_type == '0') {
                                                        $price = $totalAmounts;
                                                        $grandTotalAmount = $preAmount + $price;
                                                    } else {
                                                        $price = 0;
                                                        $grandTotalAmount = $preAmount + $price;
                                                    }
                                                }
                                            @endphp
                                            @if ($tableDataCount)
                                                <div class="col-12 d-none">
                                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline"
                                                            for="" style="width:300px;">Previous
                                                            Amount:</label>
                                                        <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                                            for="">Previous Amount
                                                            :</label>
                                                        <input type="number" class="form-control"
                                                            placeholder="Ex, 132" name="previousAmount"
                                                            value="{{ $grandTotalAmount }}">
                                                    </div>
                                                </div>
                                            @else
                                                <div class="col-12 d-none">
                                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline"
                                                            for="" style="width:300px;">Previous
                                                            Amount:</label>
                                                        <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                                            for="">Previous Amount
                                                            :</label>
                                                        <input type="number" class="form-control"
                                                            placeholder="Ex, 132" name="previousAmount"
                                                            value="0">
                                                    </div>
                                                </div>
                                            @endif
                                            @if (!empty($selectInvoicess->invoice_gsttext))
                                                {{--  --}}
                                                <div class="col-12 d-none">
                                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline"
                                                            for="" style="width:300px;">GST Text:</label>
                                                        <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                                            for="">GST Text
                                                            :</label>
                                                        <input type="number" class="form-control"
                                                            placeholder="Ex, 132" name="gstText"
                                                            value="{{ $selectInvoicess->invoice_gsttext }}">
                                                    </div>
                                                </div>
                                            @else
                                                <div class="col-12 d-none">
                                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline"
                                                            for="" style="width:300px;">GST Text:</label>
                                                        <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                                            for="">GST Text
                                                            :</label>
                                                        <input type="number" class="form-control"
                                                            placeholder="Ex, 132" name="gstText" value="0">
                                                    </div>
                                                </div>
                                            @endif
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-outline-primary">Save</button>
                            </div>
                        </form>
                        {{--  --}}
                    @else
                        {{--  --}}
                        {{-- disposible items wala --}}
                        <form action="{{ route('createOperationAccountHistoryDisposibleOperations') }}"
                            method="post" class="row" enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-10 py-2 px-2">
                                <div class="row px-2 py-2">
                                    <h3 class="text-start d-none d-md-block">For Disposible Items</h3>
                                    <h3 class="text-center d-md-none ">For Disposible Items</h3>
                                    <div class="col-12 d-none">

                                        <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                            <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                                style="width:300px;">Client ID:</label>
                                            <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                                for="">Client ID
                                                :</label>
                                            <input type="text" class="form-control" placeholder="Ex, demo client"
                                                name="clientId" value="{{ $selectInvoicess->invoice_client_id }}">
                                        </div>
                                    </div>
                                    {{--  --}}
                                    <div class="col-12 d-none">
                                        <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                            <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                                style="width:300px;">Invoice Id:</label>
                                            <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                                for="">Invoice Id
                                                :</label>
                                            <input type="text" class="form-control" placeholder="Ex, abc@abc.com"
                                                name="invoiceId" value="{{ $selectInvoicess->id }}">
                                        </div>
                                    </div>
                                    {{--  --}}
                                    {{--  --}}
                                    {{--  --}}
                                    @php
                                        $quotation_item_srNumber = isset($selectInvoicess->invoice_item_srNumber)
                                            ? json_decode($selectInvoicess->invoice_item_srNumber, true)
                                            : [];
                                        $quotation_item_description = isset($selectInvoicess->item_id)
                                            ? json_decode($selectInvoicess->item_id, true)
                                            : [];
                                        $quotation_item_name = isset($selectInvoicess->item_name)
                                            ? json_decode($selectInvoicess->item_name, true)
                                            : [];
                                        $quotation_total_price = isset($selectInvoicess->invoice_total_price)
                                            ? json_decode($selectInvoicess->invoice_total_price, true)
                                            : [];
                                        $quotation_item_disposible_batchNo = isset(
                                            $selectInvoicess->invoice_item_disposible_batchNo,
                                        )
                                            ? json_decode($selectInvoicess->invoice_item_disposible_batchNo, true)
                                            : [];
                                        $quotation_item_disposible_expDate = isset(
                                            $selectInvoicess->invoice_item_disposible_expDate,
                                        )
                                            ? json_decode($selectInvoicess->invoice_item_disposible_expDate, true)
                                            : [];
                                        $quotation_item_disposible_qtv = isset(
                                            $selectInvoicess->invoice_item_disposible_qtv,
                                        )
                                            ? json_decode($selectInvoicess->invoice_item_disposible_qtv, true)
                                            : [];
                                        $quotation_item_disposible_pricePerUnit = isset(
                                            $selectInvoicess->invoice_item_disposible_pricePerUnit,
                                        )
                                            ? json_decode($selectInvoicess->invoice_item_disposible_pricePerUnit, true)
                                            : [];
                                    @endphp
                                    @foreach ($quotation_item_srNumber as $key => $quotation_item_srNumbers)
                                        <div id="add_form">
                                            <div id="show_items4">
                                                <div class="row px-2 py-2">

                                                    <div class="col-12">
                                                        <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                                            <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline"
                                                                for="" style="width:300px;">Serial
                                                                Number:</label>
                                                            <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                                                for="">Serial Number
                                                                :</label>
                                                            <input type="number" class="form-control"
                                                                placeholder="Ex, 132" name="quotationItemSrNumber[]"
                                                                value="{{ $quotation_item_srNumbers }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div
                                                            class="d-md-flex flex-md-row align-items-md-start
                                                                    py-2">
                                                            <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline"
                                                                for=""
                                                                style="width:300px;">Description:</label>
                                                            <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                                                for="">Description
                                                                :</label>
                                                            <select name="quotationItemDescription[]"
                                                                id="quotationItemDescription" class="form-control">
                                                                @if (isset($quotation_item_description[$key]))
                                                                    @php
                                                                        $item = DB::table('stock_records')
                                                                            ->where(
                                                                                'id',
                                                                                $quotation_item_description[$key],
                                                                            )
                                                                            ->first();
                                                                    @endphp
                                                                @endif
                                                                <option
                                                                    value="{{ $quotation_item_description[$key] }}">
                                                                    {{ $item ? $item->item_name : '' }}
                                                                </option>
                                                                @if ($selectStock->isEmpty())
                                                                @else
                                                                    @foreach ($selectStock as $selectStocks)
                                                                        <option value="{{ $selectStocks->id }}">
                                                                            {{ $selectStocks->item_name }}
                                                                        </option>
                                                                    @endforeach
                                                                @endif

                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div
                                                            class="d-md-flex flex-md-row align-items-md-start
                                                                    py-2">
                                                            <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline"
                                                                for="" style="width:300px;">Batch
                                                                No:</label>
                                                            <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                                                for="">Batch No
                                                                :</label>
                                                            <input type="number" class="form-control"
                                                                placeholder="Ex, 132"
                                                                name="quotationItemBatchNumber[]"
                                                                value = "{{ $quotation_item_disposible_batchNo[$key] }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div
                                                            class="d-md-flex flex-md-row align-items-md-start
                                                                    py-2">
                                                            <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline"
                                                                for="" style="width:300px;">Expire
                                                                Date:</label>
                                                            <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                                                for="">Expire Date
                                                                :</label>
                                                            <input type="date" class="form-control"
                                                                placeholder="Ex, 12-12-0000"
                                                                name="quotationItemExpireDate[]"
                                                                value = "{{ $quotation_item_disposible_expDate[$key] }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div
                                                            class="d-md-flex flex-md-row align-items-md-start
                                                                    py-2">
                                                            <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline"
                                                                for="" style="width:300px;">Qty:</label>
                                                            <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                                                for="">Qty
                                                                :</label>
                                                            <input type="number" class="form-control"
                                                                placeholder="Ex, 132" name="quotationItemQtv[]"
                                                                value = "{{ $quotation_item_disposible_qtv[$key] }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div
                                                            class="d-md-flex flex-md-row align-items-md-start
                                                                    py-2">
                                                            <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline"
                                                                for="" style="width:300px;">Price:</label>
                                                            <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                                                for="">Price
                                                                :</label>
                                                            <input type="number" class="form-control"
                                                                placeholder="Ex, 132" name="quotationItemPrice[]"
                                                                value = "{{ $quotation_item_disposible_pricePerUnit[$key] }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                                            <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline"
                                                                for="" style="width:300px;">Total
                                                                Amount:</label>
                                                            <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                                                for="">Total Amount
                                                                :</label>
                                                            <input type="number" class="form-control"
                                                                placeholder="Ex, 132" name="quotationItemAmount[]"
                                                                value="{{ $quotation_total_price[$key] }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    @php
                                        $totalAmount = 0;
                                        $quotation_total_price = isset($selectInvoicess->invoice_total_price)
                                            ? json_decode($selectInvoicess->invoice_total_price, true)
                                            : [];

                                        foreach ($quotation_total_price as $key => $invoice_total_prices) {
                                            $totalAmount += $invoice_total_prices;
                                        }

                                    @endphp

                                    <div class="col-12">
                                        <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                            <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                                style="width:300px;">Total Amount:</label>
                                            <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                                for="">Total Amount
                                                :</label>
                                            <input type="number" class="form-control" placeholder="Ex, 132"
                                                name="totalAmount" value="{{ $totalAmount }}">
                                        </div>
                                    </div>
                                    {{--  --}}
                                    <div class="col-12">
                                        <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                            <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                                style="width:300px;">Payment Type:</label>
                                            <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                                for="">Payment Type
                                                :</label>
                                            {{-- <input type="text" class="form-control" placeholder="Ex, 123abc" name="companyNTNNumber"> --}}
                                            <select name="clientPayementType" id="clientPayementType"
                                                class="form-control">
                                                <option value="">Select Payment Type</option>
                                                <option value="0">Payment Pending</option>
                                                <option value="1">Payment Received</option>
                                            </select>
                                        </div>
                                    </div>
                                    {{--  --}}
                                    <div class="col-12">
                                        <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                            <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                                style="width:300px;">Notes:</label>
                                            <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                                for="">Notes
                                                :</label>
                                            <textarea name="clientNotes" id="clientNotes" cols="30" rows="5" class="form-control"
                                                placeholder="Ex, Taxila punjab pakistan"></textarea>
                                        </div>
                                    </div>
                                    @php
                                        // Retrieve data from client_account_historys table based on invoice_client_id
                                        $tableDataCount = \DB::table('client_account_historys')
                                            ->where('account_name', '=', $selectInvoicess->invoice_client_id)
                                            ->get();

                                        $totalQtv = 0;
                                        $price = 0;
                                        $grandTotalAmount = 0;
                                        $amount = 0;

                                        if ($tableDataCount->isNotEmpty()) {
                                            // Extract the last record from retrieved data
                                            $lastRecord = $tableDataCount->last();
                                            $previousAmount = $lastRecord->Previous_amount;
                                            $preAmount = $previousAmount;
                                            $totalAmounts = 0;

                                            // Extract total amount from invoice_total_price
                                            $totalAmounts = $lastRecord->invoice_grant_total_amount;

                                            // Calculate price based on payment type and GST text
                                            if ($lastRecord->payment_type == '0') {
                                                $price = $totalAmounts;
                                                $grandTotalAmount = $preAmount + $price;
                                            } else {
                                                $price = 0;
                                                $grandTotalAmount = $preAmount + $price;
                                            }
                                        }
                                    @endphp
                                    {{-- @endphp --}}
                                    @if ($tableDataCount)
                                        <div class="col-12 d-none">
                                            <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                                <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline"
                                                    for="" style="width:300px;">Previous
                                                    Amount:</label>
                                                <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                                    for="">Previous Amount
                                                    :</label>
                                                <input type="number" class="form-control" placeholder="Ex, 132"
                                                    name="previousAmount" value="{{ $grandTotalAmount }}">
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-12 d-none">
                                            <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                                <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline"
                                                    for="" style="width:300px;">Previous
                                                    Amount:</label>
                                                <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                                    for="">Previous Amount
                                                    :</label>
                                                <input type="number" class="form-control" placeholder="Ex, 132"
                                                    name="previousAmount" value="0">
                                            </div>
                                        </div>
                                    @endif
                                    @if (!empty($selectInvoicess->invoice_gsttext))
                                        <div class="col-12 d-none">
                                            <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                                <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline"
                                                    for="" style="width:300px;">GST Text:</label>
                                                <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                                    for="">GST Text
                                                    :</label>
                                                <input type="number" class="form-control" placeholder="Ex, 132"
                                                    name="gstText" value="{{ $selectInvoicess->invoice_gsttext }}">
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-12 d-none">
                                            <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                                <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline"
                                                    for="" style="width:300px;">GST Text:</label>
                                                <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                                    for="">GST Text
                                                    :</label>
                                                <input type="number" class="form-control" placeholder="Ex, 132"
                                                    name="gstText" value="0">
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-outline-primary">Save</button>
                            </div>
                        </form>
                        {{--  --}}
                    @endif
                @else
                    {{--  --}}
                    {{-- repairing scope wala --}}
                    <form action="{{ route('createOperationAccountHistoryRepairing_Operation') }}" method="post"
                        class="row" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-10 py-2 px-2">
                            <div class="row px-2 py-2">
                                <h3 class="text-start d-none d-md-block">For Repairing Scopes</h3>
                                <h3 class="text-center d-md-none ">For Repairing Scopes</h3>
                                <div class="col-12 d-none">
                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                            style="width:300px;">Client ID:</label>
                                        <label class="lable2 text-start mx-2 mt-1  d-md-none " for="">Client
                                            ID
                                            :</label>
                                        <input type="text" class="form-control" placeholder="Ex, demo client"
                                            name="clientId" value="{{ $selectInvoicess->invoice_client_id }}">
                                    </div>
                                </div>
                                {{--  --}}
                                <div class="col-12 d-none">
                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                            style="width:300px;">Invoice Id:</label>
                                        <label class="lable2 text-start mx-2 mt-1  d-md-none " for="">Invoice
                                            Id
                                            :</label>
                                        <input type="text" class="form-control" placeholder="Ex, abc@abc.com"
                                            name="invoiceId" value="{{ $selectInvoicess->id }}">
                                    </div>
                                </div>
                                {{--  --}}

                                @php
                                    $quotation_item_srNumber = isset($selectInvoicess->invoice_item_srNumber)
                                        ? json_decode($selectInvoicess->invoice_item_srNumber, true)
                                        : [];
                                    $quotation_scope_model = isset($selectInvoicess->invoice_scope_model)
                                        ? json_decode($selectInvoicess->invoice_scope_model, true)
                                        : [];
                                    $quotation_total_price = isset($selectInvoicess->invoice_total_price)
                                        ? json_decode($selectInvoicess->invoice_total_price, true)
                                        : [];
                                    $quotation_scope_srno = isset($selectInvoicess->invoice_scope_srno)
                                        ? json_decode($selectInvoicess->invoice_scope_srno, true)
                                        : [];
                                    $quotation_need_work = isset($selectInvoicess->invoice_need_work)
                                        ? json_decode($selectInvoicess->invoice_need_work, true)
                                        : [];
                                @endphp
                                {{--  --}}
                                <div id="add_form">
                                    @foreach ($quotation_item_srNumber as $key => $quotation_item_srNumbers)
                                        <div id="show_items7">
                                            <div class="row px-2 py-2">
                                                <div class="col-12">
                                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline"
                                                            for="" style="width:300px;">Serial
                                                            Number:</label>
                                                        <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                                            for="">Serial Number
                                                            :</label>
                                                        <input type="number" class="form-control"
                                                            placeholder="Ex, 132" name="quotationItemSrNumber[]"
                                                            value="{{ $quotation_item_srNumbers }}">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline"
                                                            for="" style="width:300px;">Scope
                                                            Model:</label>
                                                        <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                                            for="">Scope Model
                                                            :</label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Ex, cf-140L" name="quotationItemScopeModel[]"
                                                            value="{{ $quotation_scope_model[$key] }}">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline"
                                                            for="" style="width:300px;">Scope Sr
                                                            No:</label>
                                                        <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                                            for="">Scope Sr No
                                                            :</label>
                                                        <input type="number" class="form-control"
                                                            placeholder="Ex, 132" name="quotationItemScopeSrNumber[]"
                                                            value="{{ $quotation_scope_srno[$key] }}">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline"
                                                            for="" style="width:300px;">Done
                                                            Work:</label>
                                                        <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                                            for="">Done Work
                                                            :</label>
                                                        <textarea name="quotationItemNeedWork[]" id="quotationItemNeedWork" class="form-control"
                                                            placeholder="Ex, Description" cols="30" rows="5">{{ $quotation_need_work[$key] }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline"
                                                            for="" style="width:300px;">Amount/Rate:</label>
                                                        <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                                            for="">Amount/Rate
                                                            :</label>
                                                        <input type="number" class="form-control"
                                                            placeholder="Ex, 132" name="quotationItemAmount[]"
                                                            value="{{ $quotation_total_price[$key] }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                @endforeach
                {{--  --}}
                @php
                    $totalAmount = 0;
                    $quotation_total_price = isset($selectInvoicess->invoice_total_price)
                        ? json_decode($selectInvoicess->invoice_total_price, true)
                        : [];

                    foreach ($quotation_total_price as $key => $invoice_total_prices) {
                        $totalAmount += $invoice_total_prices;
                    }

                @endphp
                <div class="col-12">
                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                            style="width:300px;">Total Amount:</label>
                        <label class="lable2 text-start mx-2 mt-1  d-md-none " for="">Total Amount
                            :</label>
                        <input type="number" class="form-control" placeholder="Ex, 132" name="totalAmount"
                            value="{{ $totalAmount }}">
                    </div>
                </div>
                <div class="col-12">
                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                            style="width:300px;">Payment Type:</label>
                        <label class="lable2 text-start mx-2 mt-1  d-md-none " for="">Payment Type
                            :</label>
                        {{-- <input type="text" class="form-control" placeholder="Ex, 123abc" name="companyNTNNumber"> --}}
                        <select name="clientPayementType" id="clientPayementType" class="form-control">
                            <option value="">Select Payment Type</option>
                            <option value="0">Payment Pending</option>
                            <option value="1">Payment Received</option>
                        </select>
                    </div>
                </div>
                {{--  --}}
                <div class="col-12">
                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                            style="width:300px;">Notes:</label>
                        <label class="lable2 text-start mx-2 mt-1  d-md-none " for="">Notes
                            :</label>
                        <textarea name="clientNotes" id="clientNotes" cols="30" rows="5" class="form-control"
                            placeholder="Ex, Taxila punjab pakistan"></textarea>
                    </div>
                </div>
                @php
                    // Retrieve data from client_account_historys table based on invoice_client_id
                    $tableDataCount = \DB::table('client_account_historys')
                        ->where('account_name', '=', $selectInvoicess->invoice_client_id)
                        ->get();

                    $totalQtv = 0;
                    $price = 0;
                    $grandTotalAmount = 0;
                    $amount = 0;

                    if ($tableDataCount->isNotEmpty()) {
                        // Extract the last record from retrieved data
                        $lastRecord = $tableDataCount->last();
                        $previousAmount = $lastRecord->Previous_amount;
                        $preAmount = $previousAmount;
                        $totalAmounts = 0;

                        // Extract total amount from invoice_total_price
                        $totalAmounts = $lastRecord->invoice_grant_total_amount;

                        // Calculate price based on payment type and GST text
                        if ($lastRecord->payment_type == '0') {
                            $price = $totalAmounts;
                            $grandTotalAmount = $preAmount + $price;
                        } else {
                            $price = 0;
                            $grandTotalAmount = $preAmount + $price;
                        }
                    }
                @endphp
                @if ($tableDataCount)
                    <div class="col-12 d-none">
                        <div class="d-md-flex flex-md-row align-items-md-start py-2">
                            <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                style="width:300px;">Previous Amount:</label>
                            <label class="lable2 text-start mx-2 mt-1  d-md-none " for="">Previous Amount
                                :</label>
                            <input type="number" class="form-control" placeholder="Ex, 132" name="previousAmount"
                                value="{{ $grandTotalAmount }}">
                        </div>
                    </div>
                @else
                    <div class="col-12 d-none">
                        <div class="d-md-flex flex-md-row align-items-md-start py-2">
                            <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                style="width:300px;">Previous Amount:</label>
                            <label class="lable2 text-start mx-2 mt-1  d-md-none " for="">Previous Amount
                                :</label>
                            <input type="number" class="form-control" placeholder="Ex, 132" name="previousAmount"
                                value="0">
                        </div>
                    </div>
                @endif
                @if (!empty($selectInvoicess->invoice_gsttext))
                    <div class="col-12 d-none">
                        <div class="d-md-flex flex-md-row align-items-md-start py-2">
                            <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                style="width:300px;">GST Text:</label>
                            <label class="lable2 text-start mx-2 mt-1  d-md-none " for="">GST Text
                                :</label>
                            <input type="number" class="form-control" placeholder="Ex, 132" name="gstText"
                                value="{{ $selectInvoicess->invoice_gsttext }}">
                        </div>
                    </div>
                @else
                    <div class="col-12 d-none">
                        <div class="d-md-flex flex-md-row align-items-md-start py-2">
                            <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                style="width:300px;">GST Text:</label>
                            <label class="lable2 text-start mx-2 mt-1  d-md-none " for="">GST Text
                                :</label>
                            <input type="number" class="form-control" placeholder="Ex, 132" name="gstText"
                                value="0">
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-outline-primary">Save</button>
        </div>
        </form>
        {{--  --}}
        @endif
        {{--  --}}
    </div>
    </div>
    </div>
    <script src="/themes/public/vendors/popper/popper.min.js"></script>
    <script src="/themes/public/vendors/bootstrap/bootstrap.min.js"></script>
    <script src="/themes/public/vendors/anchorjs/anchor.min.js"></script>
    <script src="/themes/public/vendors/is/is.min.js"></script>
    <script src="/themes/public/vendors/echarts/echarts.min.js"></script>
    <script src="/themes/public/vendors/fontawesome/all.min.js"></script>
    <script src="/themes/public/vendors/lodash/lodash.min.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
    <script src="/themes/public/vendors/list.js/list.min.js"></script>
    <script src="/themes/public/assets/js/theme.js"></script>
    <script src="/jquery-3.7.1.min.js"></script>
    <script src="/custom.js"></script>
</body>

</html>
