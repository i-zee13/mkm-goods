<?php
require('fpdf.php');
require('db.php');

$data = [];
$parameters = explode(',', $_GET['params']);

$sql = "SELECT id, customer_id, currency_symbol, order_type, (Select company_name from customers where id = oc.customer_id) as customer_name, (Select address from customers where id = oc.customer_id) as customer_address, issue_date, po_num, invoice_num, total_amount, quoted_freight_charges, currency, order_discount, discount_value, eform_num, payment_type, (Select invoice_for from custom_invoices where order_id = oc.id) as invoice_for, (Select marks_no from custom_invoices where order_id = oc.id) as marks_no, (Select invoice_date from custom_invoices where order_id = oc.id) as invoice_date, (Select lc_number from custom_invoices where order_id = oc.id) as lc_number, (Select lc_date from custom_invoices where order_id = oc.id) as lc_date, (Select lc_through from custom_invoices where order_id = oc.id) as lc_through, vessel_name, vessel_number, shipment_route, (Select company_name from shipping_company where id = oc.shipment_company) as shipper_name, (Select invoice_to from custom_invoices where order_id = oc.id) as invoice_to, (Select invoice_address from custom_invoices where order_id = oc.id) as invoice_address, container_types from orders as oc where id = ?";
$stmt = $conn->prepare($sql);
$orderId = $_GET['oid'];
$stmt->bind_param('i', $orderId);
$stmt->execute();
$stmt->bind_result($id, $cust_id, $currency_symbol, $order_type, $customer_name, $customer_address, $issue_date, $po_num, $invoice_num, $total_amount, $quoted_freight_charges, $currency, $order_discount, $discount_value, $eform_num, $payment_type, $invoice_for, $marks_no, $invoice_date, $lc_number, $lc_date, $lc_through, $vessel_name, $vessel_number, $shipment_route, $shipper_name, $invoice_to, $invoice_address, $container_types);
$order_core = [];
while($stmt->fetch()){
    $order_core = [ "id" => $id, "cust_id" => $cust_id, "currency_symbol" => $currency_symbol, "customer_name" => $customer_name, "customer_address" => $customer_address, "issue_date" => $issue_date, "po_num" => $po_num, "invoice_num" => $invoice_num, "total_amount" => $total_amount, 'currency' => $currency, 'order_discount' => $order_discount, 'discount_value' => $discount_value, 'eform_num' => $eform_num, 'payment_type' => $payment_type, 'invoice_for' => $invoice_for, 'marks_no' => $marks_no, 'invoice_date' => $invoice_date, 'lc_number' => $lc_number, 'lc_date' => $lc_date, 'lc_through' => $lc_through, 'vessel_name' => $vessel_name, 'vessel_number' => $vessel_number, 'shipment_route' => $shipment_route, 'shipper_name' => $shipper_name, 'invoice_to' => $invoice_to, 'invoice_address' => $invoice_address, 'container_types' => $container_types, 'order_type' => $order_type, 'quoted_freight_charges' => $quoted_freight_charges];
}
$data = $order_core;
$stmt->close();

// echo "<pre>"; print_r($data);die;

$sql = "SELECT id, qty, item_id, (Select name from brand_related_products where sku = (Select product_sku from product_related_items where id = oc.item_id limit 1)) as product_name, (Select description from product_related_items where id = oc.item_id) as product_description, commercial_unit_price, commercial_amount, net_weight, gross_weight from order_contents as oc where order_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $_GET['oid']);
$stmt->execute();
$stmt->bind_result($id, $qty, $item_id, $product_name, $product_description, $commercial_unit_price, $commercial_amount, $net_weight, $gross_weight);
$order_contents = [];
while($stmt->fetch()){
    $order_contents[] = ["id" => $id, "qty" => $qty, "item_id" => $item_id, "product_name" => $product_name, "product_description" => $product_description, 'commercial_unit_price' => $commercial_unit_price, 'commercial_amount' => $commercial_amount, 'net_weight' => $net_weight, 'gross_weight' => $gross_weight];
}
$data["contents"] = $order_contents;
$stmt->close();


