<?php 
include $_SERVER['DOCUMENT_ROOT'] . '/ShiftTrack/config.php';
include ROOT_PATH . 'includes/navbar.php';
include ROOT_PATH . 'includes/sidebar.php';
include ROOT_PATH . 'database.php';

$selectedDate = $_GET['date'] ?? date('Y-m-d');

$present = $connection->query("
    SELECT COUNT(*) AS total 
    FROM attendance 
    WHERE date = '$selectedDate' AND status = 'Present'
")->fetch()['total'];

$totalEmployees = $connection->query("
    SELECT COUNT(*) AS total 
    FROM employees
")->fetch()['total'];

$absent = $totalEmployees - $present;

$leave = $connection->query("
    SELECT COUNT(*) AS total 
    FROM attendance 
    WHERE date = '$selectedDate' AND status = 'On Leave'
")->fetch()['total'];

$halfday = $connection->query("
    SELECT COUNT(*) AS total 
    FROM attendance 
    WHERE date = '$selectedDate' AND status = 'Half Day'
")->fetch()['total'];

$query = $connection->prepare("
    SELECT 
        e.id AS emp_id,
        e.name AS employee_name,
        e.email AS emp_email,
        d.name AS dept_name,
        a.id AS attendance_id,
        a.check_in,
        a.check_out,
        a.status,
        a.late_minutes,
        a.overtime_minutes
    FROM employees e
    JOIN departments d ON e.department_id = d.id
    LEFT JOIN attendance a 
        ON a.employee_id = e.id AND a.date = :date
");

$query->execute(['date' => $selectedDate]);

?>

<div class="main-content">
    <div class="container-fluid">

        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-start mt-1">
            <div>
                <h3>Attendance</h3>
                <p class="text-muted">Record and manage daily attendance</p>
            </div>

            <button class="btn btn-primary d-flex align-items-center mt-2"
                data-bs-toggle="modal" data-bs-target="#addAttendanceModal">
                <i class="bi bi-plus-lg me-2"></i> Manual Entry
            </button>
        </div>

        <!-- Summary Cards -->
        <div class="row g-3 ">

            <div class="col-md-3 col-lg-2">
                <div class="card stat-card">
                    <div class="card-body text-center">
                        <div class="stat-icon bg-green-light">
                            <i class="bi bi-check2-circle text-success"></i>
                        </div>
                        <h3><?= $present ?></h3>
                        <p>Present</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-lg-2">
                <div class="card stat-card">
                    <div class="card-body text-center">
                        <div class="stat-icon bg-danger-light">
                            <i class="bi bi-x-circle text-danger"></i>
                        </div>
                        <h3><?= $absent ?></h3>
                        <p>Absent</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-lg-2">
                <div class="card stat-card">
                    <div class="card-body text-center">
                        <div class="stat-icon bg-info-light">
                            <i class="bi bi-calendar-event text-info"></i>
                        </div>
                        <h3><?= $leave ?></h3>
                        <p>On Leave</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-lg-2">
                <div class="card stat-card">
                    <div class="card-body text-center">
                        <div class="stat-icon bg-warning-light">
                            <i class="bi bi-clock text-warning"></i>
                        </div>
                        <h3><?= $halfday ?></h3>
                        <p>Half Day</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Date Filter -->
        <div class="card p-3 mt-3">
            <form method="GET">
                <div class="row g-2">
                    <div class="col-md-3">
                        <input type="date" name="date" class="form-control"
                            value="<?= $selectedDate ?>"
                            onchange="this.form.submit()">
                    </div>
                </div>
            </form>
        </div>

        <!-- Attendance Table -->
        <div class="card mt-3">
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
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($query as $a): ?>
                        <tr>
                            <td><?= $a['emp_id'] ?></td>

                            <td>
                                <strong><?= $a['employee_name'] ?></strong><br>
                                <small class="text-muted"><?= $a['emp_email'] ?></small>
                            </td>

                            <td><?= $a['dept_name'] ?></td>

                            <td>
                                <?php if (!$a['check_in']): ?>
                                    <form method="POST" action="checkin.php">
                                        <input type="hidden" name="employee_id" value="<?= $a['emp_id'] ?>">
                                        <button class="btn btn-outline-success btn-sm">
                                            <i class="bi bi-box-arrow-in-right"></i> Check In
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <?= date("H:i", strtotime($a['check_in'])) ?>
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php if ($a['check_in'] && !$a['check_out']): ?>
                                    <form method="POST" action="checkout.php">
                                        <input type="hidden" name="attendance_id" value="<?= $a['attendance_id'] ?>">
                                        <button class="btn btn-outline-danger btn-sm">
                                            <i class="bi bi-box-arrow-right"></i> Check Out
                                        </button>
                                    </form>
                                <?php elseif ($a['check_out']): ?>
                                    <?= date("H:i", strtotime($a['check_out'])) ?>
                                <?php else: ?>
                                    —
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php if ($a['status']): ?>
                                    <span class="badge bg-success-subtle text-success"><?= $a['status'] ?></span>
                                <?php else: ?>
                                    <span class="badge bg-secondary-subtle text-muted">Not Marked</span>
                                <?php endif; ?>
                            </td>

                            <td><?= $a['late_minutes'] ?? 0 ?></td>
                            <td><?= $a['overtime_minutes'] ?? 0 ?></td>

                            <td>
                                <?php if ($a['attendance_id']): ?>
                                    <button class="btn btn-outline-primary btn-sm edit-btn"
                                        data-id="<?= $a['attendance_id'] ?>"
                                        data-checkin="<?= $a['check_in'] ?>"
                                        data-checkout="<?= $a['check_out'] ?>"
                                        data-status="<?= $a['status'] ?>">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
        </div>

        <!-- EDIT Attendance Modal -->
        <div class="modal fade" id="editAttendanceModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Attendance</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <form action="edit_attendance.php" method="POST">
                        <div class="modal-body">

                            <input type="hidden" id="editId" name="id">

                            <div class="row">
                                <div class="col">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label class="form-label">Check In</label>
                                        <span class="error-message text-danger small d-none"></span>
                                    </div>
                                    <input type="time" id="editIn" name="check_in"
                                        class="form-control mb-3">
                                </div>

                                <div class="col">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label class="form-label">Check Out</label>
                                        <span class="error-message text-danger small d-none"></span>
                                    </div>
                                    <input type="time" id="editOut" name="check_out"
                                        class="form-control mb-3">
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <label class="form-label">Status *</label>
                                <span class="error-message text-danger small d-none"></span>
                            </div>
                            <select id="editStatus" name="status" class="form-select mb-3">
                                <option value="">Select status</option>
                                <option>Present</option>
                                <option>Absent</option>
                                <option>On Leave</option>
                                <option>Half Day</option>
                            </select>

                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                            <button class="btn btn-primary">Save</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>


    </div>
</div>


<script>
    document.querySelectorAll(".edit-btn").forEach(btn => {
        btn.addEventListener("click", () => {
            document.getElementById("editId").value = btn.dataset.id;
            let ci = btn.dataset.checkin ? btn.dataset.checkin.slice(0,5) : "";
            let co = btn.dataset.checkout ? btn.dataset.checkout.slice(0,5) : "";

            document.getElementById("editIn").value = ci;
            document.getElementById("editOut").value = co;
            document.getElementById("editStatus").value = btn.dataset.status;

            new bootstrap.Modal(document.getElementById("editAttendanceModal")).show();
        });
    });
</script>

