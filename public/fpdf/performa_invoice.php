<?php
require('fpdf.php');
require('db.php');

$data = [];
$parameters = explode(',', $_GET['params']);

$sql = "SELECT id, customer_id, currency_symbol, order_type, (Select company_name from customers where id = oc.customer_id) as customer_name, (Select address from customers where id = oc.customer_id) as customer_address, issue_date, po_num, invoice_num, total_amount, IFNULL(quoted_freight_charges, 0), currency, order_discount, discount_value, eform_num, payment_type, (Select invoice_for from custom_invoices where order_id = oc.id) as invoice_for, (Select marks_no from custom_invoices where order_id = oc.id) as marks_no, (Select invoice_date from custom_invoices where order_id = oc.id) as invoice_date, (Select lc_number from custom_invoices where order_id = oc.id) as lc_number, (Select lc_date from custom_invoices where order_id = oc.id) as lc_date, (Select lc_through from custom_invoices where order_id = oc.id) as lc_through, vessel_name, vessel_number, shipment_route, (Select company_name from shipping_company where id = oc.shipment_company) as shipper_name, (Select invoice_to from custom_invoices where order_id = oc.id) as invoice_to, (Select invoice_address from custom_invoices where order_id = oc.id) as invoice_address, container_types, (Select first_name from company_poc_list where customer_id = oc.customer_id order by id desc limit 1) as poc_first_name, (Select COALESCE(business_phone, mobile_phone, whatsapp_phone) from customers where id = oc.customer_id) as customer_phone, customer_custom_id, expected_delivery_date, mode_of_shipment, Date(created_at) as order_date, country_of_origin, (Select port_name from delivery_ports where id = oc.port_of_loading) as port_of_loading, (Select port_name from delivery_ports where id = oc.port_of_discharge) as port_of_discharge, notes, terms, IFNULL(insurance_charges, 0), (Select company_name from shipping_company where id = oc.shipment_company) as shipping_compnay, (Select Group_concat(port_name) from delivery_ports where id IN (oc.shipment_route)) as delivery_routes, advance from orders as oc where id = ?";
$stmt = $conn->prepare($sql);
$orderId = $_GET['oid'];
$stmt->bind_param('i', $orderId);
$stmt->execute();
$stmt->bind_result($id, $cust_id, $currency_symbol, $order_type, $customer_name, $customer_address, $issue_date, $po_num, $invoice_num, $total_amount, $quoted_freight_charges, $currency, $order_discount, $discount_value, $eform_num, $payment_type, $invoice_for, $marks_no, $invoice_date, $lc_number, $lc_date, $lc_through, $vessel_name, $vessel_number, $shipment_route, $shipper_name, $invoice_to, $invoice_address, $container_types, $poc_first_name, $customer_phone, $customer_custom_id, $expected_delivery_date, $mode_of_shipment, $order_date, $country_of_origin, $port_of_loading, $port_of_discharge, $notes, $terms, $insurance_charges, $shipping_compnay, $delivery_routes, $advance);
$order_core = [];

while($stmt->fetch()){
    $order_core = [ "id" => $id, "cust_id" => $cust_id, "currency_symbol" => $currency_symbol, "customer_name" => $customer_name, "customer_address" => $customer_address, "issue_date" => $issue_date, "po_num" => $po_num, "invoice_num" => $invoice_num, "total_amount" => $total_amount, 'currency' => $currency, 'order_discount' => $order_discount, 'discount_value' => $discount_value, 'eform_num' => $eform_num, 'payment_type' => $payment_type, 'invoice_for' => $invoice_for, 'marks_no' => $marks_no, 'invoice_date' => $invoice_date, 'lc_number' => $lc_number, 'lc_date' => $lc_date, 'lc_through' => $lc_through, 'vessel_name' => $vessel_name, 'vessel_number' => $vessel_number, 'shipment_route' => $shipment_route, 'shipper_name' => $shipper_name, 'invoice_to' => $invoice_to, 'invoice_address' => $invoice_address, 'container_types' => $container_types, 'order_type' => $order_type, 'quoted_freight_charges' => $quoted_freight_charges, 'poc_first_name' => $poc_first_name, 'customer_phone' => $customer_phone, 'customer_custom_id' => $customer_custom_id, 'expected_delivery_date' => $expected_delivery_date, 'mode_of_shipment' => $mode_of_shipment, 'order_date' => $order_date, 'country_of_origin' => $country_of_origin, 'port_of_loading' => $port_of_loading, 'port_of_discharge' => $port_of_discharge, 'notes' => $notes, 'terms' => $terms, 'insurance_charges' => $insurance_charges, 'shipping_compnay' => $shipping_compnay, 'delivery_routes' => $delivery_routes, 'advance' => $advance];
}
$data = $order_core;
$stmt->close();

