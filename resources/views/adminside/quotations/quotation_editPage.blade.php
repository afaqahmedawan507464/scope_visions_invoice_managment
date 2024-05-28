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
    <title>Scope Visions | Edit Quotation</title>
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
                            <a href="{{ route('quotationListPage') }}" class="btn btn-outline-primary"><i class="fas fa-angle-left me-2"></i>Back</a>
                        </div> --}}
                        <div class="col-12">
                            <h2 class="text-end d-none d-md-block">Edit Quotation</h2>
                            <h4 class="text-center d-md-none ">Edit Quotation</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @foreach ($selectQuotation as $selectQuotations)
                @endforeach
                @if ($selectQuotations->quotation_scope_model == '')

                    @if ($selectQuotations->quotation_item_disposible_batchNo == '')
                        <form action="{{ route('editQuotationRepairingOperation', $selectQuotations->id) }}"
                            method="post" class="row" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="col-md-10 py-2 px-2">
                                {{--  --}}
                                <h4 class="text-start d-none d-md-block">Quotation Basic Information</h4>
                                <h4 class="text-center d-md-none ">Quotation Basic Information</h4>
                                {{--  --}}
                                <div class="row px-2 py-2">
                                    <div class="col-12">
                                        <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                            <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                                style="width:300px;">Quotation Number:</label>
                                            <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                                for="">Quotation Number
                                                :</label>
                                            <input type="text" class="form-control" placeholder="Ex, ABC123"
                                                name="quotationNumber"
                                                value="{{ $selectQuotations->quotation_number }}">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                            <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                                style="width:300px;">Billing To:</label>
                                            <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                                for="">Billing
                                                To
                                                :</label>
                                            <select name="quotationClient" id="quotationClient" class="form-control">
                                                <option value="{{ $selectQuotations->client_id }}">
                                                    {{ $selectQuotations->client_name }}</option>
                                                @if ($selectClient->isEmpty())
                                                @else
                                                    @foreach ($selectClient as $selectClients)
                                                        <option value="{{ $selectClients->id }}">
                                                            {{ $selectClients->client_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                            <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                                style="width:300px;">Date:</label>
                                            <label class="lable2 text-start mx-2 mt-1  d-md-none " for="">Date
                                                :</label>
                                            <input type="date" class="form-control" placeholder="Ex, 12-12-0000"
                                                name="quotationDate"value="{{ $selectQuotations->quotation_date }}">
                                        </div>
                                    </div>
                                    <div class="col-12 d-none">
                                        <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                            <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                                style="width:300px;"></label>
                                            <label class="lable2 text-start mx-2 mt-1  d-md-none " for="">
                                            </label>
                                            <textarea name="quotationHeading" id="quotationHeading" class="form-control" placeholder="Ex, Data" cols="30"
                                                rows="4">{{ $selectQuotations->quotation_heading }}</textarea>
                                        </div>
                                    </div>
                                    {{--  --}}
                                </div>
                                {{--  --}}
                                <h4 class="text-start d-none d-md-block">Quotation Item Details</h4>
                                <h4 class="text-center d-md-none ">Quotation Item Details</h4>
                                {{--  --}}
                                @php
                                    $quotation_item_srNumber = isset($selectQuotations->quotation_item_srNumber)
                                        ? json_decode($selectQuotations->quotation_item_srNumber, true)
                                        : [];
                                    $quotation_item_description = isset($selectQuotations->quotation_item_decription)
                                        ? json_decode($selectQuotations->quotation_item_decription, true)
                                        : [];
                                    $quotation_total_price = isset($selectQuotations->quotation_total_price)
                                        ? json_decode($selectQuotations->quotation_total_price, true)
                                        : [];
                                @endphp
                                {{--  --}}
                                @foreach ($quotation_item_srNumber as $key => $quotation_item_srNumbers)
                                    <div id="add_form">
                                        <div id="show_items">
                                            <div class="row px-2 py-2">
                                                <div class="col-12">
                                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline"
                                                            for="" style="width:300px;">Serial Number:</label>
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
                                                            for="" style="width:300px;">Description:</label>
                                                        <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                                            for="">Description
                                                            :</label>
                                                        <select name="quotationItemDescription[]"
                                                            id="quotationItemDescription" class="form-control">
                                                            @if (isset($quotation_item_description[$key]))
                                                                @php
                                                                    $item = DB::table('stock_records')
                                                                        ->where('id', $quotation_item_description[$key])
                                                                        ->first();
                                                                @endphp
                                                            @endif
                                                            <option value="{{ $quotation_item_description[$key] }}">
                                                                {{ $item ? $item->item_name : '' }}</option>
                                                            @if ($selectStock->isEmpty())
                                                            @else
                                                                @foreach ($selectStock as $selectStocks)
                                                                    <option value="{{ $selectStocks->id }}">
                                                                        {{ $selectStocks->item_name }}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
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
                                <h4 class="text-start d-none d-md-block">Term And Conditions</h4>
                                <h4 class="text-center d-md-none ">Term And Conditions</h4>
                                {{--  --}}
                                @php
                                    $quotation_termAndConditions = isset($selectQuotations->quotation_termAndConditions)
                                        ? json_decode($selectQuotations->quotation_termAndConditions, true)
                                        : [];
                                @endphp
                                {{--  --}}
                                @foreach ($quotation_termAndConditions as $quotation_termAndCondition)
                                    {{--  --}}
                                    <div id="add_form1">
                                        <div id="show_items1">
                                            <div class="row px-2 py-2">
                                                <div class="col-12">
                                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline"
                                                            for="" style="width:300px;"></label>
                                                        <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                                            for="">
                                                        </label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Ex, Term And Conditions"
                                                            name="quotationTermAndConditions[]"
                                                            value="{{ $quotation_termAndCondition }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{--  --}}
                                @endforeach
                                {{--  --}}
                                @if (empty($selectQuotations->quotation_gsttext))
                                @else
                                    {{--  --}}
                                    <h4 class="text-start d-none d-md-block">Quotation GST Text</h4>
                                    <h4 class="text-center d-md-none ">Quotation GST Text</h4>
                                    {{--  --}}
                                    <div class="row px-2 py-2">
                                        <div class="col-12">
                                            <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                                <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline"
                                                    for="" style="width:300px;">GST Text:</label>
                                                <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                                    for="">GST Text
                                                    :</label>
                                                <input type="text" class="form-control" placeholder="Ex, ABC123"
                                                    name="quotationGstText"
                                                    value="{{ $selectQuotations->quotation_gsttext }}">
                                            </div>
                                        </div>
                                        {{--  --}}
                                        {{--  --}}
                                    </div>
                                @endif
                                {{--  --}}
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-outline-primary">Update</button>
                            </div>
                        </form>
                    @else
                        <form action="{{ route('editQuotationDisposibleOperation', $selectQuotations->id) }}"
                            method="post" class="row" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="col-md-10 py-2 px-2">
                                {{--  --}}
                                <h4 class="text-start d-none d-md-block">Quotation Basic Information</h4>
                                <h4 class="text-center d-md-none ">Quotation Basic Information</h4>
                                {{--  --}}
                                <div class="row px-2 py-2">
                                    <div class="col-12">
                                        <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                            <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                                style="width:300px;">Quotation Number:</label>
                                            <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                                for="">Quotation Number
                                                :</label>
                                            <input type="text" class="form-control" placeholder="Ex, ABC123"
                                                name="quotationNumber"
                                                value="{{ $selectQuotations->quotation_number }}">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                            <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                                style="width:300px;">Billing To:</label>
                                            <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                                for="">Billing
                                                To
                                                :</label>
                                            <select name="quotationClient" id="quotationClient" class="form-control">
                                                <option value="{{ $selectQuotations->client_id }}">
                                                    {{ $selectQuotations->client_name }}</option>
                                                @if ($selectClient->isEmpty())
                                                @else
                                                    @foreach ($selectClient as $selectClients)
                                                        <option value="{{ $selectClients->id }}">
                                                            {{ $selectClients->client_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                            <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                                style="width:300px;">Date:</label>
                                            <label class="lable2 text-start mx-2 mt-1  d-md-none " for="">Date
                                                :</label>
                                            <input type="date" class="form-control" placeholder="Ex, 12-12-0000"
                                                name="quotationDate"value="{{ $selectQuotations->quotation_date }}">
                                        </div>
                                    </div>
                                    <div class="col-12 d-none">
                                        <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                            <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                                style="width:300px;"></label>
                                            <label class="lable2 text-start mx-2 mt-1  d-md-none " for="">
                                            </label>
                                            <textarea name="quotationHeading" id="quotationHeading" class="form-control" placeholder="Ex, Data" cols="30"
                                                rows="4">{{ $selectQuotations->quotation_heading }}</textarea>
                                        </div>
                                    </div>
                                    {{--  --}}
                                    {{--  --}}
                                </div>
                                {{--  --}}
                                <h4 class="text-start d-none d-md-block">Quotation Item Details</h4>
                                <h4 class="text-center d-md-none ">Quotation Item Details</h4>
                                {{--  --}}
                                @php
                                    $quotation_item_srNumber = isset($selectQuotations->quotation_item_srNumber)
                                        ? json_decode($selectQuotations->quotation_item_srNumber, true)
                                        : [];
                                    $quotation_item_description = isset($selectQuotations->item_id)
                                        ? json_decode($selectQuotations->item_id, true)
                                        : [];
                                    $quotation_total_price = isset($selectQuotations->quotation_total_price)
                                        ? json_decode($selectQuotations->quotation_total_price, true)
                                        : [];
                                    $quotation_item_disposible_batchNo = isset(
                                        $selectQuotations->quotation_item_disposible_batchNo,
                                    )
                                        ? json_decode($selectQuotations->quotation_item_disposible_batchNo, true)
                                        : [];
                                    $quotation_item_disposible_expDate = isset(
                                        $selectQuotations->quotation_item_disposible_expDate,
                                    )
                                        ? json_decode($selectQuotations->quotation_item_disposible_expDate, true)
                                        : [];
                                    $quotation_item_disposible_qtv = isset(
                                        $selectQuotations->quotation_item_disposible_qtv,
                                    )
                                        ? json_decode($selectQuotations->quotation_item_disposible_qtv, true)
                                        : [];
                                    $quotation_item_disposible_pricePerUnit = isset(
                                        $selectQuotations->quotation_item_disposible_pricePerUnit,
                                    )
                                        ? json_decode($selectQuotations->quotation_item_disposible_pricePerUnit, true)
                                        : [];
                                @endphp
                                @foreach ($quotation_item_srNumber as $key => $quotation_item_srNumbers)
                                    <div id="add_form">
                                        <div id="show_items4">
                                            <div class="row px-2 py-2">
                                                <div class="col-12">
                                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline"
                                                            for="" style="width:300px;">Serial Number:</label>
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
                                                            for="" style="width:300px;">Description:</label>
                                                        <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                                            for="">Description
                                                            :</label>
                                                        <select name="quotationItemDescription[]"
                                                            id="quotationItemDescription" class="form-control">
                                                            @if (isset($quotation_item_description[$key]))
                                                                @php
                                                                    $item = DB::table('stock_records')
                                                                        ->where('id', $quotation_item_description[$key])
                                                                        ->first();
                                                                @endphp
                                                            @endif
                                                            <option value="{{ $quotation_item_description[$key] }}">
                                                                {{ $item ? $item->item_name : '' }}</option>
                                                            @if ($selectStock->isEmpty())
                                                            @else
                                                                @foreach ($selectStock as $selectStocks)
                                                                    <option value="{{ $selectStocks->id }}">
                                                                        {{ $selectStocks->item_name }}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline"
                                                            for="" style="width:300px;">Batch No:</label>
                                                        <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                                            for="">Batch No
                                                            :</label>
                                                        <input type="number" class="form-control"
                                                            placeholder="Ex, 132" name="quotationItemBatchNumber[]"
                                                            value = "{{ $quotation_item_disposible_batchNo[$key] }}">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline"
                                                            for="" style="width:300px;">Expire Date:</label>
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
                                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
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
                                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
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
                                                            for="" style="width:300px;">Total Amount:</label>
                                                        <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                                            for="">Total Amount
                                                            :</label>
                                                        <input type="number" class="form-control"
                                                            placeholder="Ex, 132" name="quotationItemAmount[]"
                                                            value="{{ $quotation_total_price[$key] }}">
                                                    </div>
                                                </div>
                                                {{--  --}}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <h4 class="text-start d-none d-md-block">Term And Conditions</h4>
                                <h4 class="text-center d-md-none ">Term And Conditions</h4>
                                {{--  --}}
                                {{--  --}}
                                @php
                                    $quotation_termAndConditions = isset($selectQuotations->quotation_termAndConditions)
                                        ? json_decode($selectQuotations->quotation_termAndConditions, true)
                                        : [];
                                @endphp
                                {{--  --}}
                                @foreach ($quotation_termAndConditions as $quotation_termAndCondition)
                                    {{--  --}}
                                    <div id="add_form1">
                                        <div id="show_items1">
                                            <div class="row px-2 py-2">
                                                <div class="col-12">
                                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline"
                                                            for="" style="width:300px;"></label>
                                                        <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                                            for="">
                                                        </label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Ex, Term And Conditions"
                                                            name="quotationTermAndConditions[]"
                                                            value="{{ $quotation_termAndCondition }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{--  --}}
                                @endforeach
                                {{--  --}}
                                @if (empty($selectQuotations->quotation_gsttext))
                                @else
                                    {{--  --}}
                                    <h4 class="text-start d-none d-md-block">Quotation GST Text</h4>
                                    <h4 class="text-center d-md-none ">Quotation GST Text</h4>
                                    {{--  --}}
                                    <div class="row px-2 py-2">
                                        <div class="col-12">
                                            <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                                <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline"
                                                    for="" style="width:300px;">GST Text:</label>
                                                <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                                    for="">GST Text
                                                    :</label>
                                                <input type="text" class="form-control" placeholder="Ex, ABC123"
                                                    name="quotationGstText"
                                                    value="{{ $selectQuotations->quotation_gsttext }}">
                                            </div>
                                        </div>
                                        {{--  --}}
                                        {{--  --}}
                                    </div>
                                @endif
                                <div class="col-12">
                                    <button type="submit" class="btn btn-outline-primary">Update</button>
                                </div>
                                {{--  --}}
                            </div>
                        </form>
                    @endif
                @else
                    <form action="{{ route('updateQuotationRepairing_Operations', $selectQuotations->id) }}"
                        method="post" class="row" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="col-md-10 py-2 px-2">
                            {{--  --}}
                            <h4 class="text-start d-none d-md-block">Quotation Basic Information</h4>
                            <h4 class="text-center d-md-none ">Quotation Basic Information</h4>
                            {{--  --}}
                            <div class="row px-2 py-2">
                                <div class="col-12">
                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                            style="width:300px;">Quotation Number:</label>
                                        <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                            for="">Quotation Number
                                            :</label>
                                        <input type="text" class="form-control" placeholder="Ex, ABC123"
                                            name="quotationNumber" value="{{ $selectQuotations->quotation_number }}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                            style="width:300px;">Billing To:</label>
                                        <label class="lable2 text-start mx-2 mt-1  d-md-none " for="">Billing
                                            To
                                            :</label>
                                        <select name="quotationClient" id="quotationClient" class="form-control">
                                            <option value="{{ $selectQuotations->client_id }}">
                                                {{ $selectQuotations->client_name }}</option>
                                            @if ($selectClient->isEmpty())
                                            @else
                                                @foreach ($selectClient as $selectClients)
                                                    <option value="{{ $selectClients->id }}">
                                                        {{ $selectClients->client_name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                            style="width:300px;">Date:</label>
                                        <label class="lable2 text-start mx-2 mt-1  d-md-none " for="">Date
                                            :</label>
                                        <input type="date" class="form-control" placeholder="Ex, 12-12-0000"
                                            name="quotationDate"value="{{ $selectQuotations->quotation_date }}">
                                    </div>
                                </div>
                                <div class="col-12 d-none">
                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                            style="width:300px;"></label>
                                        <label class="lable2 text-start mx-2 mt-1  d-md-none " for="">
                                        </label>
                                        <textarea name="quotationHeading" id="quotationHeading" class="form-control" placeholder="Ex, Data" cols="30"
                                            rows="4">{{ $selectQuotations->quotation_heading }}</textarea>
                                    </div>
                                </div>
                                {{--  --}}
                            </div>
                            {{--  --}}
                            <h4 class="text-start d-none d-md-block">Quotation Item Details</h4>
                            <h4 class="text-center d-md-none ">Quotation Item Details</h4>
                            {{--  --}}
                            @php
                                $quotation_item_srNumber = isset($selectQuotations->quotation_item_srNumber)
                                    ? json_decode($selectQuotations->quotation_item_srNumber, true)
                                    : [];
                                $quotation_scope_model = isset($selectQuotations->quotation_scope_model)
                                    ? json_decode($selectQuotations->quotation_scope_model, true)
                                    : [];
                                $quotation_total_price = isset($selectQuotations->quotation_total_price)
                                    ? json_decode($selectQuotations->quotation_total_price, true)
                                    : [];
                                $quotation_scope_srno = isset($selectQuotations->quotation_scope_srno)
                                    ? json_decode($selectQuotations->quotation_scope_srno, true)
                                    : [];
                                $quotation_scope_problem = isset($selectQuotations->quotation_scope_problem)
                                    ? json_decode($selectQuotations->quotation_scope_problem, true)
                                    : [];
                                $quotation_need_work = isset($selectQuotations->quotation_need_work)
                                    ? json_decode($selectQuotations->quotation_need_work, true)
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
                                                        for="" style="width:300px;">Serial Number:</label>
                                                    <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                                        for="">Serial Number
                                                        :</label>
                                                    <input type="number" class="form-control" placeholder="Ex, 132"
                                                        name="quotationItemSrNumber[]"
                                                        value="{{ $quotation_item_srNumbers }}">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                                    <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline"
                                                        for="" style="width:300px;">Scope Model:</label>
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
                                                        for="" style="width:300px;">Scope Sr No:</label>
                                                    <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                                        for="">Scope Sr No
                                                        :</label>
                                                    <input type="number" class="form-control" placeholder="Ex, 132"
                                                        name="quotationItemScopeSrNumber[]"
                                                        value="{{ $quotation_scope_srno[$key] }}">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                                    <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline"
                                                        for="" style="width:300px;">Problem:</label>
                                                    <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                                        for="">Problem
                                                        :</label>
                                                    <textarea name="quotationItemProblem[]" id="quotationItemProblem" class="form-control" placeholder="Ex, Description"
                                                        cols="30" rows="2">{{ $quotation_scope_problem[$key] }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                                    <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline"
                                                        for="" style="width:300px;">Need Work:</label>
                                                    <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                                        for="">Need Work
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
                                                    <input type="number" class="form-control" placeholder="Ex, 132"
                                                        name="quotationItemAmount[]"
                                                        value="{{ $quotation_total_price[$key] }}">
                                                </div>
                                            </div>
                                            {{--  --}}
                                        </div>
                                    </div>
                            </div>
                @endforeach
                <h4 class="text-start d-none d-md-block">Term And Conditions</h4>
                <h4 class="text-center d-md-none ">Term And Conditions</h4>

                {{--  --}}
                @php
                    $quotation_termAndConditions = isset($selectQuotations->quotation_termAndConditions)
                        ? json_decode($selectQuotations->quotation_termAndConditions, true)
                        : [];
                @endphp
                {{--  --}}
                @foreach ($quotation_termAndConditions as $quotation_termAndCondition)
                    {{--  --}}
                    <div id="add_form1">
                        <div id="show_items1">
                            <div class="row px-2 py-2">
                                <div class="col-12">
                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                            style="width:300px;"></label>
                                        <label class="lable2 text-start mx-2 mt-1  d-md-none " for="">
                                        </label>
                                        <input type="text" class="form-control"
                                            placeholder="Ex, Term And Conditions" name="quotationTermAndConditions[]"
                                            value="{{ $quotation_termAndCondition }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--  --}}
                @endforeach
                {{--  --}}
                @if (empty($selectQuotations->quotation_gsttext))
                @else
                    {{--  --}}
                    <h4 class="text-start d-none d-md-block">Quotation GST Text</h4>
                    <h4 class="text-center d-md-none ">Quotation GST Text</h4>

                    {{--  --}}
                    <div class="row px-2 py-2">
                        <div class="col-12">
                            <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                    style="width:300px;">GST Text:</label>
                                <label class="lable2 text-start mx-2 mt-1  d-md-none " for="">GST Text
                                    :</label>
                                <input type="text" class="form-control" placeholder="Ex, ABC123"
                                    name="quotationGstText" value="{{ $selectQuotations->quotation_gsttext }}">
                            </div>
                        </div>
                        {{--  --}}
                @endif
                {{--  --}}
            </div>
            {{--  --}}

            <div class="col-12">
                <button type="submit" class="btn btn-outline-primary">Save</button>
            </div>
            </form>

            @endif
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
