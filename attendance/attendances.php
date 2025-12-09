<?php include $_SERVER['DOCUMENT_ROOT'] . '/ShiftTrack/config.php';?>
<?php include ROOT_PATH . 'includes/navbar.php'; ?>
<?php include ROOT_PATH . 'includes/sidebar.php'; ?>
<?php include ROOT_PATH . 'database.php'; ?>


<div class="main-content">
    <div class="container-fluid">  
        
        <!-- Header Row -->
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

        <?php
            $today = date('Y-m-d');

            $present = $connection->query("
                SELECT COUNT(*) AS total 
                FROM attendance 
                WHERE date = '$today' AND status = 'Present'
            ")->fetch()['total'];

            $absent = $connection->query("
                SELECT COUNT(*) AS total 
                FROM attendance 
                WHERE date = '$today' AND status = 'Absent'
            ")->fetch()['total'];

            $leave = $connection->query("
                SELECT COUNT(*) AS total 
                FROM attendance 
                WHERE date = '$today' AND status = 'On Leave'
            ")->fetch()['total'];

            $halfday = $connection->query("
                SELECT COUNT(*) AS total 
                FROM attendance 
                WHERE date = '$today' AND status = 'Half Day'
            ")->fetch()['total'];
        ?>

        <!-- CARDS -->
        <div class="row g-3 ">

            <!-- Present -->
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

            <!-- Absent -->
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

            <!-- On Leave -->
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

            <!-- Half Day -->
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

        <!-- Filters -->
        <div class="card p-3 mt-3">
            <form method="GET">
                <div class="row g-2">
                    <div class="col-md-3">
                        <input type="date" name="date" class="form-control"
                            value="<?= $_GET['date'] ?? date('Y-m-d') ?>"
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

                    <?php
                        $selectedDate = $_GET['date'] ?? date('Y-m-d');
                        $query = $connection->prepare("
                            SELECT a.*, e.name AS employee_name, e.email AS emp_email, d.name AS dept_name
                            FROM attendance a
                            JOIN employees e ON a.employee_id = e.id
                            JOIN departments d ON e.department_id = d.id
                            WHERE a.date = :date
                            ORDER BY a.id DESC
                        ");

                        $query->execute(['date' => $selectedDate]);

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
                        <td>
                            <button class="btn btn-outline-primary btn-sm edit-btn"
                                data-id="<?= $a['id'] ?>"
                                data-checkin="<?= $a['check_in'] ?>"
                                data-checkout="<?= $a['check_out'] ?>"
                                data-status="<?= $a['status'] ?>">
                                <i class="bi bi-pencil"></i>
                            </button>
                        </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<!-- ADD Attendance Modal -->
<div class="modal fade" id="addAttendanceModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Manual Attendance Entry</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="add_attendance.php" method="POST">
                <div class="modal-body">

                    <label class="form-label">Employee *</label>
                    <select name="employee" class="form-select mb-3" required>
                        <option value="">Select employee</option>
                        <?php
                            $query = $connection->query("SELECT id,name FROM employees ORDER BY name");
                            foreach ($query as $e) echo "<option value='{$e['id']}'>{$e['name']}</option>";
                        ?>
                    </select>


                    <label class="form-label">Date *</label>
                    <input type="date" name="date" class="form-control mb-3" required>

                    <div class="row">
                        <div class="col">
                            <label>Check In</label>
                            <input type="time" name="check_in" class="form-control mb-3">
                        </div>
                        <div class="col">
                            <label>Check Out</label>
                            <input type="time" name="check_out" class="form-control mb-3">
                        </div>
                    </div>

                    <label>Status *</label>
                    <select name="status" class="form-select" required>
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
                            <label>Check In</label>
                            <input type="time" id="editIn" name="check_in" class="form-control mb-3">
                        </div>
                        <div class="col">
                            <label>Check Out</label>
                            <input type="time" id="editOut" name="check_out" class="form-control mb-3">
                        </div>
                    </div>

                    <label>Status *</label>
                    <select id="editStatus" name="status" class="form-select">
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

<script>
    document.querySelectorAll(".edit-btn").forEach(btn => {
        btn.addEventListener("click", () => {

            document.getElementById("editId").value = btn.dataset.id;
            document.getElementById("editIn").value = btn.dataset.checkin || "";
            document.getElementById("editOut").value = btn.dataset.checkout || "";
            document.getElementById("editStatus").value = btn.dataset.status;

            new bootstrap.Modal(document.getElementById("editAttendanceModal")).show();
        });
    });
</script>
