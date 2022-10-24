<?php
require('fpdf.php');
require('db.php');
 $data = [];
 $parameters = explode(',', $_GET['params']);
$sql = "SELECT id, customer_id, currency_symbol, (Select company_name from customers where id = oc.customer_id) as customer_name, (Select address from customers where id = oc.customer_id) as customer_address, issue_date, po_num, invoice_num, total_amount, currency, (Select lc_number from custom_invoices where order_id = oc.id) as lc_number, vessel_name, vessel_number, (Select company_name from shipping_company where id = oc.shipment_company) as shipper_name, (Select lc_date from custom_invoices where order_id = oc.id) as lc_date, (Select invoice_date from custom_invoices where order_id = oc.id) as invoice_date, (Select marks_no from custom_invoices where order_id = oc.id) as marks_no from orders as oc where id = ?";
$stmt = $conn->prepare($sql);
$orderId = $_GET['oid'];
$stmt->bind_param('i', $orderId);
$stmt->execute();
$stmt->bind_result($id, $cust_id, $currency_symbol, $customer_name, $customer_address, $issue_date, $po_num, $invoice_num, $total_amount, $currency, $lc_number, $vessel_name, $vessel_number, $shipper_name, $lc_date, $invoice_date, $marks_no);
$order_core = [];
while($stmt->fetch()){
    $order_core = [ "id" => $id, "cust_id" => $cust_id, "currency_symbol" => $currency_symbol, "customer_name" => $customer_name, "customer_address" => $customer_address, "issue_date" => $issue_date, "po_num" => $po_num, "invoice_num" => $invoice_num, "total_amount" => $total_amount, 'currency' => $currency, 'lc_number' => $lc_number, 'vessel_name' => $vessel_name, 'vessel_number' => $vessel_number, 'shipper_name' => $shipper_name, 'lc_date' => $lc_date, 'invoice_date' => $invoice_date, 'marks_no' => $marks_no];
}
$data = $order_core;
$stmt->close();
$sql = "SELECT id, qty, item_id, from_ctn_no, to_ctn_no, gross_weight, (Select name from brand_related_products where sku = (Select product_sku from product_related_items where id = oc.item_id limit 1)) as product_name, (Select description from product_related_items where id = oc.item_id) as product_description, unit_price, amount, net_weight from order_contents as oc where order_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $_GET['oid']);
$stmt->execute();
$stmt->bind_result($id, $qty, $item_id, $from_ctn_no, $to_ctn_no, $gross_weight, $product_name, $product_description, $unit_price, $amount, $net_weight);
$order_contents = [];
while($stmt->fetch()){
    $order_contents[] = ["id" => $id, "qty" => $qty, "item_id" => $item_id, "from_ctn_no" => $from_ctn_no, "to_ctn_no" => $to_ctn_no, "product_name" => $product_name, "product_description" => $product_description, 'unit_price' => $unit_price, 'amount' => $amount, 'net_weight' => $net_weight, 'gross_weight' => $gross_weight];
}
$data["contents"] = $order_contents;
$stmt->close();
// echo "<pre>"; print_r($data); die;
Class dcFpdf extends FPDF{
    
    function Header()
    {
        //global $data;
        
        $this->Image('../images/letter-bg.jpg', 0, 0, 210, 297);

        $this->AddFont('pb','','Poppins-Bold.php');
        $this->AddFont('pl','','Poppins-Light.php');
        $this->AddFont('rcb','','RobotoCondensed-Bold.php');
        $this->AddFont('rcl','','RobotoCondensed-Light.php');
        $this->AddFont('cal','','calibri.php');
        $this->AddFont('calb','','calibrib.php');

        $this->SetXY(40, 10);
        $logo = "../images/topheader-left.png";
        $this->SetFont('Arial','B',12);
        $this->Cell( 25, 25, $this->Image($logo, $this->GetX(), $this->GetY(), 50), 0, 0, '', false );
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

        $this->SetDrawColor(200, 200, 200);
        $this->Line(0, 283, 150, 283);

        $this->SetFillColor(255, 255, 255);
        $this->SetFont('rcb','',8);
        $this->SetXY(2, 284);
        $this->Cell(10, 3, "DANPAK FOODS (PVT) LIMITED", 0, 0, 'L');

        $this->SetXY(2, 287);
        $this->Cell(12, 3, "Address: ", 0, 0, 'L');

        $this->SetXY(2, 290);
        $this->Cell(12, 3, "Tel: ", 0, 0, 'L');

        $this->SetXY(52, 287);
        $this->Cell(15, 3, " Postal Code: ", 0, 0, 'L');

        $this->SetXY(47, 290);
        $this->Cell(15, 3, " Email: ", 0, 0, 'L');

        $this->SetXY(75.5, 287);
        $this->Cell(10, 3, "Tax ID: ", 0, 0, 'L');

        $this->SetXY(79.5, 290);
        $this->Cell(15, 3, " Web: ", 0, 0, 'L');

        $this->SetFont('rcl','',7);
        $this->SetXY(13, 287);
        $this->Cell(18, 3, "24-D, Block -1 K.A.E.C.H.S., Karachi, PK. | ", 0, 0, 'L');

        $this->SetXY(68, 287);
        $this->Cell(12, 3, "75350 |", 0, 0, 'L');

        $this->SetXY(84.5, 287);
        $this->Cell(12, 3, "0710183-0", 0, 0, 'L');

        $this->SetXY(7, 290);
        $this->Cell(20, 3, "+92 (21) 345 39572, + 92 (21) 345 45253 |", 0, 0, 'L');


        $this->SetDrawColor(0, 18, 255);
        $this->Line(57, 293, 79.5, 293);
        $this->Line(88, 293, 111, 293);

        
        $this->SetTextColor(0, 18, 255);
        $this->SetXY(55.5, 290);
        $this->Cell(20, 3, "info@danpakfoods.com", 0, 0, 'L');
        

        $this->SetXY(87, 290);
        $this->Cell(20, 3, "www.danpakfoods.com", 0, 0, 'L');
        
        $this->SetTextColor(0,0,0);
        $this->SetXY(79, 290);
        $this->Cell(1, 3, "|", 0, 0, 'L');

    }
}
$pdf = new dcFpdf();
// // Total width is 210mm
$pdf->AddPage("P", "A4");
$pdf->AliasNbPages();
// Header of table
$pdf->SetXY(10, 65);
$pdf->SetFont('Arial','B',7);
$pdf->Cell( 40, 4, 'InvoiceNumber   '.($data['invoice_num'] ? $data['invoice_num'] : 'NA'), 0, 'L');
$pdf->SetXY(10, 69);
$pdf->SetFont('Arial','B',7);
$pdf->Cell( 40, 4, 'L/C Number:       '.($data['lc_number'] ? $data['lc_number'] : 'NA'), 0, 'L');
$pdf->SetXY(10, 73);
$pdf->SetFont('Arial','B',7);
$pdf->Cell( 40, 4, 'Dated:                 '.($data['lc_date'] ? date("d-M-y", strtotime($data['lc_date'])) : 'NA'), 0, 'L');
$pdf->SetXY(10, 77);
$pdf->SetFont('Arial','B',7);
$pdf->Cell( 40, 4, 'B/L Number:      --', 0, 'L');
$pdf->SetXY(10, 81);
$pdf->SetFont('Arial','B',7);
$pdf->Cell( 40, 4, 'B/L Date:            '.($data['invoice_date'] ? date("d-M-y", strtotime($data['invoice_date'])) : 'NA'), 0, 'L');
$pdf->SetXY(10, 88);
$pdf->SetFont('Arial','B',8);
$pdf->Cell( 40, 4, 'The goods being shipped / Shipped per', 0, 'L');
$pdf->SetXY(10, 92);
$pdf->SetFont('Arial','B',8);
$pdf->Cell( 40, 4, 'following packing', 0, 'L');
$pdf->SetXY(10, 100);
$pdf->SetFont('Arial','B',8);
$pdf->Cell( 40, 4, 'Marks & No:   '.($data['marks_no'] ? $data['marks_no'] : 'NA'), 0, 'L');
$pdf->SetXY(160, 60);
$pdf->SetFont('Arial','B',8);
$pdf->Cell( 30, 4, 'Date '.($data['invoice_date'] ? date("d-M-y", strtotime($data['invoice_date'])) : 'NA'), 0, 0,'C');
$pdf->SetXY(130, 88);
$pdf->SetFont('Arial','B',8);
$pdf->Cell( 30, 4, ($data['shipper_name'] ? $data['shipper_name'] : '--').'/'.($data['vessel_name'] ? $data['vessel_name'] : '--').', '.($data['vessel_number'] ? $data['vessel_number'] : '--').'              have', 0, 0,'C');
$pdf->SetXY(85, 55);
$pdf->SetFont('Arial','B',10);
$pdf->MultiCell( 40, 4, 'PACKING LIST', 0, 'L');
$pdf->SetXY(85, 59);
$pdf->SetFont('Arial','B',11);
$pdf->Line(86, 59, 111, 59);
$pdf->SetXY(9.85, 108);
$pdf->SetFillColor(255, 255, 255);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(191, 7, "",0,0,'L', 1);
$pdf->SetFont('Arial','B',7);
$pdf->SetX(9.85);
if(!in_array('p-goods', $parameters)){
    if(in_array('ctn_no', $parameters))
        $pdf->Cell((190/sizeof($parameters)), 9, "CARTON NO.",1,0,'C');
    if(in_array('net_weight', $parameters))
        $pdf->Cell((190/sizeof($parameters)), 9, "CARTONS",1,0,'C');
    if(in_array('p-qty', $parameters))
        $pdf->Cell((190/sizeof($parameters)), 9, "NET WEIGHT",1,0,'C');
    if(in_array('gross_weight', $parameters))
        $pdf->Cell((190/sizeof($parameters)), 9, "GR.WEIGHT",1,0,'C');
}else{
    if(in_array('ctn_no', $parameters))
        $pdf->Cell(ROUND((10.52/100)*190, 2), 9, "CARTON NO.",1,0,'C');
    $ttlWidthCovered = 0;
    if(in_array('ctn_no', $parameters)){
        $ttlWidthCovered += ROUND((10.52/100)*190, 2);
    }
    if(in_array('net_weight', $parameters)){
        $ttlWidthCovered += ROUND((10.52/100)*190, 2);
    }
    if(in_array('gross_weight', $parameters)){
        $ttlWidthCovered += ROUND((10.52/100)*190, 2);
    }
    if(in_array('p-qty', $parameters)){
        $ttlWidthCovered += ROUND((10.52/100)*190, 2);
    }
    $pdf->Cell((190 - $ttlWidthCovered), 9, "DESCRIPTION OF GOODS",1,0,'C');
    if(in_array('p-qty', $parameters))
        $pdf->Cell(ROUND((10.52/100)*190, 2), 9, "CARTONS",1,0,'C');
    if(in_array('net_weight', $parameters))
        $pdf->Cell(ROUND((10.52/100)*190, 2), 9, "NET WEIGHT",1,0,'C');
    if(in_array('gross_weight', $parameters))
        $pdf->Cell(ROUND((10.52/100)*190, 2), 9, "GR.WEIGHT",1,0,'C');
}
// $pdf->SetDrawColor(0);
// Row of table
 $yPos = 112;
 unset($stmt);
 $total_ctn = 0;
 $total_amount = 0;
 $total_net_weight = 0;
 $total_gross_weight = 0;
 $pdf->SetFont('Arial','',7);