unset($stmt);
$start_shipment_port = '';
$end_shipment_port = '';
if($data['shipment_route']){

    $exploded_array = (explode(",",$data['shipment_route']));

    $start_port = (explode(",",$data['shipment_route'])[0]);

    $end_port= end($exploded_array);

    $sql = "SELECT port_name from delivery_ports where id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $start_port);
    $stmt->execute();
    $stmt->bind_result($port_name);
    $port_content = [];
    while($stmt->fetch()){
        $port_content = $port_name;
    }
    $start_shipment_port = $port_content;
    $stmt->close();

    $sql = "SELECT port_name from delivery_ports where id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $end_port);
    $stmt->execute();
    $stmt->bind_result($port_name);
    $port_content = [];
    while($stmt->fetch()){
        $port_content =  $port_name;
    }
    $end_shipment_port = $port_content;
    $stmt->close();
}



Class dcFpdf extends FPDF{

    
    function Header()
    {
        //global $data;
        $this->SetXY(40, 10);
        $logo = "../images/danpak-logo.jpg";
        $this->SetFont('Arial','B',12);
        $this->Cell( 25, 25, $this->Image($logo, $this->GetX(), $this->GetY(), 50), 0, 0, '', false );

        $this->SetXY(40, 28);
        $this->SetFillColor(255, 255, 255);
        $this->SetFont('Arial','B',10);
        $this->SetTextColor(0,0,0);
        $this->Cell(50, 4, "DANPAK FOOD INDUSTRIES",0,0,'L', 1);

        $this->SetXY(73, 32);
        $this->SetFillColor(255, 255, 255);
        $this->SetFont('Arial','B',9);
        $this->SetTextColor(0,0,0);
        $this->Cell(10, 4, "(PVT) LTD.",0,0,'L', 1);


        $this->SetXY(114, 10);
        $this->SetFillColor(255, 255, 255);
        $this->SetFont('Arial','',8);
        $this->SetTextColor(0,0,0);
        $this->Cell(50, 4, "Head Office:",0,0,'L', 1);

        $this->SetXY(131, 10);
        $this->SetFillColor(255, 255, 255);
        $this->SetFont('Arial','B',8);
        $this->SetTextColor(0,0,0);
        $this->Cell(50, 4, "24-D,Block-1, K.A.E.C.H.S. - 75350 Pakistan.",0,0,'L', 1);



        $this->SetXY(114, 14);
        $this->SetFillColor(255, 255, 255);
        $this->SetFont('Arial','',8);
        $this->SetTextColor(0,0,0);
        $this->Cell(22, 4, "Tel:",0,0,'L', 1);

        $this->SetXY(120, 14);
        $this->SetFillColor(255, 255, 255);
        $this->SetFont('Arial','B',8);
        $this->SetTextColor(0,0,0);
        $this->Cell(50, 4, "92-21-34539572",0,0,'L', 1);

        $this->SetXY(115, 18);
        $this->SetFont('Arial','B',11);
        $this->Line(115, 18, 200, 18);


        $this->SetXY(114, 19);
        $this->SetFillColor(255, 255, 255);
        $this->SetFont('Arial','',8);
        $this->SetTextColor(0,0,0);
        $this->Cell(22, 4, "Unit # 1:",0,0,'L', 1);

        $this->SetXY(125.5, 19);
        $this->SetFillColor(255, 255, 255);
        $this->SetFont('Arial','B',8);
        $this->SetTextColor(0,0,0);
        $this->Cell(50, 4, "E-29, S.I.T.E., Karachi - 75700 Pakistan.",0,0,'L', 1);

        $this->SetXY(114, 23);
        $this->SetFillColor(255, 255, 255);
        $this->SetFont('Arial','',8);
        $this->SetTextColor(0,0,0);
        $this->Cell(22, 4, "Tel:",0,0,'L', 1);

        $this->SetXY(120, 23);
        $this->SetFillColor(255, 255, 255);
        $this->SetFont('Arial','B',8);
        $this->SetTextColor(0,0,0);
        $this->Cell(50, 4, "92-21-32577762, 32578025, 32578026",0,0,'L', 1);

        $this->SetXY(170, 23);
        $this->SetFillColor(255, 255, 255);
        $this->SetFont('Arial','',8);
        $this->SetTextColor(0,0,0);
        $this->Cell(18, 4, "Fax:",0,0,'L', 1);

        $this->SetXY(176.5, 23);
        $this->SetFillColor(255, 255, 255);
        $this->SetFont('Arial','B',8);
        $this->SetTextColor(0,0,0);
        $this->Cell(50, 4, "92-21-32563435",0,0,'L', 1);

        $this->SetXY(115, 27);
        $this->SetFont('Arial','B',11);
        $this->Line(115, 27, 200, 27);

        $this->SetXY(114, 28);
        $this->SetFillColor(255, 255, 255);
        $this->SetFont('Arial','',8);
        $this->SetTextColor(0,0,0);
        $this->Cell(22, 4, "Unit # 2:",0,0,'L', 1);

        $this->SetXY(125.5, 28);
        $this->SetFillColor(255, 255, 255);
        $this->SetFont('Arial','B',8);
        $this->SetTextColor(0,0,0);
        $this->Cell(50, 4, "E-3/A, S.I.T.E., Karachi - 75700 Pakistan.",0,0,'L', 1);

        $this->SetXY(114, 32);
        $this->SetFillColor(255, 255, 255);
        $this->SetFont('Arial','',8);
        $this->SetTextColor(0,0,0);
        $this->Cell(22, 4, "Tel:",0,0,'L', 1);

        $this->SetXY(120, 32);
        $this->SetFillColor(255, 255, 255);
        $this->SetFont('Arial','B',8);
        $this->SetTextColor(0,0,0);
        $this->Cell(50, 4, "92-21-32566693, 32566802",0,0,'L', 1);

        $this->SetXY(114, 36);
        $this->SetFillColor(255, 255, 255);
        $this->SetFont('Arial','',8);
        $this->SetTextColor(0,0,0);
        $this->Cell(22, 4, "Email:",0,0,'L', 1);

        $this->SetXY(123, 36);
        $this->SetFillColor(255, 255, 255);
        $this->SetFont('Arial','B',8);
        $this->SetTextColor(0,0,0);
        $this->Cell(50, 4, "info@danpakfoods.com",0,0,'L', 1);


    }

    function Footer()
    {

        // $this->SetXY(8, -21);
        // $this->SetFont('Arial','B',11);
        // $this->Line(31, 277, 70, 277);

        $this->SetXY(50, -6);
        $this->Cell(120, 5, "Page " . $this->PageNo() . "/{nb}", 0, 0, 'C');
    }
}




