<?php 
include $_SERVER['DOCUMENT_ROOT'] . '/ShiftTrack/config.php';
include ROOT_PATH . 'includes/navbar.php';
include ROOT_PATH . 'includes/sidebar.php';
require ROOT_PATH . 'database.php';
?>

<div class="main-content">
    <div class="container-fluid">   
        <h3 class="mt-1">Dashboard</h3>
        <p class="text-muted">Welcome back! Here's what's happening today.</p>
        <div class="row g-3">

            <?php 
                $totalEmployees = $connection->query("SELECT COUNT(*) AS c FROM employees")->fetch(PDO::FETCH_ASSOC)['c'];
                $totalShifts = $connection->query("SELECT COUNT(*) AS c FROM shifts")->fetch(PDO::FETCH_ASSOC)['c'];
                $presentToday = $connection->query("SELECT COUNT(*) AS c FROM attendance WHERE date = CURDATE() AND status = 'Present'")->fetch(PDO::FETCH_ASSOC)['c'];
                $absentToday = $connection->query("SELECT COUNT(*) AS c FROM attendance WHERE date = CURDATE() AND status = 'Absent'")->fetch(PDO::FETCH_ASSOC)['c'];
                $onLeaveToday = $connection->query("SELECT COUNT(*) AS c FROM attendance WHERE date = CURDATE() AND status = 'On Leave'")->fetch(PDO::FETCH_ASSOC)['c'];
            ?>

            <div class="col-md-4 col-lg-2">
                <div class="card stat-card">
                    <div class="card-body text-center">
                        <div class="stat-icon bg-primary-light">
                            <i class="bi bi-people-fill text-primary"></i>
                        </div>
                        <h3><?= $totalEmployees ?></h3>
                        <p>Total Employees</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-lg-2">
                <div class="card stat-card">
                    <div class="card-body text-center">
                        <div class="stat-icon bg-success-light">
                            <i class="bi bi-clock-history text-success"></i>
                        </div>
                        <h3><?= $totalShifts ?></h3>
                        <p>Total Shifts</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-lg-2">
                <div class="card stat-card">
                    <div class="card-body text-center">
                        <div class="stat-icon bg-green-light">
                            <i class="bi bi-check2-circle text-green"></i>
                        </div>
                        <h3><?= $presentToday ?></h3>
                        <p>Present Today</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-lg-2">
                <div class="card stat-card">
                    <div class="card-body text-center">
                        <div class="stat-icon bg-danger-light">
                            <i class="bi bi-x-circle text-danger"></i>
                        </div>
                        <h3><?= $absentToday = $totalEmployees - $presentToday?></h3>
                        <p>Absent Today</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-lg-2">
                <div class="card stat-card">
                    <div class="card-body text-center">
                        <div class="stat-icon bg-info-light">
                            <i class="bi bi-calendar-event text-info"></i>
                        </div>
                        <h3><?= $onLeaveToday ?></h3>
                        <p>On Leave</p>
                    </div>
                </div>
            </div>
        </div>

        <h3 class="mt-4">Today's Attendance</h3>

        <div class="card mt-4">
            <table class="table align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Employee</th>
                        <th>Department</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th>Status</th>
                        <th>Late(Min)</th>
                        <th>OT(Min)</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                        $query = $connection->query("
                            SELECT a.*, e.name AS employee_name, e.email AS emp_email, d.name AS dept_name
                            FROM attendance a
                            JOIN employees e ON a.employee_id = e.id
                            JOIN departments d ON e.department_id = d.id
                            WHERE a.date = CURDATE()
                            ORDER BY a.date DESC
                        ");
                        foreach($query as $a){
                    ?>
                        <tr>
                        <td><?= $a['id'] ?></td>
                        <td><strong><?= $a['employee_name'] ?></strong><br><small class="text-muted"><?= $a['emp_email'] ?></small></td>
                        <td><?= $a['dept_name'] ?></td>
                        <td><?= $a['check_in'] ?></td>
                        <td><?= $a['check_out'] ?></td>
                        <td><span class="badge bg-success-subtle text-success"><?= $a['status'] ?></span></td>
                        <td><?= $a['late_minutes'] ?></td>
                        <td><?= $a['overtime_minutes'] ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>
</div>