//echo "<pre>"; print_r($data['order_type']);die;

$sql = "SELECT id, qty, item_id, product_desc, unit_price, amount, (Select name from brand_related_products where sku = (Select product_sku from product_related_items where id = oc.item_id limit 1)) as product_name, (Select description from product_related_items where id = oc.item_id) as product_description, commercial_unit_price, commercial_amount, net_weight, gross_weight from order_contents as oc where order_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $_GET['oid']);
$stmt->execute();
$stmt->bind_result($id, $qty, $item_id, $product_desc, $unit_price, $amount, $product_name, $product_description, $commercial_unit_price, $commercial_amount, $net_weight, $gross_weight);
$order_contents = [];
while($stmt->fetch()){
    $order_contents[] = ["id" => $id, "qty" => $qty, "product_desc" => $product_desc, "unit_price" => $unit_price, "amount" => $amount, "item_id" => $item_id, "product_name" => $product_name, "product_description" => $product_description, 'commercial_unit_price' => $commercial_unit_price, 'commercial_amount' => $commercial_amount, 'net_weight' => $net_weight, 'gross_weight' => $gross_weight];
}
$data["contents"] = $order_contents;
$stmt->close();


unset($stmt);
$customer_address = json_decode($data['customer_address'], true);

$test = $customer_address[0]['street'];