$pdf = new dcFpdf();
// // Total width is 210mm
$pdf->AddPage("P", "A4");
$pdf->AliasNbPages();

// Header of table




$pdf->SetDrawColor(0, 0, 0);
$pdf->SetXY(10, 47);
$pdf->SetFont('Arial','B',8);
$pdf->Cell( 40, 4, 'COMMERCIAL INVOICE', 0, 'L');

$pdf->SetXY(10, 51);
$pdf->SetFont('Arial','B',8);
$pdf->Cell( 40, 4, 'NO '.$data['invoice_num'], 0, 'L');

$pdf->SetXY(10, 55);
$pdf->SetFont('Arial','B',8);
$pdf->Cell( 40, 4, 'Invoice for consignment for', 0, 'L');

unset($stmt);
$address = json_decode($data['customer_address'], true);

$pdf->SetXY(10, 65);
$pdf->SetFont('Arial','B',8);
$pdf->Cell( 40, 4, "Consigned to Messers: ", 0, 1);
$pdf->SetFont('Arial','',8);
$pdf->Cell( 40, 4, ($data['invoice_to'] ? $data['invoice_to'] : $data['customer_name']). ' - ' .($data['invoice_address'] ? $data['invoice_address'] : $address[0]['street']), 0, 'L');

$pdf->SetXY(10, 75);
$pdf->SetFont('Arial','B',8);
$pdf->Cell( 40, 4, 'against Purchase Order No/Lc '.($data['lc_number'] ? $data['lc_number'] : $data['po_num'] ), 0, 'L');

$pdf->SetXY(10, 79);
$pdf->SetFont('Arial','',8);
$pdf->Cell( 40, 4, 'FROM '.$start_shipment_port.'/Pakistan'. ' To '.$end_shipment_port, 0, 'L');

