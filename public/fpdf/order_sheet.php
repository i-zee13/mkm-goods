<?php
require('fpdf.php');
require('db.php');
$data = [];
$sql = "SELECT id, customer_id, (Select company_name from customers where id = oc.customer_id) as customer_name, (Select address from customers where id = oc.customer_id) as customer_address, issue_date, po_num, invoice_num, total_amount, currency, (Select country from customers where id = oc.customer_id) as cust_country, (Select city from customers where id = oc.customer_id) as cust_city, (Select first_name from customers where id = oc.customer_id) as poc_name, order_discount, discount_value from orders as oc where id = ?";
$stmt = $conn->prepare($sql);
$orderId = $_GET['oid'];
$stmt->bind_param('i', $orderId);
$stmt->execute();
$stmt->bind_result($id, $cust_id, $customer_name, $customer_address, $issue_date, $po_num, $invoice_num, $total_amount, $currency, $cust_country, $cust_city, $poc_name, $order_discount, $discount_value);
$order_core = [];
while($stmt->fetch()){
    $order_core = [ "id" => $id, "cust_id" => $cust_id, "customer_name" => $customer_name, "customer_address" => $customer_address, "issue_date" => $issue_date, "po_num" => $po_num, "invoice_num" => $invoice_num, "total_amount" => $total_amount, 'currency' => $currency, 'cust_country' => $cust_country, 'cust_city' => $cust_city, 'poc_name' => $poc_name, 'order_discount' => $order_discount, 'discount_value' => $discount_value];
}
$data["order"] = $order_core;
$stmt->close();
$batch = isset($_GET['batch']) ? $_GET['batch'] : null;
$whereQuery = $batch ? " and item_id IN (SELECT item_id FROM `supplier_product_assignment` where batch = '$batch')" : "";
$qtyQuery = $batch ? "(SELECT CONCAT(item_quantity, '--!!!--', remarks) from supplier_product_assignment where item_id = oc.item_id and batch = '$batch')" : "qty";
$descQuery = $batch ? "(SELECT special_note from supplier_product_assignment where batch = '$batch' and item_id = oc.item_id) as product_desc" : "product_desc";
$sql = "SELECT id, $qtyQuery, item_id, (Select name from brand_related_products where sku = (Select product_sku from product_related_items where id = oc.item_id ) order by id limit 1) as product_name, (Select description from product_related_items where id = oc.item_id) as product_description, $descQuery, amount, (SELECT name from product_related_items where id = oc.item_id) as product from order_contents as oc where order_id = ? $whereQuery";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $_GET['oid']);
$stmt->execute();
$stmt->bind_result($id, $qty, $item_id, $product_name, $product_description, $product_desc, $amount, $product);
$order_contents = [];
while($stmt->fetch()){
    $order_contents[] = ["id" => $id, "qty" => $qty, "item_id" => $item_id, "product_name" => $product_name, "product_description" => $product, 'product_desc' => $product_desc, 'amount' => $amount];
}
$data["contents"] = $order_contents;
$stmt->close();
Class dcFpdf extends FPDF{
    
    function Header()
    {
        global $data;
        $this->SetXY(85, 10);
        $this->SetFillColor(255, 255, 255);
        $this->SetFont('Arial','B',12);
        $this->SetTextColor(0,0,0);
        $this->Cell(10, 4, "ORDER SHEET",0,0,'L', 1);
       
        $this->SetXY(10, 20);
        $this->SetFont('Arial','',10);
        $this->Cell(10, 4, "Order No.",0,0,'L', 1);
        $this->SetXY(80, 20);
        $this->Cell(10, 4, "Order Sheet ID: ".$data['order']['id'],0,0,'L', 1);
        $this->SetXY(160, 20);
        $this->Cell(10, 4, "Order Date   ".$data['order']['issue_date'],0,0,'L', 1);
    }
    function Footer()
    {
        $this->SetXY(50, -6);
        $this->SetFont('Arial','',6);
        $this->Cell(120, 5, "Page " . $this->PageNo() . "/{nb}", 0, 0, 'C');
    }
}
$pdf = new dcFpdf();
// // Total width is 210mm
$pdf->AddPage("P", "A4");
$pdf->AliasNbPages();
$pdf->SetXY(10, 29);
$pdf->SetFillColor(255, 255, 255);
$pdf->SetFont('Arial','B',8);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(190, 12, "",0,0,'R', 1);
$pdf->SetXY(10, 31);
$pdf->Cell(10, 4, "Order of: ",0,0,'L', 1);
$pdf->SetXY(10, 35);
$pdf->Cell(10, 4, "Order Country: ",0,0,'L', 1);
$pdf->SetXY(100, 31);
$pdf->Cell(10, 4, $data['order']['customer_name'],0,0,'L', 1);
$pdf->SetXY(100, 35);
$pdf->Cell(10, 4, $data['order']['cust_country'],0,0,'L', 1);
$pdf->SetFont('Arial','B',7);
// Header of table
$pdf->SetXY(10, 47);
$pdf->Cell(25, 4, "QUANTITY IN",'L,R,T',0,'C', 1);
$pdf->SetXY(10, 51);
$pdf->Cell(25, 4, "CTNS ",'L,R,B',0,'C', 1);
$pdf->SetXY(35, 47);
$pdf->Cell(90, 8, "DESCRIPTION OF GOODS ",1,0,'C', 1);
$pdf->SetXY(125, 47);
$pdf->Cell(75, 8, "SPECIAL NOTE ",1,0,'L', 1);
// Row of table
$yPos = 55;
unset($stmt);
$total_ctn = 0;
$total_amount = 0;
foreach ($data["contents"] as $item) {
    
    if($yPos >= 280){
        $pdf->AddPage("P", "A4");
        $yPos = 55;
    }
    $H = $pdf->GetY();
    $pdf->SetXY(35, $yPos);
    $pdf->SetFont('Arial','',8);
    $pdf->MultiCell(90, 4, $item['product_name']."\n".$item['product_description'],1, 'L');
    $H = $pdf->GetY();
    $pdf->SetXY(10, $yPos);
    $pdf->MultiCell(25, 8, ($batch ? number_format(explode("--!!!--", $item['qty'])[0]) : number_format($item['qty']) ),1,"C");
    $total_ctn += ($batch ? explode("--!!!--", $item['qty'])[0] : $item['qty']);
    
    $pdf->SetXY(125, $yPos);
    $pdf->MultiCell(75, 8, $item['product_desc'],1,'L');
    if($yPos < 280){
        $yPos += 8;
    } 
}
$yPos = $pdf->GetY();
$pdf->SetXY(10, $yPos);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(25, 8, $total_ctn,1,0,"C");
$pdf->SetXY(35, $yPos);
$pdf->Cell(90, 8, "",1,0,"C");
$pdf->SetXY(125, $yPos);
$pdf->Cell(75, 8, "",1,0,"C");
$pdf->SetLineWidth(1);
$pdf->Line(10.4, $yPos+8.5, 199.7, $yPos+8.5);
if($batch){
    $pdf->SetXY(10, $yPos + 20);
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(25, 6, 'Remarks',0,0,"L");
    $pdf->SetXY(10, $yPos + 25);
    $pdf->SetFont('Arial','',7);
    $pdf->MultiCell(190, 6, explode("--!!!--", $item['qty'])[1],0);
}
$pdf->Output();
?>
