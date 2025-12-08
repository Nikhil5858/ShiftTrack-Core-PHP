<?php include $_SERVER['DOCUMENT_ROOT'] . '/ShiftTrack/config.php';?>
<?php include ROOT_PATH . 'includes/navbar.php'; ?>
<?php include ROOT_PATH . 'includes/sidebar.php'; ?>
<?php include ROOT_PATH . 'database.php'; ?>


<div class="main-content">
    <div class="container-fluid">

        <!-- Header Row -->
        <div class="d-flex justify-content-between align-items-start mt-3">
            <div>
                <h3>Holidays</h3>
                <p class="text-muted">Manage company holidays and non-working days</p>
            </div>

            <button class="btn btn-primary d-flex align-items-center mt-2"
                data-bs-toggle="modal" data-bs-target="#addHolidayModal">
                <i class="bi bi-plus-lg me-2"></i> Add Holiday
            </button>
        </div>

        <div class="row g-3 mt-3">
    
            <!-- CARD 1 -->
            <div class="col-md-4">
                <div class="card">
                    <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-calendar-week text-primary"></i>
                            <strong>January</strong>
                        </div>
                        <span class="badge bg-light text-dark">1</span>
                    </div>

                    <div class="p-3 d-flex justify-content-between align-items-center">
                        <div>
                            <strong>New Year's Day</strong><br>
                            <small class="text-muted">Wednesday, January 1, 2025</small>
                        </div>

                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-primary btn-sm edit-btn"
                                data-id="1"
                                data-name="New Year's Day"
                                data-date="2025-01-01">
                                <i class="bi bi-pencil"></i>
                            </button>

                            <button class="btn btn-outline-danger btn-sm delete-btn"
                                data-id="1"
                                data-name="New Year's Day">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>


<!-- ADD HOLIDAY MODAL -->
<div class="modal fade" id="addHolidayModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add Holiday</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="add_holiday.php" method="POST">
                <div class="modal-body">

                    <label class="form-label">Holiday Name *</label>
                    <input type="text" name="holiday_name" class="form-control mb-3" required>

                    <label class="form-label">Holiday Date *</label>
                    <input type="date" name="holiday_date" class="form-control mb-3" required>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Holiday</button>
                </div>

            </form>

        </div>
    </div>
</div>


<!-- EDIT HOLIDAY MODAL -->
<div class="modal fade" id="editHolidayModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit Holiday</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="edit_holiday.php" method="POST">
                <div class="modal-body">

                    <input type="hidden" name="edit_id" id="editHolidayId">

                    <label class="form-label">Holiday Name *</label>
                    <input type="text" name="holiday_name" id="editHolidayName" class="form-control mb-3" required>

                    <label class="form-label">Holiday Date *</label>
                    <input type="date" name="holiday_date" id="editHolidayDate" class="form-control mb-3" required>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>

            </form>

        </div>
    </div>
</div>


<!-- DELETE HOLIDAY MODAL -->
<div class="modal fade" id="deleteHolidayModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title text-danger">Delete Holiday</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="delete_holiday.php" method="POST">
                <div class="modal-body">

                    <input type="hidden" name="delete_id" id="deleteHolidayId">

                    <p>Are you sure you want to delete this holiday?</p>
                    <p class="fw-bold text-danger" id="deleteHolidayName"></p>

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
        btn.addEventListener("click", () => {
            document.getElementById("editHolidayId").value = btn.dataset.id;
            document.getElementById("editHolidayName").value = btn.dataset.name;
            document.getElementById("editHolidayDate").value = btn.dataset.date;

            new bootstrap.Modal(document.getElementById("editHolidayModal")).show();
        });
    });

    document.querySelectorAll(".delete-btn").forEach(btn => {
        btn.addEventListener("click", () => {
            document.getElementById("deleteHolidayId").value = btn.dataset.id;
            document.getElementById("deleteHolidayName").innerText = btn.dataset.name;

            new bootstrap.Modal(document.getElementById("deleteHolidayModal")).show();
        });
    });
</script>
