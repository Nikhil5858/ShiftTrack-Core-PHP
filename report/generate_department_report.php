<?php
include '../config.php';
include ROOT_PATH . "database.php";
require '../xlsxwriter.class.php';   

$department_id = $_POST['department_id'];
$month = $_POST['month'];

$query = $connection->prepare("
    SELECT a.*, e.name AS employee_name, d.name AS dept_name
    FROM attendance a
    JOIN employees e ON a.employee_id = e.id
    JOIN departments d ON e.department_id = d.id
    WHERE e.department_id = :dept
    AND DATE_FORMAT(a.date, '%Y-%m') = :month
    ORDER BY e.name, a.date
");

$query->execute([
    ':dept' => $department_id,
    ':month' => $month
]);

$rows = $query->fetchAll(PDO::FETCH_ASSOC);

$filename = "Department_Report_{$month}.xlsx";

$header = [
    'Employee'       => 'string',
    'Date'           => 'date',
    'Status'         => 'string',
    'Late (Min)'     => 'integer',
    'Overtime (Min)' => 'integer',
];

$writer = new XLSXWriter();
$writer->writeSheetHeader('Sheet1', $header, ['freeze_rows' => 1]);

foreach ($rows as $r) {
    $writer->writeSheetRow('Sheet1', [
        $r['employee_name'],
        $r['date'],
        $r['status'],
        $r['late_minutes'],
        $r['overtime_minutes'],
    ]);
}

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"$filename\"");
header('Cache-Control: must-revalidate');

$writer->writeToStdOut();
exit;
