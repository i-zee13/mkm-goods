
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title></title>

    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;600&display=swap" rel="stylesheet">
</head>

<body>
    <style>
        @page {
            width: auto;
			margin: 0;
        }

        strong {
            font-weight: 600;
        }

        .table {
            padding-top: 15px;
        }

        .table td,
        .table th {
            border: solid 1px #d2d2d2;
            font-size: 13px;
            text-align: left;
        }

    </style>
    <table style="font-size: 13px;font-family: 'Barlow', sans-serif; width:28cm;margin:auto" border="0" align="center"
        cellpadding="0" cellspacing="0">
        <tbody>
            <tr>
                <td>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding-top:20px">
                        <tbody>
                            <tr> 
                                <td width="60%">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0"
                                        style="font-size: 15px;">
                                        <tbody>
                                            <tr>
                                                <td valign="top" style="font-size: 22px; padding-bottom:5px"><strong>CBM
                                                    </strong> CALCULATION</td>
                                            </tr>
                                            <tr>
                                                <td valign="top" style="letter-spacing:2px; padding-bottom:5px;">
                                                    <strong><u>PROFORMA</u></strong> FOR:</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Client:</strong> {{ $performa->customer->company_name }} |
                                                    <strong>Country:</strong> {{ $performa->customer->country }} </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>

                                <td width="40%">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tbody>
                                            <tr>
                                                <td><strong>DATE:</strong></td>
                                                <td>{{date('d-M-Y')}}</td>
                                                <td style="border-left:solid 1px #d2d2d2; padding-left: 20px">
                                                    <strong>INVOICE #</strong></td>
                                                <td> {{ $performa->invoice_num ? $performa->invoice_num : 'not found' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>P.O.:</strong></td>
                                                <td> {{ $performa->po_num }} </td>
                                                <td style="border-left:solid 1px #d2d2d2; padding-left: 20px">
                                                    <strong>Customer ID:</strong></td>
                                                <td> {{ $performa->customer_id }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>

            <tr>
                <td>
                    <table class="table" width="100%" border="0" cellspacing="0" cellpadding="2">
                        <thead style="background-color:#f2f2f2" bgcolor="#f2f2f2">

                            <tr>
                                <th rowspan="2">S No.</th>
                                <th rowspan="2">Product</th>
                                <th rowspan="2" >Packing</th>
                                <th colspan="6" style="text-align:center">Carton Size</th>
                                <th colspan="2" style="text-align:center">Order Quantity</th>
                                <th colspan="2" style="text-align:center">Weight</th>
                            </tr>
                            <tr>
                                <th>L”</th>
                                <th>W” </th>
                                <th>H”</th>
                                <th>CU MT</th>
                                <th>T. CU</th>
                                <th>PKT WT</th>
                                <th>CTNs</th>
                                <th>PKTs</th>
                                <th>Net WT</th>
                                <th>Gross WT</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($performaItems as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item->product_name ? $item->product_name : 0 }}</td>
                                    <td>{{ $item->packaging ? $item->packaging : 0 }}</td>
                                    <td>{{ $item->lenght ? number_format($test, 2, '.', ',') : 0 }}</td>
                                    <td>{{ $item->width ? number_format($item->width, 2, '.', ',') : 0 }}</td>
                                    <td>{{ $item->height ? number_format($item->height, 2, '.', ',') : 0 }}</td>
                                    <td>{{ $item->cu_mt ? number_format($item->cu_mt, 2, '.', ',') : 0 }}</td>
                                    <td>{{ $item->t_cu ? number_format($item->t_cu, 2, '.', ',') : 0 }}</td>
                                    <td>{{ $item->pkt_wt ? number_format($item->pkt_wt, 2, '.', ',') : 0 }}</td>
                                    <td>{{ $item->total_ctn ? number_format($item->total_ctn, 2, '.', ',') : 0 }}</td>
                                    <td>{{ $item->pkts ? number_format($item->pkts, 2, '.', ',') : 0 }}</td>
                                    <td>{{ $item->net_weight ? number_format($item->net_weight, 2, '.', ',') : 0 }}</td>
                                    <td>{{ $item->gross_weight ? number_format($item->gross_weight, 2, '.', ',') : 0 }}
                                    </td>

                                </tr>
                            @endforeach
                            <tr style="background-color:#f2f2f2" bgcolor="#f2f2f2">
                                <td colspan="9" align="center" style="text-align:center"><strong>Total</strong></td>
                                <td><strong>{{ number_format($total_ctns, 2, '.', ',') }}</strong></td>
                                <td><strong>{{ number_format($total_pkts, 2, '.', ',') }}</strong></td>
                                <td><strong>{{ number_format($total_net_weight, 2, '.', ',') }}</strong></td>
                                <td><strong>{{ number_format($total_gross_weight, 2, '.', ',') }}</strong></td>
                            </tr>
                        </tbody>

                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table class="table" width="100%" border="0" cellspacing="0" cellpadding="2">
                        <tbody>
							
                            <tr>
                                <td style="border: none"><span style="border-bottom:solid 1px #d2d2d2; width: 100%; display: block"></span></td>
                                <td width="50px" style="border: none; text-align: right"><strong>01/02</strong></td>
                            </tr>
                        </tbody>
                    </table>

                </td>
            </tr>

        </tbody>
    </table>




</body>

</html>