foreach ($data["contents"] as $key => $item) {
    if($yPos >= 280){
        $pdf->AddPage("P", "A4");
        $yPos = 64;
    }
    $total_ctn += $item['qty'];
    $total_net_weight += $net_weight;
    $total_gross_weight += $item['gross_weight'];
    $total_amount += $item['amount'];
    
    if(!in_array('p-goods', $parameters)){
        $pdf->SetXY(10, $pdf->GetY()+9);
        if(in_array('ctn_no', $parameters))
            $pdf->Cell((190/sizeof($parameters)), 9, $item['from_ctn_no']."-".$item['to_ctn_no'],1,0,'C');
        if(in_array('p-qty', $parameters))
            $pdf->Cell((190/sizeof($parameters)), 9, number_format($item['qty']),1,0,'C');
        if(in_array('net_weight', $parameters))
            $pdf->Cell((190/sizeof($parameters)), 9, number_format($item['net_weight']),1,0,'C');
    
        if(in_array('gross_weight', $parameters))
            $pdf->Cell((190/sizeof($parameters)), 9, number_format($item['gross_weight']),1,0,'C');
        if($key == sizeof($data['contents']) - 1){
            $pdf->SetXY(10, $pdf->GetY()+9);
            $pdf->SetFont('Arial','B',7);
            if(in_array('ctn_no', $parameters))
                $pdf->Cell((190/sizeof($parameters)), 9, 'Total',1,0,'C');
            if(in_array('p-qty', $parameters))
                $pdf->Cell((190/sizeof($parameters)), 9,  number_format($total_ctn)." \n CARTONS",1,0,'C');
            if(in_array('net_weight', $parameters))
                $pdf->Cell((190/sizeof($parameters)), 9,number_format($total_net_weight)." \n KGS",1,0,'C');
            if(in_array('gross_weight', $parameters))
                $pdf->Cell((190/sizeof($parameters)), 9,number_format($total_gross_weight)." \n KGS",1,0,'C');
        }
    }else{
        $pdf->SetXY(9.9, $pdf->GetY()+9);
        if(in_array('ctn_no', $parameters))
            $pdf->Cell(ROUND((10.52/100)*190, 2), 9, $item['from_ctn_no']."-".$item['to_ctn_no'],1,0,'C');
    
        $xPos = $pdf->GetX();
        $xPos = $pdf->GetX();
        $yPos = $pdf->GetY();
        $ttlWidthCovered = 0;
        if(in_array('ctn_no', $parameters)){
            $ttlWidthCovered += ROUND((10.52/100)*190, 2);
        }
        if(in_array('net_weight', $parameters)){
            $ttlWidthCovered += ROUND((10.52/100)*190, 2);
        }
        if(in_array('gross_weight', $parameters)){
            $ttlWidthCovered += ROUND((10.52/100)*190, 2);
        }
        if(in_array('p-qty', $parameters)){
            $ttlWidthCovered += ROUND((10.52/100)*190, 2);
        }
        // $pdf->SetFillColor(0,0,0);
        $pdf->SetXY($xPos, $yPos+1);
        $pdf->Cell((190 - $ttlWidthCovered), 3, $item['product_name'],'L', 0, 'C', 1);
        $pdf->SetXY($xPos, $yPos+4);
        $pdf->Cell((190 - $ttlWidthCovered), 5, $item['product_description'],'B,L',0,'C', 1);
        $pdf->SetXY($xPos+(190 - $ttlWidthCovered), $yPos);
        if(in_array('p-qty', $parameters))
            $pdf->Cell(ROUND((10.52/100)*190, 2), 9, number_format($item['qty']),1,0,'C');
    
        if(in_array('net_weight', $parameters))
            $pdf->Cell(ROUND((10.52/100)*190, 2), 9, number_format($item['net_weight']),1,0,'C');
        if(in_array('gross_weight', $parameters))
            $pdf->Cell(ROUND((10.52/100)*190, 2), 9, number_format($item['gross_weight']),1,0,'C');
        if($key == sizeof($data['contents']) - 1){
            $pdf->SetXY(9.9, $pdf->GetY()+9);
            if(in_array('ctn_no', $parameters))
                $pdf->Cell(ROUND((10.52/100)*190, 2), 9, '',1,0,'C');
        
            $xPos = $pdf->GetX();
            $xPos = $pdf->GetX();
            $yPos = $pdf->GetY();
            $ttlWidthCovered = 0;
            if(in_array('ctn_no', $parameters)){
                $ttlWidthCovered += ROUND((10.52/100)*190, 2);
            }
            if(in_array('net_weight', $parameters)){
                $ttlWidthCovered += ROUND((10.52/100)*190, 2);
            }
            if(in_array('gross_weight', $parameters)){
                $ttlWidthCovered += ROUND((10.52/100)*190, 2);
            }
            if(in_array('p-qty', $parameters)){
                $ttlWidthCovered += ROUND((10.52/100)*190, 2);
            }
            $pdf->SetXY($xPos, $yPos+1);
            $pdf->Cell((190 - $ttlWidthCovered), 3, '','L', 0, 'C', 1);
            $pdf->SetXY($xPos, $yPos+4);
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell((190 - $ttlWidthCovered), 5, 'Total','B,L',0,'C', 1);
            $pdf->SetFont('Arial','B',7);
            $pdf->SetXY($xPos+(190 - $ttlWidthCovered), $yPos);
            if(in_array('p-qty', $parameters))
                $pdf->Cell(ROUND((10.52/100)*190, 2), 9, number_format($total_ctn)." CTNS",1,0,'C');
            if(in_array('net_weight', $parameters))
                $pdf->Cell(ROUND((10.52/100)*190, 2), 9, number_format($total_net_weight)." KGS",1,0,'C');
            if(in_array('gross_weight', $parameters))
                $pdf->Cell(ROUND((10.52/100)*190, 2), 9, number_format($total_gross_weight)." KGS",1,0,'C');    
        }
    }
    
    if($yPos < 280){
        $yPos += 5;
    }
}
$yPos = $pdf->GetY()+9;
$pdf->SetXY(150, $yPos + 35);
$pdf->SetFont('Arial','B',6);
$pdf->Cell(50, 4, "For Danpak Food Industries (Pvt) Ltd",0,0, 'R');
$pdf->SetXY(150, $yPos + 40);
$pdf->SetFont('Arial','B',7);
$pdf->Cell(50, 4, "Export Manager",0,0, 'R');
$pdf->Output();
?>
