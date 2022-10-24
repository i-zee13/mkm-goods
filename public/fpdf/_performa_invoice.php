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

//echo "<pre>"; print_r($data);die;

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


Class dcFpdf extends FPDF{

    
    function Header()
    {
        //global $data;
        $this->Image('../images/letter-bg.jpg', 0, 0, 210, 297);

        $this->SetXY(40, 10);
        $logo = "../images/topheader-left.png";
        $this->SetFont('Arial','B',12);
        $this->Cell( 25, 25, $this->Image($logo, $this->GetX(), $this->GetY(), 50), 0, 0, '', false );


        
        $this->SetFont('Arial','B',8);
        $this->SetTextColor(0,0,0);
        $this->SetFillColor(255, 255, 255);

        $this->SetXY(108, 29);
        $this->Cell(22, 4, "DATE",0,0,'L', 1);

        $this->SetXY(108, 33);
        $this->Cell(22, 4, "P.O.:",0,0,'L', 1);

        $this->SetFont('Arial','',8);
        $this->SetXY(122, 29);
        $this->Cell(22, 4, "03-DEC-2019",0,0,'L', 1);
        $this->SetXY(122, 33);
        $this->Cell(22, 4, "CS351-p",0,0,'L', 1);
       
        $this->Line(147, 29, 147, 37);

        $this->SetFont('Arial','B',8);
        $this->SetXY(150, 29);
        $this->Cell(22, 4, "Invoice#",0,0,'L', 1);
        $this->SetXY(150, 33);
        $this->Cell(22, 4, "Customer ID:",0,0,'L', 1);

        $this->SetFont('Arial','',8);
        $this->SetXY(175, 29);
        $this->Cell(22, 4, "03-DEC-2019",0,0,'L', 1);
        $this->SetXY(175, 33);
        $this->Cell(22, 4, "CS351-p",0,0,'L', 1);

        $this->SetFont('Arial','B',7);
        $this->SetXY(183, 23);
        $this->Cell(22, 4, "Page " . $this->PageNo() . "/{nb}", 0, 0, 'C');


        $this->SetFont('Arial','B',18);
        $this->SetXY(160, 10);
        $this->Cell(22, 4, "PROFORMA",0,0,'L', 1);

        $this->SetFont('Arial','',10);
        $this->SetXY(182, 16);
        $this->Cell(22, 4, "INOVICE",0,0,'L', 1);

        $this->Line(187, 20, 197, 20);

        $this->SetFont('Arial','B',9);
        $this->SetXY(20, 50);
        $this->Cell(10, 4, "INOVICE ",0,0,'L', 1);

        $this->SetXY(121, 50);
        $this->Cell(10, 4, "SHIPPING ",0,0,'L', 1);

        $this->SetFont('Arial','',9);
        $this->SetXY(34, 50);
        $this->Cell(10, 4, "FOR:",0,0,'L', 1);

        $this->SetXY(137, 50);
        $this->Cell(10, 4, "DETAILs:",0,0,'L', 1);

        $this->Line(21, 54, 42.5, 54);
        $this->Line(122.5, 54, 151.5, 54);

        $this->SetFont('Arial','B',8);
        $this->SetXY(20, 56);
        $this->Cell(10, 4, "POC: ",0,0,'L', 1);

        $this->SetFont('Arial','',8);
        $this->SetXY(28, 56);
        $this->Cell(10, 4, "Mr. POC Name",0,0,'L', 1);


        $this->SetFont('Arial','B',7);
        $this->SetXY(20, 60);
        $this->Cell(10, 4, "Company: ",0,0,'L', 1);

        $this->SetXY(20, 64);
        $this->Cell(10, 4, "Address: ",0,0,'L', 1);

        $this->SetXY(20, 72);
        $this->Cell(10, 4, "TEL# ",0,0,'L', 1);

        $this->SetXY(120, 56);
        $this->Cell(10, 4, "Expected Delivery Date: ",0,0,'L', 1);

        $this->SetXY(120, 60);
        $this->Cell(10, 4, "Mode of Shipment: ",0,0,'L', 1);

        $this->SetXY(120, 64);
        $this->Cell(10, 4, "Container Type: ",0,0,'L', 1);

        $this->SetXY(120, 68);
        $this->Cell(10, 4, "Ship Via: ",0,0,'L', 1);

        $this->SetXY(120, 72);
        $this->Cell(10, 4, "Freight Type: ",0,0,'L', 1);


        $this->SetFont('Arial','',7);
        $this->SetXY(33, 60);
        $this->Cell(10, 4, "Complete Company Name ",0,0,'L', 1);

        $this->SetXY(32, 64);
        $this->MultiCell(80, 4, "Complete Company Name And Address Goes Here Street Address AND City",0,'L', 1);

        $this->SetXY(28, 72);
        $this->MultiCell(80, 4, "+923135034540, 123456789",0,'L', 1);

        $this->SetXY(149, 56);
        $this->Cell(10, 4, "22-02-2020",0,0,'L', 1);

        $this->SetXY(143, 60);
        $this->Cell(10, 4, "Sea",0,0,'L', 1);

        $this->SetXY(140, 64);
        $this->Cell(10, 4, "HTCGshs",0,0,'L', 1);

        $this->SetXY(132, 68);
        $this->Cell(10, 4, "Marakesh",0,0,'L', 1);

        $this->SetXY(137, 72);
        $this->Cell(10, 4, "FOB",0,0,'L', 1);

    }

    function Footer()
    {
        $this->SetDrawColor(200, 200, 200);
        $this->Line(0, 283, 150, 283);

        $this->SetFillColor(255, 255, 255);
        $this->SetFont('Arial','B',7);
        $this->SetXY(2, 284);
        $this->Cell(10, 3, "DANPAK FOODS (PVT) LIMITED", 0, 0, 'L');

        $this->SetXY(2, 287);
        $this->Cell(12, 3, "Address: ", 0, 0, 'L');

        $this->SetXY(2, 290);
        $this->Cell(12, 3, "Tel: ", 0, 0, 'L');

        $this->SetXY(60, 287);
        $this->Cell(15, 3, " Postal Code: ", 0, 0, 'L');

        $this->SetXY(53.5, 290);
        $this->Cell(15, 3, " Email: ", 0, 0, 'L');

        $this->SetXY(84, 287);
        $this->Cell(10, 3, "Tax ID: ", 0, 0, 'L');

        $this->SetXY(89, 290);
        $this->Cell(15, 3, " Web: ", 0, 0, 'L');

        $this->SetFont('Arial','',7);
        $this->SetXY(13, 287);
        $this->Cell(18, 3, "24-D, Block -1 K.A.E.C.H.S., Karachi, PK. | ", 0, 0, 'L');

        $this->SetXY(75.5, 287);
        $this->Cell(12, 3, "75350 |", 0, 0, 'L');

        $this->SetXY(93, 287);
        $this->Cell(12, 3, "0710183-0", 0, 0, 'L');

        $this->SetXY(7, 290);
        $this->Cell(20, 3, "+92 (21) 345 39572, + 92 (21) 345 45253 |", 0, 0, 'L');


        $this->SetDrawColor(0, 18, 255);
        $this->Line(63, 293, 89, 293);
        $this->Line(97, 293, 123, 293);

        
        $this->SetTextColor(0, 18, 255);
        $this->SetXY(62, 290);
        $this->Cell(20, 3, "info@danpakfoods.com", 0, 0, 'L');
        

        $this->SetXY(96, 290);
        $this->Cell(20, 3, "www.danpakfoods.com", 0, 0, 'L');
        
        $this->SetTextColor(0,0,0);
        $this->SetXY(88.5, 290);
        $this->Cell(1, 3, "|", 0, 0, 'L');

    }
}

 
$pdf = new dcFpdf();