$pdf->SetXY(10, 88);
$pdf->SetFont('Arial','B',8);
$pdf->Cell( 40, 4, 'TERMS OF PAYMENT   '.($data['payment_type'] ? $data['payment_type'] : '--').' PMT', 0, 'L');

$pdf->SetXY(10, 92);
$pdf->SetFont('Arial','B',6);
$pdf->Cell( 40, 4, 'Export Form No   '.$data['eform_num'], 0, 'L');



$pdf->SetXY(162, 47);
$pdf->SetFont('Arial','B',8);
$pdf->Cell( 40, 4, 'INVOICE DATE  '.date("d-M-y", strtotime($data['invoice_date'])), 0, 'L');

$pdf->SetXY(162, 51);
$pdf->SetFont('Arial','B',8);
$pdf->Cell( 40, 4, 'B/L NUMB          --', 0, 'L');

$pdf->SetXY(162, 55);
$pdf->SetFont('Arial','B',8);
$pdf->Cell( 40, 4, 'B/L DATE           '.date("d-M-y", strtotime($data['invoice_date'])), 0, 'L');


$pdf->SetXY(130, 75);
$pdf->SetFont('Arial','B',8);
$pdf->Cell( 20, 4, 'Through', 0, 0,'R');

$pdf->SetXY(130, 79);
$pdf->SetFont('Arial','B',8);
$pdf->Cell( 20, 4, 'Shipped Via', 0, 0,'R');

$pdf->SetXY(130, 92);
$pdf->SetFont('Arial','B',6);
$pdf->Cell( 20, 4, 'Dated', 0, 0,'R');


$pdf->SetXY(160, 75);
$pdf->SetFont('Arial','B',8);
$pdf->Cell( 30, 4, ($data['lc_through'] ? $data['lc_through'] : 'NA'), 0, 0,'C');

$pdf->SetXY(160, 79);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell( 30, 4, ($data['shipper_name'] ? $data['shipper_name'] : '--').'/'.($data['vessel_name'] ? $data['vessel_name'] : '--').', '.($data['vessel_number'] ? $data['vessel_number'] : '--'), 0,'C');

$pdf->SetXY(160, 92);
$pdf->SetFont('Arial','B',6);
$pdf->Cell( 30, 4, date("d-M-y", strtotime($data['invoice_date'])), 0, 0,'L');

$pdf->SetXY(85, 51);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell( 40, 4, $data['invoice_for'], 0, 'L');

$pdf->SetXY(83, 75);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell( 40, 4, 'Dated', 0, 'C');

$pdf->SetXY(83, 80);
$pdf->Cell( 40, 4, ($data['lc_number'] ? $data['lc_date'] : $data['invoice_date']), 0, 0, 'C');

$pdf->SetXY(9.85, 100);
$pdf->SetFillColor(255, 255, 255);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(191, 7, "",0,1,'L', 1);


$pdf->SetFont('Arial','B',5.5);

unset($stmt);

if(!in_array('goods', $parameters)){
    if(in_array('marks', $parameters))
        $pdf->Cell((190/sizeof($parameters)), 9, "MARKS & NO.",1,0,'C');

    if(in_array('qty', $parameters))
        $pdf->Cell((190/sizeof($parameters)), 9, "CTN. QTY",1,0,'C');

    if(in_array('price', $parameters))
        $pdf->Cell((190/sizeof($parameters)), 9, "UNIT PRICE/CTN",1,0,'C');

    if(in_array('amount', $parameters))
        $pdf->Cell((190/sizeof($parameters)), 9, "AMOUNT IN ".$data['currency_symbol'],1,0,'C');
}else{

    $ttlWidthCovered = 0;
    if(in_array('marks', $parameters)){
        $ttlWidthCovered += ROUND((10.52/100)*190, 2);
    }
    if(in_array('price', $parameters)){
        $ttlWidthCovered += ROUND((10.52/100)*190, 2);
    }
    if(in_array('amount', $parameters)){
        $ttlWidthCovered += ROUND((10.52/100)*190, 2);
    }
    if(in_array('qty', $parameters)){
        $ttlWidthCovered += ROUND((10.52/100)*190, 2);
    }

    if(in_array('marks', $parameters))
        $pdf->Cell(ROUND((10.52/100)*190, 2), 9, "MARKS & NO.",1,0,'C');

    if(in_array('qty', $parameters))
        $pdf->Cell(ROUND((10.52/100)*190, 2), 9, "CTN. QTY",1,0,'C');

    $pdf->Cell((190 - $ttlWidthCovered), 9, "DESCRIPTION OF GOODS",1,0,'C');

    if(in_array('price', $parameters))
        $pdf->Cell(ROUND((10.52/100)*190, 2), 9, "UNIT PRICE/CTN",1,0,'C');

    if(in_array('amount', $parameters))
        $pdf->Cell(ROUND((10.52/100)*190, 2), 9, "AMOUNT IN ".$data['currency_symbol'],1,0,'C');
}

