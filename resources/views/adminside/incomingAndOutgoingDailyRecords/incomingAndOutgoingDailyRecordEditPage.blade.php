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
    <title>Scope Visions | Edit Scope Incoming</title>
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
                        <div class="col-6">
                            <a href="{{ route('incomingAndOutGoingDailyRecordList') }}"
                                class="btn btn-outline-primary"><i class="fas fa-angle-left me-2"></i>Back</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <h2 class="text-end d-none d-md-block">Incoming And Outgoing Daily Record</h2>
                <h4 class="text-center d-md-none ">Incoming And Outgoing Daily Record</h4>
                @foreach ($selectincomingAndOutGoingDaily as $selectincomingAndOutGoingDailys)
                @endforeach
                <form
                    action="{{ route('editOperationIncomingAndOutgoingDailyRecord', $selectincomingAndOutGoingDailys->id) }}"
                    method="post" class="row" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="col-md-10 py-2 px-2">
                        <div class="row px-2 py-2">

                            <div class="col-12 d-none">
                                <div class="d-flex justify-content-center align-items-center py-2">
                                    <input type="text" class="form-control" placeholder="Ex, gif-140"
                                        name="incoming_report_id" style="display: none"
                                        value="{{ $selectincomingAndOutGoingDailys->id }}">
                                </div>
                            </div>
                            {{--  --}}
                            <div class="col-12 d-none">
                                <div class="d-flex justify-content-center align-items-center py-2">
                                    <label class="text-end mx-2 mt-1" for="" style="width:300px;">Incoming
                                        Date:</label>
                                    <input type="date" class="form-control" placeholder="Ex, 12-12-2023"
                                        name="scopeIncomingDate"
                                        value="{{ $selectincomingAndOutGoingDailys->incoming_date }}">
                                </div>
                            </div>
                            {{--  --}}
                            <div class="col-12 d-none">
                                <div class="d-flex justify-content-center align-items-center py-2">
                                    <label class="text-end mx-2 mt-1" for="" style="width:300px;">Scope
                                        Model:</label>
                                    <input type="text" class="form-control" placeholder="Ex, gif-140"
                                        name="scopeModel" value="{{ $selectincomingAndOutGoingDailys->model }}">
                                </div>
                            </div>
                            {{--  --}}
                            <div class="col-12 d-none">
                                <div class="d-flex justify-content-center align-items-center py-2">
                                    <label class="text-end mx-2 mt-1" for="" style="width:300px;">Sr
                                        Number:</label>
                                    <input type="number" class="form-control" placeholder="Ex, 123456789"
                                        name="scopeSrNumber" value="{{ $selectincomingAndOutGoingDailys->item_sr_no }}">
                                </div>
                            </div>
                            {{--  --}}
                            <div class="col-12 d-none">
                                <div class="d-flex justify-content-center align-items-center py-2">
                                    <label class="text-end mx-2 mt-1" for="" style="width:300px;">Sender
                                        Name:</label>
                                    <input type="text" class="form-control" placeholder="Ex, Demo Person"
                                        name="scopeSenderName"
                                        value="{{ $selectincomingAndOutGoingDailys->sender_name }}">
                                </div>
                            </div>
                            {{--  --}}
                            <div class="col-12 d-none">
                                <div class="d-flex justify-content-center align-items-center py-2">
                                    <label class="text-end mx-2 mt-1" for="" style="width:300px;">Incoming
                                        Slip Number:</label>
                                    <input type="text" class="form-control " placeholder="Ex, 123546789"
                                        name="incomingSlipNumber"
                                        value="{{ $selectincomingAndOutGoingDailys->incoming_slip_number }}">
                                </div>
                            </div>
                            {{--  --}}
                            <div class="col-12">
                                <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                    <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                        style="width:300px;">Outgoing Date:</label>
                                    <label class="lable2 text-start mx-2 mt-1  d-md-none " for="">Outgoing
                                        Date
                                        :</label>
                                    <input type="date" class="form-control" placeholder="Ex, 123546789"
                                        name="outgoingDate">
                                </div>
                            </div>
                            {{--  --}}
                            <div class="col-12">
                                <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                    <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                        style="width:300px;">Outgoing Slip Number:</label>
                                    <label class="lable2 text-start mx-2 mt-1  d-md-none " for="">Outgoing
                                        Slip Number
                                        :</label>
                                    <input type="text" class="form-control" placeholder="Ex, 123546789"
                                        name="outgoingSlipNumber">
                                </div>
                            </div>
                            {{--  --}}
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-outline-primary">Save</button>
                    </div>
                </form>
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
