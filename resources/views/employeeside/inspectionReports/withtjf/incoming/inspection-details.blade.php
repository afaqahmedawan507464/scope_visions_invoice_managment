<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="theme-color" content="#ffffff">
    <script src="/themes/public/assets/js/config.js"></script>
    <script src="/themes/public/vendors/overlayscrollbars/OverlayScrollbars.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>

    <script src="/pdf.js"></script>

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
    <title>Scope Visions | Detail Inspection Report</title>
</head>

<body>
    <div class="col-md-12 text-right mb-3">
        <button class="btn btn-primary" id="download"> download pdf</button>
    </div>
    <div class="container-fluid mt-2" id="invoice">

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
        <div class="bg-light px-3 py-2">
            @foreach ($selectCompany as $selectCompanyss)
            @endforeach
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col-6 text-center">
                    <div class="d-flex align-items-center">
                        <div class="img-div mx-3" style="height: 100px;width: 105px;border-radius:50%;">
                            <img src="{{ $selectCompanyss->company_logo }}" alt=""
                                style="height: 100%;width: 100%;border-radius:50%;">
                        </div>
                        <h3 style="text-transform: uppercase;color: #15A4FB;">{{ $selectCompanyss->company_name }}</h3>
                    </div>
                </div>
                @foreach ($selectIncomingReportInspection as $selectIncomingReportInspections)
                @endforeach
                <div class="col-6 text-end">
                    <p>
                        Serial Number : {{ $selectIncomingReportInspections->id }}
                    </p>
                </div>
            </div>
            <div class="row mt-3">
                <h3 style="text-transform:capitalize;text-align:center">Incoming Inspection Report</h3>
                <div class="col-3 py-2" style="border:0.5px solid lightgray">
                    <label class="my-1" style="margin-top: 5px;">Scope Model:</label>
                    <input type="text" class="form-control" placeholder="enter data"
                        style="width:100%;font-size:10px; !important;"
                        value="{{ $selectIncomingReportInspections->scope_model }}" disabled>
                </div>
                <div class="col-3 py-2" style="border:0.5px solid lightgray">
                    <label class="my-1" style="margin-top: 5px;">Incoming Date:</label>
                    <input type="text" class="form-control" placeholder="enter data"
                        style="width:100%;font-size:10px; !important;"
                        value="{{ $selectIncomingReportInspections->scope_incoming_date }}" disabled>
                </div>
                <div class="col-3 py-2" style="border:0.5px solid lightgray">
                    <label class="my-1" style="margin-top: 5px;">Sr Number:</label>
                    {{-- <input type="number" class="form-control" placeholder="enter data" style="width:100%;"> --}}
                    <input type="text" class="form-control" placeholder="enter data"
                        style="width:100%;font-size:10px; !important;"
                        value="{{ $selectIncomingReportInspections->scope_sr_number }}" disabled>
                </div>
                <div class="col-3 py-2" style="border:0.5px solid lightgray">
                    <label class="my-1" style="margin-top: 5px;">Sender Name:</label>
                    {{-- <input type="text" class="form-control" placeholder="enter data" style="width:100%;"> --}}
                    <input type="text" class="form-control" placeholder="enter data"
                        style="width:100%;font-size:10px; !important;"
                        value="{{ $selectIncomingReportInspections->sender_name }}" disabled>
                </div>
                @if ($selectIncomingReportInspections->scope_tjf_elevator_channel == '')
                    <div class="col-12 py-2" style="border:0.5px solid lightgray">
                        <label class="my-1" style="margin-top: 5px;">Scope Received With:</label>
                        {{-- <textarea name="" id="" cols="30" rows="4" class="form-control" disabled>{{ $selectIncomingReportInspections->scope_sending_with }}</textarea> --}}
                        <p style="font-size: 12px">{{ $selectIncomingReportInspections->scope_sending_with }}</p>
                    </div>
                @else
                    <div class="col-12 py-2" style="border:0.5px solid lightgray">
                        <label class="my-1" style="margin-top: 5px;">Scope Received With:</label>
                        {{-- <textarea name="" id="" cols="30" rows="4" class="form-control" disabled>{{ $selectIncomingReportInspections->scope_sending_with }}</textarea> --}}
                        <p style="font-size: 10px">{{ $selectIncomingReportInspections->scope_sending_with }}</p>
                    </div>
                @endif
            </div>
            <!--  -->
            <h5 class="text-center mt-2">Current Condition At The Time Of Inspection</h5>
            <!--  -->
            <div class="row">

                <div class="col-2 p-2" style="border:0.5px solid lightgray">
                    <label class="my-2" style="margin-top: 5px;font-size:12px;">Leakage:</label>
                    @if ($selectIncomingReportInspections->scope_leakage == 1)
                        <option value="">Ok</option>
                    @else
                        <option value="">Not Ok</option>
                    @endif
                    </select>
                </div>
                <div class="col-2 p-2" style="border:0.5px solid lightgray">
                    <label class="my-2" style="margin-top: 5px;font-size:12px;">View:</label>
                    @if ($selectIncomingReportInspections->scope_view == 1)
                        <option value="">Ok</option>
                    @else
                        <option value="">Not Ok</option>
                    @endif
                    </select>
                </div>
                <div class="col-2 p-2" style="border:0.5px solid lightgray">
                    <label class="my-2" style="margin-top: 5px;font-size:12px;">Light Guide:</label>
                    @if ($selectIncomingReportInspections->scope_lightguide == 1)
                        <option value="">Ok</option>
                    @else
                        <option value="">Not Ok</option>
                    @endif
                    </select>
                </div>
                <div class="col-2 p-2" style="border:0.5px solid lightgray">
                    <label class="my-2" style="margin-top: 5px;font-size:12px;">Air/Water:</label>
                    @if ($selectIncomingReportInspections->scope_airwater == 1)
                        <option value="">Ok</option>
                    @else
                        <option value="">Not Ok</option>
                    @endif
                    </select>
                </div>
                <div class="col-2 p-2" style="border:0.5px solid lightgray">
                    <label class="my-2" style="margin-top: 5px;font-size:12px;">Angulations:</label>
                    @if ($selectIncomingReportInspections->scope_angulation == 1)
                        <option value="">Ok</option>
                    @else
                        <option value="">Not Ok</option>
                    @endif
                    </select>
                </div>
                <div class="col-2 p-2" style="border:0.5px solid lightgray">
                    <label class="my-2" style="margin-top: 5px;font-size:12px;">LG Tube:</label>
                    @if ($selectIncomingReportInspections->scope_lgtube == 1)
                        <option value="">Ok</option>
                    @else
                        <option value="">Not Ok</option>
                    @endif
                    </select>
                </div>
                <!--  -->
                <div class="col-2 p-2" style="border:0.5px solid lightgray">
                    <label class="my-2" style="margin-top: 5px;font-size:12px;">Insertion Tube:</label>
                    @if ($selectIncomingReportInspections->scope_insertiontube == 1)
                        <option value="">Ok</option>
                    @else
                        <option value="">Not Ok</option>
                    @endif
                    </select>
                </div>
                <div class="col-2 p-2" style="border:0.5px solid lightgray">
                    <label class="my-2" style="margin-top: 5px;font-size:10px;">Biopsy Channel:</label>
                    @if ($selectIncomingReportInspections->scope_biopsychannel == 1)
                        <option value="">Ok</option>
                    @else
                        <option value="">Not Ok</option>
                    @endif
                    </select>
                </div>
                <div class="col-2 p-2" style="border:0.5px solid lightgray">
                    <label class="my-2" style="margin-top: 5px;font-size:12px;">Objective Lenz:</label>
                    @if ($selectIncomingReportInspections->scope_objectivelenz == 1)
                        <option value="">Ok</option>
                    @else
                        <option value="">Not Ok</option>
                    @endif
                    </select>
                </div>
                <div class="col-2 p-2" style="border:0.5px solid lightgray">
                    <label class="my-2" style="margin-top: 5px;font-size:12px;">Suction:</label>
                    @if ($selectIncomingReportInspections->scope_suction == 1)
                        <option value="">Ok</option>
                    @else
                        <option value="">Not Ok</option>
                    @endif
                    </select>
                </div>
                <div class="col-2 p-2" style="border:0.5px solid lightgray">
                    <label class="my-2" style="margin-top: 5px;font-size:12px;">Lock:</label>
                    @if ($selectIncomingReportInspections->scope_angulation_lock == 1)
                        <option value="">Ok</option>
                    @else
                        <option value="">Not Ok</option>
                    @endif
                    </select>
                </div>
                <div class="col-2 p-2" style="border:0.5px solid lightgray">
                    <label class="my-2" style="margin-top: 5px;font-size:12px;">Freeze Buttons:</label>
                    @if ($selectIncomingReportInspections->scope_freezing_buttons == 1)
                        <option value="">Ok</option>
                    @else
                        <option value="">Not Ok</option>
                    @endif
                    </select>
                </div>
            </div>
            {{--  --}}
            @if ($selectIncomingReportInspections->scope_tjf_elevator_channel == '')
            @else
                {{--  --}}
                <!--  -->
                <div class="row">
                    <div class="col-2 p-2" style="border:0.5px solid lightgray">
                        <label class="my-2" style="margin-top: 5px;font-size:12px;">Ele Channel:</label>
                        @if ($selectIncomingReportInspections->scope_tjf_elevator_channel == 1)
                            <option value="">Ok</option>
                        @else
                            <option value="">Not Ok</option>
                        @endif
                        </select>
                    </div>
                    <div class="col-2 p-2" style="border:0.5px solid lightgray">
                        <label class="my-2" style="margin-top: 5px;font-size:12px;">Elevator Wire:</label>
                        @if ($selectIncomingReportInspections->scope_tjf_elevator_wire == 1)
                            <option value="">Ok</option>
                        @else
                            <option value="">Not Ok</option>
                        @endif
                        </select>
                    </div>
                    <div class="col-2 p-2" style="border:0.5px solid lightgray">
                        <label class="my-2" style="margin-top: 5px;font-size:12px;">Elevator Axel:</label>
                        @if ($selectIncomingReportInspections->scope_tjf_elevator_axel == 1)
                            <option value="">Ok</option>
                        @else
                            <option value="">Not Ok</option>
                        @endif
                        </select>
                    </div>
                    <div class="col-2 p-2" style="border:0.5px solid lightgray">
                        <label class="my-2" style="margin-top: 5px;font-size:12px;">Tip Cover:</label>
                        @if ($selectIncomingReportInspections->scope_tjf_tip_cover == 1)
                            <option value="">Ok</option>
                        @else
                            <option value="">Not Ok</option>
                        @endif
                        </select>
                    </div>
                    <div class="col-2 p-2" style="border:0.5px solid lightgray">
                        <label class="my-2" style="margin-top: 5px;font-size:12px;">Ele Clinder:</label>
                        @if ($selectIncomingReportInspections->scope_tjf_elevator_clinder == 1)
                            <option value="">Ok</option>
                        @else
                            <option value="">Not Ok</option>
                        @endif
                        </select>
                    </div>
                    <div class="col-2 p-2" style="border:0.5px solid lightgray">
                        <label class="my-2" style="margin-top: 5px;font-size:12px;">Ele Liver:</label>
                        @if ($selectIncomingReportInspections->scope_tjf_liver == 1)
                            <option value="">Ok</option>
                        @else
                            <option value="">Not Ok</option>
                        @endif
                        </select>
                    </div>
                    <!--  -->
                </div>
                {{--  --}}
            @endif
            {{--  --}}
            <h5 class="text-center mt-2">Observe Scope Faults & Remarks In Details</h5>
            <div class="row">
                @if ($selectIncomingReportInspections->scope_tjf_elevator_channel == '')
                    <div class="col-12 py-2">
                        <label class="my-1" style="margin-top: 5px;">Remarks:</label>
                        {{-- <textarea class="form-control" name="" id="" cols="30" rows="8"></textarea> --}}
                        <p style="font-size: 12px">{{ $selectIncomingReportInspections->remarks }}</p>
                    </div>
                @else
                    <div class="col-12 py-2">
                        <label class="my-1" style="margin-top: 5px;">Remarks:</label>
                        {{-- <textarea class="form-control" name="" id="" cols="30" rows="8"></textarea> --}}
                        <p style="font-size: 12px">{{ $selectIncomingReportInspections->remarks }}</p>
                    </div>
                @endif
                <div class="col-6">
                    <div class="d-flex py-2">
                        <label class="my-1" style="margin-top: 5px;width: 150px;">Inspected By:</label>
                        <input type="text" class="form-control" placeholder="enter data" style="width:60%;"
                            value="{{ $selectIncomingReportInspections->employeename }}" disabled>
                    </div>
                    <div class="d-flex py-2">
                        <label class="my-1" style="margin-top: 5px;width: 150px;">Signature:</label>
                        <textarea class="form-control" name="" id="" cols="30" rows="2" style="width:60%;"></textarea>
                    </div>
                </div>
                <div class="col-6 p-2">
                    <div class="p-5" style="border:0.5px solid lightgray"></div>
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
    <script src="/custom.js"></script>
</body>

</html>
