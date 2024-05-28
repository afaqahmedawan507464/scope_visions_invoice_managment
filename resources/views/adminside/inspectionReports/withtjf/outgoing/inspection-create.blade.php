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
    <title> Scope Visions | New Outgoing Inspection</title>
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
                            <a href="{{ route('incomingAndOutGoingDailyRecordList') }}"
                                class="btn btn-outline-primary"><i class="fas fa-angle-left me-2"></i>Back</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <h2 class="text-end d-none d-md-block">Outgoing Inspection Report</h2>
                <h4 class="text-center d-md-none ">Outgoing Inspection Report</h4>
                @foreach ($incomingInsppectionFormDatas as $incomingInsppectionFormData)
                @endforeach
                @if ($incomingInsppectionFormData->scope_tjf_elevator_channel == '')
                    {{-- gastro and colono --}}
                    <form action="{{ route('withoutTjfInspectionOutgoingCreatingOperation') }}" method="post"
                        class="row" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-10 py-2 px-2">
                            <div class="row px-2 py-2">
                                <h5 class="text-start d-none d-md-block">Scope Basic Information</h5>
                                <h5 class="text-center d-md-none ">Scope Basic Information</h5>
                                <div class="col-12">
                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                            style="width:300px;">Scope Model:</label>
                                        <label class="lable2 text-start mx-2 mt-1  d-md-none " for="">Scope
                                            Model
                                            :</label>
                                        <input type="text" class="form-control" placeholder="Ex, gif-140"
                                            name="scopeModel" value="{{ $incomingInsppectionFormData->scope_model }}">
                                        <input type="text" class="form-control d-none" placeholder="Ex, gif-140"
                                            name="companyId" value="{{ $incomingInsppectionFormData->company_id }}">
                                        <input type="text" class="form-control d-none" placeholder="Ex, gif-140"
                                            name="incomingInspectionId" value="{{ $incomingInsppectionFormData->id }}">
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
                                        <input type="date" class="form-control" placeholder="Ex, 12-12-2023"
                                            name="scopeIncomingDate">
                                    </div>
                                </div>
                                {{--  --}}
                                <div class="col-12">
                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                            style="width:300px;">Sr Number:</label>
                                        <label class="lable2 text-start mx-2 mt-1  d-md-none " for="">Sr
                                            Number
                                            :</label>
                                        <input type="number" class="form-control" placeholder="Ex, 123456789"
                                            name="scopeSrNumber"
                                            value="{{ $incomingInsppectionFormData->scope_sr_number }}">
                                    </div>
                                </div>
                                {{--  --}}
                                <div class="col-12">
                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                            style="width:300px;">Receiver Name:</label>
                                        <label class="lable2 text-start mx-2 mt-1  d-md-none " for="">Receiver
                                            Name
                                            :</label>
                                        <input type="text" class="form-control" placeholder="Ex, Demo Person"
                                            name="scopeSenderName"
                                            value="{{ $incomingInsppectionFormData->sender_name }}">
                                    </div>
                                </div>
                                {{--  --}}
                                <br>
                                <h5 class="text-start d-none d-md-block">Scope Received With</h5>
                                <h5 class="text-center d-md-none ">Scope Received With</h5>
                                {{--  --}}
                                <div class="col-12">
                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                            style="width:300px;">Scope Received With:</label>
                                        <label class="lable2 text-start mx-2 mt-1  d-md-none " for="">Scope
                                            Received With
                                            :</label>
                                        <textarea name="scopeReceivedWith" id="scopeReceivedWith" cols="30" rows="6" class="form-control"
                                            placeholder="Ex, Demo Data">{{ $incomingInsppectionFormData->scope_sending_with }}</textarea>
                                    </div>
                                </div>
                                {{--  --}}
                                <br>
                                <h5 class="text-start d-none d-md-block">Inspection Related Information</h5>
                                <h5 class="text-center d-md-none ">Inspection Related Information</h5>
                                {{--  --}}
                                <div class="col-md-6">
                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                            style="width:300px;">Leakage:</label>
                                        <label class="lable2 text-start mx-2 mt-1  d-md-none " for="">Leakage
                                            :</label>
                                        <select name="scopeLeakage" id="scopeLeakage" class="form-control">
                                            @if ($incomingInsppectionFormData->scope_leakage == 1)
                                                <option value="1">Ok</option>
                                                <option value="0">Not Ok</option>
                                            @else
                                                <option value="0">Not Ok</option>
                                                <option value="1">Ok</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                {{--  --}}
                                <div class="col-md-6">
                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                            style="width:300px;">View:</label>
                                        <label class="lable2 text-start mx-2 mt-1  d-md-none " for="">View
                                            :</label>
                                        <select name="scopeView" id="scopeView" class="form-control">
                                            @if ($incomingInsppectionFormData->scope_view == 1)
                                                <option value="1">Ok</option>
                                                <option value="0">Not Ok</option>
                                            @else
                                                <option value="0">Not Ok</option>
                                                <option value="1">Ok</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                {{--  --}}
                                <div class="col-md-6">
                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                            style="width:300px;">Light Guide:</label>
                                        <label class="lable2 text-start mx-2 mt-1  d-md-none " for="">Light
                                            Guide
                                            :</label>
                                        <select name="scopeLightGuide" id="scopeLightGuide" class="form-control">
                                            @if ($incomingInsppectionFormData->scope_lightguide == 1)
                                                <option value="1">Ok</option>
                                                <option value="0">Not Ok</option>
                                            @else
                                                <option value="0">Not Ok</option>
                                                <option value="1">Ok</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                {{--  --}}
                                <div class="col-md-6">
                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                            style="width:300px;">Air/Water:</label>
                                        <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                            for="">Air/Water
                                            :</label>
                                        <select name="scopeairwater" id="scopeairwater" class="form-control">
                                            @if ($incomingInsppectionFormData->scope_airwater == 1)
                                                <option value="1">Ok</option>
                                                <option value="0">Not Ok</option>
                                            @else
                                                <option value="0">Not Ok</option>
                                                <option value="1">Ok</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                {{--  --}}
                                <div class="col-md-6">
                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                            style="width:300px;">Angulations:</label>
                                        <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                            for="">Angulations
                                            :</label>
                                        <select name="scopeAngulation" id="scopeAngulation" class="form-control">
                                            @if ($incomingInsppectionFormData->scope_angulation == 1)
                                                <option value="1">Ok</option>
                                                <option value="0">Not Ok</option>
                                            @else
                                                <option value="0">Not Ok</option>
                                                <option value="1">Ok</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                {{--  --}}
                                <div class="col-md-6">
                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                            style="width:300px;">LG Tube:</label>
                                        <label class="lable2 text-start mx-2 mt-1  d-md-none " for="">LG Tube
                                            :</label>
                                        <select name="scopeLgTube" id="scopeLgTube" class="form-control">
                                            @if ($incomingInsppectionFormData->scope_lgtube == 1)
                                                <option value="1">Ok</option>
                                                <option value="0">Not Ok</option>
                                            @else
                                                <option value="0">Not Ok</option>
                                                <option value="1">Ok</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                {{--  --}}
                                <div class="col-md-6">
                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                            style="width:300px;">Insertion Tube:</label>
                                        <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                            for="">Insertion Tube:</label>
                                        <select name="scopeInsertionTube" id="scopeInsertionTube"
                                            class="form-control">
                                            @if ($incomingInsppectionFormData->scope_insertiontube == 1)
                                                <option value="1">Ok</option>
                                                <option value="0">Not Ok</option>
                                            @else
                                                <option value="0">Not Ok</option>
                                                <option value="1">Ok</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                {{--  --}}
                                <div class="col-md-6">
                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                            style="width:300px;">Biopsy Channel:</label>
                                        <label class="lable2 text-start mx-2 mt-1  d-md-none " for="">Biopsy
                                            Channel:</label>
                                        <select name="scopeBiopsyChannel" id="scopeBiopsyChannel"
                                            class="form-control">
                                            @if ($incomingInsppectionFormData->scope_biopsychannel == 1)
                                                <option value="1">Ok</option>
                                                <option value="0">Not Ok</option>
                                            @else
                                                <option value="0">Not Ok</option>
                                                <option value="1">Ok</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                {{--  --}}
                                <div class="col-md-6">
                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                            style="width:300px;">Objective Lenz:</label>
                                        <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                            for="">Objective Lenz:</label>
                                        <select name="scopeObjectiveLenz" id="scopeObjectiveLenz"
                                            class="form-control">
                                            @if ($incomingInsppectionFormData->scope_objectivelenz == 1)
                                                <option value="1">Ok</option>
                                                <option value="0">Not Ok</option>
                                            @else
                                                <option value="0">Not Ok</option>
                                                <option value="1">Ok</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                {{--  --}}
                                <div class="col-md-6">
                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                            style="width:300px;">Suction:</label>
                                        <label class="lable2 text-start mx-2 mt-1  d-md-none " for="">Suction
                                            :</label>
                                        <select name="scopeSuction" id="scopeSuction" class="form-control">
                                            @if ($incomingInsppectionFormData->scope_suction == 1)
                                                <option value="1">Ok</option>
                                                <option value="0">Not Ok</option>
                                            @else
                                                <option value="0">Not Ok</option>
                                                <option value="1">Ok</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                {{--  --}}
                                <div class="col-md-6">
                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                            style="width:300px;">Angulation Lock:</label>
                                        <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                            for="">Angulation Lock:</label>
                                        <select name="scopeAngulationLock" id="scopeAngulationLock"
                                            class="form-control">
                                            @if ($incomingInsppectionFormData->scope_angulation_lock == 1)
                                                <option value="1">Ok</option>
                                                <option value="0">Not Ok</option>
                                            @else
                                                <option value="0">Not Ok</option>
                                                <option value="1">Ok</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                {{--  --}}
                                <div class="col-md-6">
                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                            style="width:300px;">Freeze Buttons:</label>
                                        <label class="lable2 text-start mx-2 mt-1  d-md-none " for="">Freeze
                                            Buttons
                                            :</label>
                                        <select name="scopeFreezeButtons" id="scopeFreezeButtons"
                                            class="form-control">
                                            @if ($incomingInsppectionFormData->scope_freezing_buttons == 1)
                                                <option value="1">Ok</option>
                                                <option value="0">Not Ok</option>
                                            @else
                                                <option value="0">Not Ok</option>
                                                <option value="1">Ok</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                {{--  --}}
                                {{--  --}}
                                <br>
                                <h5 class="text-start d-none d-md-block">Your Remarks In Details</h5>
                                <h5 class="text-center d-md-none ">Your Remarks In Details</h5>
                                {{--  --}}
                                <div class="col-12">
                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                            style="width:300px;">Remarks:</label>
                                        <label class="lable2 text-start mx-2 mt-1  d-md-none " for="">Remarks
                                            :</label>
                                        <textarea name="scopeRemarks" id="scopeRemarks" cols="30" rows="10" class="form-control"
                                            placeholder="Ex, Describe Scope Fault And Your Remarks In Details">{{ $incomingInsppectionFormData->remarks }}</textarea>
                                    </div>
                                </div>
                                {{--  --}}
                                <br>
                                <h5 class="text-start d-none d-md-block">Scope Checked And Inspected By</h5>
                                <h5 class="text-center d-md-none ">Scope Checked And Inspected By</h5>
                                {{--  --}}
                                @if ($selectEmployees->isEmpty())
                                @else
                                    <div class="col-12">
                                        <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                            <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                                style="width:300px;">Inspected By:</label>
                                            <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                                for="">Inspected By
                                                :</label>
                                            <select name="scopeInspectedBy" id="scopeInspectedBy"
                                                class="form-control">
                                                <option value="{{ $incomingInsppectionFormData->inspectedby_id }}">
                                                    {{ $incomingInsppectionFormData->employeename }}</option>
                                                @foreach ($selectEmployees as $selectEmployee)
                                                    <option value="{{ $selectEmployee->id }}">
                                                        {{ $selectEmployee->employeename }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif
                                {{--  --}}
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-outline-primary">Save</button>
                        </div>
                    </form>
                @else
                    {{-- tjf --}}
                    <form action="{{ route('TjfInspectionOutgoingCreatingOperation') }}" method="post"
                        class="row" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-10 py-2 px-2">
                            <div class="row px-2 py-2">
                                <h5 class="text-start d-none d-md-block">Scope Basic Information</h5>
                                <h5 class="text-center d-md-none ">Scope Basic Information</h5>
                                <div class="col-12">
                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                            style="width:300px;">Scope Model:</label>
                                        <label class="lable2 text-start mx-2 mt-1  d-md-none " for="">Scope
                                            Model
                                            :</label>
                                        <input type="text" class="form-control" placeholder="Ex, gif-140"
                                            name="scopeModel"
                                            value="{{ $incomingInsppectionFormData->scope_model }}">
                                        <input type="text" class="form-control d-none" placeholder="Ex, gif-140"
                                            name="companyId" value="{{ $incomingInsppectionFormData->company_id }}">
                                        <input type="text" class="form-control d-none" placeholder="Ex, gif-140"
                                            name="incomingInspectionId"
                                            value="{{ $incomingInsppectionFormData->id }}">
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
                                        <input type="date" class="form-control" placeholder="Ex, 12-12-2023"
                                            name="scopeIncomingDate">
                                    </div>
                                </div>
                                {{--  --}}
                                <div class="col-12">
                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                            style="width:300px;">Sr Number:</label>
                                        <label class="lable2 text-start mx-2 mt-1  d-md-none " for="">Sr
                                            Number
                                            :</label>
                                        <input type="number" class="form-control" placeholder="Ex, 123456789"
                                            name="scopeSrNumber"
                                            value="{{ $incomingInsppectionFormData->scope_sr_number }}">
                                    </div>
                                </div>
                                {{--  --}}
                                <div class="col-12">
                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                            style="width:300px;">Receiver Name:</label>
                                        <label class="lable2 text-start mx-2 mt-1  d-md-none " for="">Receiver
                                            Name
                                            :</label>
                                        <input type="text" class="form-control" placeholder="Ex, Demo Person"
                                            name="scopeSenderName"
                                            value="{{ $incomingInsppectionFormData->sender_name }}">
                                    </div>
                                </div>
                                {{--  --}}
                                <br>
                                <h5 class="text-start d-none d-md-block">Scope Sending With</h5>
                                <h5 class="text-center d-md-none ">Scope Sending With</h5>
                                {{--  --}}
                                <div class="col-12">
                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                            style="width:300px;">Scope Received With:</label>
                                        <label class="lable2 text-start mx-2 mt-1  d-md-none " for="">Scope
                                            Received With
                                            :</label>
                                        <textarea name="scopeReceivedWith" id="scopeReceivedWith" cols="30" rows="6" class="form-control"
                                            placeholder="Ex, Demo Data">{{ $incomingInsppectionFormData->scope_sending_with }}</textarea>
                                    </div>
                                </div>
                                {{--  --}}
                                <br>
                                <h5 class="text-start d-none d-md-block">Inspection Related Information</h5>
                                <h5 class="text-center d-md-none ">Inspection Related Information</h5>
                                {{--  --}}
                                <div class="col-md-6">
                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                            style="width:300px;">Leakage:</label>
                                        <label class="lable2 text-start mx-2 mt-1  d-md-none " for="">Leakage
                                            :</label>
                                        <select name="scopeLeakage" id="scopeLeakage" class="form-control">
                                            @if ($incomingInsppectionFormData->scope_leakage == 1)
                                                <option value="1">Ok</option>
                                                <option value="0">Not Ok</option>
                                            @else
                                                <option value="0">Not Ok</option>
                                                <option value="1">Ok</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                {{--  --}}
                                <div class="col-md-6">
                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                            style="width:300px;">View:</label>
                                        <label class="lable2 text-start mx-2 mt-1  d-md-none " for="">View
                                            :</label>
                                        <select name="scopeView" id="scopeView" class="form-control">
                                            @if ($incomingInsppectionFormData->scope_view == 1)
                                                <option value="1">Ok</option>
                                                <option value="0">Not Ok</option>
                                            @else
                                                <option value="0">Not Ok</option>
                                                <option value="1">Ok</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                {{--  --}}
                                <div class="col-md-6">
                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                            style="width:300px;">Light Guide:</label>
                                        <label class="lable2 text-start mx-2 mt-1  d-md-none " for="">Light
                                            Guide
                                            :</label>
                                        <select name="scopeLightGuide" id="scopeLightGuide" class="form-control">
                                            @if ($incomingInsppectionFormData->scope_lightguide == 1)
                                                <option value="1">Ok</option>
                                                <option value="0">Not Ok</option>
                                            @else
                                                <option value="0">Not Ok</option>
                                                <option value="1">Ok</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                {{--  --}}
                                <div class="col-md-6">
                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                            style="width:300px;">Air/Water:</label>
                                        <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                            for="">Air/Water
                                            :</label>
                                        <select name="scopeairwater" id="scopeairwater" class="form-control">
                                            @if ($incomingInsppectionFormData->scope_airwater == 1)
                                                <option value="1">Ok</option>
                                                <option value="0">Not Ok</option>
                                            @else
                                                <option value="0">Not Ok</option>
                                                <option value="1">Ok</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                {{--  --}}
                                <div class="col-md-6">
                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                            style="width:300px;">Angulations:</label>
                                        <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                            for="">Angulations
                                            :</label>
                                        <select name="scopeAngulation" id="scopeAngulation" class="form-control">
                                            @if ($incomingInsppectionFormData->scope_angulation == 1)
                                                <option value="1">Ok</option>
                                                <option value="0">Not Ok</option>
                                            @else
                                                <option value="0">Not Ok</option>
                                                <option value="1">Ok</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                {{--  --}}
                                <div class="col-md-6">
                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                            style="width:300px;">LG Tube:</label>
                                        <label class="lable2 text-start mx-2 mt-1  d-md-none " for="">LG Tube
                                            :</label>
                                        <select name="scopeLgTube" id="scopeLgTube" class="form-control">
                                            @if ($incomingInsppectionFormData->scope_lgtube == 1)
                                                <option value="1">Ok</option>
                                                <option value="0">Not Ok</option>
                                            @else
                                                <option value="0">Not Ok</option>
                                                <option value="1">Ok</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                {{--  --}}
                                <div class="col-md-6">
                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                            style="width:300px;">Insertion Tube:</label>
                                        <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                            for="">Insertion Tube:</label>
                                        <select name="scopeInsertionTube" id="scopeInsertionTube"
                                            class="form-control">
                                            @if ($incomingInsppectionFormData->scope_insertiontube == 1)
                                                <option value="1">Ok</option>
                                                <option value="0">Not Ok</option>
                                            @else
                                                <option value="0">Not Ok</option>
                                                <option value="1">Ok</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                {{--  --}}
                                <div class="col-md-6">
                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                            style="width:300px;">Biopsy Channel:</label>
                                        <label class="lable2 text-start mx-2 mt-1  d-md-none " for="">Biopsy
                                            Channel:</label>
                                        <select name="scopeBiopsyChannel" id="scopeBiopsyChannel"
                                            class="form-control">
                                            @if ($incomingInsppectionFormData->scope_biopsychannel == 1)
                                                <option value="1">Ok</option>
                                                <option value="0">Not Ok</option>
                                            @else
                                                <option value="0">Not Ok</option>
                                                <option value="1">Ok</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                {{--  --}}
                                <div class="col-md-6">
                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                            style="width:300px;">Objective Lenz:</label>
                                        <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                            for="">Objective Lenz:</label>
                                        <select name="scopeObjectiveLenz" id="scopeObjectiveLenz"
                                            class="form-control">
                                            @if ($incomingInsppectionFormData->scope_objectivelenz == 1)
                                                <option value="1">Ok</option>
                                                <option value="0">Not Ok</option>
                                            @else
                                                <option value="0">Not Ok</option>
                                                <option value="1">Ok</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                {{--  --}}
                                <div class="col-md-6">
                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                            style="width:300px;">Suction:</label>
                                        <label class="lable2 text-start mx-2 mt-1  d-md-none " for="">Suction
                                            :</label>
                                        <select name="scopeSuction" id="scopeSuction" class="form-control">
                                            @if ($incomingInsppectionFormData->scope_suction == 1)
                                                <option value="1">Ok</option>
                                                <option value="0">Not Ok</option>
                                            @else
                                                <option value="0">Not Ok</option>
                                                <option value="1">Ok</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                {{--  --}}
                                <div class="col-md-6">
                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                            style="width:300px;">Angulation Lock:</label>
                                        <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                            for="">Angulation Lock:</label>
                                        <select name="scopeAngulationLock" id="scopeAngulationLock"
                                            class="form-control">
                                            @if ($incomingInsppectionFormData->scope_angulation_lock == 1)
                                                <option value="1">Ok</option>
                                                <option value="0">Not Ok</option>
                                            @else
                                                <option value="0">Not Ok</option>
                                                <option value="1">Ok</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                {{--  --}}
                                <div class="col-md-6">
                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                            style="width:300px;">Freeze Buttons:</label>
                                        <label class="lable2 text-start mx-2 mt-1  d-md-none " for="">Freeze
                                            Buttons
                                            :</label>
                                        <select name="scopeFreezeButtons" id="scopeFreezeButtons"
                                            class="form-control">
                                            @if ($incomingInsppectionFormData->scope_freezing_buttons == 1)
                                                <option value="1">Ok</option>
                                                <option value="0">Not Ok</option>
                                            @else
                                                <option value="0">Not Ok</option>
                                                <option value="1">Ok</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                {{--  --}}
                                <br>
                                <h5 class="text-start d-none d-md-block">Tjf Scope Related Information</h5>
                                <h5 class="text-center d-md-none ">Tjf Scope Related Information</h5>
                                {{--  --}}
                                <div class="col-md-6">
                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                            style="width:300px;">Elevator Channel:</label>
                                        <label class="lable2 text-start mx-2 mt-1  d-md-none " for="">Elevator
                                            Channel
                                            :</label>
                                        <select name="scopeElevatorChannel" id="scopeElevatorChannel"
                                            class="form-control">
                                            @if ($incomingInsppectionFormData->scope_tjf_elevator_channel == 1)
                                                <option value="1">Ok</option>
                                                <option value="0">Not Ok</option>
                                            @else
                                                <option value="0">Not Ok</option>
                                                <option value="1">Ok</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                {{--  --}}
                                <div class="col-md-6">
                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                            style="width:300px;">Elevator Wire:</label>
                                        <label class="lable2 text-start mx-2 mt-1  d-md-none " for="">Elevator
                                            Wire
                                            :</label>
                                        <select name="scopeElevatorWire" id="scopeElevatorWire" class="form-control">
                                            @if ($incomingInsppectionFormData->scope_tjf_elevator_wire == 1)
                                                <option value="1">Ok</option>
                                                <option value="0">Not Ok</option>
                                            @else
                                                <option value="0">Not Ok</option>
                                                <option value="1">Ok</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                {{--  --}}
                                <div class="col-md-6">
                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                            style="width:300px;">Elevator Axel:</label>
                                        <label class="lable2 text-start mx-2 mt-1  d-md-none " for="">Elevator
                                            Axel
                                            :</label>
                                        <select name="scopeElevatorAxel" id="scopeElevatorAxel" class="form-control">
                                            @if ($incomingInsppectionFormData->scope_tjf_elevator_axel == 1)
                                                <option value="1">Ok</option>
                                                <option value="0">Not Ok</option>
                                            @else
                                                <option value="0">Not Ok</option>
                                                <option value="1">Ok</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                {{--  --}}
                                <div class="col-md-6">
                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                            style="width:300px;">Tjf Tip Cover:</label>
                                        <label class="lable2 text-start mx-2 mt-1  d-md-none " for="">Tjf Tip
                                            Cover
                                            :</label>
                                        <select name="scopeTipCover" id="scopeTipCover" class="form-control">
                                            @if ($incomingInsppectionFormData->scope_tjf_tip_cover == 1)
                                                <option value="1">Ok</option>
                                                <option value="0">Not Ok</option>
                                            @else
                                                <option value="0">Not Ok</option>
                                                <option value="1">Ok</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                {{--  --}}
                                <div class="col-md-6">
                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                            style="width:300px;">Elevator Clinder:</label>
                                        <label class="lable2 text-start mx-2 mt-1  d-md-none " for="">Elevator
                                            Clinder
                                            :</label>
                                        <select name="scopeElevatorClinder" id="scopeElevatorClinder"
                                            class="form-control">
                                            @if ($incomingInsppectionFormData->scope_tjf_elevator_clinder == 1)
                                                <option value="1">Ok</option>
                                                <option value="0">Not Ok</option>
                                            @else
                                                <option value="0">Not Ok</option>
                                                <option value="1">Ok</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                {{--  --}}
                                <div class="col-md-6">
                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                            style="width:300px;">Elevator Liver:</label>
                                        <label class="lable2 text-start mx-2 mt-1  d-md-none " for="">Elevator
                                            Liver
                                            :</label>
                                        <select name="scopeElevatorLiver" id="scopeElevatorLiver"
                                            class="form-control">
                                            @if ($incomingInsppectionFormData->scope_tjf_liver == 1)
                                                <option value="1">Ok</option>
                                                <option value="0">Not Ok</option>
                                            @else
                                                <option value="0">Not Ok</option>
                                                <option value="1">Ok</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                {{--  --}}
                                {{--  --}}
                                <br>
                                <h5 class="text-start d-none d-md-block">Your Remarks In Details</h5>
                                <h5 class="text-center d-md-none ">Your Remarks In Details</h5>
                                {{--  --}}
                                <div class="col-12">
                                    <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                        <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                            style="width:300px;">Remarks:</label>
                                        <label class="lable2 text-start mx-2 mt-1  d-md-none " for="">Remarks
                                            :</label>
                                        <textarea name="scopeRemarks" id="scopeRemarks" cols="30" rows="10" class="form-control"
                                            placeholder="Ex, Describe Scope Fault And Your Remarks In Details">{{ $incomingInsppectionFormData->remarks }}</textarea>
                                    </div>
                                </div>
                                {{--  --}}
                                <br>
                                <h5>Scope Checked And Inspected By</h5>
                                {{--  --}}
                                @if ($selectEmployees->isEmpty())
                                @else
                                    <div class="col-12">
                                        <div class="d-md-flex flex-md-row align-items-md-start py-2">
                                            <label class="lable1 text-end mx-2 mt-1 d-none d-md-inline" for=""
                                                style="width:300px;">Inspected By:</label>
                                            <label class="lable2 text-start mx-2 mt-1  d-md-none "
                                                for="">Inspected By
                                                :</label>
                                            <select name="scopeInspectedBy" id="scopeInspectedBy"
                                                class="form-control">
                                                <option value="{{ $incomingInsppectionFormData->inspectedby_id }}">
                                                    {{ $incomingInsppectionFormData->employeename }}</option>
                                                @foreach ($selectEmployees as $selectEmployee)
                                                    <option value="{{ $selectEmployee->id }}">
                                                        {{ $selectEmployee->employeename }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif
                                {{--  --}}
                            </div>
                        </div>
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
