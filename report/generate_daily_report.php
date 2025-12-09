<?php
include '../config.php';
include ROOT_PATH . "database.php";
require '../xlsxwriter.class.php';

$date = $_POST['date'];

$query = $connection->prepare("
    SELECT a.*, e.name AS employee_name, d.name AS dept_name
    FROM attendance a
    JOIN employees e ON a.employee_id = e.id
    JOIN departments d ON e.department_id = d.id
    WHERE a.date = :date
");

$query->execute([':date' => $date]);

$rows = $query->fetchAll(PDO::FETCH_ASSOC);

$filename = "Daily_Report_$date.xlsx";

$writer = new XLSXWriter();

$header = [
    'Employee' => 'string',
    'Department' => 'string',
    'Check In' => 'string',
    'Check Out' => 'string',
    'Status' => 'string'
];

$writer->writeSheetHeader('Daily Report', $header);

foreach ($rows as $r) {
    $writer->writeSheetRow('Daily Report', [
        $r['employee_name'],
        $r['dept_name'],
        $r['check_in'],
        $r['check_out'],
        $r['status']
    ]);
}

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"$filename\"");
header('Cache-Control: max-age=0');

$writer->writeToStdOut();
exit;

?>
