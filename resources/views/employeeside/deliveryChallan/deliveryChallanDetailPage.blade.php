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
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap" rel="stylesheet">
    <link href="/themes/public/vendors/overlayscrollbars/OverlayScrollbars.min.css" rel="stylesheet">
    <link href="/themes/public/assets/css/theme-rtl.min.css" rel="stylesheet" id="style-rtl">
    <link href="/themes/public/assets/css/theme.min.css" rel="stylesheet" id="style-default">
    <link href="/themes/public/assets/css/user-rtl.min.css" rel="stylesheet" id="user-style-rtl">
    <link href="/themes/public/assets/css/user.min.css" rel="stylesheet" id="user-style-default">
    <link rel="stylesheet" href="/project scope vision/quotation/quotation-disposible/with logo/With-Logo_quotation.css">
    <title>Scope Visions | Detail Delivery Challan</title>
</head>
<body>
    <div class="container-fluid mt-2">
        <div class="col-md-12 text-right mb-3">
            <button class="btn btn-primary" id="download"> download pdf</button>
        </div>
        <div class="bg-white" id="invoice">
            {{-- <div class="card-header"> --}}
            {{-- </div> --}}
            {{-- <div class="card-body"> --}}
                <div class="col-12">
                    <h1 class="text-start">Delivery Challan</h1>
                </div>
                @if ( $selectQuotation->isEmpty() )
                    
                @else
                    @foreach ($selectQuotation as $selectQuotations)
                    @endforeach
                    <div class="col-12 px-2">
                        <div class="row">
                            <div class="col-6 d-flex flex-column justify-content-center align-items-center">
                                <div class="d-flex justify-content-start align-items-start w-100">
                                    <b class="me-2" style="text-align: start;width:120px;">
                                        Delivered To:
                                     </b>
                                     <p style="width: 70%;">{{ $selectQuotations->client_organizationname }} <br><span>{{ $selectQuotations->client_address }}</span></p>
                                </div>
                               </div>
                           <div class="col-6 d-flex flex-column justify-content-end align-items-center">
                            <div class="d-flex justify-content-end align-items-start w-100">
                                <b class="me-2" style="text-align: end;width:100px;">
                                   Serial No:
                                </b>
                                <span style="width: 40%;">{{ $selectQuotations->id }}</span>
                            </div>
                            
                            <div class="d-flex justify-content-end align-items-start w-100">
                                <b class="me-2" style="text-align: end;width:100px;">
                                   Date:
                                </b>
                                <span style="width: 40%;">{{ \Carbon\Carbon::parse($selectQuotations->delivery_challan_date)->format('M d, Y') }}</span>
                             </div>
                             
                             <div class="d-flex justify-content-end align-items-start w-100">
                                <b class="me-2" style="text-align: end;width:100px;">
                                   Inv No:
                                </b>
                                <span style="width: 40%;">{{ $selectQuotations->invoice_id }}</span>
                            </div>
                            
                           </div>
                        </div>
                        <div class="row">
                            <div class="col-12 pt-2">
                                <span style="width: 70%;font-size:14px;">{{ $selectQuotations->delivery_challan }}</span>
                            </div>
                            <div class="col-12">
                                <div class="d-none d-md-block">
                                <table class="w-100 py-2">
                                    <thead>
                                        <tr>
                                           <th  class="py-1 mb-2" style="width:10%;font-size: 16px;text-align:center;border-top: 2px solid black;border-bottom: 2px solid black;">Sr no</th>
                                           <th class="py-1 mb-2" style="width:70%;font-size: 16px;text-align:start;border-top: 2px solid black;border-bottom: 2px solid black;">Details</th>
                                           <th class="py-1 mb-2" style="width:20%;font-size: 16px;text-align:center;border-top: 2px solid black;border-bottom: 2px solid black;">Quantities</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $delivery_challan_item_srNumber = isset($selectQuotations->delivery_challan_item_srNumber) ? json_decode($selectQuotations->delivery_challan_item_srNumber, true) : [];
                                            $delivery_challan_item_description = isset($selectQuotations->item_id) ? json_decode($selectQuotations->item_id, true) : [];
                                            $delivery_challan_item_qtv = isset($selectQuotations->delivery_challan_item_qtv) ? json_decode($selectQuotations->delivery_challan_item_qtv, true) : [];
                                        @endphp
                                        @foreach ($delivery_challan_item_srNumber as $key => $delivery_challan_item_srNumbers)
                                        <tr>
                                            <td style="width:10%;">
                                                <div class="d-flex justify-content-center align-items-start">
                                                    <span>{{ $delivery_challan_item_srNumbers }}</span>
                                                </div>
                                            </td>
                                            <td style="width:70%;">
                                                <div class="d-flex flex-column justify-content-center align-items-start">
                                                    @if(isset($delivery_challan_item_description[$key]))
                                                    @php
                                                        $item = DB::table('stock_records')->where('id', $delivery_challan_item_description[$key])->first();
                                                    @endphp
                                                    <span>
                                                    {{ $item ? $item->item_name : '' }}
                                                    </span>
                                                    @if (empty($item->item_srno))
                                                        
                                                    @else
                                                    <div class="d-flex justify-content-center align-items-start">
                                                   ( <span>Model: {{ $item->item_model }}</span>, <span class="mx-1">Sr No:{{$item->item_srno}}</span> )
                                                    </div>
                                                    @endif
                                                    @endif
                                                </div>
                                            </td>
                                            <td style="width:20%;">
                                                <div class="d-flex justify-content-center align-items-start">
                                                    <span>{{ $delivery_challan_item_qtv[$key] }}</span>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                </div>
                                <div class="d-md-none">
                                    <div style="overflow-x:auto;">
                                    <table class="w-100 py-2">
                                        <thead>
                                            <tr>
                                               <th class="py-1 mb-2" style="font-size: 16px;text-align:center;border-top: 2px solid black;border-bottom: 2px solid black;"><div class="d-flex justify-content-center align-items-start" style="width: 50px;"><span>Sr no</span></div></th>
                                               <th class="py-1 mb-2" style="font-size: 16px;text-align:start;border-top: 2px solid black;border-bottom: 2px solid black;"><div class="d-flex justify-content-center align-items-start" style="width: 350px;"><span>Details</span></div></th>
                                               <th class="py-1 mb-2" style="font-size: 16px;text-align:center;border-top: 2px solid black;border-bottom: 2px solid black;"><div class="d-flex justify-content-center align-items-start" style="width: 50px;"><span>Quantities</span></div></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $delivery_challan_item_srNumber = isset($selectQuotations->delivery_challan_item_srNumber) ? json_decode($selectQuotations->delivery_challan_item_srNumber, true) : [];
                                                $delivery_challan_item_description = isset($selectQuotations->item_id) ? json_decode($selectQuotations->item_id, true) : [];
                                                $delivery_challan_item_qtv = isset($selectQuotations->delivery_challan_item_qtv) ? json_decode($selectQuotations->delivery_challan_item_qtv, true) : [];
                                            @endphp
                                            @foreach ($delivery_challan_item_srNumber as $key => $delivery_challan_item_srNumbers)
                                            <tr>
                                                <td>
                                                    <div class="d-flex justify-content-center align-items-start" style="width: 50px;">
                                                        <span>{{ $delivery_challan_item_srNumbers }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center align-items-start" style="width:350px;">
                                                        @if(isset($delivery_challan_item_description[$key]))
                                                        @php
                                                            $item = DB::table('stock_records')->where('id', $delivery_challan_item_description[$key])->first();
                                                        @endphp
                                                        <span>
                                                        {{ $item ? $item->item_name : '' }}
                                                        </span>
                                                        @if (empty($item->item_srno))
                                                            
                                                        @else
                                                        <div class="d-flex justify-content-center align-items-start">
                                                       ( <span>Model: {{ $item->item_model }}</span>, <span class="mx-1">Sr No:{{$item->item_srno}}</span> )
                                                        </div>
                                                        @endif
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-center align-items-start" style="width:50px;">
                                                        <span>{{ $delivery_challan_item_qtv[$key] }}</span>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                                {{--  --}}
                                <div class="row mt-1 px-3 py-2 d-flex justify-content-between align-items-center">
                                    <div class="col-12" style="border-bottom:2px solid black"></div>
                                    <div class="col-md-6 mt-3 mb-2">
                                        <h5>Delivered By,</h5>
                                        <div class="py-1">
                                            <div class="d-flex flex-column justify-content-start align-items-end w-100">
                                                <div class="col-12 py-2 d-flex justify-content-start align-items-center">
                                                    <div class="col-4 d-flex justify-content-start align-items-center">
                                                        <b class="me-2" style="text-align: end;font-size:13px;">
                                                           Name:
                                                        </b>
                                                       
                                                     </div>
                                                     <div class="col-8 d-flex justify-content-start align-items-center pt-2">
                                                        <div style="border-bottom:1px solid black;width:100%;"></div>
                                                     </div>
                                                </div>
                                                <div class="col-12 py-2 d-flex justify-content-start align-items-center">
                                                    <div class="col-4 d-flex justify-content-start align-items-center">
                                                        <b class="me-2" style="text-align: end;font-size:13px;">
                                                           Designation:
                                                        </b>
                                                        
                                                     </div>
                                                     <div class="col-8 d-flex justify-content-start align-items-center pt-2">
                                                        <div style="border-bottom:1px solid black;width:100%;"></div>
                                                     </div>
                                                </div>
                                                <div class="col-12 py-2 d-flex justify-content-start align-items-center">
                                                    <div class="col-4 d-flex justify-content-start align-items-center">
                                                        <b class="me-2" style="text-align: end;font-size:13px;">
                                                            Date:
                                                        </b>
                                                        
                                                     </div>
                                                     <div class="col-8 d-flex justify-content-start align-items-center pt-2">
                                                        <div style="border-bottom:1px solid black;width:100%;"></div>
                                                     </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-3 mb-2">
                                        <h5 class="d-none d-md-block" style="text-align: end">Received By,</h5>
                                        <h5 class="d-md-none" style="text-align: start">Received By,</h5>
                                        <div class="py-1">
                                            <div class="d-flex flex-column justify-content-start align-items-end w-100">
                                                <div class="col-12 py-2 d-flex justify-content-start align-items-center">
                                                    <div class="col-4 d-flex justify-content-start align-items-center">
                                                        <b class="me-2" style="text-align: end;font-size:13px;">
                                                           Name:
                                                        </b>
                                                       
                                                     </div>
                                                     <div class="col-8 d-flex justify-content-start align-items-center pt-2">
                                                        <div style="border-bottom:1px solid black;width:100%;"></div>
                                                     </div>
                                                </div>
                                                <div class="col-12 py-2 d-flex justify-content-start align-items-center">
                                                    <div class="col-4 d-flex justify-content-start align-items-center">
                                                        <b class="me-2" style="text-align: end;font-size:13px;">
                                                           Designation:
                                                        </b>
                                                        
                                                     </div>
                                                     <div class="col-8 d-flex justify-content-start align-items-center pt-2">
                                                        <div style="border-bottom:1px solid black;width:100%;"></div>
                                                     </div>
                                                </div>
                                                <div class="col-12 py-2 d-flex justify-content-start align-items-center">
                                                    <div class="col-4 d-flex justify-content-start align-items-center">
                                                        <b class="me-2" style="text-align: end;font-size:13px;">
                                                            Date:
                                                        </b>
                                                        
                                                     </div>
                                                     <div class="col-8 d-flex justify-content-start align-items-center pt-2">
                                                        <div style="border-bottom:1px solid black;width:100%;"></div>
                                                     </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            {{-- </div> --}}
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