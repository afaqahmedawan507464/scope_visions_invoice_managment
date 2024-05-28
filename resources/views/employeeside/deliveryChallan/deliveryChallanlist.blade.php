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
    <title> Scope Visions | Delivery Challan List</title>
</head>

<body>
    <div class="container mt-2">
        @if (Session::has('error_message'))
            <div class="alert alert-danger alert-dismissible fade show px-4 d-flex justify-content-center flex-column"
                role="alert">
                <strong>Error</strong> {{ Session::get('error_message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (Session::has('success_message'))
            <div class="alert alert-success alert-dismissible fade show px-4 d-flex justify-content-center flex-column"
                role="alert">
                <strong>Success:</strong> {{ Session::get('success_message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show px-4 d-flex justify-content-center flex-column"
                role="alert">
                @foreach ($errors->all() as $item)
                    <li style="list-style: none">{{ $item }}</li>
                @endforeach
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="card">
            <div class="card-header">
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ route('employeeDashboardPage') }}" class="btn btn-outline-primary"><i
                                    class="fas fa-angle-left me-2"></i>Back</a>
                        </div>
                        <div class="col-md-6">
                            <h2 class="text-end">Delivery Challan List</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('searchOperationDeliveryChallan') }}" method="post"
                    class="d-md-flex justify-content-center align-items-center">
                    @csrf
                    <input type="text" class="form-control mt-1 mt-md-0" id="searchInvoice" name="searchInvoice">
                    <input type="date" class="form-control mx-md-2 mt-1 mt-md-0" id="searchstartingDate"
                        name="searchstartingDate">
                    <input type="date" class="form-control mt-1 mt-md-0" id="searchendingDate"
                        name="searchendingDate">
                    <button class="btn btn-outline-primary mx-md-2 mt-1 mt-md-0">Search</button>
                </form>
                <div class="col-12 py-2">
                    {{-- <table class="table">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 5%;text-align:center">
                                    Id
                                </th>
                                <th scope="col" style="width: 20%;text-align:center">
                                    P.O No
                                </th>
                                <th scope="col" style="width: 35%;text-align:center">
                                    Delivered To
                                </th>
                                <th scope="col" style="width: 20%;text-align:center">
                                    Date
                                </th>
                                <th scope="col" style="width: 5%;text-align:center">
                                    Menu
                                </th>
                            </tr>
                        </thead>
                        @if ($selectQuotations->isEmpty())
                        @else
                            <tbody id="clientData">
                                <div id="total_records">
                                    @foreach ($selectQuotations as $selectQuotation)
                                        <tr>
                                            <th scope="row" style="width: 5%;text-align:center">
                                                {{ $selectQuotation->id }}
                                            </th>
                                            <td style="width: 20%;text-align:center">
                                                {{ $selectQuotation->delivery_challan_po_no }}
                                            </td>
                                            <td style="width: 35%;text-align:center">
                                                {{ $selectQuotation->client_name }}
                                            </td>
                                            <td style="width: 20%;text-align:center">
                                                {{ $selectQuotation->delivery_challan_date }}
                                            </td>
                                            <td style="width: 20%;text-align:center">
                                                <div class="d-flex justify-content-center">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <a href="#"
                                                                class="action-icon dropdown-toggle text-black"
                                                                data-bs-toggle="dropdown" aria-expanded="false"><i
                                                                    class="fas fa-bars"></i></a>
                                                            <div class="dropdown-menu dropdown-menu-right"
                                                                style="">
                                                                <a class="dropdown-item"
                                                                    href="{{ route('pageDetailDeleiveryChallanPage', $selectQuotation->id) }}"><i
                                                                        class="fas fa-user mx-2"></i> View Detail</a>
                                                                @if (\DB::table('stock_outgoings')->where('invoice_id', '=', $selectQuotation->invoice_id)->count() > 0)
                                                                @else
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('pageOutgoingSystemDataStock', $selectQuotation->id) }}"><i
                                                                            class="fas fa-weight-hanging mx-2"></i>
                                                                        Exit Product</a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </div>
                            </tbody>
                        @endif
                    </table> --}}
                    @if ($selectQuotations->isEmpty())
                    @else
                        <div class="row py-2">
                            @foreach ($selectQuotations as $selectQuotation)
                                <div class="col-sm-6 col-md-3 d-flex align-items-stretch flex-column px-2 py-2">
                                    <div class="card bg-light d-flex flex-fill">
                                        <div class="card-body">
                                            <div class="row py-2">
                                                <div class="col-12" style="padding-left: 90%;">
                                                    <a href="#" class="action-icon dropdown-toggle text-black"
                                                        data-bs-toggle="dropdown" aria-expanded="false"></a>
                                                    <div class="dropdown-menu dropdown-menu-right" style="">
                                                        <a class="dropdown-item"
                                                            href="{{ route('pageDetailDeleiveryChallanPage', $selectQuotation->id) }}"><i
                                                                class="fas fa-user mx-2"></i> View Detail</a>
                                                        @if (\DB::table('stock_outgoings')->where('invoice_id', '=', $selectQuotation->invoice_id)->count() > 0)
                                                        @else
                                                            <a class="dropdown-item"
                                                                href="{{ route('pageOutgoingSystemDataStock', $selectQuotation->id) }}"><i
                                                                    class="fas fa-weight-hanging mx-2"></i>
                                                                Exit Product</a>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <span
                                                        style="font-size: 20px;">{{ $selectQuotation->client_name }}</span>
                                                    <br>
                                                    <span style="font-size: 12px;"><i class="mx-2 fas fa-envelope"></i>
                                                        <span mx-2>P.O No :
                                                            {{ $selectQuotation->delivery_challan_po_no }}</span></span>
                                                    <br>
                                                    <span style="font-size: 12px;"><i class="mx-2 fas fa-phone"></i>
                                                        <span mx-2>Date :
                                                            {{ $selectQuotation->delivery_challan_date }}</span></span>
                                                    <br>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Select Invoice Type</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6 px-3 py-3">
                            <a href="{{ route('createDisposibleInvoicePage') }}"
                                class="btn btn-outline-primary">Invoice For Disposible</a>
                        </div>
                        <div class="col-6 px-3 py-3">
                            <a href="{{ route('createRepairingInvoicePage') }}"
                                class="btn btn-outline-primary">Invoice For Repairing</a>
                        </div>
                    </div>
                </div>
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
</body>

</html>
