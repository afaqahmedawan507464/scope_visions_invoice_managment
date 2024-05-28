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

    {{-- <script src="/pdf.js"></script> --}}

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
    <title>Scope Visions | Client Account Detail</title>
</head>

<body>
    <div class="container-fluid mt-2">
        <div class="col-md-12 text-right mb-3">
            <button class="btn btn-primary" id="download"> download pdf</button>
        </div>
        <div class="bg-white py-2" id="invoice">
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
            <div class="row pt-2 px-2">
                <div class="col-12">
                    <h3 class="text-center">Stocks Details</h3>
                </div>
                {{--  --}}
                @if ($selectStocks->isEmpty())
                    <div class="col-12">
                        <h3 class="text-center">Not Data Founded</h3>
                    </div>
                @else
                    <div style="overflow-x:auto;">
                        <table style="width: 100%;">
                            <thead>
                                <tr>
                                    <th class="py-2"
                                        style="text-align:center;border:1px solid black;font-size:12px;">
                                        Item Name
                                    </th>
                                    <th class="py-2"
                                        style="text-align:center;border:1px solid black;font-size:12px;">
                                        Company Name
                                    </th>
                                    <th class="py-2"
                                        style="text-align:center;border:1px solid black;font-size:12px;">
                                        Item Model
                                    </th>
                                    <th class="py-2"
                                        style="text-align:center;border:1px solid black;font-size:12px;">
                                        Serial Number
                                    </th>
                                    <th class="py-2"
                                        style="text-align:center;border:1px solid black;font-size:12px;">
                                        Batch No
                                    </th>
                                    <th class="py-2"
                                        style="text-align:center;border:1px solid black;font-size:12px;">
                                        Exp Date
                                    </th>
                                    <th class="py-2"
                                        style="text-align:center;border:1px solid black;font-size:12px;">
                                        Sizes
                                    </th>
                                    <th class="py-2"
                                        style="text-align:center;border:1px solid black;font-size:12px;">Rate/Unit
                                    </th>
                                    <th class="py-2"
                                        style="text-align:center;border:1px solid black;font-size:12px;">Qtv
                                    </th>
                                    <th class="py-2"
                                        style="text-align:center;border:1px solid black;font-size:12px;">
                                        Total Amount
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($selectStocks as $selectStockss)
                                    @if (!empty($selectStockss->item_batchNo))
                                        {{-- for disposible items --}}
                                        <tr>
                                            <td style="text-align:center;border:1px solid black;">
                                                <p style="font-size:12px;width:120px;">
                                                    {{ $selectStockss->item_name }}
                                                </p>
                                            </td>
                                            <td style="text-align:center;border:1px solid black;">
                                            </td>
                                            <td style="text-align:center;border:1px solid black;">
                                            </td>
                                            <td style="text-align:center;border:1px solid black;">
                                            </td>
                                            <td style="text-align:center;border:1px solid black;">
                                                <p style="font-size:12px;width:120px;">
                                                    {{ $selectStockss->item_batchNo }}
                                                </p>

                                            </td>
                                            <td style="text-align:center;border:1px solid black;">
                                                <p style="font-size:12px;width:120px;">
                                                    {{ \Carbon\Carbon::parse($selectStockss->item_expDate)->format('M d, Y') }}
                                                </p>

                                            </td>
                                            <td style="text-align:center;border:1px solid black;">
                                                <p style="font-size:12px;width:120px;">
                                                    {{ $selectStockss->size }}
                                                </p>

                                            </td>
                                            <td style="text-align:center;border:1px solid black;">
                                                <p style="font-size:12px;width:120px;">
                                                    {{ $selectStockss->ratePerUnit }}
                                                </p>

                                            </td>
                                            <td style="text-align:center;border:1px solid black;">
                                                <p style="font-size:12px;width:120px;">
                                                    {{ $selectStockss->item_qtv }}
                                                </p>

                                            </td>
                                            <td style="text-align:center;border:1px solid black;">
                                                <p style="font-size:12px;width:120px;">
                                                    {{ $selectStockss->totalAmount }}
                                                </p>
                                            </td>
                                        </tr>
                                    @else
                                        @if (!empty($selectStockss->item_model))
                                            {{-- for others items --}}
                                            <tr>
                                                <td style="text-align:center;border:1px solid black;">
                                                    <p style="font-size:12px;width:120px;">
                                                        {{ $selectStockss->item_name }}</p>

                                                </td>
                                                <td style="text-align:center;border:1px solid black;">
                                                    <p style="font-size:12px;width:120px;">
                                                        {{ $selectStockss->item_companyname }}</p>

                                                </td>
                                                <td style="text-align:center;border:1px solid black;">
                                                    <p style="font-size:12px;width:120px;">
                                                        {{ $selectStockss->item_model }}</p>

                                                </td>
                                                <td style="text-align:center;border:1px solid black;">
                                                    <p style="font-size:12px;width:120px;">
                                                        {{ $selectStockss->item_srno }}</p>

                                                </td>
                                                <td
                                                    style="text-align:center;border:1px solid black;font-size:12px;">
                                                </td>
                                                <td
                                                    style="text-align:center;border:1px solid black;font-size:12px;">
                                                </td>
                                                <td
                                                    style="text-align:center;border:1px solid black;font-size:12px;">
                                                </td>
                                                <td style="text-align:center;border:1px solid black;">
                                                    <p style="font-size:12px;width:120px;">
                                                        {{ $selectStockss->ratePerUnit }}</p>

                                                </td>
                                                <td style="text-align:center;border:1px solid black;">
                                                    <p style="font-size:12px;width:120px;">
                                                        {{ $selectStockss->item_qtv }}</p>

                                                </td>
                                                <td style="text-align:center;border:1px solid black;">
                                                    <p style="font-size:12px;width:120px;">
                                                        {{ $selectStockss->totalAmount }}</p>

                                                </td>
                                            </tr>
                                        @elseif (!empty($selectStockss->item_scope_model))
                                            {{-- for scopes --}}
                                            <tr>
                                                <td style="text-align:center;border:1px solid black;">
                                                    <p style="font-size:12px;width:120px;">
                                                        {{ $selectStockss->item_name }}</p>

                                                </td>
                                                <td style="text-align:center;border:1px solid black;">
                                                    <p style="font-size:12px;width:120px;">
                                                        {{ $selectStockss->item_companyname }}</p>

                                                </td>
                                                <td style="text-align:center;border:1px solid black;">
                                                    <p style="font-size:12px;width:120px;">
                                                        {{ $selectStockss->item_scope_model }}</p>

                                                </td>
                                                <td style="text-align:center;border:1px solid black;">
                                                    <p style="font-size:12px;width:120px;">
                                                        {{ $selectStockss->item_srno }}</p>

                                                </td>
                                                <td
                                                    style="text-align:center;border:1px solid black;font-size:12px;">
                                                </td>
                                                <td
                                                    style="text-align:center;border:1px solid black;font-size:12px;">
                                                </td>
                                                <td
                                                    style="text-align:center;border:1px solid black;font-size:12px;">
                                                </td>
                                                <td style="text-align:center;border:1px solid black;">
                                                    <p style="font-size:12px;width:120px;">
                                                        {{ $selectStockss->ratePerUnit }}</p>

                                                </td>
                                                <td style="text-align:center;border:1px solid black;">
                                                    <p style="font-size:12px;width:120px;">
                                                        {{ $selectStockss->item_qtv }}</p>

                                                </td>
                                                <td style="text-align:center;border:1px solid black;">
                                                    <p style="font-size:12px;width:120px;">
                                                        {{ $selectStockss->totalAmount }}</p>

                                                </td>
                                            </tr>
                                        @else
                                            {{-- for repairing Parts --}}
                                            <tr>
                                                <td style="text-align:center;border:1px solid black;">
                                                    <p style="font-size:12px;width:120px;">
                                                        {{ $selectStockss->item_name }}</p>

                                                </td>
                                                <td style="text-align:center;border:1px solid black;">
                                                    <p style="font-size:12px;width:120px;">
                                                        {{ $selectStockss->part_companyname }}</p>

                                                </td>
                                                <td
                                                    style="text-align:center;border:1px solid black;font-size:12px;">
                                                </td>
                                                <td
                                                    style="text-align:center;border:1px solid black;font-size:12px;">
                                                </td>
                                                <td
                                                    style="text-align:center;border:1px solid black;font-size:12px;">
                                                </td>
                                                <td
                                                    style="text-align:center;border:1px solid black;font-size:12px;">
                                                </td>
                                                <td style="text-align:center;border:1px solid black;">
                                                    <p style="font-size:12px;width:120px;">
                                                        {{ $selectStockss->size }}</p>

                                                </td>
                                                <td style="text-align:center;border:1px solid black;">
                                                    <p style="font-size:12px;width:120px;">
                                                        {{ $selectStockss->ratePerUnit }}</p>

                                                </td>
                                                <td style="text-align:center;border:1px solid black;">
                                                    <p style="font-size:12px;width:120px;">
                                                        {{ $selectStockss->item_qtv }}</p>

                                                </td>
                                                <td style="text-align:center;border:1px solid black;">
                                                    <p style="font-size:12px;width:120px;">
                                                        {{ $selectStockss->totalAmount }}</p>

                                                </td>
                                            </tr>
                                        @endif
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{--  --}}
                    @php
                        $totalPrice = 0;
                        $totalQtv = 0;
                        $totalPrice = DB::table('stock_records')->sum('totalAmount');
                        $totalQtv = DB::table('stock_records')->sum('item_qtv');
                    @endphp
                    <div class="col-12 pb-2 pt-3">
                        <h5>Availible Stock Amount : <span>{{ $totalPrice }} /=</span></h5>
                        <h5>Availible Stock Qtv : <span>{{ $totalQtv }}</span></h5>
                    </div>
                @endif
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
    <script>
        window.onload = function () {
    document.getElementById("download").addEventListener("click", () => {
            const invoice = this.document.getElementById("invoice");
            console.log(invoice);
            console.log(window);
            var opt = {
                margin: 1,
                filename: 'myfile.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'in', format: 'A3', orientation: 'landscape' }
            };
            html2pdf().from(invoice).set(opt).save();
    });
}
    </script>
</body>

</html>
