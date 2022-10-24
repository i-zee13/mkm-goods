<?php
require('fpdf.php');
require('db.php');
 $data = [];
$order_id = $_GET['oid'];
$sql = "SELECT id, exporter_info, exporter_membership_num, (Select company_name from customers where id = (Select customer_id from orders where id = $order_id)) as customer_name, (Select address from customers where id = (Select customer_id from orders where id = $order_id)) as customer_address from company_information";

$stmt = $conn->prepare($sql);
// $orderId = $_GET['oid'];
// $stmt->bind_param('i', $orderId);
$stmt->execute();
$stmt->bind_result($id, $exporter_info, $exporter_membership_num, $customer_name, $customer_address);
$core = [];
while($stmt->fetch()){
    $core = [ "id" => $id, "exporter_info" => $exporter_info, "exporter_membership_num" => $exporter_membership_num, "customer_name" => $customer_name, "customer_address" => $customer_address];
}
$stmt->close();
//echo '<pre>'; print_r($core); die;



$pdf = new FPDF('P','mm',array(210,286));
// // Total width is 210mm
 $pdf->AddPage();
$pdf->AliasNbPages();
// Header of table


$pdf->Image('../images/certificate-of-origin.jpg', 0, 0, 210, 286);

$pdf->SetXY(7.5, 20.5);
$pdf->SetFont('Arial','B',8); 

$pdf->MultiCell(85, 4, $core['exporter_info'],0,'L',0);
 
$customer = json_decode($core['customer_name'], true);
$pdf->SetXY(7.5, 53.5);
$pdf->MultiCell(85, 4, $core['customer_name'].' '.$customer[0]['street'].' '.$customer[0]['country'],0,'L',0);

$pdf->SetXY(7.5, 76);
$pdf->MultiCell(85, 4, $core['exporter_membership_num'],0,'L',0);

$pdf->Output();
?>
