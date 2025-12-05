<?php include './includes/sidebar.php'; ?>
<?php include './includes/navbar.php'; ?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="main-content">
    <div class="container-fluid">

        <h3 class="mt-3">Dashboard</h3>
        <p class="text-muted">Welcome back! Here's what's happening today.</p>

        <!-- Cards Row -->
        <div class="row g-3">
            <div class="col-md-4 col-lg-2">
                <div class="card stat-card">
                    <div class="card-body text-center">
                        <h3>70</h3>
                        <p>Total Employees</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-2">
                <div class="card stat-card">
                    <div class="card-body text-center">
                        <h3>4</h3>
                        <p>Total Shifts</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-2">
                <div class="card stat-card">
                    <div class="card-body text-center">
                        <h3>7</h3>
                        <p>Present Today</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-2">
                <div class="card stat-card">
                    <div class="card-body text-center">
                        <h3>1</h3>
                        <p>Absent Today</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-2">
                <div class="card stat-card">
                    <div class="card-body text-center">
                        <h3>1</h3>
                        <p>On Leave</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-2">
                <div class="card stat-card">
                    <div class="card-body text-center">
                        <h3>3</h3>
                        <p>Pending Corrections</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Weekly Overview Placeholder -->
        <div class="card mt-4">
            <div class="card-header">
                Weekly Attendance Overview
            </div>
            <div class="card-body">
                <div class="placeholder-chart"></div>
            </div>
        </div>
    </div>
</div>