// // Total width is 210mm
$pdf->AddPage("P", "A4");
$pdf->AliasNbPages(); 

// Header of table


$pdf->SetFont('Arial','B',6.5);
$pdf->SetDrawColor(200, 200, 200);
$pdf->setFillColor(240, 240, 240);

unset($stmt);

$pdf->SetXY(10, 80); 

$pdf->Cell(7, 5, "SN.",1,0,'C', 1);

$pdf->Cell(105, 5, "GOODS & DESCRIPTION",1,0,'L', 1);

$pdf->Cell(25, 5, "QUANTITY",1,0,'C', 1);

$pdf->Cell(25, 5, "UNIT PRICE",1,0,'C', 1);

$pdf->Cell(25, 5, "TOTAL",1,0,'C', 1);


$pdf->setFillColor(255, 255, 255);


foreach ($data["contents"] as $key => $item) {
    if($yPos >= 260){
        $pdf->AddPage("P", "A4");
        $yPos = 50;
    }


    if($key == 0){
        $yPos = $pdf->GetY(); 
    }else{
        $yPos = $pdf->GetY() - 5; 
    }
    
    
    
    $pdf->SetFont('Arial','',7);
    $pdf->SetXY(17, $yPos+5); 
    $pdf->MultiCell(105, 5, "GOODS & DESCRIPTION \n Wafer Cookie filled with assorted flavour cream Galleta Tipe Wafer Releine de Cream sabores surtidos Carton with 8 display with 40 pieces 18 g each one Caja can 8 displays con 40 piezas de 18g cada une \n".($_GET['params'] != '0' ? 'Product Details: CBM: 0.0574 , Total CBM: 24.108 , GW/Unit: 1910 GMs, GW/Carton: 1533 KGs' : ''),1,'L', 1);

    

    $coloumn = $pdf->GetY();

    $test = $_GET['params']; 
    if($_GET['params'] != '0'){
        $pdf->Line(17, $coloumn-10, 122, $coloumn-10);
    }

      
    $pdf->SetFont('Arial','B',7);
    $pdf->SetXY(10, $yPos+5); 
    $pdf->MultiCell(7, ($coloumn - $yPos) - 5, "SN.",1,'C', 1);

    $pdf->SetXY(122, $yPos+5); 
    $pdf->SetFont('Arial','',6);
    $pdf->MultiCell(25, ($coloumn - $yPos) - 5, "QUANTITY",1,'C', 1);

    $pdf->SetXY(147, $yPos+5); 
    $pdf->MultiCell(25, ($coloumn - $yPos) - 5, "UNIT PRICE",1,'C', 1);

    $pdf->SetXY(172, $yPos+5); 
    $pdf->MultiCell(25, ($coloumn - $yPos) - 5, "TOTAL",1,'C', 1);
    
    if($yPos < 260){
        $yPos += 5;
    }
}

$pdf->Output();
?>
