<?php
require('fpdf.php');
require('db.php');

$data = []; 

$sql = "SELECT id, invoice_no, invoice_to, sro, invoice_date, lc_through, custom_invoice_no, invoice_for, lc_number, invoice_country, invoice_address, invoice_city, invoice_port, form_e_no, fob_value, form_e_date, freight, fobcfrcfi, fdbc_prc_no, fdbc_prc_date, insurance, shipped_via, discount, marks_no, export_pak_rs, sb_no, adv_pmt, st_no, sb_date, ptc_code, contents from custom_invoices where order_id = ?";
$stmt = $conn->prepare($sql);
$orderId = $_GET['oid'];
$stmt->bind_param('i', $orderId);
$stmt->execute();
$stmt->bind_result($id, $invoice_no, $invoice_to, $sro, $invoice_date, $lc_through, $custom_invoice_no, $invoice_for, $lc_number, $invoice_country, $invoice_address, $invoice_city, $invoice_port, $form_e_no, $fob_value, $form_e_date, $freight, $fobcfrcfi, $fdbc_prc_no, $fdbc_prc_date, $insurance, $shipped_via, $discount, $marks_no, $export_pak_rs, $sb_no, $adv_pmt, $st_no, $sb_date, $ptc_code, $contents);
$order_core = [];
while($stmt->fetch()){
    $order_core = [ "id" => $id, "invoice_no" => $invoice_no, "invoice_to" => $invoice_to, "sro" => $sro, "invoice_date" => $invoice_date, "lc_through" => $lc_through, "custom_invoice_no" => $custom_invoice_no, "invoice_for" => $invoice_for, "lc_number" => $lc_number, 'invoice_country' => $invoice_country, 'invoice_address' => $invoice_address, 'invoice_city' => $invoice_city, 'invoice_port' => $invoice_port, 'form_e_no' => $form_e_no, 'fob_value' => $fob_value, 'form_e_date' => $form_e_date, 'freight' => $freight, 'fobcfrcfi' => $fobcfrcfi, 'fdbc_prc_no' => $fdbc_prc_no, 'fdbc_prc_date' => $fdbc_prc_date, 'insurance' => $insurance, 'shipped_via' => $shipped_via, 'discount' => $discount, 'marks_no' => $marks_no, 'export_pak_rs' => $export_pak_rs, 'sb_no' => $sb_no, 'adv_pmt' => $adv_pmt, 'st_no' => $st_no, 'sb_date' => $sb_date, 'ptc_code' => $ptc_code, 'contents' => $contents];
}
$data = $order_core;
$stmt->close();

//echo "<pre>"; print_r($data['customer_name']); die;

