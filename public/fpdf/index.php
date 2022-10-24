<?php
require('fpdf.php');
require('db.php');
 $data = [];
$sql = "SELECT id, customer_id, (Select company_name from customers where id = oc.customer_id) as customer_name, (Select address from customers where id = oc.customer_id) as customer_address, issue_date, po_num, invoice_num, total_amount, currency, container_types, country_of_origin, mode_of_shipment, expected_delivery_date, order_discount, discount_value from orders as oc where id = ?";
$stmt = $conn->prepare($sql);
$orderId = $_GET['oid'];
$stmt->bind_param('i', $orderId);
$stmt->execute();
$stmt->bind_result($id, $cust_id, $customer_name, $customer_address, $issue_date, $po_num, $invoice_num, $total_amount, $currency, $container_types, $country_of_origin, $mode_of_shipment, $expected_delivery_date, $order_discount, $discount_value);
$order_core = [];
while($stmt->fetch()){
    $order_core = [ "id" => $id, "cust_id" => $cust_id, "customer_name" => $customer_name, "customer_address" => $customer_address, "issue_date" => $issue_date, "po_num" => $po_num, "invoice_num" => $invoice_num, "total_amount" => $total_amount, 'currency' => $currency, 'container_types' => $container_types, 'country_of_origin' => $country_of_origin, 'mode_of_shipment' => $mode_of_shipment, 'expected_delivery_date' => $expected_delivery_date, 'order_discount' => $order_discount, 'discount_value' => $discount_value];
}
$data["order"] = $order_core;
$stmt->close();
//echo "<pre>"; print_r($data['order']); die;
$sql = "SELECT id, qty, item_id, (Select name from brand_related_products where sku = (Select product_sku from product_related_items where id = oc.item_id limit 1)) as product_name, (Select description from product_related_items where id = oc.item_id) as product_description, unit_price, amount from order_contents as oc where order_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $_GET['oid']);
$stmt->execute();
$stmt->bind_result($id, $qty, $item_id, $product_name, $product_description, $unit_price, $amount);
$order_contents = [];
while($stmt->fetch()){
    $order_contents[] = ["id" => $id, "qty" => $qty, "item_id" => $item_id, "product_name" => $product_name, "product_description" => $product_description, 'unit_price' => $unit_price, 'amount' => $amount];
}
$data["contents"] = $order_contents;
$stmt->close();
//echo "<pre>"; print_r($data['order']['customer_name']); die;
Class dcFpdf extends FPDF{
    
    function Header()
    {
        //global $data;
        $this->SetY(5);
        $logo = "../images/danpak-logo.jpg";
        $this->SetFont('Arial','B',12);
        $this->Cell( 20, 20, $this->Image($logo, $this->GetX(), $this->GetY(), 40), 0, 0, 'L', false );
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
$pdf->SetXY(10, 28);
$pdf->SetFillColor(255, 255, 255);
$pdf->SetFont('Arial','B',8);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(190, 4, "PROFORMA INVOICE/SHM/01/18",0,0,'C', 1);
$pdf->SetXY(10, 32);
$pdf->SetFillColor(255, 255, 255);
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(190, 4, "INVOICE FOR                         ".($data['order']['customer_name'] ? $data['order']['customer_name'] : ''),1,0,'L', 1);
$pdf->SetXY(10, 36);
$pdf->SetFillColor(255, 255, 255);
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(190, 4, "CONSIGNED TO MESSRS    --",1,0,'L', 1);
$pdf->SetXY(10, 40);
$pdf->SetFillColor(255, 255, 255);
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(190, 4, "CONTAINER TYPE                ".($data['order']['container_types'] ? $data['order']['container_types'] : 'NA'),1,0,'L', 1);
$pdf->SetXY(10, 44);
$pdf->SetFillColor(255, 255, 255);
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(190, 4, "COUNTRY OF ORIGIN          ".($data['order']['country_of_origin'] ? $data['order']['country_of_origin'] : 'NA'),1,0,'L', 1);
$pdf->SetXY(10, 48);
$pdf->SetFillColor(255, 255, 255);
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(190, 4, "PORT OF LOADING              --",1,0,'L', 1);
$pdf->SetXY(10, 52);
$pdf->SetFillColor(255, 255, 255);
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(190, 4, "PORT OF DISCHARGE         --",1,0,'L', 1);
$pdf->SetXY(115, 32.2);
$pdf->SetFillColor(255, 255, 255);
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(80, 3.5, "PRICE                                    ".($data['order']['total_amount'] ? number_format($data['order']['total_amount']) : 'NA'),0,0,'L', 1);
$pdf->SetXY(115, 36.2);
$pdf->SetFillColor(255, 255, 255);
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(80, 3.5, "FINAL DESTINATION           --",0,0,'L', 1);
$pdf->SetXY(115, 40.2);
$pdf->SetFillColor(255, 255, 255);
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(80, 3.5, "PAYMENT TERMS                --",0,0,'L', 1);
$pdf->SetXY(115, 44.2);
$pdf->SetFillColor(255, 255, 255);
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(80, 3.5, "MODE OF SHIPMENT           ".($data['order']['mode_of_shipment'] ? $data['order']['mode_of_shipment'] : 'NA'),0,0,'L', 1);
$pdf->SetXY(115, 48.2);
$pdf->SetFillColor(255, 255, 255);
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(80, 3.5, "HS CODE                               --",0,0,'L', 1);
//delivery date
$pdf->SetXY(115, 52.2);
$pdf->SetFillColor(255, 255, 255);
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(80, 3.6, "DELIVERY DATE:                 ".($data['order']['expected_delivery_date'] ? date("d-M-y", strtotime($data['order']['expected_delivery_date'])) : ''),0,0,'L', 1);
//DATE
$pdf->SetXY(147, 28);
$pdf->SetFillColor(255, 255, 255);
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(50, 3.6, "DATE: ".date("d-M-y"),0,0,'R', 1);
$pdf->SetXY(9.85, 56);
$pdf->SetFillColor(255, 255, 255);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(191, 7, "",0,0,'L', 1);
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetXY(10, 56);
$pdf->SetFont('Arial','B',9);
$pdf->MultiCell( 20, 4, 'MARKS & NO.', 1, 'C');
// $pdf->Cell(20, 8, "MARKS",1,0,'L');
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetXY(30, 56);
$pdf->SetFont('Arial','B',9);
$pdf->MultiCell(25, 4, "QUANTITY IN CTNS",1,'C');
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetXY(55, 56);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(85, 8, "DESCRIPTION OF GOODS",1,0,'C');
$pdf->SetXY(140, 56);
$pdf->SetFont('Arial','B',9);
$pdf->MultiCell(30, 4, "UNIT PRICE PER CTN",1,'C');
$pdf->SetXY(170, 56);
$pdf->SetFont('Arial','B',9);
$pdf->MultiCell(30, 8, "AMOUNT IN ".$data['order']['currency'],1,'C');
$pdf->SetDrawColor(0);
// Row of table
 $yPos = 64;
// $ttlCtns = 0;
 unset($stmt);
 $total_ctn = 0;
 $total_amount = 0;
// $order_total_price = 0;
foreach ($data["contents"] as $item) {
    
        if($yPos >= 280){
        $pdf->AddPage("P", "A4");
        $yPos = 64;
    }
    $test = $yPos;
    $H = $pdf->GetY();
    $pdf->SetXY(55, ($H == $yPos ? $yPos : $yPos = $H));
    $pdf->SetFont('Arial','',7);
    $pdf->MultiCell(85, 5, $item['product_name']."\n".$item['product_description'],1);
    $H = $pdf->GetY();
    //$yPos = $H;
    $test = $H - $yPos;
    $pdf->SetXY(10, $yPos);
    $pdf->SetFont('Arial','',7);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->MultiCell(20, ($H == $yPos ? $yPos : $H - $yPos), "" ,1,'C');
    
    $pdf->SetXY(30, $yPos);
    $pdf->SetFont('Arial','',7);
    $pdf->MultiCell(25, ($H == $yPos ? $yPos : $H - $yPos), number_format($item['qty']),1,"C");
    $total_ctn += $item['qty'];
    
    
    // $pdf->SetXY(55, ($H == $yPos ? $yPos : $yPos = $H));
    // $pdf->SetFont('Arial','',7);
    // $pdf->MultiCell(85, 5, $item['product_name']."\n".$item['product_description'],1,'C');
    
    //$H = $pdf->GetY();
   
    $pdf->SetXY(140, $yPos);
    $pdf->SetFont('Arial','',7);
    $pdf->MultiCell(30, ($H == $yPos ? $yPos : $H - $yPos), number_format($item['unit_price']),1,'C');
    $pdf->SetXY(170, $yPos);
    $pdf->SetFont('Arial','',7);
    $pdf->MultiCell(30, ($H == $yPos ? $yPos : $H - $yPos), number_format($item['amount']),1,'C');
    $total_amount += $item['amount'];
    if($yPos < 280){
        $yPos += 5;
    }
    
}
$yPos = $pdf->GetY();
$pdf->SetXY(55, $yPos);
$pdf->SetFont('Arial','B',6);
$pdf->MultiCell(85, 4, "ACCOUNT NAME: DANPAK FOOD INDUSTRIES (PVT) LTD \n ACCOUNT NO: 081-6483-01-6 \n BANK NAME: BANK AL HABIB LTD \n IJ CHUNDRIGAR ROAD MACKINNONS BUILDING \n KARACHI, PAKISTAN \n TELEX: 21286, SWIFT: BAHLPKKA \n IBAN: PK15BAHL1001008100648301",0,'C');
$H = $pdf->GetY();
$pdf->SetXY(10, $yPos);
$pdf->SetFont('Arial','B',6);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(20, ($H == $yPos ? $yPos : $H - $yPos), '' ,0,'C');
$pdf->SetXY(30, $yPos);
$pdf->SetFont('Arial','B',7);
$pdf->MultiCell(25, ($H == $yPos ? $yPos : ($H - $yPos) / 2), 'TOTAL CARTONS'."\n".number_format($total_ctn) ,0,"C");
$pdf->SetXY(140, $yPos-5);
$pdf->SetFont('Arial','B',6);
$pdf->MultiCell(30, ($H == $yPos ? $yPos : $H - $yPos),'Discount',0,'C');
$pdf->SetXY(170, $yPos-5);
$pdf->SetFont('Arial','B',7);
$pdf->MultiCell(30, ($H == $yPos ? $yPos : $H - $yPos), $data['order']['order_discount'].'%',0,'C');
$pdf->SetXY(140, $yPos);
$pdf->SetFont('Arial','B',6);
$pdf->MultiCell(30, ($H == $yPos ? $yPos : $H - $yPos),'TOTAL AMOUNT',0,'C');
$pdf->SetXY(170, $yPos);
$pdf->SetFont('Arial','B',7);
$pdf->MultiCell(30, ($H == $yPos ? $yPos : $H - $yPos), $data['order']['currency'].' '.number_format($total_amount - $data['order']['discount_value']),0,'C');
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
