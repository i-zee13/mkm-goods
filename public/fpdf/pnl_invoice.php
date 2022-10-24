<?php
require('fpdf.php');
require('db.php');

$month = explode("/",$_GET['orders'])[0];
$year = explode("/",$_GET['orders'])[1];
$data = [];
$sql = "SELECT id, product_id, item_id, qty, (SELECT currency_symbol from orders where id = oc.order_id) as currency, cost, profit_loss, pkr_unit_price, unit_price, (Select name from product_related_items where id = oc.item_id) as item_name, (Select company_name from customers where id = (Select customer_id from orders where id = oc.order_id)) as customer_name, (Select name from brand_related_products where id = oc.product_id) as product_name FROM order_contents as oc WHERE order_id IN (Select id from orders where Month(created_at) = ? AND Year(created_at) = ? AND total_cost IS NOT NULL)";
$stmt = $conn->prepare($sql);

$stmt->bind_param('ii', $month, $year);
$stmt->execute();
$stmt->bind_result($id, $product_id, $item_id, $qty, $currency, $cost, $profit_loss, $pkr_unit_price, $unit_price, $item_name, $customer_name, $product_name);
$order_core = [];
while($stmt->fetch()){
    $order_core[] = [ "id" => $id, "product_id" => $product_id, "item_id" => $item_id, "qty" => $qty, "cost" => $cost, "profit_loss" => $profit_loss, "pkr_unit_price" => $pkr_unit_price, "item_name" => $item_name, "customer_name" => $customer_name, "product_name" => $product_name, "unit_price" => $unit_price, "currency" => $currency];
}
$data["contents"] = $order_core;

$stmt->close();
Class dcFpdf extends FPDF{

    public $month;
    public $year;
    function __construct($month, $year){
        parent::__construct();
        $this->month = $month;
        $this->year = $year;
    }
    function Header()
    {
        global $data;
        $this->SetXY(62, 10);
        $this->SetFont('Arial','B',12);
        $this->MultiCell(85, 5, "PNL Report" , 0, 'C');
        $this->SetXY(79.5, 16);
        $this->SetFont('Arial','',11);
        $this->Cell(50, 5, date('F', mktime(0, 0, 0, $this->month)).", ".date('Y', mktime(0, 0, 0, 1, 1, $this->year)), 0, 0, 'C');
    }
    function Footer()
    {
        $this->SetXY(50, -6);
        $this->SetFont('Arial','',6);
        $this->Cell(120, 5, "Page " . $this->PageNo() . "/{nb}", 0, 0, 'C');
    }
}
$pdf = new dcFpdf($month, $year);
// // Total width is 210mm
$pdf->AddPage("P", "A4");
$pdf->AliasNbPages();
$pdf->SetFillColor(255, 255, 255);
$pdf->SetFont('Arial','B',8);
// Header of table
$pdf->SetXY(10, 30);
$pdf->Cell(28, 5, "CUSTOMER",1,0,'C');
$pdf->Cell(28, 5, "PRODUCT",1,0,'C');
$pdf->Cell(20, 5, "ITEM",1,0,'C');
$pdf->Cell(20, 5, "QTY",1,0,'C');
$pdf->Cell(20, 5, "COST",1,0,'C');
$pdf->Cell(22, 5, "SELL PRICE IN",1,0,'C');
$pdf->Cell(22, 5, "PRICE IN Rs",1,0,'C');
$pdf->Cell(30, 5, "PROFIT/LOSS",1,0,'C');
// Row of table
$yPos = 30;
unset($stmt);
$total_ctn = 0;
$total_amount = 0;
$pdf->SetXY(10, 15);
$pdf->SetFont('Arial','',7);
foreach ($data["contents"] as $item) {
    $pdf->SetXY(10, $yPos+5);
    if($yPos >= 280){
        $pdf->AddPage("P", "A4");
        $yPos = 15;
    }
    $pdf->Cell(28, 5, $item['customer_name'],1,0,'C');
    $pdf->Cell(28, 5, $item['product_name'],1,0,'C');
    $pdf->Cell(20, 5, $item['item_name'],1,0,'C');
    $pdf->Cell(20, 5, $item['qty'],1,0,'C');
    $pdf->Cell(20, 5, "PKR ".number_format($item['cost']),1,0,'C');
    $pdf->Cell(22, 5, $item['currency'].number_format($item['unit_price']),1,0,'C');
    $pdf->Cell(22, 5, "PKR ".number_format($item['pkr_unit_price']),1,0,'C');
    $pdf->Cell(30, 5, "PKR ".number_format($item['profit_loss']),1,0,'C');
    if($yPos < 280){
        $yPos += 5;
    } 
}

$pdf->Output();
?>
