<?php include $_SERVER['DOCUMENT_ROOT'] . '/ShiftTrack/config.php';?>
<?php include ROOT_PATH . 'includes/navbar.php'; ?>
<?php include ROOT_PATH . 'includes/sidebar.php'; ?>
<?php include ROOT_PATH . 'database.php'; ?>


<div class="main-content">
    <div class="container-fluid">

        <h3 class="mt-3">Reports</h3>
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
                        <input type="date" class="form-control w-25">
                        <button class="btn btn-primary"><i class="bi bi-bar-chart"></i> Generate Report</button>
                    </div>
                </div>
            </div>

            <!-- Monthly Summary -->
            <div id="monthlyReport" class="report-content">
                <div class="p-3">
                    <h5>Monthly Summary</h5>
                    <p>Select month and generate attendance summary.</p>

                    <div class="row mt-3">
                        <div class="col-md-3">
                            <label>Select Employee</label>
                            <select class="form-select">
                                <option>Abc</option>
                                <option>Xyz</option>
                                <option>dasbhj</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Select Month</label>
                            <input type="month" class="form-control">
                        </div>
                        <div class="col-md-3 mt-4">
                            <button class="btn btn-primary mt-1">Generate Monthly Report</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Department Summary -->
            <div id="departmentReport" class="report-content">
                <div class="p-3">
                    <h5>Department Summary</h5>
                    <p>Select department and month to generate summary.</p>

                    <div class="row mt-3">
                        <div class="col-md-3">
                            <label>Select Department</label>
                            <select class="form-select">
                                <option>Engineering</option>
                                <option>Human Resources</option>
                                <option>Marketing</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Select Month</label>
                            <input type="month" class="form-control">
                        </div>
                        <div class="col-md-3 mt-4">
                            <button class="btn btn-primary mt-1">Generate Report</button>
                        </div>
                    </div>

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
