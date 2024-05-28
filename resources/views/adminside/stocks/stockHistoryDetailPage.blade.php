<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="theme-color" content="#ffffff">
    <script src="/themes/public/assets/js/config.js"></script>
    <script src="/themes/public/vendors/overlayscrollbars/OverlayScrollbars.min.js"></script>


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
    <link rel="stylesheet"
        href="/project scope vision/quotation/quotation-disposible/with logo/With-Logo_quotation.css">
    <title>Scope Visions | Detail Page Use & Send Stock</title>
</head>

<body>
    <div class="container-fluid mt-2">

        <div class="bg-white py-2">
            @if ($selectCompanies->isEmpty())
            @else
                @foreach ($selectCompanies as $selectCompany)
                @endforeach
                <div class="row d-flex justify-content-center align-items-center px-2">
                    <div class="col-12 text-center">
                        <div class="d-flex flex-column align-items-center justify-content-center py-2">
                            <h3 style="text-transform: uppercase;color: #15A4FB;" class="mx-2 text-center">
                                {{ $selectCompany->company_name }}</h3>
                            <span style="text-transform:capitalize;"
                                class="mx-2 text-center">{{ $selectCompany->company_address }}</span>
                        </div>
                    </div>
                </div>
            @endif
            {{--  --}}
            <div class="row pt-2 px-3">
                <div class="col-12">
                    <h3 class="text-center">Products History</h3>
                </div>
                <div class="col-12">
                    @if ($stockDetails->isEmpty())
                        <h4 class="text-center py-2">Not Data Founded</h4>
                    @else
                        @foreach ($stockDetails as $stockDetailss)
                        @endforeach
                        <div class="row">
                            <span class="col-sm-6 py-sm-2">
                                <span><b>Item Name:</b><span class="mx-2" style="text-transform: uppercase">
                                        <span
                                            class="largeScreen d-none d-md-inline">{{ $stockDetailss->item_name }}</span>
                                        <span class="mediumScreen d-md-none" style="font-size:12px">
                                            {{ $stockDetailss->item_name }}</span>
                                    </span></span>
                            </span>
                            {{--  --}}
                            <span class="col-sm-6 d-flex justify-content-md-end align-items-center py-sm-2">
                                <span><b>Last Update:</b><span class="mx-2">
                                        <span class="largeScreen d-none d-md-inline">
                                            {{ \Carbon\Carbon::parse($stockDetailss->updated_at)->format('M d, Y') }}
                                        </span>
                                        <span class="mediumScreen d-md-none" style="font-size:12px">
                                            {{ \Carbon\Carbon::parse($stockDetailss->updated_at)->format('M d, Y') }}
                                        </span>
                                    </span></span>
                            </span>
                        </div>
                    @endif
                </div>
                <div class="col-12 d-flex flex-column justify-content-center align-items-center">
                    @if ($stockDetails->isEmpty())
                    @else
                        @if (empty($stockDetailss->inspection_id))
                            @if (empty($stockDetailss->item_batchNo))
                            
                                <div
                                    class="col-12 mb-1 d-flex justify-content-center align-items-center">
                                    <table style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th class="py-2"
                                                    style="width:56.6%;text-align:center;border:1px solid black">
                                                    <p class="largeScreen d-none d-md-inline">Reference Name</p>
                                                    <p class="mediumScreen d-md-none" style="font-size:12px">Ref
                                                        Name</p>

                                                </th>
                                                <th class="py-2"
                                                    style="width:15.6%;text-align:center;border:1px solid black">
                                                    <p class="largeScreen d-none d-md-inline">Invoice
                                                        Number</p>
                                                    <p class="mediumScreen d-md-none" style="font-size:12px">Invoice
                                                    </p>

                                                </th>
                                                <th class="py-2"
                                                    style="width:10.6%;text-align:center;border:1px solid black">
                                                    <p class="largeScreen d-none d-md-inline">Quantities</p>
                                                    <p class="mediumScreen d-md-none" style="font-size:12px">Qtv
                                                    </p>

                                                </th>
                                                <th class="py-2"
                                                    style="width:16.6%;text-align:center;border:1px solid black">
                                                    <p class="largeScreen d-none d-md-inline">Date</p>
                                                    <p class="mediumScreen d-md-none" style="font-size:12px">Date</p>

                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($stockDetails as $stockDetailss)
                                                <tr>
                                                    <td class="py-2"
                                                        style="width:56.6%;text-align:center;border:1px solid black">
                                                        <p class="largeScreen d-none d-md-inline">
                                                            {{ $stockDetailss->client_name }}</p>
                                                        <p class="mediumScreen d-md-none" style="font-size:12px">
                                                            {{ $stockDetailss->client_name }}
                                                        </p>

                                                    </td>
                                                    <td class="py-2"
                                                        style="width:15.6%;text-align:center;border:1px solid black">
                                                        <p class="largeScreen d-none d-md-inline">
                                                            {{ $stockDetailss->invoice_number }}</p>
                                                        <p class="mediumScreen d-md-none" style="font-size:12px">
                                                            {{ $stockDetailss->invoice_number }}
                                                        </p>

                                                    </td>
                                                    <td class="py-2"
                                                        style="width:10.6%;text-align:center;border:1px solid black">
                                                        <p class="largeScreen d-none d-md-inline">
                                                            {{ $stockDetailss->solid_qtv }}</p>
                                                        <p class="mediumScreen d-md-none" style="font-size:12px">
                                                            {{ $stockDetailss->solid_qtv }}
                                                        </p>

                                                    </td>
                                                    <td class="py-2"
                                                        style="width:16.6%;text-align:center;border:1px solid black">
                                                        <p class="largeScreen d-none d-md-inline">
                                                            {{ \Carbon\Carbon::parse($stockDetailss->invoice_date)->format('M d, Y') }}
                                                        </p>
                                                        <p class="mediumScreen d-md-none" style="font-size:12px">
                                                            {{ \Carbon\Carbon::parse($stockDetailss->invoice_date)->format('M d, Y') }}
                                                        </p>

                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            
                            
                            @else
                            
                                <div class="col-12 mb-1 d-flex justify-content-center align-items-center">
                                    <table class="w-100 py-2">
                                        <thead>
                                            <tr>
                                                <th class="py-2"
                                                    style="width:23.6%;text-align:center;border:1px solid black">
                                                    <p class="largeScreen d-none d-md-inline">Reference Name</p>
                                                    <p class="mediumScreen d-md-none" style="font-size:12px">Ref
                                                        Name</p>

                                                </th>
                                                <th class="py-2"
                                                    style="width:15.6%;text-align:center;border:1px solid black">
                                                    <p class="largeScreen d-none d-md-inline">Invoice Number</p>
                                                    <p class="mediumScreen d-md-none" style="font-size:12px">Invoice
                                                    </p>

                                                </th>
                                                <th class="py-2"
                                                    style="width:16.6%;text-align:center;border:1px solid black">
                                                    <p class="largeScreen d-none d-md-inline">Batch No</p>
                                                    <p class="mediumScreen d-md-none" style="font-size:12px">Batch No
                                                    </p>

                                                </th>
                                                <th class="py-2"
                                                    style="width:16.6%;text-align:center;border:1px solid black">
                                                    <p class="largeScreen d-none d-md-inline">Exp Date</p>
                                                    <p class="mediumScreen d-md-none" style="font-size:12px">Exp Date
                                                    </p>

                                                </th>
                                                <th class="py-2"
                                                    style="width:10.6%;text-align:center;border:1px solid black">
                                                    <p class="largeScreen d-none d-md-inline">Quantities</p>
                                                    <p class="mediumScreen d-md-none" style="font-size:12px">
                                                        Qtv</p>

                                                </th>
                                                <th class="py-2"
                                                    style="width:16.6%;text-align:center;border:1px solid black">
                                                    <p class="largeScreen d-none d-md-inline">Date</p>
                                                    <p class="mediumScreen d-md-none" style="font-size:12px">Date</p>

                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($stockDetails as $stockDetailss)
                                                <tr>
                                                    <td class="py-2"
                                                        style="width:23.6%;text-align:center;border:1px solid black">
                                                        <p class="largeScreen d-none d-md-inline">
                                                            {{ $stockDetailss->client_name }}</p>
                                                        <p class="mediumScreen d-md-none" style="font-size:12px">
                                                            {{ $stockDetailss->client_name }}
                                                        </p>

                                                    </td>
                                                    <td class="py-2"
                                                        style="width:15.6%;text-align:center;border:1px solid black">
                                                        <p class="largeScreen d-none d-md-inline">
                                                            {{ $stockDetailss->invoice_number }}</p>
                                                        <p class="mediumScreen d-md-none" style="font-size:12px">
                                                            {{ $stockDetailss->invoice_number }}
                                                        </p>

                                                    </td>
                                                    <td class="py-2"
                                                        style="width:16.6%;text-align:center;border:1px solid black">
                                                        <p class="largeScreen d-none d-md-inline">
                                                            {{ $stockDetailss->item_batchNo }}</p>
                                                        <p class="mediumScreen d-md-none" style="font-size:12px">
                                                            {{ $stockDetailss->item_batchNo }}
                                                        </p>

                                                    </td>
                                                    <td class="py-2"
                                                        style="width:16.6%;text-align:center;border:1px solid black">
                                                        <p class="largeScreen d-none d-md-inline">
                                                            {{ \Carbon\Carbon::parse($stockDetailss->item_expDate)->format('M d, Y') }}
                                                        </p>
                                                        <p class="mediumScreen d-md-none" style="font-size:12px">
                                                            {{ \Carbon\Carbon::parse($stockDetailss->item_expDate)->format('M d, Y') }}
                                                        </p>

                                                    </td>
                                                    <td class="py-2"
                                                        style="width:10.6%;text-align:center;border:1px solid black">
                                                        <p class="largeScreen d-none d-md-inline">
                                                            {{ $stockDetailss->solid_qtv }}</p>
                                                        <p class="mediumScreen d-md-none" style="font-size:12px">
                                                            {{ $stockDetailss->solid_qtv }}
                                                        </p>

                                                    </td>
                                                    <td class="py-2"
                                                        style="width:16.6%;text-align:center;border:1px solid black">
                                                        <p class="largeScreen d-none d-md-inline">
                                                            {{ \Carbon\Carbon::parse($stockDetailss->invoice_date)->format('M d, Y') }}
                                                        </p>
                                                        <p class="mediumScreen d-md-none" style="font-size:12px">
                                                            {{ \Carbon\Carbon::parse($stockDetailss->invoice_date)->format('M d, Y') }}
                                                        </p>

                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                           
                            
                            @endif
                        @else
                        
                            <div class="col-12 mb-1 d-flex justify-content-center align-items-center">
                                <table style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th class="py-2"
                                                style="width:40%;text-align:center;border:1px solid black">
                                                <p class="largeScreen d-none d-md-inline">Reference Name</p>
                                                <p class="mediumScreen d-md-none" style="font-size:12px">Ref
                                                    Name</p>

                                            </th>
                                            <th class="py-2"
                                                style="width:20%;text-align:center;border:1px solid black">
                                                <p class="largeScreen d-none d-md-inline">Inspection Number</p>
                                                <p class="mediumScreen d-md-none" style="font-size:12px">Inspection
                                                </p>

                                            </th>
                                            <th class="py-2"
                                                style="width:20%;text-align:center;border:1px solid black">
                                                <p class="largeScreen d-none d-md-inline">Quantities</p>
                                                <p class="mediumScreen d-md-none" style="font-size:12px">Qtv
                                                </p>

                                            </th>
                                            <th class="py-2"
                                                style="width:20%;text-align:center;border:1px solid black">
                                                <p class="largeScreen d-none d-md-inline">Date</p>
                                                <p class="mediumScreen d-md-none" style="font-size:12px">Date</p>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($stockDetails as $stockDetailss)
                                            <tr>
                                                <td class="py-2"
                                                    style="width:40%;text-align:center;border:1px solid black">
                                                    <p class="largeScreen d-none d-md-inline">
                                                        {{ $stockDetailss->sender_name }}</p>
                                                    <p class="mediumScreen d-md-none" style="font-size:12px">
                                                        {{ $stockDetailss->sender_name }}</p>

                                                </td>
                                                <td class="py-2"
                                                    style="width:20%;text-align:center;border:1px solid black">
                                                    <p class="largeScreen d-none d-md-inline">
                                                        {{ $stockDetailss->inspection_id }}</p>
                                                    <p class="mediumScreen d-md-none" style="font-size:12px">
                                                        {{ $stockDetailss->inspection_id }}</p>

                                                </td>
                                                <td class="py-2"
                                                    style="width:20%;text-align:center;border:1px solid black">
                                                    <p class="largeScreen d-none d-md-inline">
                                                        {{ $stockDetailss->solid_qtv }}</p>
                                                    <p class="mediumScreen d-md-none" style="font-size:12px">
                                                        {{ $stockDetailss->solid_qtv }}</p>

                                                </td>
                                                <td class="py-2"
                                                    style="width:20%;text-align:center;border:1px solid black">
                                                    <p class="largeScreen d-none d-md-inline">
                                                        {{ \Carbon\Carbon::parse($stockDetailss->scope_incoming_date)->format('M d, Y') }}
                                                    </p>
                                                    <p class="mediumScreen d-md-none" style="font-size:12px">
                                                        {{ \Carbon\Carbon::parse($stockDetailss->scope_incoming_date)->format('M d, Y') }}
                                                    </p>

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        
                        @endif
                    @endif
                </div>
            </div>
            {{--  --}}
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
    <script src="/custom2.js"></script>
</body>

</html>