Class dcFpdf extends FPDF{

    
    function Header()
    {
        global $data;
        global $customer_address;
        $this->Image('../images/letter-bg.jpg', 0, 0, 210, 297);

        $this->AddFont('pb','','Poppins-Bold.php');
        $this->AddFont('pl','','Poppins-Light.php');
        $this->AddFont('rcb','','RobotoCondensed-Bold.php');
        $this->AddFont('rcl','','RobotoCondensed-Light.php');
        $this->AddFont('cal','','calibri.php');
        $this->AddFont('calb','','calibrib.php');

        $this->SetXY(40, 10);
        $logo = "../images/topheader-left.png";
        $this->SetFont('rcb','',12);
        $this->Cell( 25, 25, $this->Image($logo, $this->GetX(), $this->GetY(), 50), 0, 0, '', false );
        
        $this->SetFont('rcb','',8);
        $this->SetTextColor(0,0,0);
        $this->SetFillColor(255, 255, 255);

        $this->SetXY(108, 29);
        $this->SetFont('calb','',8);
        $this->Cell(22, 4, "DATE",0,0,'L', 1);

        $this->SetXY(108, 33);
        $this->Cell(22, 4, "P.O.:",0,0,'L', 1);

        $this->SetFont('cal','',8);
        $this->SetXY(122, 29);
        $this->Cell(22, 4, $data['order_date'],0,0,'L', 1);
        $this->SetXY(122, 33);
        $this->Cell(22, 4, $data['po_num'],0,0,'L', 1);
       
        $this->Line(147, 29, 147, 37);
 
        $this->SetFont('calb','',8);
        $this->SetXY(150, 29);
        $this->Cell(22, 4, "Invoice#",0,0,'L', 1);
        $this->SetXY(150, 33);
        $this->Cell(22, 4, "Customer ID:",0,0,'L', 1);

        $this->SetFont('cal','',8);
        $this->SetXY(175, 29);
        $this->Cell(22, 4, $data['eform_num'] ? $data['eform_num'] : $data['invoice_num'],0,0,'L', 1);
        $this->SetXY(175, 33);
        $this->Cell(22, 4, $data['customer_custom_id'] ? $data['customer_custom_id'] : 'NA' ,0,0,'L', 1);

        $this->SetFont('Arial','B',7);
        $this->SetXY(183, 23);
        $this->Cell(22, 4, "Page " . $this->PageNo() . "/{nb}", 0, 0, 'C');

        $this->SetFont('pb','',18);
        $this->SetXY(162.5, 10);
        $this->Cell(22, 4, "PROFORMA",0,0,'L', 1);

        $this->SetFont('pl','',12);
        $this->SetXY(182, 16);
        $this->Cell(22, 4, "INOVICE",0,0,'L', 1);

        $this->Line(187, 20, 197, 20);

        $this->SetFont('rcb','',10);
        $this->SetXY(20, 45);
        $this->Cell(10, 4, "INOVICE ",0,0,'L', 1);

        $this->SetXY(119.5, 45);
        $this->Cell(10, 4, "SHIPPING ",0,0,'L', 1);

        $this->SetFont('rcl','',10);
        $this->SetXY(33, 45);
        $this->Cell(10, 4, "FOR:",0,0,'L', 1);

        $this->SetXY(134.5, 45);
        $this->Cell(10, 4, "DETAILs:",0,0,'L', 1);

        $this->Line(21, 49, 41, 49);
        $this->Line(121, 49, 148, 49);

        $this->SetFont('Arial','B',8);
        $this->SetXY(20, 51);
        $this->Cell(10, 4, "POC: ",0,0,'L', 1);

        $this->SetFont('Arial','',8);
        $this->SetXY(28, 51);
        $this->Cell(10, 4, $data['poc_first_name'],0,0,'L', 1);


        $this->SetFont('Arial','B',7);
        $this->SetXY(20, 55);
        $this->Cell(10, 4, "Company: ",0,0,'L', 1);

        $this->SetXY(20, 59);
        $this->Cell(10, 4, "Address: ",0,0,'L', 1);

        $this->SetXY(20, 67);
        $this->Cell(10, 4, "TEL# ",0,0,'L', 1);

        $this->SetXY(120, 51);
        $this->Cell(10, 4, "Expected Delivery Date: ",0,0,'L', 1);

        $this->SetXY(120, 55);
        $this->Cell(10, 4, "Mode of Shipment: ",0,0,'L', 1);

        $this->SetXY(120, 59);
        $this->Cell(10, 4, "Container Type: ",0,0,'L', 1);

        $this->SetXY(120, 63);
        $this->Cell(10, 4, "Ship Via: ",0,0,'L', 1);

        $this->SetXY(120, 67);
        $this->Cell(10, 4, "Freight Type: ",0,0,'L', 1);


        $this->SetFont('Arial','',7);
        $this->SetXY(33, 55);
        $this->Cell(10, 4, $data['customer_name'],0,0,'L', 1);

        $this->SetXY(32, 59);
        $this->MultiCell(80, 4, $customer_address[0]['street'],0,'L', 1);

        $this->SetXY(28, 67);
        $this->MultiCell(80, 4, $data['customer_phone'],0,'L', 1);

        $this->SetXY(149, 51);
        $this->Cell(10, 4, $data['expected_delivery_date'],0,0,'L', 1);

        $this->SetXY(143, 55);
        $this->Cell(10, 4, $data['mode_of_shipment'] ? $data['mode_of_shipment'] : 'NA',0,0,'L', 1);

        $this->SetXY(140, 59);
        $this->Cell(10, 4, "NA",0,0,'L', 1);

        $this->SetXY(132, 63);
        $this->Cell(10, 4, $data['shipping_compnay'],0,0,'L', 1);

        $this->SetXY(137, 67);
        $this->Cell(10, 4, $data['order_type'],0,0,'L', 1);

        $this->SetFont('rcb','',10);
        $this->SetDrawColor(200, 200, 200);
        $this->setFillColor(240, 240, 240);

        $this->SetXY(10, 75); 

        $this->Cell(10, 5, "SN.",1,0,'C', 1);

        $this->Cell(102, 5, "GOODS & DESCRIPTION",1,0,'L', 1);

        $this->Cell(25, 5, "QUANTITY",1,0,'C', 1);

        $this->Cell(25, 5, "UNIT PRICE",1,0,'C', 1);

        $this->Cell(25, 5, "TOTAL",1,0,'C', 1);

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


unset($stmt);


$pdf->SetDrawColor(191, 191, 191); 

$pdf->setFillColor(255, 255, 255);
$yPos = $pdf->GetY(); 
$new_page_heading = 0;

foreach ($data["contents"] as $key => $item) {
    if($yPos >= 220){
        $new_page_heading = 0;
        $pdf->AddPage("P", "A4");
        $yPos = 80;
    }

    $test = $pdf->GetY();
    if($new_page_heading == 0){
        $yPos = $pdf->GetY(); 
    }else{
        $yPos = $pdf->GetY() - 5; 
    }
    
    $new_page_heading ++;
    
    $pdf->SetFont('rcb','',11);
    $pdf->SetXY(20, $yPos+5); 
    $pdf->MultiCell(102, 5, $item['product_name'],0,'L', 1);

    $pdf->SetFont('cal','',9);
    $pdf->SetXY(20, $yPos+10); 
    $pdf->SetFontSpacing(0.00001);
    $pdf->MultiCell(102, 5, $item['product_desc']."\n".($_GET['params'] != '0' ? 'Product Details: CBM: 0.0574 , Total CBM: 24.108 , GW/Unit: 1910 GMs, GW/Carton: 1533 KGs' : ''),'R,L,B','L', 1);

    $coloumn = $pdf->GetY();

    $test = $_GET['params']; 
    if($_GET['params'] != '0'){
        $pdf->Line(17, $coloumn-10, 122, $coloumn-10);
    }

      
    $pdf->SetFont('rcb','',9);
    $pdf->SetXY(10, $yPos+5); 
    $pdf->MultiCell(10, ($coloumn - $yPos) - 5, $key+1,1,'C',1);

    $pdf->SetXY(122, $yPos+5); 
    $pdf->SetFont('rcl','',9);
    $pdf->MultiCell(25, ($coloumn - $yPos) - 5, $item["qty"].' CTNs',1,'C');

    $pdf->SetXY(147, $yPos+5); 
    $pdf->MultiCell(25, ($coloumn - $yPos) - 5, $order_core['currency_symbol'].' '.number_format($item["unit_price"]),1,'C');

    $pdf->SetXY(172, $yPos+5); 
    $pdf->MultiCell(25, ($coloumn - $yPos) - 5, $order_core['currency_symbol'].' '.number_format($item["amount"]),1,'C');
    
    if($yPos < 220){
        $yPos += 5;
    }
}


$yPos = $pdf->GetY(); 

$pdf->SetDrawColor(200, 200, 200);
$pdf->setFillColor(255, 255, 255);

$pdf->SetXY(10, $yPos); 

$pdf->SetFont('rcb','',9);
$pdf->Cell(10, 5, "NOTEs.",0,0,'R', 1);

$pdf->MultiCell(102, 5, "TERMs:",0,'R', 1);

$pdf->SetFont('cal','',9);
$pdf->SetXY(9, $yPos+5); 
$pdf->MultiCell(30, 5, $data['notes'],0,'L', 1);

$pdf->SetXY(63, $yPos+5); 
$pdf->MultiCell(60, 5, $data['terms'],0,'R', 1);

$pdf->SetXY(122, $yPos); 
$pdf->Cell(25, 5, '',0,0,'C', 1);
$pdf->Cell(25, 5, "SUBTOTAL",'',0,'L', 1);
$pdf->Cell(25, 5, $data['currency_symbol'] .' ' .number_format($data['total_amount']),1,0,'L', 1);

$pdf->SetXY(122, $yPos+5); 
$pdf->Cell(25, 5, '',0,0,'C', 1);
$pdf->Cell(25, 5, "FREIGHT",'',0,'L', 1);
$pdf->Cell(25, 5, $data['currency_symbol'] .' ' .number_format($data['quoted_freight_charges']) ,1,0,'L', 1);

$pdf->SetXY(122, $yPos+10); 
$pdf->Cell(25, 5, '',0,0,'C', 1);
$pdf->Cell(25, 5, "INSURANCE",'',0,'L', 1);
$pdf->Cell(25, 5, $data['currency_symbol'] .' ' .number_format($data['insurance_charges']) ,1,0,'L', 1);

$pdf->SetXY(122, $yPos+15); 
$pdf->Cell(25, 5, '',0,0,'C', 1);
$pdf->Cell(25, 5, "ADVANCE",'',0,'L', 1);
$pdf->Cell(25, 5, $data['currency_symbol'] .' ' .number_format($data['advance']) ,1,0,'L', 1);

$pdf->SetXY(122, $yPos+20); 
$pdf->Cell(25, 5, '',0,0,'C', 1);
$pdf->Cell(25, 5, "DISCOUNT",'B',0,'L', 1);
$pdf->Cell(25, 5, $data['currency_symbol'] .' ' .number_format($data['discount_value']) ,1,0,'L', 1);

$total = (($data['total_amount'] + $data['quoted_freight_charges'] + $data['insurance_charges']) - $data['advance']) - $data['discount_value'];
$pdf->SetXY(122, $yPos+25); 
$pdf->SetFont('Arial','B',9);
$pdf->Cell(25, 5, '',0,0,'C', 1);
$pdf->Cell(25, 5, "TOTAL",'B',0,'L', 1);
$pdf->SetFont('Arial','B',7);
$pdf->Cell(25, 5, $data['currency_symbol'] .' ' .number_format($total),1,0,'L', 1);

$yPos = $pdf->GetY(); 

$pdf->SetDrawColor(200, 200, 200);
$pdf->setFillColor(240, 240, 240);
$pdf->SetXY(10, $yPos+5); 
$pdf->SetFont('rcb','',10);
$pdf->Cell(85, 6, 'ADDITIONAL DETAILS',0,0,'L', 1);



$pdf->setFillColor(255, 255, 255);
$pdf->SetFont('rcb','',9);
$pdf->SetXY(10, $yPos+12); 
$pdf->Cell(20, 4, 'Country Of Origin: ',0,0,'L', 1);

$pdf->SetXY(10, $yPos+16); 
$pdf->Cell(40, 4, 'Port of Loading: ',0,0,'L', 1);

$pdf->SetXY(10, $yPos+20); 
$pdf->Cell(40, 4, 'Discharge Port: ',0,0,'L', 1);

$pdf->SetXY(10, $yPos+24); 
$pdf->Cell(40, 4, 'Delivery Route: ',0,0,'L', 1);

$pdf->SetXY(10, $yPos+28); 
$pdf->Cell(40, 4, 'Payment Terms: ',0,0,'L', 1);

$pdf->SetXY(130, $yPos+15);
$pdf->Cell( 60, 60, $pdf->Image('../images/signature.PNG', $pdf->GetX(), $pdf->GetY(), 50), 0, 0, '', false );

$pdf->SetFont('cal','',9);
$pdf->SetXY(34, $yPos+12); 
$pdf->Cell(40, 4, $data['country_of_origin'],0,0,'L', 1);

$pdf->SetXY(31, $yPos+16); 
$pdf->Cell(40, 4, $data['port_of_loading'],0,0,'L', 1);

$pdf->SetXY(30.5, $yPos+20); 
$pdf->Cell(40, 4, $data['port_of_discharge'],0,0,'L', 1);

$pdf->SetXY(30.5, $yPos+24); 
$pdf->Cell(40, 4, $data['delivery_routes'],0,0,'L', 1);

$pdf->SetXY(31.5, $yPos+28); 
$pdf->Cell(40, 4, 'NA',0,0,'L', 1);



$yPos = $pdf->GetY(); 
$pdf->Line(120, $yPos+30, 188, $yPos+30);

$pdf->SetXY(135, $yPos+33); 
$pdf->SetFont('Arial','B',11);
$pdf->Cell(40, 4, 'Export Manager',0,0,'C', 1);





$pdf->Output();
?>
