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
    <title> Scope Visions | Outgoing Inspection List</title>
</head>

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

<body>
    <div class="container mt-2">
        <div class="card">
            <div class="card-header">
                <div class="col-12">
                    <div class="row">
                        <div class="col-6">
                            <a href="{{ route('employeeDashboardPage') }}" class="btn btn-outline-primary"><i
                                    class="fas fa-angle-left me-2"></i>Back</a>
                        </div>
                        <div class="col-6">
                            <h2 class="text-end">Outgoing Inspection List</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <input type="text" class="form-control" id="searchOutGoingInspectionReport"
                    name="searchOutGoingInspectionReport">
                <div class="col-12 py-2">
                    <div class="py-2 d-flex justify-content-end align-items-center">
                    </div>
                    {{-- <table class="table">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 10%;text-align:center">
                                    Id
                                </th>
                                <th scope="col" style="width: 15%;text-align:center">
                                    Scope Model
                                </th>
                                <th scope="col" style="width: 15%;text-align:center">
                                    Scope Sr No
                                </th>
                                <th scope="col" style="width: 15%;text-align:center">
                                    Outgoing Date
                                </th>
                                <th scope="col" style="width: 30%;text-align:center">
                                    Receiver name
                                </th>
                                <th scope="col" style="width: 20%;text-align:center">
                                    Options
                                </th>
                            </tr>
                        </thead>
                        @if ($selectOutGoingInspectionReports->isEmpty())
                        @else
                            <tbody id="clientData">
                                <div id="total_records">
                                    @foreach ($selectOutGoingInspectionReports as $selectOutGoingInspectionReport)
                                        <tr>
                                            <th scope="row" style="width: 10%;text-align:center">
                                                {{ $selectOutGoingInspectionReport->id }}
                                            </th>
                                            <td style="width: 15%;text-align:center">
                                                {{ $selectOutGoingInspectionReport->scope_model }}
                                            </td>
                                            <td style="width: 15%;text-align:center">
                                                {{ $selectOutGoingInspectionReport->scope_sr_number }}
                                            </td>
                                            <td style="width: 10%;text-align:center">
                                                {{ $selectOutGoingInspectionReport->scope_incoming_date }}
                                            </td>
                                            <td style="width: 30%;text-align:center">
                                                {{ $selectOutGoingInspectionReport->sender_name }}
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
                                                                    href="{{ route('detailsOperationPageOutgoingGastroAndColonoScope', $selectOutGoingInspectionReport->id) }}"><i
                                                                        class="fas fa-user mx-2"></i> View Detail</a>
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
                    <div class="row py-2" id="companyList">
                        @if ($selectOutGoingInspectionReports->isEmpty())
                        @else
                            @foreach ($selectOutGoingInspectionReports as $selectOutGoingInspectionReport)
                                <div class="col-sm-6 col-md-3 d-flex align-items-stretch flex-column px-2 py-2">
                                    <div class="card bg-light d-flex flex-fill">
                                        <div class="card-body">
                                            <div class="row py-2">
                                                <div class="col-12" style="padding-left: 90%;">
                                                    <a href="#" class="action-icon dropdown-toggle text-black"
                                                        data-bs-toggle="dropdown" aria-expanded="false"></a>
                                                    <div class="dropdown-menu dropdown-menu-right" style="">
                                                        <a class="dropdown-item"
                                                            href="{{ route('detailsOperationPageOutgoingGastroAndColonoScope', $selectOutGoingInspectionReport->id) }}"><i
                                                                class="fas fa-user mx-2"></i> View Detail</a>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <span
                                                        style="font-size: 15px;">{{ $selectOutGoingInspectionReport->sender_name }}</span>
                                                    <br>
                                                    <span style="font-size: 12px;"><i class="mx-2 fas fa-box"></i>
                                                        <span
                                                            mx-2>{{ $selectOutGoingInspectionReport->scope_model }}</span></span>
                                                    <br>
                                                    <span style="font-size: 12px;"><i class="mx-2 fas fa-barcode"></i>
                                                        <span
                                                            mx-2>{{ $selectOutGoingInspectionReport->scope_sr_number }}</span></span>
                                                    <br>
                                                    <span style="font-size: 12px;"><i class="mx-2 fas fa-calendar"></i>
                                                        <span
                                                            mx-2>{{ $selectOutGoingInspectionReport->scope_incoming_date }}</span></span>
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
    <script>
        // search operations
        $(document).ready(function() {

            fetch_customer_data();

            function fetch_customer_data(query = '') {
                $.ajax({
                    url: "{{ route('searchOperationOutgoingGastroAndColonoScopeReport') }}",
                    method: 'GET',
                    data: {
                        query: query
                    },
                    dataType: 'json',
                    success: function(data) {
                        $('#companyList').html(data.table_data);
                    }
                })
            }

            $(document).on('keyup', '#searchOutGoingInspectionReport', function() {
                var query = $(this).val();
                fetch_customer_data(query);
            });
        });
    </script>
</body>

</html>
