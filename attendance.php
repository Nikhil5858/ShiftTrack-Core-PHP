<?php include './includes/navbar.php'; ?>
<?php include './includes/sidebar.php'; ?>

<div class="main-content">
    <div class="container-fluid">  
        
        <!-- Header Row -->
        <div class="d-flex justify-content-between align-items-start mt-3">
            <div>
                <h3>Attendance</h3>
                <p class="text-muted">Record and manage daily attendance</p>
            </div>

            <button class="btn btn-primary d-flex align-items-center mt-2"
                data-bs-toggle="modal" data-bs-target="#addAttendanceModal">
                <i class="bi bi-plus-lg me-2"></i> Manual Entry
            </button>
        </div>

        <!-- STAT CARDS -->
        <div class="row g-3 ">

            <!-- Present -->
            <div class="col-md-3 col-lg-2">
                <div class="card stat-card">
                    <div class="card-body text-center">
                        <div class="stat-icon bg-green-light">
                            <i class="bi bi-check2-circle text-success"></i>
                        </div>
                        <h3>7</h3>
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
                        <h3>1</h3>
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
                        <h3>1</h3>
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
                        <h3>1</h3>
                        <p>Half Day</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="card p-3 mt-3">
            <div class="row g-2">

                <!-- Employee Filter -->
                <div class="col-md-3">
                    <input type="date" name="date" class="form-control">
                </div>

                <!-- Shift Filter -->
                <div class="col-md-3">
                    <select class="form-select">
                        <option selected>All Shifts</option>
                        <option>Morning</option>
                        <option>Evening</option>
                        <option>Night</option>
                    </select>
                </div>

            </div>
        </div>

        <!-- Attendance Table -->
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
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td>1</td>
                        <td><strong>John Smith</strong><br><small class="text-muted">john@company.com</small></td>
                        <td>Engineering</td>
                        <td>08:55</td>
                        <td>17:30</td>
                        <td><span class="badge bg-success-subtle text-success">Present</span></td>
                        <td>0</td>
                        <td>30</td>
                        <td>
                            <button class="btn btn-outline-primary btn-sm edit-btn"
                                data-id="1"
                                data-emp="John Smith"
                                data-date="2025-12-08"
                                data-in="08:55"
                                data-out="17:30"
                                data-status="Present">
                                <i class="bi bi-pencil"></i>
                            </button>
                        </td>
                    </tr>

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
                        <option>Select employee</option>
                        <option value="1">John Smith</option>
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
            document.getElementById("editIn").value = btn.dataset.in;
            document.getElementById("editOut").value = btn.dataset.out;
            document.getElementById("editStatus").value = btn.dataset.status;

            new bootstrap.Modal(document.getElementById("editAttendanceModal")).show();
        });
    });
</script>
