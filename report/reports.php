<?php include $_SERVER['DOCUMENT_ROOT'] . '/ShiftTrack/config.php';?>
<?php include ROOT_PATH . 'includes/navbar.php'; ?>
<?php include ROOT_PATH . 'includes/sidebar.php'; ?>
<?php include ROOT_PATH . 'database.php'; ?>


<div class="main-content">
    <div class="container-fluid">

        <h3 class="mt-1">Reports</h3>
        <p class="text-muted">Generate attendance reports and summaries</p>

        <!-- CARD TABS -->
        <div class="row g-3 mt-3" id="reportTabs">

            <!-- Daily Card -->
            <div class="col-md-4">
                <div class="report-card active" data-target="dailyReport">
                    <div class="icon bg-primary-light"><i class="bi bi-calendar-date"></i></div>
                    <h5 class="mt-2">Daily Attendance</h5>
                    <p class="text-muted small">View attendance for a specific date</p>
                </div>
            </div>

            <!-- Monthly Card -->
            <div class="col-md-4">
                <div class="report-card" data-target="monthlyReport">
                    <div class="icon bg-info-light"><i class="bi bi-calendar3"></i></div>
                    <h5 class="mt-2">Monthly Summary</h5>
                    <p class="text-muted small">Employee's monthly attendance summary</p>
                </div>
            </div>

            <!-- Department Card -->
            <div class="col-md-4">
                <div class="report-card" data-target="departmentReport">
                    <div class="icon bg-success-light"><i class="bi bi-building"></i></div>
                    <h5 class="mt-2">Department Summary</h5>
                    <p class="text-muted small">Monthly summary by department</p>
                </div>
            </div>

        </div>

        <!-- TAB CONTENTS -->
        <div class="card mt-4">

            <!-- Daily Attendance Report -->
            <div id="dailyReport" class="report-content active">
                <div class="p-3">
                    <h5>Daily Attendance Report</h5>
                    <label class="mt-3">Select Date</label>
                    <div class="d-flex gap-3">
                        <form action="generate_daily_report.php" method="POST" class="d-flex align-items-start gap-3">
                            <div class="d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="error-message text-danger small d-none"></span>
                                </div>
                                <input type="date" name="date" class="form-control w-auto" data-required="true" data-error="Please select a date">
                            </div>
                            <button class="btn btn-primary mt-auto">
                                <i class="bi bi-download"></i> Download Excel
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Monthly Summary -->
            <div id="monthlyReport" class="report-content">
                <div class="p-3">
                    <h5>Monthly Summary</h5>
                    <p>Select month and generate attendance summary.</p>

                    <form action="generate_monthly_report.php" method="POST">
                        <div class="row mt-3">

                            <div class="col-md-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label class="form-label ms-1">Select Employee *</label>
                                    <span class="error-message text-danger small d-none"></span>
                                </div>
                                <select name="employee_id" class="form-select mb-3"
                                        data-required="true" data-error="Please select an employee">
                                    <option value="">Select Employee</option>
                                    <?php
                                    $query = $connection->query("SELECT id, name FROM employees ORDER BY name");
                                    foreach ($query as $e) { ?>
                                        <option value="<?= $e['id'] ?>"><?= $e['name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label class="form-label">Select Month *</label>
                                    <span class="error-message text-danger small d-none"></span>
                                </div>
                                <input type="month" name="month" class="form-control mb-3" data-required="true" data-error="Please select a month">
                            </div>

                            <div class="col-md-3 mt-4">
                                <button class="btn btn-primary mt-1">
                                    Generate Monthly Report
                                </button>
                            </div>

                        </div>
                    </form>

                </div>
            </div>


            <!-- Department Summary -->
            <div id="departmentReport" class="report-content">
                <div class="p-3">
                    <h5>Department Summary</h5>
                    <p>Select department and month to generate summary.</p>

                    <form action="generate_department_report.php" method="POST">
                        <div class="row mt-3">

                            <div class="col-md-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label class="form-label ms-1">Select Department *</label>
                                    <span class="error-message text-danger small d-none"></span>
                                </div>
                                <select name="department_id" class="form-select mb-3" data-required="true" data-error="Please select a department">
                                    <option value="">Select Department</option>
                                    <?php 
                                    $query = $connection->query("SELECT id, name FROM departments ORDER BY name");
                                    foreach ($query as $d) { ?>
                                        <option value="<?= $d['id'] ?>"><?= $d['name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label class="form-label">Select Month *</label>
                                    <span class="error-message text-danger small d-none"></span>
                                </div>
                                <input type="month" name="month" class="form-control mb-3" data-required="true" data-error="Please select a month">
                            </div>

                            <div class="col-md-3 mt-4">
                                <button class="btn btn-primary mt-1">
                                    Generate Report
                                </button>
                            </div>

                        </div>
                    </form>


                </div>
            </div>


        </div>

    </div>
</div>
<script>
    document.querySelectorAll(".report-card").forEach(card => {
        card.addEventListener("click", () => {

            // remove active from all cards
            document.querySelectorAll(".report-card").forEach(c => c.classList.remove("active"));
            card.classList.add("active");

            // hide all tab content
            document.querySelectorAll(".report-content").forEach(c => c.classList.remove("active"));

            // show selected content
            const targetId = card.getAttribute("data-target");
            document.getElementById(targetId).classList.add("active");
        });
    });
</script>