$yPos = $pdf->GetY();
$pdf->SetFont('Arial','',5.5);
$total_ctn = 0;
 $total_amount = 0;
 $total_net_weight = 0;
 $total_gross_weight = 0;

foreach ($data["contents"] as $key => $item) {
    if($yPos >= 280){
        $pdf->AddPage("P", "A4");
        $yPos = 64;
    }
    $total_amount += $item['commercial_amount'];
    $total_net_weight += $item['net_weight'];
    $total_gross_weight += $item['gross_weight'];
    $total_ctn += $item['qty'];

    if(!in_array('goods', $parameters)){
        $pdf->SetXY(10, $pdf->GetY()+9);
        if(in_array('marks', $parameters))
            $pdf->Cell((190/sizeof($parameters)), 9, $data['marks_no'],0,0,'C');
    
        if(in_array('qty', $parameters))
            $pdf->Cell((190/sizeof($parameters)), 9, $item['qty'],1,0,'C');
    
        if(in_array('price', $parameters))
            $pdf->Cell((190/sizeof($parameters)), 9, $data['currency_symbol'].$item['commercial_unit_price'],1,0,'C');
    
        if(in_array('amount', $parameters))
            $pdf->Cell((190/sizeof($parameters)), 9, $data['currency_symbol'].number_format($item['commercial_amount']),1,0,'C');

    }else{
        $pdf->SetXY(10, $pdf->GetY()+9);
        if(in_array('marks', $parameters))
            $pdf->Cell(ROUND((10.52/100)*190, 2), 9, $key+1,1,0,'C');
    
        if(in_array('qty', $parameters))
            $pdf->Cell(ROUND((10.52/100)*190, 2), 9, $item['qty'],1,0,'C');
    
        $xPos = $pdf->GetX();
        $xPos = $pdf->GetX();
        $yPos = $pdf->GetY();
        $ttlWidthCovered = 0;
        if(in_array('marks', $parameters)){
            $ttlWidthCovered += ROUND((10.52/100)*190, 2);
        }
        if(in_array('price', $parameters)){
            $ttlWidthCovered += ROUND((10.52/100)*190, 2);
        }
        if(in_array('amount', $parameters)){
            $ttlWidthCovered += ROUND((10.52/100)*190, 2);
        }
        if(in_array('qty', $parameters)){
            $ttlWidthCovered += ROUND((10.52/100)*190, 2);
        }
        // $pdf->SetFillColor(0,0,0);

        $pdf->SetXY($xPos, $yPos);

        $pdf->Cell((190 - $ttlWidthCovered), 4, $item['product_name'],'L,T', 0, 'C', 1);
        $pdf->SetXY($xPos, $yPos+4);
        $pdf->Cell((190 - $ttlWidthCovered), 5, $item['product_description'],'B,L',0,'C', 1);

        $pdf->SetXY($xPos+(190 - $ttlWidthCovered), $yPos);
    
        if(in_array('price', $parameters))
            $pdf->Cell(ROUND((10.52/100)*190, 2), 9, $data['currency_symbol'].$item['commercial_unit_price'],1,0,'C');
    
        if(in_array('amount', $parameters))
            $pdf->Cell(ROUND((10.52/100)*190, 2), 9, $data['currency_symbol'].number_format($item['commercial_amount']),1,0,'C');
    }
    
    if($yPos < 280){
        $yPos += 5;
    }
}

