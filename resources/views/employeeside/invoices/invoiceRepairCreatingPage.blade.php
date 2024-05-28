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
    <title>Scope Visions | New Invoice Scope</title>
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
                            <h2 class="text-end d-none d-md-block">Create New Invoice</h2>
                            <h4 class="text-center d-md-none ">Create New Invoice</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('createOperationInvoiceRepairing_Operations') }}" method="post" class="row"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-10 py-2 px-2">
                        {{--  --}}
                        <h4 class="text-start d-none d-md-block">Invoice Basic Information</h4>
                        <h4 class="text-center d-md-none ">Invoice Basic Information</h4>
                        {{--  --}}
                        <div class="row px-2 py-2">
                            {{-- <div class="col-12">
                                <div class="d-flex justify-content-center align-items-center py-2">
                                    <label class="text-end mx-2 mt-1" for="" style="width:300px;">Invoice
                                        Number:</label>
                                    <input type="text" class="form-control" placeholder="Ex, ABC123"
                                        name="quotationNumber">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex justify-content-center align-items-center py-2">
                                    <label class="text-end mx-2 mt-1" for="" style="width:300px;">Billing
                                        To:</label>
                                    <select name="quotationClient" id="quotationClient" class="form-control">
                                        <option value="">Select Client</option>
                                        @if ($selectClient->isEmpty())
                                        @else
                                            @foreach ($selectClient as $selectClients)
                                                <option value="{{ $selectClients->id }}">
                                                    {{ $selectClients->client_name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div> --}}
                            {{-- <div class="col-12">
                            <div class="d-flex justify-content-center align-items-center py-2">
                                <label class="text-end mx-2 mt-1" for="" style="width:300px;">Date:</label>
                                <input type="date" class="form-control" placeholder="Ex, 12-12-0000" name="quotationDate">
                            </div>
                        </div> --}}
                            {{-- <div class="col-12 d-none">
                                <div class="d-flex justify-content-center align-items-center py-2">
                                    <label class="text-end mx-2 mt-1" for="" style="width:300px;"></label>
                                    <textarea name="quotationHeading" id="quotationHeading" class="form-control" placeholder="Ex, Data" cols="30"
                                        rows="4"></textarea>
                                </div>
                            </div> --}}
                            {{-- aaaaaaaaaaaaaaaaaaaaaaaaa --}}
                            <div class="col-12">
                                <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                    <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                        style="width:300px;">Invoice Number:</label>
                                    <label class="lable2 text-start mx-2 mt-1  d-md-none " for="">Invoice Number
                                        :</label>
                                    <input type="text" class="form-control" placeholder="Ex, ABC123"
                                        name="quotationNumber">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                    <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                        style="width:300px;">Billing To:</label>
                                    <label class="lable2 text-start mx-2 mt-1  d-md-none " for="">Billing To
                                        :</label>
                                    <select name="quotationClient" id="quotationClient" class="form-control">
                                        <option value="">Select Client</option>
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
                            <div class="col-12 d-none">
                                <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                    <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                        style="width:300px;">Date:</label>
                                    <label class="lable2 text-start mx-2 mt-1  d-md-none " for="">Date
                                        :</label>
                                    <input type="date" class="form-control" placeholder="Ex, 12-12-0000"
                                        name="quotationDate">
                                </div>
                            </div>
                            <div class="col-12 d-none">
                                <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                    <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                        style="width:300px;"></label>
                                    <label class="lable2 text-start mx-2 mt-1  d-md-none " for=""></label>
                                    <textarea name="quotationHeading" id="quotationHeading" class="form-control" placeholder="Ex, Data" cols="30"
                                        rows="4"></textarea>
                                </div>
                            </div>
                        </div>
                        {{--  --}}
                        <h4 class="text-start d-none d-md-block">Invoice Item Details</h4>
                        <h4 class="text-center d-md-none ">Invoice Item Details</h4>
                        {{--  --}}
                        <div id="add_form">
                            <div id="show_items7">
                                <div class="row px-2 py-2">
                                    {{-- <div class="col-12 py-2">
                                        <div class="row">
                                            <div class="col-12 d-flex justify-content-end align-items-center">
                                                <button class="btn btn-outline-primary add_item_btn11"><i
                                                        class="mx-2 fas fa-plus"></i>Add More</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-flex justify-content-center align-items-center py-2">
                                            <label class="text-end mx-2 mt-1" for="" style="width:300px;">Serial
                                                Number:</label>
                                            <input type="number" class="form-control" placeholder="Ex, 132"
                                                name="quotationItemSrNumber[]">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-flex justify-content-center align-items-center py-2">
                                            <label class="text-end mx-2 mt-1" for="" style="width:300px;">Scope
                                                Model:</label>
                                            <input type="text" class="form-control" placeholder="Ex, cf-140L"
                                                name="quotationItemScopeModel[]">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-flex justify-content-center align-items-center py-2">
                                            <label class="text-end mx-2 mt-1" for="" style="width:300px;">Scope
                                                Sr No:</label>
                                            <input type="number" class="form-control" placeholder="Ex, 132"
                                                name="quotationItemScopeSrNumber[]">
                                        </div>
                                    </div>
                                    <div class="col-12 d-none">
                                        <div class="d-flex justify-content-center align-items-start py-2">
                                            <label class="text-end mx-2 mt-1" for=""
                                                style="width:300px;">Problem</label>
                                            <textarea name="quotationItemProblem[]" id="quotationItemProblem" class="form-control" placeholder="Ex, Description"
                                                cols="30" rows="2"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-flex justify-content-center align-items-start py-2">
                                            <label class="text-end mx-2 mt-1" for="" style="width:300px;">Work
                                                Done</label>
                                            <textarea name="quotationItemNeedWork[]" id="quotationItemNeedWork" class="form-control" placeholder="Ex, Description"
                                                cols="30" rows="5"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-flex justify-content-center align-items-center py-2">
                                            <label class="text-end mx-2 mt-1" for=""
                                                style="width:300px;">Amount/Rate:</label>
                                            <input type="number" class="form-control" placeholder="Ex, 132"
                                                name="quotationItemAmount[]">
                                        </div>
                                    </div> --}}
                                    {{-- aaaaaaaaaaaaaaaaaaaaaa --}}
                                    <div class="col-12">
                                        <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                            <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                                style="width:300px;">Serial Number:</label>
                                            <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                                for="">Serial Number
                                                :</label>
                                            <input type="number" class="form-control" placeholder="Ex, 132"
                                                name="quotationItemSrNumber[]">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                            <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                                style="width:300px;">Scope Model:</label>
                                            <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                                for="">Scope Model
                                                :</label>
                                            <input type="text" class="form-control" placeholder="Ex, cf-140L"
                                                name="quotationItemScopeModel[]">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                            <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                                style="width:300px;">Scope Sr No:</label>
                                            <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                                for="">Scope Sr No
                                                :</label>
                                            <input type="number" class="form-control" placeholder="Ex, 132"
                                                name="quotationItemScopeSrNumber[]">
                                        </div>
                                    </div>
                                    <div class="col-12 d-none">
                                        <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                            <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                                style="width:300px;">Problem:</label>
                                            <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                                for="">Problem
                                                :</label>
                                            <textarea name="quotationItemProblem[]" id="quotationItemProblem" class="form-control" placeholder="Ex, Description"
                                                cols="30" rows="2"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                            <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                                style="width:300px;">Need Work:</label>
                                            <label class="lable2 text-start mx-2 mt-1  d-md-none " for="">Need
                                                Work
                                                :</label>
                                            <textarea name="quotationItemNeedWork[]" id="quotationItemNeedWork" class="form-control"
                                                placeholder="Ex, Description" cols="30" rows="5"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                            <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                                style="width:300px;">Amount/Rate:</label>
                                            <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                                for="">Amount/Rate
                                                :</label>
                                            <input type="number" class="form-control" placeholder="Ex, 132"
                                                name="quotationItemAmount[]">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h4 class="text-start d-none d-md-block">Term And Conditions</h4>
                        <h4 class="text-center d-md-none ">Term And Conditions</h4>
                        {{--  --}}
                        <div id="add_form1">
                            <div id="show_items1">
                                <div class="row px-2 py-2">
                                    {{-- <div class="col-12">
                                        <div class="d-flex justify-content-center align-items-center py-2">
                                            <label class="text-end mx-2 mt-1" for=""
                                                style="width:300px;"></label>
                                            <input type="text" class="form-control"
                                                placeholder="Ex, Term And Conditions"
                                                name="quotationTermAndConditions[]">
                                            <button class="btn btn-outline-primary add_item_btn1 mx-2"><i
                                                    class="mx-2 fas fa-plus"></i></button>
                                        </div>
                                    </div> --}}
                                    {{-- aaaaaaaaaaaaaaaaaaaaa --}}
                                    <div class="col-12">
                                        <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                            <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                                style="width:300px;"></label>
                                            <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                                for=""></label>
                                            <input type="text" class="form-control"
                                                placeholder="Ex, Term And Conditions"
                                                name="quotationTermAndConditions[]">
                                            <button
                                                class="btn btn-outline-primary add_item_btn1 mx-0 mx-md-2 mt-md-0 mt-2"><i
                                                    class="mx-2 fas fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h4 class="text-start d-none d-md-block">Invoice GST Text</h4>
                        <h4 class="text-center d-md-none ">Invoice GST Text</h4>
                        {{--  --}}
                        <div class="row px-2 py-2">
                            {{-- <div class="col-12">
                                <div class="d-flex justify-content-center align-items-center py-2">
                                    <label class="text-end mx-2 mt-1" for="" style="width:300px;">GST
                                        Text:</label>
                                    <input type="text" class="form-control" placeholder="Ex, ABC123"
                                        name="quotationGstText">
                                </div>
                            </div> --}}
                            {{-- aaaaaaaaaaaaaaa --}}
                            <div class="col-12">
                                <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                    <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                        style="width:300px;">GST Text:</label>
                                    <label class="lable2 text-start mx-2 mt-1  d-md-none " for="">GST Text
                                        :</label>
                                    <input type="text" class="form-control" placeholder="Ex, ABC123"
                                        name="quotationGstText">
                                </div>
                            </div>
                        </div>
                        {{--  --}}
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
    <script src="/custom2.js"></script>
</body>

</html>
