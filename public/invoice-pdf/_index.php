<?php
require('fpdf.php');

$servername = "localhost";
$username = "junaid";
$password = "Snakebite76253";
$dbname = "import_export";

if($_SERVER['SERVER_NAME'] == "import-export.development"){
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "import_export";
}

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$data = [];

$sql = "SELECT id, (SELECT name from users where id = orders.employee_id) as name, po_num, total_amount, issue_date, invoice_num, currency, notes, terms, (SELECT company_name from customers where id = orders.customer_id) as company, (SELECT CONCAT(first_name, ' ', IFNULL(last_name, '')) from customers where id = orders.customer_id) as poc, (SELECT country from customers where id = orders.customer_id) as country, (SELECT email from customers where id = orders.customer_id) as email from orders where id = ?";
$stmt = $conn->prepare($sql);
$performaId = $_GET['performa'];
$stmt->bind_param('i', $performaId);
$stmt->execute();
$stmt->bind_result($id, $name, $po_num, $total_amount, $issue_date, $invoice_num, $currency, $notes, $terms, $company, $poc, $country, $email);
$order = [];
while($stmt->fetch()){
    $order = [ "id" => $id, "name" => $name, "po_num" => $po_num, "total_amount" => $total_amount, "issue_date" => $issue_date, "invoice_num" => $invoice_num, "currency" => $currency, "terms" => $terms, "notes" => $notes, "company" => $company, "poc" => $poc, "country" => $country, "email" => $email ];
}
$data["order"] = $order;
$stmt->close();

$sql = "SELECT qty, product_desc, (SELECT description from product_related_items where id = order_contents.item_id) as item_description, weight_per_unit, weight_per_ctn, cbm, total_cbm, unit_price, amount, (SELECT name from product_related_items where id = order_contents.item_id) as product, (SELECT unit_quantity from product_related_items where id = order_contents.item_id) as unit_quantity, (SELECT unit_name from item_units where id = (SELECT unit_id from product_related_items where id = order_contents.item_id)) as unit_name, (SELECT variant_name from item_variants where id = (SELECT variant_id from product_related_items where id = order_contents.item_id)) as variant_name, (SELECT unit_variant_quantity from product_related_items where id = order_contents.item_id) as unit_variant_quantity from order_contents where order_id = ?";
$stmt = $conn->prepare($sql);
$performaId = $_GET['performa'];
$stmt->bind_param('i', $performaId);
$stmt->execute();
$stmt->bind_result($qty, $product_desc, $item_description, $weight_per_unit, $weight_per_ctn, $cbm, $total_cbm, $unit_price, $amount, $product, $unit_quantity, $unit_name, $variant_name, $unit_variant_quantity);
$contents = [];
while($stmt->fetch()){
    $contents[] = [ "qty" => $qty, "product_desc" => $product_desc, "item_description" => $item_description, "weight_per_unit" => $weight_per_unit, "weight_per_ctn" => $weight_per_ctn, "cbm" => $cbm, "total_cbm" => $total_cbm, "amount" => $amount, "unit_price" => $unit_price, "product" => $product, "variant_name" => $variant_name, "unit_name" => $unit_name, "unit_quantity" => $unit_quantity, "unit_variant_quantity" => $unit_variant_quantity ];
}
$data["contents"] = $contents;
$stmt->close();

$pdf = new FPDF();
// Total width is 210mm
$pdf->AddPage("P", "A4");

$pdf->SetXY(0, 0);
$pdf->SetFillColor(0, 56, 186);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(250, 0.7, "",0,0,'L', 1);

$pdf->SetY(15);
$logo = "../images/danpak-logo.jpg";
$pdf->SetFont('Arial','B',12);
$pdf->Cell( 40, 40, $pdf->Image($logo, $pdf->GetX(), $pdf->GetY(), 80), 0, 0, 'L', false );

$pdf->SetX(110);
$pdf->SetFont('Arial','',9);
$pdf->MultiCell(90, 5, "Head Office: 24-D,Block-1, K.A.E.C.H.S. - 75350 Pakistan. Tel: 92-21-34539572",0,'L');

