<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title></title>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@300;400;500;600;700&family=Rationale&display=swap" rel="stylesheet">
</head>

<body>
    <style>
        @page {
            width: 100%
        }

        strong {
            font-weight: 600;
        }

        table {
            font-family: 'Barlow', sans-serif;
            font-size: 12px;
        }

        .table th {
            vertical-align: top;
            border: solid 1px #eeeeee;
            text-align: left;
            padding: 4px 5px;
        }

        .table td {
            vertical-align: top;
            border: solid 1px #eeeeee;
            text-align: left;
            padding: 2px 5px;
        }
    </style>

    <table style="width:100%; margin: auto; margin-top: 10px; margin-bottom: 0;" align="center" border="0" cellspacing="0" cellpadding="0">
        <tbody>
            <tr>
                <td style="text-align: center; font-size: 22px;"><strong>ORDER</strong> SHEET</td>
            </tr>
        </tbody>
    </table>

    <table style="width:100%; margin: auto;" align="center" border="0" cellspacing="0" cellpadding="0">
        <tbody>
            <tr>
                <td>
                    <table width="100%" border="0" align="right" cellpadding="0" cellspacing="0">
                        <tbody>
                            <tr>
                                <td style="width: 110px;">PO No:{{ $order->po_num}}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td style="width: 110px;">ORDER DATE:</td>
                                <td><strong class="pl-15">{{date('d-m-Y', strtotime($order->created_at))}}</strong></td>
                            </tr>
                            <tr>
                                <td style="width: 110px;">PARTY</td>
                                <td><strong class="pl-15">{{$order->customer->company_name}}</strong></td>
                            </tr>
                        </tbody>
                    </table>

                </td>
                <td style="width: 460px;"></td>
                <td align="right">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tbody>
                            <tr>
                                <td style="width: 110px;">DATE OF MAKING:</td>
                                <td><strong>{{date('d-m-Y', strtotime($order->created_at))}}</strong></td>
                            </tr>
                            <tr>
                                <td style="width: 110px;">ORDER #</td>
                                <td><strong class="pl-15">{{$order->id}}</strong></td>
                            </tr>
                            <tr>
                                <td style="width: 110px;">BRAND:</td>
                                <td><strong class="pl-15">PRIME HARVEST MAZEDAR</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>

    <table class="table" style="width:100%; margin: auto; margin-top: 10px;" align="center" border="0" cellspacing="0" cellpadding="0">

        <thead style="background-color:#f5f5f5" bgcolor="#f5f5f5">
            <tr>
                <th rowspan="2" style="vertical-align:middle">SKU</th>
                <th rowspan="2" style="vertical-align:middle">PRODUCT</th>
                <th colspan="2" style="text-align:center">ORDER QTY.</th>
                <th rowspan="2" style="vertical-align:middle;width: 62px;">EXPIRY</th>
                <th colspan="2" style="text-align:center">FINISH GOODS STOCK</th>
                <th colspan="2" style="text-align:center">REQUIRED GOODS</th>
                <th colspan="4" style="text-align:center">PACKING MATERIAL STOCK</th>
                <th rowspan="2" style="vertical-align:middle">BATCH</th>
                <th rowspan="2" style="vertical-align:middle">REMARKS</th>
            </tr>
            <tr>
                <th style="text-align:center">CTNS</th>
                <th style="text-align:center">PKT</th>
                <th style="text-align:center">FG STOCK</th>
                <th style="text-align:center;width: 62px;">FG STOCK (EXP)</th>
                <th style="text-align:center">CTN</th>
                <th style="text-align:center">PKT/BOX</th>
                <th style="text-align:center">CTNS STOCK</th>
                <th style="text-align:center">BAG OR BOX STOCK</th>
                <th style="text-align:center">STICKER TRAY STOCK</th>
                <th style="text-align:center">PPB STOCK</th>
            </tr>
        </thead>

        <tbody>
            @forelse($order_sheet_contents as $key=>$content)
                @if(getType($key) == 'string')
                <tr>
                    <td colspan="15" bgcolor="#f5f5f5"><strong>{{$key}}</strong></td>
                </tr>
                @forelse($content as $order_sheet_content)
                <tr>
                    <td>{{$order_sheet_content->item->custom_id}}</td>
                    <td>{{$order_sheet_content->item->description }} {{$order_sheet_content->item->name}}</td>
                    <td>-</td>
                    <td>{{$order_sheet_content->order_qty_boxes}}</td>
                    <td>{{$order_sheet_content->batch_id != 0 ? $order_sheet_content->batch->batch_expiry_date : '----'}}</td>
                    <td>{{$order_sheet_content->finish_goods_stock_boxes}}</td>
                    <td>{{$order_sheet_content->batch_id != 0 ? $order_sheet_content->batch->batch_expiry_date : '----'}}</td>
                    <td>-</td>
                    <td>{{$order_sheet_content->required_stock_boxes}}</td>
                    <td>{{$order_sheet_content->ctns_stock}}</td>
                    <td>{{$order_sheet_content->bag_box}}</td>
                    <td>{{$order_sheet_content->sticker_tray_stock}}</td>
                    <td>{{$order_sheet_content->ppb_stock}}</td>
                    <td>{{$order_sheet_content->batch_id != 0 ? $order_sheet_content->batch->batch_id : '----'}}</td>
                    <td>{{$order_sheet_content->remarks}}</td>
                </tr>
                @empty
                @endforelse
                @endif
                @if(getType($key) =='integer')
                <tr>
                    <td>{{$content->item->custom_id}}</td>
                    <td>{{$content->item->description }} {{$content->item->name}}</td>
                    <td>-</td>
                    <td>{{$content->order_qty_boxes}}</td>
                    <td>{{$content->batch_id != 0 ? $content->batch->batch_expiry_date : '----'}}</td>
                    <td>{{$content->finish_goods_stock_boxes}}</td>
                    <td>{{$content->batch_id != 0 ? $content->batch->batch_expiry_date : '----'}}</td>
                    <td>-</td>
                    <td>{{$content->required_stock_boxes}}</td>
                    <td>{{$content->ctns_stock}}</td>
                    <td>{{$content->bag_box}}</td>
                    <td>{{$content->sticker_tray_stock}}</td>
                    <td>{{$content->ppb_stock}}</td>
                    <td>{{$content->batch_id != 0 ? $content->batch->batch_id : '----'}}</td>
                    <td>{{$content->remarks}}</td>
                </tr>
                @endif
            @empty
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td><strong>TOTAL</strong></td>
                <td style="border:none;border-bottom:solid 1px #eeeeee"></td>
                <td></td>
                <td style="border:none;border-bottom:solid 1px #eeeeee"><strong>{{$order_sheet->total_order_qty_boxes}}</strong></td>
                <td style="border:none;border-bottom:solid 1px #eeeeee"></td>
                <td style="border:none;border-bottom:solid 1px #eeeeee">{{$order_sheet->finish_goods_stock_boxes}}</td>
                <td style="border:none;border-bottom:solid 1px #eeeeee"></td>
                <td style="border:none;border-bottom:solid 1px #eeeeee"></td>
                <td style="border:none;border-bottom:solid 1px #eeeeee">{{$total_required}}</td>
                <td style="border:none;border-bottom:solid 1px #eeeeee"></td>
                <td style="border:none;border-bottom:solid 1px #eeeeee"></td>
                <td style="border:none;border-bottom:solid 1px #eeeeee"></td>
                <td style="border:none;border-bottom:solid 1px #eeeeee"></td>
                <td style="border:none;border-bottom:solid 1px #eeeeee"></td>
                <td style="border:none;border-bottom:solid 1px #eeeeee;border-right:solid 1px #eeeeee"></td>
            </tr>
        </tfoot>




    </table>






</body>

</html>