// Total Row Start
$containerNumbers = $data['container_types'] ? json_decode($data['container_types'],true) : [];
$totalColumnHeight = (sizeof($containerNumbers)*5)+25;
if(in_array('goods', $parameters)){
    $pdf->SetXY(10, $pdf->GetY()+9);
    if(in_array('marks', $parameters))
        $pdf->Cell(ROUND((10.52/100)*190, 2), $totalColumnHeight, "",1,0,'C');

    if(in_array('qty', $parameters))
        $pdf->Cell(ROUND((10.52/100)*190, 2), $totalColumnHeight, number_format($total_ctn),1,0,'C');

    $xPos = $pdf->GetX();
    $xPos = $pdf->GetX();
    $yPos = $pdf->GetY();
    $ttlWidthCovered = 0;
    if(in_array('marks', $parameters)){
        $ttlWidthCovered += ROUND((10.52/100)*190, 2);
    }
    if(in_array('price', $parameters)){
        $ttlWidthCovered += ROUND((10.52/100)*190, 2);
    }
    if(in_array('amount', $parameters)){
        $ttlWidthCovered += ROUND((10.52/100)*190, 2);
    }
    if(in_array('qty', $parameters)){
        $ttlWidthCovered += ROUND((10.52/100)*190, 2);
    }
    $pdf->SetXY($xPos, $yPos); 
    $pdf->SetFont('Arial','B',8);
    $pdf->SetFillColor(0, 0, 0);
    $pdf->Cell((190 - $ttlWidthCovered), $totalColumnHeight, '','L',0,'C');
    $pdf->SetXY($xPos, $yPos); 
    $pdf->Cell((190 - $ttlWidthCovered), 10, '  TOTAL','L', 1);

    $pdf->SetFontSpacing(5);
    if(sizeof($containerNumbers)){
        foreach($containerNumbers as $key => $value){
            if($yPos >= 280){
                $pdf->AddPage("P", "A4");
                $yPos = 60;
            }
            $pdf->SetX($xPos+10);
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(90, 5, 'CONTAINER # '.$value['number'], 0, 1);
        }
    }
    $pdf->SetX($xPos);
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell((190 - $ttlWidthCovered), 15, '', 'B', 1);
    $pdf->SetFontSpacing(0);
    $pdf->SetFont('Arial','B',6);
    $pdf->SetXY($xPos+(190 - $ttlWidthCovered), $yPos);
    if(in_array('price', $parameters)){
        $pdf->Cell(ROUND((10.52/100)*190, 2), $totalColumnHeight, '',1,0,'C');
        $pdf->SetXY($xPos+(190 - $ttlWidthCovered), $yPos);
        $pdf->Cell(ROUND((10.52/100)*190, 2), 10, 'FOBVALUE','L', 0);
        $pdf->SetXY($xPos+(190 - $ttlWidthCovered), $yPos+5);
        $pdf->Cell(ROUND((10.52/100)*190, 2), 10, 'FREIGHT','L', 0);
    }
    $xPos += ROUND((10.52/100)*190, 2);
    $pdf->SetXY($xPos+(190 - $ttlWidthCovered), $yPos);
    if(in_array('amount', $parameters)){
        $pdf->Cell(ROUND((10.52/100)*190, 2), $totalColumnHeight, '',1,0,'C');
        $pdf->SetXY($xPos+(190 - $ttlWidthCovered), $yPos);
        $pdf->Cell(ROUND((10.52/100)*190, 2), 10, $data['currency_symbol'].number_format($data['total_amount']),'L', 0, 'C');
        $pdf->SetXY($xPos+(190 - $ttlWidthCovered), $yPos+5);
        $pdf->Cell(ROUND((10.52/100)*190, 2), 10, $data['currency_symbol'].number_format($data['quoted_freight_charges']),'L,B', 0, 'C');
        $pdf->SetXY($xPos+(190 - $ttlWidthCovered), $yPos+15);
        $pdf->Cell(ROUND((10.52/100)*190, 2), 10, $data['currency_symbol'].number_format($data['quoted_freight_charges']+$data['total_amount']),'L', 0, 'C');
        $pdf->SetXY($xPos+(190 - $ttlWidthCovered), $yPos+20);
        $pdf->Cell(ROUND((10.52/100)*190, 2), 10, $data['order_type'].' '.strtoupper($end_shipment_port),'L', 0, 'C');
    }
}else{
    $pdf->SetXY(10, $pdf->GetY()+9);
    if(in_array('marks', $parameters))
        $pdf->Cell((190/sizeof($parameters)), $totalColumnHeight, '',1,0,'C');

    if(in_array('qty', $parameters))
        $pdf->Cell((190/sizeof($parameters)), $totalColumnHeight, number_format($total_ctn),1,0,'C');

    $pdf->SetFont('Arial','B',6);
    $pdf->SetXY($xPos+(190 - $ttlWidthCovered), $yPos);
    if(in_array('price', $parameters)){
        $pdf->Cell(ROUND((10.52/100)*190, 2), $totalColumnHeight, '',1,0,'C');
        $pdf->SetXY($xPos+(190 - $ttlWidthCovered), $yPos);
        $pdf->Cell(ROUND((10.52/100)*190, 2), 10, 'FOBVALUE','L', 0);
        $pdf->SetXY($xPos+(190 - $ttlWidthCovered), $yPos+5);
        $pdf->Cell(ROUND((10.52/100)*190, 2), 10, 'FREIGHT','L', 0);
    }

    $xPos += ROUND((10.52/100)*190, 2);
    $pdf->SetXY($xPos+(190 - $ttlWidthCovered), $yPos);
    if(in_array('amount', $parameters)){
        $pdf->Cell(ROUND((10.52/100)*190, 2), $totalColumnHeight, '',1,0,'C');
        $pdf->SetXY($xPos+(190 - $ttlWidthCovered), $yPos);
        $pdf->Cell(ROUND((10.52/100)*190, 2), 10, $data['currency_symbol'].number_format($data['total_amount']),'L', 0, 'C');
        $pdf->SetXY($xPos+(190 - $ttlWidthCovered), $yPos+5);
        $pdf->Cell(ROUND((10.52/100)*190, 2), 10, $data['currency_symbol'].number_format($data['quoted_freight_charges']),'L,B', 0, 'C');
        $pdf->SetXY($xPos+(190 - $ttlWidthCovered), $yPos+15);
        $pdf->Cell(ROUND((10.52/100)*190, 2), 10, $data['currency_symbol'].number_format($data['quoted_freight_charges']+$data['total_amount']),'L', 0, 'C');
        $pdf->SetXY($xPos+(190 - $ttlWidthCovered), $yPos+20);
        $pdf->Cell(ROUND((10.52/100)*190, 2), 10, $data['order_type'].' '.strtoupper($end_shipment_port),'L', 0, 'C');
    }
}
// Total Row End