Class dcFpdf extends FPDF{

    
    function Header()
    {
        //global $data;
        $this->SetXY(10, 10);
        $logo = "../images/danpak-logo.jpg";
        $this->SetFont('Arial','B',12);
        $this->Cell( 10, 10, $this->Image($logo, $this->GetX(), $this->GetY(), 50), 0, 0, '', false );

        $this->SetXY(10, 28);
        $this->SetFillColor(255, 255, 255);
        $this->SetFont('Arial','B',10);
        $this->SetTextColor(0,0,0);
        $this->Cell(50, 4, "DANPAK FOOD INDUSTRIES",0,0,'L', 1);

        $this->SetXY(43, 32);
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
$pdf->SetXY(10, 50);
$pdf->SetFont('Arial','B',7);
$pdf->Cell( 40, 4, 'InvoiceNo              '.$data['invoice_no'], 0, 'L');

$pdf->SetXY(10, 55);
$pdf->Cell( 40, 4, 'InvoiceDate           '.date("d-M-y", strtotime($data['invoice_date'])), 0, 'L');

$pdf->SetXY(10, 60);
$pdf->Cell( 40, 4, 'InvoiceFor             '.$data['invoice_for'], 0, 'L');

$pdf->SetXY(10, 65);
$pdf->Cell( 40, 4, 'InvoiceAddress     '.$data['invoice_address'], 0, 'L');

$pdf->SetXY(10, 70);
$pdf->Cell( 40, 4, 'InvoicePort            '.$data['invoice_port'], 0, 'L');

$pdf->SetXY(10, 75);
$pdf->Cell( 40, 4, 'FOBValue:             '.$data['fob_value'], 0, 'L');

$pdf->SetXY(10, 80);
$pdf->Cell( 40, 4, 'Freight:                  '.$data['freight'], 0, 'L');

$pdf->SetXY(10, 85);
$pdf->Cell( 40, 4, 'Insurance:             '.$data['insurance'], 0, 'L');

$pdf->SetXY(10, 90);
$pdf->Cell( 40, 4, 'Discount:               '.$data['discount'], 0, 'L');

$pdf->SetXY(10, 95);
$pdf->Cell( 40, 4, 'S/B No:                   '.$data['sb_no'], 0, 'L');

$pdf->SetXY(10, 100);
$pdf->Cell( 40, 4, 'S/B Date:                '.$data['sb_date'], 0, 'L');




$pdf->SetXY(80, 50);
$pdf->Cell( 40, 4, 'InvoiceTo         '.$data['invoice_to'], 0, 'L');

$pdf->SetXY(80, 55);
$pdf->Cell( 40, 4, 'L/C Through:   '.$data['lc_through'], 0, 'L');

$pdf->SetXY(80, 60);
$pdf->Cell( 40, 4, 'L/C Number     '.$data['lc_number'], 0, 'L');

$pdf->SetXY(80, 65);
$pdf->Cell( 40, 4, 'L/C Date           NA', 0, 'L');

$pdf->SetXY(80, 70);
$pdf->Cell( 40, 4, 'Form "E" No:   '.$data['form_e_no'], 0, 'L');

$pdf->SetXY(80, 75);
$pdf->Cell( 40, 4, 'Form "E" Date: '.$data['form_e_date'], 0, 'L');

$pdf->SetXY(80, 80);
$pdf->Cell( 40, 4, 'FOBCFRCIF      '.$data['fobcfrcfi'], 0, 'L');

$pdf->SetXY(80, 85);
$pdf->Cell( 40, 4, 'ShippedVia       '.$data['shipped_via'], 0, 'L');

$pdf->SetXY(80, 90);
$pdf->Cell( 40, 4, 'MarksNumber:  '.$data['marks_no'], 0, 'L');

$pdf->SetXY(80, 95);
$pdf->Cell( 40, 4, 'AdvPmt:             '.$data['adv_pmt'], 0, 'L');





$pdf->SetXY(140, 50);
$pdf->Cell( 40, 4, 'SRO                               '.$data['sro'], 0, 'L');

$pdf->SetXY(140, 55);
$pdf->Cell( 40, 4, 'CustomInvoiceNo       '.$data['custom_invoice_no'], 0, 'L');

$pdf->SetXY(140, 60);
$pdf->Cell( 40, 4, 'InvoiceNo                    '.$data['invoice_no'], 0, 'L');

$pdf->SetXY(140, 65);
$pdf->Cell( 40, 4, 'InvoiceCountry            '.$data['invoice_country'], 0, 'L');

$pdf->SetXY(140, 70);
$pdf->Cell( 40, 4, 'InvoiceCity                   '.$data['invoice_city'], 0, 'L');

$pdf->SetXY(140, 75);
$pdf->Cell( 40, 4, 'PaymentTerms:           NA', 0, 'L');

$pdf->SetXY(140, 80);
$pdf->Cell( 40, 4, 'FDBC/PRC No:            '.$data['fdbc_prc_no'], 0, 'L');

$pdf->SetXY(140, 85);
$pdf->Cell( 40, 4, 'FDBC/PRC Date:         '.$data['fdbc_prc_date'], 0, 'L');

$pdf->SetXY(140, 90);
$pdf->Cell( 40, 4, 'Export Pak Rs:            '.$data['export_pak_rs'], 0, 'L');

$pdf->SetXY(140, 95);
$pdf->Cell( 40, 4, 'S/T No:                         '.$data['st_no'], 0, 'L');

$pdf->SetXY(140, 100);
$pdf->Cell( 40, 4, 'PTC Code:                   '.$data['ptc_code'], 0, 'L');



$pdf->Output();
?>
