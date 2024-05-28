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
    <title>Scope Visions | Invoice List</title>
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
                        <div class="col-md-6">
                            <a href="{{ route('employeeDashboardPage') }}" class="btn btn-outline-primary"><i
                                    class="fas fa-angle-left me-2"></i>Back</a>
                        </div>
                        <div class="col-md-6">
                            <h2 class="text-end d-none d-md-block">Invoice List</h2>
                            <h4 class="text-center d-md-none ">Invoice List</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('searchOperationInvoices') }}" method="post"
                    class="d-md-flex justify-content-center align-items-center">
                    @csrf
                    <input type="text" class="form-control mt-1 mt-md-0" id="searchInvoice" name="searchInvoice">
                    <input type="date" class="form-control mt-1 mt-md-0 mx-md-2" id="searchstartingDate"
                        name="searchstartingDate">
                    <input type="date" class="form-control mt-1 mt-md-0" id="searchendingDate"
                        name="searchendingDate">
                    <button class="btn btn-outline-primary mt-1 mt-md-0 mx-md-2">Search</button>
                </form>
                <div class="col-12 py-2">
                    <div class="py-2 d-flex justify-content-end align-items-center">
                        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"><i
                                class="mx-2 fas fa-plus"></i>Add More</button>
                    </div>

                    <div class="row py-2">
                        @if ($selectQuotations->isEmpty())
                        @else
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
                                                            href="{{ route('pageDetailInvoicePage', $selectQuotation->id) }}"><i
                                                                class="fas fa-user mx-2"></i> View Detail</a>
                                                        @if (\DB::table('deliever_challans')->where('invoice_id', '=', $selectQuotation->id)->count() > 0)
                                                        @else
                                                            {{-- @if (empty($selectQuotation->quotation_id))
                                                            @else --}}
                                                            @if (!empty($selectQuotation->invoice_scope_model))
                                                            @else
                                                                {{-- @if (!empty($selectQuotation->invoice_item_disposible_batchNo))
                                                                @else --}}
                                                                <a class="dropdown-item"
                                                                    href="{{ route('pageCreateDeliveryChallanPage', $selectQuotation->id) }}"><i
                                                                        class="fas fa-list mx-2"></i> Create
                                                                    Delivery Challan</a>
                                                                {{-- @endif --}}
                                                            @endif
                                                        @endif
                                                        {{--  --}}
                                                        @if (\DB::table('client_account_historys')->where('invoice_id', '=', $selectQuotation->id)->count() > 0)
                                                        @else
                                                            <a class="dropdown-item"
                                                                href="{{ route('pageCreateClientAccountHistoryPage', $selectQuotation->id) }}"><i
                                                                    class="fas fa-dollar-sign mx-2"></i>
                                                                Payment</a>
                                                        @endif
                                                        @if (\DB::table('stock_outgoings')->where('invoice_id', '=', $selectQuotation->id)->count() > 0)
                                                            <!-- Do nothing if stock_outgoings with invoice_id exists -->
                                                        @else
                                                            @if (\DB::table('invoices')->where('id', '=', $selectQuotation->id)->whereNotNull('invoice_item_disposible_batchNo')->count() > 0)
                                                                <a class="dropdown-item"
                                                                    href="{{ route('pageOutgoingDataStock', $selectQuotation->id) }}"><i
                                                                        class="fas fa-weight-hanging mx-2"></i>
                                                                    Exit Product</a>
                                                            @else
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <span
                                                        style="font-size: 20px;">{{ $selectQuotation->client_name }}</span>
                                                    <br>
                                                    <span style="font-size: 12px;"><i class="mx-2 fas fa-box"></i>
                                                        <span mx-2>Reference :
                                                            {{ $selectQuotation->invoice_number }}</span></span>
                                                    <br>
                                                    <span style="font-size: 12px;"><i class="mx-2 fas fa-calendar"></i>
                                                        <span mx-2>Date :
                                                            {{ $selectQuotation->invoice_date }}</span></span>
                                                    <br>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
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
                        <div class="d-flex justify-content-center align-items-center flex-wrap">
                            <div class="d-flex mx-1 mt-1">
                                <a href="{{ route('pageCreateDisposibleInvoicePage') }}"
                                    class="btn btn-outline-primary">Invoice For Disposible</a>
                            </div>
                            <div class="d-flex mx-1 mt-1">
                                <a href="{{ route('pageCreateRepairingInvoicePage') }}"
                                    class="btn btn-outline-primary">Invoice For System</a>
                            </div>
                            <div class="d-flex mx-1 mt-1">
                                <a href="{{ route('pageCreateRepairingDataSSInvoice') }}"
                                    class="btn btn-outline-primary">Invoice For Repairing</a>
                            </div>
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
