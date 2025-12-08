<?php include './includes/navbar.php'; ?>
<?php include './includes/sidebar.php'; ?>

<div class="main-content">
    <div class="container-fluid">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-start mt-3">
            <div>
                <h3>Shifts</h3>
                <p class="text-muted">Configure work shifts and schedules</p>
            </div>

            <button class="btn btn-primary d-flex align-items-center mt-2"
                data-bs-toggle="modal" data-bs-target="#addShiftModal">
                <i class="bi bi-plus-lg me-2"></i> Add Shift
            </button>
        </div>

        <div class="row mt-2 g-3">

            <div class="col-md-4">
                <div class="shift-card p-3">

                    <div class="d-flex justify-content-between">
                        <h5 class="shift-title">Morning</h5>

                        <button class="btn btn-sm btn-light menu-btn" data-bs-toggle="dropdown">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>

                        <ul class="dropdown-menu">
                            <li><button class="dropdown-item edit-btn">Edit</button></li>
                            <li><button class="dropdown-item text-danger delete-btn">Delete</button></li>
                        </ul>
                    </div>

                    <div class="shift-body d-flex justify-content-between align-items-center mt-3">
                        
                        <!-- Start -->
                        <div class="text-center ms-3">
                            <div class="shift-icon start-icon">
                                <i class="bi bi-caret-up-fill"></i>
                            </div>
                            <div class="shift-time">9:00 AM</div>
                            <small class="text-muted">Start</small>
                        </div>

                        <!-- Arrow -->
                        <div class="arrow-icon">
                            <i class="bi bi-arrow-right"></i>
                        </div>

                        <!-- End -->
                        <div class="text-center me-3">
                            <div class="shift-icon end-icon">
                                <i class="bi bi-caret-down-fill"></i>
                            </div>
                            <div class="shift-time">5:00 PM</div>
                            <small class="text-muted">End</small>
                        </div>
                    </div>

                    <div class="grace-box mt-3 d-flex justify-content-between align-items-center">
                        <span>Grace Period</span>
                        <strong>15 minutes</strong>
                    </div>

                </div>
            </div>

        </div>

    </div>
</div>

<!-- ADD SHIFT MODAL -->
<div class="modal fade" id="addShiftModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add Shift</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form method="POST" action="add_shift.php">
                <div class="modal-body">

                    <label class="form-label">Shift Name</label>
                    <input type="text" name="shift_name" class="form-control mb-3" required>

                    <div class="row">
                        <div class="col">
                            <label class="form-label">Start Time</label>
                            <input type="time" name="start_time" class="form-control mb-3" required>
                        </div>

                        <div class="col">
                            <label class="form-label">End Time</label>
                            <input type="time" name="end_time" class="form-control mb-3" required>
                        </div>
                    </div>

                    <label class="form-label">Grace Period (minutes)</label>
                    <input type="number" name="grace_minutes" value="15" class="form-control">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>

            </form>

        </div>
    </div>
</div>

<!-- EDIT SHIFT MODAL -->
<div class="modal fade" id="editShiftModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit Shift</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form method="POST" action="edit_shift.php">
                <div class="modal-body">

                    <input type="hidden" name="id" id="editShiftId">

                    <label class="form-label">Shift Name</label>
                    <input type="text" name="shift_name" id="editShiftName" class="form-control mb-3">

                    <div class="row">
                        <div class="col">
                            <label class="form-label">Start Time</label>
                            <input type="time" name="start_time" id="editStartTime" class="form-control mb-3">
                        </div>
                        <div class="col">
                            <label class="form-label">End Time</label>
                            <input type="time" name="end_time" id="editEndTime" class="form-control mb-3">
                        </div>
                    </div>

                    <label class="form-label">Grace Period (minutes)</label>
                    <input type="number" name="grace_minutes" id="editGrace" class="form-control">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>

            </form>

        </div>
    </div>
</div>

<!-- DELETE CONFIRMATION -->
<div class="modal fade" id="deleteShiftModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title text-danger">Delete Shift</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form method="POST" action="delete_shift.php">
                <div class="modal-body">
                    <input type="hidden" name="delete_id" id="deleteShiftId">
                    <p>Are you sure you want to delete this shift?</p>
                    <p id="deleteShiftName" class="fw-bold text-danger"></p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    document.querySelectorAll(".edit-btn").forEach(btn => {
        btn.onclick = () => {
            document.getElementById("editShiftId").value = btn.dataset.id;
            document.getElementById("editShiftName").value = btn.dataset.name;
            document.getElementById("editStartTime").value = btn.dataset.start;
            document.getElementById("editEndTime").value = btn.dataset.end;
            document.getElementById("editGrace").value = btn.dataset.grace;

            new bootstrap.Modal(document.getElementById("editShiftModal")).show();
        };
    });

    document.querySelectorAll(".delete-btn").forEach(btn => {
        btn.onclick = () => {
            document.getElementById("deleteShiftId").value = btn.dataset.id;
            document.getElementById("deleteShiftName").innerText = btn.dataset.name;

            new bootstrap.Modal(document.getElementById("deleteShiftModal")).show();
        };
    });
</script>