$yPos = $pdf->GetY()+$totalColumnHeight-30;
$pdf->SetXY(10, $yPos + 20);
$pdf->SetFont('Arial','B',6);
$pdf->Cell(25, 4, "Total Net Weight",0,0, 'C');

$pdf->SetXY(22, $yPos + 20);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(45, 4, number_format($total_net_weight)." Kgs App",0,0, 'C');

$pdf->SetXY(145, $yPos + 20);
$pdf->SetFont('Arial','B',6);
$pdf->Cell(25, 4, "Total Gross Weight",0,0, 'C');

$pdf->SetXY(157, $yPos + 20);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(45, 4, number_format($total_gross_weight)." Kgs App",0,0, 'C');



$pdf->SetXY(150, $yPos + 35);
$pdf->SetFont('Arial','B',6);
$pdf->Cell(50, 4, "For Danpak Food Industries (Pvt) Ltd",0,0, 'R');

$pdf->SetXY(150, $yPos + 40);
$pdf->SetFont('Arial','B',7);
$pdf->Cell(50, 4, "Export Manager",0,0, 'R');



$pdf->SetXY(10, $yPos + 35);
$pdf->SetFont('Arial','B',7);
$pdf->Cell(50, 4, "Certificate that the goods mentioned above are made in Pakistan,",0,0);

$pdf->SetXY(10, $yPos + 38);
$pdf->SetFont('Arial','B',7);
$pdf->Cell(50, 4, "and manufactured by Danpak Food Industries (Pvt) Ltd.",0,0);

$pdf->SetXY(10, $yPos + 43);
$pdf->SetFont('Arial','B',7);
$pdf->Cell(50, 4, "Export Reg W049817.",0,0);



$pdf->Output();
?>
