<?php include $_SERVER['DOCUMENT_ROOT'] . '/ShiftTrack/config.php';?>
<?php include ROOT_PATH . 'includes/navbar.php'; ?>
<?php include ROOT_PATH . 'includes/sidebar.php'; ?>
<?php include ROOT_PATH . 'database.php'; ?>

<div class="main-content">
    <div class="container-fluid">

        <!-- Header Row -->
        <div class="d-flex justify-content-between align-items-start mt-1">
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
                    <select name="shifts" id="shiftFilter" class="form-select mb-1" required>
                        <option value="all" selected>Select Shifts</option>
                        <?php 
                            $query = $connection->query("SELECT id, name FROM shifts ORDER BY name");
                            foreach ($query as $emp) echo "<option value='{$emp['name']}'>{$emp['name']}</option>";
                        ?>
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

                <tbody id="assignmentTable">

                <?php
                    $query = $connection->query("
                        SELECT es.*, e.name AS employee_name,s.name AS shift_name
                        FROM employee_shifts es
                        JOIN employees e ON es.employee_id = e.id
                        JOIN shifts s ON es.shift_id = s.id
                        ORDER BY es.id DESC
                    ");

                    foreach ($query as $es){
                    ?>
                    <tr>
                        <td><?= $es['id'] ?></td>
                        <td><?= $es['employee_name'] ?></td>
                        <td><span class="badge bg-success-subtle text-success"><?= $es['shift_name'] ?></span></td>
                        <td><?= date("d-m-Y", strtotime($es['effective_from'])) ?></td>
                        <td><?= date("d-m-Y", strtotime($es['effective_to'])) ?></td>
                        <td><span class="badge bg-success">Active</span></td>
                        <td>
                        <button class="btn btn-outline-primary btn-sm edit-btn"
                            data-id="<?= $es['id'] ?>"
                            data-employee="<?= $es['employee_id'] ?>"
                            data-shift="<?= $es['shift_id'] ?>"
                            data-from="<?= $es['effective_from'] ?>"
                            data-to="<?= $es['effective_to'] ?>">
                            <i class="bi bi-pencil"></i>
                        </button>


                        <button class="btn btn-outline-danger btn-sm delete-btn"
                                data-id="<?= $es['id'] ?>"
                                data-name="<?= $es['employee_name'] . ' - ' . $es['shift_name'] ?>">
                            <i class="bi bi-trash"></i>
                        </button>

                        </td>
                    </tr>

                <?php } ?>

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

                    <form action="add_assignments.php" method="POST">
                        <div class="modal-body">

                            <div class="d-flex justify-content-between align-items-center">
                                <label class="form-label">Employee *</label>
                                <span class="error-message text-danger small d-none"></span>
                            </div>
                            <select name="employee" class="form-select mb-3"
                                    data-required="true" data-error="Please select an employee">
                                <option value="">Select employee</option>
                                <?php 
                                    $query = $connection->query("SELECT id, name FROM employees ORDER BY name");
                                    foreach ($query as $emp) echo "<option value='{$emp['id']}'>{$emp['name']}</option>";
                                ?>
                            </select>


                            <div class="d-flex justify-content-between align-items-center">
                                <label class="form-label">Shift *</label>
                                <span class="error-message text-danger small d-none"></span>
                            </div>
                            <select name="shift" class="form-select mb-3"
                                    data-required="true" data-error="Please select a shift">
                                <option value="">Select shift</option>
                                <?php 
                                    $query = $connection->query("SELECT id, name FROM shifts ORDER BY name");
                                    foreach ($query as $shift) echo "<option value='{$shift['id']}'>{$shift['name']}</option>";
                                ?>
                            </select>


                            <div class="row">

                                <div class="col-md-6">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label class="form-label">Effective From *</label>
                                        <span class="error-message text-danger small d-none"></span>
                                    </div>
                                    <input type="date" name="effective_from"
                                        class="form-control mb-3"
                                        data-required="true"
                                        data-error="Effective From date is required">
                                </div>

                                <div class="col-md-6">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label class="form-label">Effective To *</label>
                                        <span class="error-message text-danger small d-none"></span>
                                    </div>
                                    <input type="date" name="effective_to"
                                        data-required="true"
                                        data-error="Effective To date is required"
                                        class="form-control mb-3">
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

        <!-- EDIT MODAL -->
        <div class="modal fade" id="editAssignmentModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Assignment</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <form action="edit_assignment.php" method="POST">

                    <div class="modal-body">

                        <input type="hidden" name="id" id="editId">

                        <div class="d-flex justify-content-between align-items-center">
                            <label class="form-label">Employee *</label>
                            <span class="error-message text-danger small d-none"></span>
                        </div>
                        <select name="employee" id="editEmployee" class="form-select mb-3"
                                data-required="true" data-error="Please select an employee">
                            <option value="">Select employee</option>
                            <?php 
                            $query = $connection->query("SELECT id, name FROM employees ORDER BY name");
                            foreach ($query as $emp) echo "<option value='{$emp['id']}'>{$emp['name']}</option>";
                            ?>
                        </select>


                        <div class="d-flex justify-content-between align-items-center">
                            <label class="form-label">Shift *</label>
                            <span class="error-message text-danger small d-none"></span>
                        </div>
                        <select name="shift" id="editShift" class="form-select mb-3"
                                data-required="true" data-error="Please select a shift">
                            <option value="">Select shift</option>
                            <?php 
                            $query = $connection->query("SELECT id, name FROM shifts ORDER BY name");
                            foreach ($query as $sh) echo "<option value='{$sh['id']}'>{$sh['name']}</option>";
                            ?>
                        </select>


                        <div class="row">
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label class="form-label">Effective From *</label>
                                    <span class="error-message text-danger small d-none"></span>
                                </div>
                                <input type="date" name="effective_from" id="editFrom"
                                    class="form-control mb-3"
                                    data-required="true" data-error="Effective From date is required">
                            </div>

                            <div class="col-md-6">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label class="form-label">Effective To</label>
                                    <span class="error-message text-danger small d-none"></span>
                                </div>
                                <input type="date" name="effective_to" id="editTo"
                                    class="form-control mb-3" data-required="true" data-error="Effective To date is required">
                            </div>
                        </div>


                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
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

                    <form action="delete_assignments.php" method="POST">
                        <div class="modal-body">

                            <input type="hidden" name="id" id="deleteAssignId">

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
    document.querySelectorAll(".edit-btn").forEach(btn => {
        btn.onclick = () => {
            document.getElementById("editId").value = btn.dataset.id;
            document.getElementById("editEmployee").value = btn.dataset.employee;
            document.getElementById("editShift").value = btn.dataset.shift;
            document.getElementById("editFrom").value = btn.dataset.from;
            document.getElementById("editTo").value = btn.dataset.to;

            new bootstrap.Modal(document.getElementById("editAssignmentModal")).show();
        };
    });
    document.querySelectorAll(".delete-btn").forEach(btn => {
        btn.addEventListener("click", () => {
            document.getElementById("deleteAssignId").value = btn.dataset.id;
            document.getElementById("deleteAssignName").innerText = btn.dataset.name;

            new bootstrap.Modal(document.getElementById("deleteAssignmentModal")).show();
        });
    });

    const shiftFilter = document.getElementById("shiftFilter");
    const assignRows = document.querySelectorAll("#assignmentTable tr");

    function filterAssignments() {
        const selectedShift = shiftFilter.value.toLowerCase();

        assignRows.forEach(row => {
            const shiftName = row.querySelector("td:nth-child(3)").innerText.toLowerCase();

            const match =
                selectedShift === "all" ||
                shiftName.includes(selectedShift);

            row.style.display = match ? "" : "none";
        });
    }

    shiftFilter.addEventListener("change", filterAssignments);

</script>
