<?php

require_once '../config/dbcon.php';
require_once '../objects/assets.obj.php';
require_once '../vendor/tecnickcom/tcpdf/tcpdf.php';

$database = new Connection();
$db = $database->connect();

$get_assets = new Assets($db);

//Generate PDF function
function generatePDF($getAll)
{
    //Fetch for validation
    $row = $getAll->fetch(PDO::FETCH_ASSOC);
    if ($row === false) {
        header("Location: ../200.php");
        exit;
    }

    $acctName = $row['acct_name'];
    $createdBy = $row['full_name'];
    $createdDate = $row['created_at'];

    //Reset the query
    $getAll->execute();

    //Create PDF
    $pdf = new TCPDF('L', 'mm', [215.9, 330.2], true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('IT - Desk');
    $pdf->SetTitle('IT - Desk Report');
    $pdf->SetSubject('Report');
    $pdf->SetKeywords('IT - Desk, Report, PDF');

    //Configure margins and page setup
    $pdf->SetMargins(10, 10, 10);
    $pdf->SetAutoPageBreak(true, 10);
    $pdf->AddPage();

    //Add title
    $pdf->SetFont('helvetica', 'B', 16);
    $pdf->Cell(0, 10, 'IT - Desk Report', 0, 1, 'C');

    //Add header information
    $pdf->SetFont('helvetica', '', 10);
    $pdf->Cell(0, 6, 'Accountable Name: ' . $acctName, 0, 1, 'L');
    $pdf->Cell(0, 6, 'Created By: ' . $createdBy, 0, 1, 'L');
    $pdf->Cell(0, 6, 'Date Created: ' . $createdDate, 0, 1, 'L');
    $pdf->Ln(4); // Add spacing before the table

    //Table header
    $tableHTML = '<table border="1" cellpadding="3" cellspacing="0">
    <thead>
        <tr>
            <th>Barcode</th>
            <th>Description</th>
            <th>User</th>
            <th>Department</th>
            <th>Location</th>
            <th>Level</th>
            <th>Status</th>
            <th>Remarks</th>
        </tr>
    </thead>
    <tbody>';

    //Table rows
    while ($row = $getAll->fetch(PDO::FETCH_ASSOC)) {
        $tableHTML .= '<tr>
        <td>' . htmlspecialchars($row['bar_no'], ENT_QUOTES, 'UTF-8') . '</td>
        <td>' . htmlspecialchars($row['item_desc'], ENT_QUOTES, 'UTF-8') . '</td>
        <td>' . htmlspecialchars($row['user'], ENT_QUOTES, 'UTF-8') . '</td>
        <td>' . htmlspecialchars($row['dept_name'], ENT_QUOTES, 'UTF-8') . '</td>
        <td>' . htmlspecialchars($row['location'], ENT_QUOTES, 'UTF-8') . '</td>
        <td>' . htmlspecialchars($row['bldg_lvl'], ENT_QUOTES, 'UTF-8') . '</td>
        <td>' . htmlspecialchars($row['stat_name'], ENT_QUOTES, 'UTF-8') . '</td>
        <td>' . htmlspecialchars($row['remarks'], ENT_QUOTES, 'UTF-8') . '</td>
    </tr>';
    }

    $tableHTML .= '</tbody></table>';

    //Table to PDF
    $pdf->writeHTML($tableHTML, true, false, false, false, '');

    //Output PDF
    $pdf->Output('it-Desk_report.pdf', 'I');
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
    generatePDF($getAll);
} else if (isset($_GET['acct'])) {
    $get_assets->acct = $_GET['acct'];
    $getAll = $get_assets->getAll_usingAccts();

    //Function Call
    generatePDF($getAll);
} else if (isset($_GET['dept'])) {
    $get_assets->dept_id = $_GET['dept'];
    $getAll = $get_assets->getAll_usingDepartments();

    //Function Call
    generatePDF($getAll);
} else if (isset($_GET['loc'])) {
    $get_assets->location_id = $_GET['loc'];
    $getAll = $get_assets->getAll_usingLocations();

    //Function Call
    generatePDF($getAll);
} else if (isset($_GET['stat'])) {
    $get_assets->stat_id = $_GET['stat'];
    $getAll = $get_assets->getAll_usingStats();

    //Function Call
    generatePDF($getAll);
}
