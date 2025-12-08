<?php include $_SERVER['DOCUMENT_ROOT'] . '/ShiftTrack/config.php';?>
<?php include ROOT_PATH . 'includes/navbar.php'; ?>
<?php include ROOT_PATH . 'includes/sidebar.php'; ?>
<?php include ROOT_PATH . 'database.php'; ?>

<div class="main-content">
    <div class="container-fluid">

        <!-- Header Row -->
        <div class="d-flex justify-content-between align-items-start mt-3">
            <div>
                <h3>Shift Assignments</h3>
                <p class="text-muted">Assign shifts to employees with date ranges</p>
            </div>

            <button class="btn btn-primary d-flex align-items-center mt-2"
                data-bs-toggle="modal" data-bs-target="#addAssignmentModal">
                <i class="bi bi-plus-lg me-2"></i> New Assignment
            </button>
        </div>

        <!-- Filters -->
        <div class="card p-3 mt-3">
            <div class="row g-2">

                <!-- Employee Filter -->
                <div class="col-md-3">
                    <select class="form-select">
                        <option selected>All Employees</option>
                        <option>John Smith</option>
                        <option>Sarah Johnson</option>
                        <option>Michael Brown</option>
                    </select>
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

        <!-- Assignments Table -->
        <div class="card mt-3">
            <table class="table align-middle">
                <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Employee</th>
                    <th>Shift</th>
                    <th>Effective From</th>
                    <th>Effective To</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>1</td>
                        <td>John Smith</td>
                        <td><span class="badge bg-success-subtle text-success">Morning</span></td>
                        <td>2024-02-01</td>
                        <td>Ongoing</td>
                        <td><span class="badge bg-success">Active</span></td>
                        <td>
                            <button class="btn btn-outline-danger btn-sm delete-btn"
                                    data-id="1"
                                    data-name="John Smith - Morning">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>


        <!-- Add Assignment Modal -->
        <div class="modal fade" id="addAssignmentModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">New Shift Assignment</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <form action="add_assignment.php" method="POST">
                        <div class="modal-body">

                            <label class="form-label">Employee *</label>
                            <select name="employee" class="form-select mb-3" required>
                                <option value="">Select employee</option>
                                <option>John Smith</option>
                                <option>Sarah Johnson</option>
                                <option>Michael Brown</option>
                            </select>

                            <label class="form-label">Shift *</label>
                            <select name="shift" class="form-select mb-3" required>
                                <option value="">Select shift</option>
                                <option>Morning</option>
                                <option>Evening</option>
                                <option>Night</option>
                            </select>

                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Effective From *</label>
                                    <input type="date" name="start_date" class="form-control mb-3" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Effective To</label>
                                    <input type="date" name="end_date" class="form-control mb-3">
                                </div>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Create Assignment</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>


        <!-- Delete Assignment Modal -->
        <div class="modal fade" id="deleteAssignmentModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title text-danger">Delete Assignment</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <form action="delete_assignment.php" method="POST">
                        <div class="modal-body">

                            <input type="hidden" name="assignment_id" id="deleteAssignId">

                            <p>Are you sure you want to delete this assignment?</p>
                            <p class="fw-bold text-danger" id="deleteAssignName"></p>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>
</div>


<script>
    document.querySelectorAll(".delete-btn").forEach(btn => {
        btn.addEventListener("click", () => {
            document.getElementById("deleteAssignId").value = btn.dataset.id;
            document.getElementById("deleteAssignName").innerText = btn.dataset.name;

            new bootstrap.Modal(document.getElementById("deleteAssignmentModal")).show();
        });
    });
</script>
