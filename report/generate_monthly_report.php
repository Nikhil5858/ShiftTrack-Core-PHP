<?php
include '../config.php';
include ROOT_PATH . "database.php";
require '../xlsxwriter.class.php';  

$employee_id = $_POST['employee_id'];
$month = $_POST['month'];  

$query = $connection->prepare("
    SELECT a.*, e.name AS employee_name, d.name AS dept_name
    FROM attendance a
    JOIN employees e ON a.employee_id = e.id
    JOIN departments d ON e.department_id = d.id
    WHERE a.employee_id = :id
    AND DATE_FORMAT(a.date, '%Y-%m') = :month
    ORDER BY a.date
");

$query->execute([
    ':id' => $employee_id,
    ':month' => $month
]);

$rows = $query->fetchAll(PDO::FETCH_ASSOC);

$filename = "Monthly_Report_{$month}.xlsx";

$header = [
    'Date'            => 'date',
    'Check In'        => 'string',
    'Check Out'       => 'string',
    'Status'          => 'string',
    'Late (Min)'      => 'integer',
    'Overtime (Min)'  => 'integer',
];

$writer = new XLSXWriter();
$writer->writeSheetHeader('Sheet1', $header, ['freeze_rows' => 1]);

foreach ($rows as $r) {
    $writer->writeSheetRow('Sheet1', [
        $r['date'],
        $r['check_in'],
        $r['check_out'],
        $r['status'],
        $r['late_minutes'],
        $r['overtime_minutes']
    ]);
}

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"$filename\"");
header('Cache-Control: must-revalidate');

$writer->writeToStdOut();
exit;
?>