$pdf->SetX(110);
$pdf->SetFont('Arial','',9);
$pdf->MultiCell(90, 5, "Unit # 1: E-29, S.I.T.E., Karachi - 75700 Pakistan. Tel: 92-21-32577762, 32578025, 32578026 Fax: 92-21-32563435",0,'L');

$pdf->SetX(110);
$pdf->SetFont('Arial','',9);
$pdf->MultiCell(90, 5, "Unit # 2: E-3/A, S.I.T.E., Karachi - 75700 Pakistan. Tel: 92-21-32566693, 32566802 Email: info@danpakfoods.com",0,'L');

$pdf->SetXY(7, 67);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(135, 135, 135);
$pdf->Cell(50, 5, "Order Date",0,0);

$pdf->SetXY(7, 73);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0);
$pdf->Cell(50, 5, $data["order"]["issue_date"],0,0);

$pdf->SetXY(42, 67);
$pdf->SetFont('Arial','',11);
$pdf->SetTextColor(135, 135, 135);
$pdf->Cell(50, 5, "PO NO.",0,0);

$pdf->SetXY(42, 73);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0);
$pdf->Cell(50, 5, ($data["order"]["po_num"] ? $data["order"]["po_num"] : "NA"),0,0);

$pdf->SetXY(74, 67);
$pdf->SetFont('Arial','',11);
$pdf->SetTextColor(135, 135, 135);
$pdf->Cell(50, 5, "Invoice NO.",0,0);

$pdf->SetXY(74, 73);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0);
$pdf->Cell(50, 5, $data["order"]["invoice_num"],0,0);

$pdf->SetXY(112, 67);
$pdf->SetFont('Arial','',11);
$pdf->SetTextColor(135, 135, 135);
$pdf->Cell(50, 5, "Created By",0,0);

$pdf->SetXY(112, 73);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0);
$pdf->Cell(50, 5, $data["order"]["name"],0,0);

$pdf->SetXY(160, 67);
$pdf->SetFont('Arial','',11);
$pdf->SetTextColor(135, 135, 135);
$pdf->Cell(50, 5, "Order Amount",0,0);

$pdf->SetXY(160, 73);
$pdf->SetFont('Arial','B',11);
$pdf->SetTextColor(0);
$pdf->Cell(50, 5, $data["order"]["currency"].'.'.number_format($data["order"]["total_amount"]),0,0);

$pdf->SetDrawColor(191);
$pdf->Rect(5, 82.5, 200, 15, ['DF']);

$pdf->SetXY(7, 85);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(50, 5, "Client Name:",0,0);

$pdf->SetXY(42, 85);
$pdf->SetFont('Arial','',10);
$pdf->Cell(50, 5, $data["order"]["company"],0,0);

$pdf->SetXY(125, 85);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(50, 5, "POC:",0,0);

$pdf->SetXY(140, 85);
$pdf->SetFont('Arial','',10);
$pdf->MultiCell(63, 5, $data["order"]["poc"],0,'R');

$pdf->SetX(7);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(50, 5, "Country:",0,0);

$pdf->SetX(42);
$pdf->SetFont('Arial','',10);
$pdf->Cell(50, 5, strtoupper($data["order"]["country"]),0,0);

$pdf->SetX(125);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(50, 5, "Email:",0,0);

$pdf->SetX(140);
$pdf->SetFont('Arial','',10);
$pdf->MultiCell(63, 5, $data["order"]["email"],0,'R');

$pdf->SetXY(7, 100);
$pdf->SetFillColor(191);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(195, 0.7, "",0,0,'L', 1);

// Header of table

$pdf->SetXY(7, 105);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(35, 5, "Product Name",0,0,'L');

$pdf->SetXY(50, 105);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(50, 5, "QTY.",0,0);

$pdf->SetXY(65, 105);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(50, 5, "Weight/Unit",0,0);

$pdf->SetXY(90, 105);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(50, 5, "Weight/Ctn",0,0);

$pdf->SetXY(115, 105);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(50, 5, "CBM",0,0);

$pdf->SetXY(130, 105);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(50, 5, "Total CBM",0,0);

$pdf->SetXY(155, 105);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(50, 5, "Unit Price",0,0);

