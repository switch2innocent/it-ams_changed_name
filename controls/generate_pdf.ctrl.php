<?php
session_start();

require_once '../config/dbcon.php';
require_once '../objects/assets.obj.php';
require_once '../vendor/tecnickcom/tcpdf/tcpdf.php';

$database = new Connection();
$db = $database->connect();

$get_assets = new Assets($db);

//Generate PDF function for barcode and accountable format
function generatePDF($getAll)
{
    //For validation
    $row = $getAll->fetch(PDO::FETCH_ASSOC);
    if ($row === false) {
        header("Location: ../200.php");
        exit;
    }

    $acctName = $row['acct_name'];
    $genBy = $_SESSION['firstname'] . " " . $_SESSION['lastname'];
    $dateGen = date("Y-m-d");

    //Reset
    $getAll->execute();

    //Create PDF document
    $pdf = new MyPDF('L', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('IT - AMS');
    $pdf->SetTitle('IT - AMS Report');
    $pdf->SetSubject('Report');
    $pdf->SetKeywords('IT - AMS, Report, PDF');

    $pdf->setPrintHeader(false);        //No header
    $pdf->setPrintFooter(true);         //Enable footer for page numbers
    $pdf->SetMargins(10, 10, 10);
    $pdf->SetAutoPageBreak(true, 10);
    $pdf->SetFooterMargin(10);          //Set footer margin
    $pdf->AddPage();

    //Title
    //Set font
    $pdf->SetFont('times', 'B', 14);
    $pdf->Cell(0, 10, 'IT - AMS REPORT', 0, 1, 'C');

    //Header info
    $pdf->SetFont('timesI', '', 9);
    $pdf->Cell(0, 6, 'Accountable Name: ' . $acctName, 0, 1, 'L');
    $pdf->Cell(0, 6, 'Date Generated: ' . $dateGen, 0, 1, 'L');
    $pdf->Ln(1);

    //Set font
    $pdf->SetFont('timesI', 'B', 10);
    $pdf->Cell(0, 6, 'Below are Assets/Items that employee acquired.', 0, 1, 'L');

    //Set font
    $pdf->SetFont('helvetica', '', 8);

    //Table
    $tableHTML = '<table cellpadding="4" border="1" style="border-collapse:collapse;">
<thead>
    <tr style="background-color:#f2f2f2;">
        <th width="100" align="center">Barcode</th>
        <th width="185" align="center">Description</th>
        <th width="100" align="center">Department</th>
        <th width="100" align="center">Location</th>
        <th width="100" align="center">New Assignee</th>
        <th width="100" align="center">Signature</th>
        <th width="100" align="center">Remarks</th>
    </tr>
</thead>
<tbody>';

    while ($row = $getAll->fetch(PDO::FETCH_ASSOC)) {
        $tableHTML .= '<tr>
            <td width="100" align="center">' . htmlspecialchars($row['bar_no'], ENT_QUOTES, 'UTF-8') . '</td>
            <td width="185" align="justify">' . htmlspecialchars($row['item_desc'], ENT_QUOTES, 'UTF-8') . '</td>
            <td width="100" align="center">' . htmlspecialchars($row['dept_name'], ENT_QUOTES, 'UTF-8') . '</td>
            <td width="100" align="center">' . htmlspecialchars($row['location'], ENT_QUOTES, 'UTF-8') . '</td>
            <td width="100" align="center"></td>
            <td width="100" align="center"></td>
            <td width="100" align="center"></td>
        </tr>';
    }

    $tableHTML .= '</tbody></table>';

    //Output
    $pdf->writeHTML($tableHTML, true, false, false, false, '');

    //Set font
    $pdf->SetFont('times', '', 9);

    //Footer settings
    $blockWidth = 80;
    $lineHeight = 6;
    $lineOffset = 2;
    $bottomOffset = 30; //Distance from bottom
    $pageWidth = $pdf->getPageWidth();
    $pageHeight = $pdf->getPageHeight();
    $leftMargin = 10;
    $rightMargin = 10;

    //Y position from bottom
    $startY = $pageHeight - $bottomOffset;
    //For prepared by
    $preparedX = $leftMargin;
    // Label
    $pdf->SetXY($preparedX, $startY);
    $pdf->Cell($blockWidth, $lineHeight, 'Prepared by:', 0, 2, 'L');
    // Signature Line
    $preparedLineY = $pdf->GetY() + $lineOffset;
    $pdf->Line($preparedX, $preparedLineY, $preparedX + $blockWidth, $preparedLineY);
    // Name
    $pdf->SetY($preparedLineY + $lineOffset);
    $pdf->SetX($preparedX);
    $pdf->Cell($blockWidth, $lineHeight, $genBy, 0, 2, 'C');

    //For verified by
    $verifiedX = $pageWidth - $rightMargin - $blockWidth;
    // Label
    $pdf->SetXY($verifiedX, $startY);
    $pdf->Cell($blockWidth, $lineHeight, 'Verified by:', 0, 2, 'L');
    // Signature Line
    $verifiedLineY = $pdf->GetY() + $lineOffset;
    $pdf->Line($verifiedX, $verifiedLineY, $verifiedX + $blockWidth, $verifiedLineY);
    // Name
    $pdf->SetY($verifiedLineY + $lineOffset);
    $pdf->SetX($verifiedX);
    $pdf->Cell($blockWidth, $lineHeight, 'JEFFREY C. MONILLA', 0, 2, 'C');

    //Output PDF in browser
    $pdf->Output('IT-AMS_report.pdf', 'I');
}

//Generate PDF function for description, department, location and status format
function generatePDF2($getAll)
{
    //Fetch for validation
    $row = $getAll->fetch(PDO::FETCH_ASSOC);
    if ($row === false) {
        header("Location: ../200.php");
        exit;
    }

    // $acctName = $row['acct_name'];
    $genBy = $_SESSION['firstname'] . " " . $_SESSION['lastname'];
    $dateGen = date("Y-m-d");

    //Reset the query
    $getAll->execute();

    //Create PDF document
    $pdf = new MyPDF('L', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('IT - AMS');
    $pdf->SetTitle('IT - AMS Report');
    $pdf->SetSubject('Report');
    $pdf->SetKeywords('IT - AMS, Report, PDF');

    $pdf->setPrintHeader(false);        //No header
    $pdf->setPrintFooter(true);         //Enable footer for page numbers
    $pdf->SetMargins(10, 10, 10);
    $pdf->SetAutoPageBreak(true, 10);
    $pdf->SetFooterMargin(10);          //Set footer margin
    $pdf->AddPage();

    //Title
    //Set font
    $pdf->SetFont('times', 'B', 14);
    $pdf->Cell(0, 10, 'IT - AMS REPORT', 0, 1, 'C');

    //Header info
    $pdf->SetFont('timesI', '', 9);
    // $pdf->Cell(0, 6, 'Accountable Name: ' . $acctName, 0, 1, 'L');
    $pdf->Cell(0, 6, 'Date Generated: ' . $dateGen, 0, 1, 'L');
    $pdf->Ln(1);

    //Set font
    $pdf->SetFont('timesI', 'B', 10);
    $pdf->Cell(0, 6, 'Below are Assets/Items that employee acquired.', 0, 1, 'L');

    //Set font
    $pdf->SetFont('helvetica', '', 8);

    //Table
    $tableHTML = '<table cellpadding="4" border="1" style="border-collapse:collapse;">
<thead>
    <tr style="background-color:#f2f2f2;">
        <th width="100" align="center">Barcode</th>
        <th width="100" align="center">Description</th>
        <th width="100" align="center">Accountable</th>
        <th width="100" align="center">Department</th>
        <th width="100" align="center">Location</th>
        <th width="100" align="center">New Assignee</th>
        <th width="100" align="center">Signature</th>
        <th width="100" align="center">Remarks</th>
    </tr>
</thead>
<tbody>';

    while ($row = $getAll->fetch(PDO::FETCH_ASSOC)) {
        $tableHTML .= '<tr>
            <td width="100" align="center">' . htmlspecialchars($row['bar_no'], ENT_QUOTES, 'UTF-8') . '</td>
            <td width="100" align="justify">' . htmlspecialchars($row['item_desc'], ENT_QUOTES, 'UTF-8') . '</td>
            <td width="100" align="center">' . htmlspecialchars($row['acct_name'], ENT_QUOTES, 'UTF-8') . '</td>
            <td width="100" align="center">' . htmlspecialchars($row['dept_name'], ENT_QUOTES, 'UTF-8') . '</td>
            <td width="100" align="center">' . htmlspecialchars($row['location'], ENT_QUOTES, 'UTF-8') . '</td>
            <td width="100" align="center"></td>
            <td width="100" align="center"></td>
            <td width="100" align="center"></td>
        </tr>';
    }

    $tableHTML .= '</tbody></table>';

    //Output
    $pdf->writeHTML($tableHTML, true, false, false, false, '');

    //Set font
    $pdf->SetFont('times', '', 9);

    //Footer settings
    $blockWidth = 80;
    $lineHeight = 6;
    $lineOffset = 2;
    $bottomOffset = 30; //Distance from bottom
    $pageWidth = $pdf->getPageWidth();
    $pageHeight = $pdf->getPageHeight();
    $leftMargin = 10;
    $rightMargin = 10;

    //Y position from bottom
    $startY = $pageHeight - $bottomOffset;
    //For prepared by
    $preparedX = $leftMargin;
    // Label
    $pdf->SetXY($preparedX, $startY);
    $pdf->Cell($blockWidth, $lineHeight, 'Prepared by:', 0, 2, 'L');
    // Signature Line
    $preparedLineY = $pdf->GetY() + $lineOffset;
    $pdf->Line($preparedX, $preparedLineY, $preparedX + $blockWidth, $preparedLineY);
    // Name
    $pdf->SetY($preparedLineY + $lineOffset);
    $pdf->SetX($preparedX);
    $pdf->Cell($blockWidth, $lineHeight, $genBy, 0, 2, 'C');

    //For verified by
    $verifiedX = $pageWidth - $rightMargin - $blockWidth;
    // Label
    $pdf->SetXY($verifiedX, $startY);
    $pdf->Cell($blockWidth, $lineHeight, 'Verified by:', 0, 2, 'L');
    // Signature Line
    $verifiedLineY = $pdf->GetY() + $lineOffset;
    $pdf->Line($verifiedX, $verifiedLineY, $verifiedX + $blockWidth, $verifiedLineY);
    // Name
    $pdf->SetY($verifiedLineY + $lineOffset);
    $pdf->SetX($verifiedX);
    $pdf->Cell($blockWidth, $lineHeight, 'JEFFREY C. MONILLA', 0, 2, 'C');

    //Output PDF in browser
    $pdf->Output('IT-AMS_report.pdf', 'I');
}

//For footer
class MyPDF extends TCPDF
{
    public function Footer()
    {
        //Position at 15mm from bottom
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        //Page X of Y (using TCPDF's getPage() and getNumPages())
        $this->Cell(0, 10, 'Page ' . $this->getPage() . ' of ' . $this->getNumPages(), 0, 0, 'C');
    }
}

//Check for GET parameters
if (isset($_GET['bar_no'])) {
    $get_assets->bar_no = $_GET['bar_no'];
    $getAll = $get_assets->getAll_usingBarcodes();

    //Function Call
    generatePDF($getAll);
} else if (isset($_GET['desc'])) {
    $get_assets->item_desc = $_GET['desc'];
    $getAll = $get_assets->getAll_usingDescriptions();

    //Function Call
    generatePDF2($getAll);
} else if (isset($_GET['acct'])) {
    $get_assets->acct = $_GET['acct'];
    $getAll = $get_assets->getAll_usingAccts_for_clearance();

    //Function Call
    generatePDF($getAll);
} else if (isset($_GET['dept'])) {
    $get_assets->dept_id = $_GET['dept'];
    $getAll = $get_assets->getAll_usingDepartments();

    //Function Call
    generatePDF2($getAll);
} else if (isset($_GET['loc'])) {
    $get_assets->location_id = $_GET['loc'];
    $getAll = $get_assets->getAll_usingLocations();

    //Function Call
    generatePDF2($getAll);
} else if (isset($_GET['stat'])) {
    $get_assets->stat_id = $_GET['stat'];
    $getAll = $get_assets->getAll_usingStats();

    //Function Call
    generatePDF2($getAll);
}
