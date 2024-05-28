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
    <title>Scope Visions | Edit Client</title>
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
                            <a href="{{ route('clientNameList') }}" class="btn btn-outline-primary"><i
                                    class="fas fa-angle-left me-2"></i>Back</a>
                        </div>
                        <div class="col-md-6">
                            <h2 class="text-end d-none d-md-block">Update Client Form</h2>
                            <h4 class="text-center d-md-none ">Update Client Form</h4>
                        </div>
                    </div>
                </div>
            </div>
            @foreach ($selectClients as $selectClient)
            @endforeach
            <div class="card-body">
                <form action="{{ route('updateClientOperation', $selectClient->id) }}" method="post" class="row"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="col-md-10 py-2 px-2">
                        <div class="row px-2 py-2">
                            <div class="col-12">
                                <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                    <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                        style="width:300px;">Client Name:</label>
                                    <label class="lable2 text-start mx-2 mt-1  d-md-none " for="">Client Name
                                        :</label>
                                    <input type="text" class="form-control" placeholder="Ex, demo client"
                                        name="clientName" value="{{ $selectClient->client_name }}">
                                </div>
                            </div>
                            {{--  --}}
                            <div class="col-12">
                                <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                    <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                        style="width:300px;">Client Email Address:</label>
                                    <label class="lable2 text-start mx-2 mt-1  d-md-none " for="">Client Email
                                        Address
                                        :</label>
                                    <input type="email" class="form-control" placeholder="Ex, abc@abc.com"
                                        name="clientEmailAddress" value="{{ $selectClient->client_emailaddress }}">
                                </div>
                            </div>
                            {{--  --}}
                            <div class="col-12">
                                <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                    <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                        style="width:300px;">Client Contact Number:</label>
                                    <label class="lable2 text-start mx-2 mt-1  d-md-none " for="">Client Contact
                                        Number
                                        :</label>
                                    <input type="number" class="form-control" placeholder="Ex, 0092 3010000000"
                                        name="clientContactNumber"
                                        value="{{ $selectClient->client_contactinformation }}">
                                </div>
                            </div>
                            {{--  --}}
                            <div class="col-12">
                                <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                    <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                        style="width:300px;">Client Organiztion:</label>
                                    <label class="lable2 text-start mx-2 mt-1  d-md-none " for="">Client
                                        Organiztion
                                        :</label>
                                    <input type="text" class="form-control" placeholder="Ex, Abc"
                                        name="clientOrganizationName"
                                        value="{{ $selectClient->client_organizationname }}">
                                </div>
                            </div>
                            {{--  --}}
                            <div class="col-12">
                                <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                    <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                        style="width:300px;">Client Type:</label>
                                    <label class="lable2 text-start mx-2 mt-1  d-md-none " for="">Client Type
                                        :</label>
                                    {{-- <input type="text" class="form-control" placeholder="Ex, 123abc" name="companyNTNNumber"> --}}
                                    <select name="clientType" id="clientType" class="form-control">
                                        @if ($selectClient->client_type == 0)
                                            <option value="0">Permanent</option>
                                            <option value="1">Temperary</option>
                                        @else
                                            <option value="1">Temperary</option>
                                            <option value="0">Permanent</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            {{--  --}}
                            <div class="col-12">
                                <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                    <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                        style="width:300px;">Client Address:</label>
                                    <label class="lable2 text-start mx-2 mt-1  d-md-none " for="">Client
                                        Address
                                        :</label>
                                    <textarea name="clientAddress" id="clientAddress" cols="30" rows="5" class="form-control"
                                        placeholder="Ex, Taxila punjab pakistan">{{ $selectClient->client_address }}</textarea>
                                </div>
                            </div>
                            {{--  --}}
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-outline-primary">Update</button>
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