$pdf->SetXY(155, 105);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(45, 5, "Amount",0,1, 'R');

$pdf->SetXY(7, 113);
$pdf->SetFillColor(191);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(195, 0.2, "",0,0,'L', 1);

// Row of table
$yPos = 117;
$ttlCtns = 0;

foreach ($data["contents"] as $item) {
    $pdf->SetXY(7, $yPos);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(35, 5, $item["product"],0,0,'L');
    
    $pdf->SetXY(7, $yPos+5);
    $pdf->SetFont('Arial','',9);
    $pdf->SetTextColor(64);
    $pdf->Cell(35, 5, $item["product"]." ".$item["weight_per_unit"]." Gm/".$item["unit_name"].", ".$item["unit_quantity"]." ".$item["unit_name"]."s/".$item["variant_name"].", ".$item["unit_variant_quantity"]." ".$item["variant_name"]."s/Carton",0,0,'L');

    $pdf->SetXY(50, $yPos);
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(8, 5, $item["qty"],0,0,'C');

    $pdf->SetXY(65, $yPos);
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(50, 5, $item["weight_per_unit"]." GM",0,0);

    $pdf->SetXY(90, $yPos);
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(50, 5, $item["weight_per_ctn"]." KG",0,0);

    $pdf->SetXY(115, $yPos);
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(50, 5, $item["cbm"],0,0);

    $pdf->SetXY(130, $yPos);
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(50, 5, $item["total_cbm"],0,0);

    $pdf->SetXY(155, $yPos);
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(50, 5, $data["order"]["currency"].'.'.$item["unit_price"],0,0);

    $pdf->SetXY(155, $yPos);
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(45, 5, $data["order"]["currency"].'.'.number_format($item["amount"]),0,1, 'R');

    $pdf->SetXY(7, $yPos+12);
    $pdf->SetFillColor(191);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(195, 0.2, "",0,0,'L', 1);
    
    $yPos += 15;
    $ttlCtns += $item["qty"];
}

// Table footer
// $yPos += 10;
// $pdf->SetXY(7, $yPos-3);
// $pdf->SetFillColor(191);
// $pdf->SetFont('Arial','B',10);
// $pdf->Cell(195, 0.2, "",0,0,'L', 1);

$pdf->SetXY(7, $yPos);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(35, 5, "Total",0,0,'L');

$pdf->SetXY(50, $yPos);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(50, 5, $ttlCtns." CTNS",0,0);

$pdf->SetXY(65, $yPos);
$pdf->SetFont('Arial','',10);
$pdf->Cell(50, 5, "",0,0);

$pdf->SetXY(90, $yPos);
$pdf->SetFont('Arial','',9);
$pdf->Cell(50, 5, "",0,0);

$pdf->SetXY(115, $yPos);
$pdf->SetFont('Arial','',9);
$pdf->Cell(50, 5, "",0,0);

$pdf->SetXY(130, $yPos);
$pdf->SetFont('Arial','',9);
$pdf->Cell(50, 5, "",0,0);

$pdf->SetXY(155, $yPos);
$pdf->SetFont('Arial','',9);
$pdf->Cell(50, 5, "",0,0);

$pdf->SetXY(155, $yPos);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(45, 5, $data["order"]["currency"].'.'.number_format($data["order"]["total_amount"]),0,1, 'R');

if($data["order"]["notes"]){
    $pdf->SetXY(7, 180);
    $pdf->SetFont('Arial','B',11);
    $pdf->Cell(45, 5, "Notes",0,0, 'L');

    $pdf->SetXY(7, 188);
    $pdf->SetFont('Arial','',10);
    $pdf->MultiCell(95, 5, $data["order"]["notes"],0,'L');
}
if($data["order"]["terms"]){
    $pdf->SetXY(115, 180);
    $pdf->SetFont('Arial','B',11);
    $pdf->Cell(45, 5, "Terms",0,0, 'L');

    $pdf->SetXY(115, 188);
    $pdf->SetFont('Arial','',10);
    $pdf->MultiCell(90, 5, $data["order"]["terms"],0,'L');
}

$pdf->Output();
?>
