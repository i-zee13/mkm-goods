<?php
require('fpdf.php');
require('db.php');
$link_data =  $_GET['oid'];

$orderId = explode('/', $link_data)[0];
$batch = explode('/', $link_data)[1];
$data = []; 
$sql = "SELECT id, customer_id, (Select company_name from customers where id = oc.customer_id) as customer_name, (Select address from customers where id = oc.customer_id) as customer_address, issue_date, po_num, invoice_num, total_amount, currency, country_of_origin, (Select invoice_to from custom_invoices where order_id = oc.id) as invoice_to, (Select invoice_to_address from custom_invoices where order_id = oc.id) as invoice_to_address, (Select invoice_date from custom_invoices where order_id = oc.id) as invoice_date, (Select text from certificates_detail where order_id = $orderId AND batch = '$batch' AND type = 'health') as paragraph from orders as oc where id = ?";
$stmt = $conn->prepare($sql);

$stmt->bind_param('i', $orderId);
$stmt->execute();
$stmt->bind_result($id, $cust_id, $customer_name, $customer_address, $issue_date, $po_num, $invoice_num, $total_amount, $currency, $country_of_origin, $invoice_to, $invoice_to_address, $invoice_date, $paragraph);
$order_core = [];
while($stmt->fetch()){
    $order_core = [ "id" => $id, "cust_id" => $cust_id, "customer_name" => $customer_name, "customer_address" => $customer_address, "issue_date" => $issue_date, "po_num" => $po_num, "invoice_num" => $invoice_num, "total_amount" => $total_amount, 'currency' => $currency, 'country_of_origin' => $country_of_origin, 'invoice_to_address' => $invoice_to_address, 'invoice_to' => $invoice_to, 'invoice_date' => $invoice_date, 'paragraph' => $paragraph];
}
$data["order"] = $order_core;
$stmt->close();
//echo "<pre>"; print_r($data['order']); die;
$sql = "SELECT id, qty, item_id, (Select name from brand_related_products where sku = (Select product_sku from product_related_items where id = oc.item_id limit 1)) as product_name, (Select description from product_related_items where id = oc.item_id) as product_description, unit_price, amount, weight_per_ctn from order_contents as oc where order_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $orderId);
$stmt->execute();
$stmt->bind_result($id, $qty, $item_id, $product_name, $product_description, $unit_price, $amount, $weight_per_ctn);
$order_contents = [];
while($stmt->fetch()){
    $order_contents[] = ["id" => $id, "qty" => $qty, "item_id" => $item_id, "product_name" => $product_name, "product_description" => $product_description, 'unit_price' => $unit_price, 'amount' => $amount, 'weight_per_ctn' => $weight_per_ctn];
}
$data["contents"] = $order_contents;
$stmt->close();
//echo "<pre>"; print_r($data['order']['paragraph']); die;
Class dcFpdf extends FPDF{
    
    function Header()
    {
        $this->AddFont('pb','','Poppins-Bold.php');
        $this->AddFont('pl','','Poppins-Light.php');
        $this->AddFont('rcb','','RobotoCondensed-Bold.php');
        $this->AddFont('rcl','','RobotoCondensed-Light.php');
        $this->AddFont('cal','','calibri.php');
        $this->AddFont('calb','','calibrib.php');

        $this->Image('../images/letter-bg.jpg', 0, 0, 210, 297);
        //global $data;
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
$pdf->SetXY(62, 55);
$pdf->SetFont('Arial','B',11);
$pdf->MultiCell(85, 4, "MANUFACTURER'S HEALTH CERTIFICATE" , 0, 'C');
$pdf->SetXY(85, 59);
$pdf->SetFont('Arial','B',11);
$pdf->Line(64, 59, 145, 59);
$pdf->SetXY(62, 60);
$pdf->SetFont('Arial','B',10);
$pdf->MultiCell(85, 4, "B/L NO.NA DTD:".date("d-M-y", strtotime($data['order']['invoice_date'])) , 0, 'C');
$pdf->SetXY(85, 64);
$pdf->SetFont('Arial','B',11);
$pdf->Line(75, 64, 134, 64);
$pdf->SetXY(15, 80);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(45, 4, "IMPORTER:" , 0, 'L');
$pdf->SetXY(60, 80);
$pdf->SetFont('Arial','B',9);
$pdf->MultiCell(100, 4, ($data['order']['invoice_to'] ? $data['order']['invoice_to']."\n".$data['order']['invoice_to_address'] : 'NA') , 0, 'L');
$pdf->SetXY(15, 100);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(45, 4, "ITEM:" , 0, 'L');
$pdf->SetXY(60, 100);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(45, 4, "CONFECTIONERY ITEMS" , 0, 'L');
$pdf->SetXY(15, 107);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(45, 4, "COUNTRY OF ORIGIN:" , 0, 'L');
$pdf->SetXY(60, 107);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(45, 4, $data['order']['country_of_origin'] , 0, 'L');
$pdf->SetXY(15, 114);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(45, 4, "QUANTITY:" , 0, 'L');
unset($stmt);
$total_ctn = 0;
foreach ($data["contents"] as $item) {
    $total_ctn += $item['qty'];
}
$pdf->SetXY(60, 114);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(45, 4, $total_ctn." CARTONS" , 0, 'L');
$pdf->SetXY(15, 130);
$pdf->SetFont('Arial','B',12);
$pdf->MultiCell(180, 5, $data['order']['paragraph'] , 0, 'L');
// $pdf->SetXY(15, 145);
// $pdf->SetFont('Arial','B',12);
// $pdf->MultiCell(180, 5, "FURTHER, INGREDIENTS, PERMISSIBLE FOOD COLOURS AND FLAVOURS EMPLOYED AS ABOVE DO NOT CONTAIN ANY ADDITIVES, WHICH MIGHT BE HARMFUL TO THE HUMAN HEALTH." , 0, 'L');



$pdf->SetXY(100,$pdf->GetY()+10);
$pdf->SetFont('Arial','B',10);
$pdf->MultiCell(80, 5, "FOR DANPAK FOOD INDUSTRIES (PVT) LTD." , 0, 'C');
$pdf->SetXY(100, $pdf->GetY()+10);
$pdf->SetFont('Arial','B',10);
$pdf->MultiCell(80, 5, "(QUALITY CONTROL DEPARTMENT)" , 0, 'C');
$pdf->Output();
?>
