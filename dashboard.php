<?php include './includes/navbar.php'; ?>
<?php include './includes/sidebar.php'; ?>

<div class="main-content">
    <div class="container-fluid">   
        <h3 class="mt-3">Dashboard</h3>
        <p class="text-muted">Welcome back! Here's what's happening today.</p>
        <div class="row g-3">
            <div class="col-md-4 col-lg-2">
                <div class="card stat-card">
                        <div class="card-body text-center">
                            <div class="stat-icon bg-primary-light">
                                <i class="bi bi-people-fill text-primary"></i>
                            </div>
                            <h3>70</h3>
                            <p>Total Employees</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-lg-2">
                    <div class="card stat-card">
                        <div class="card-body text-center">
                            <div class="stat-icon bg-success-light">
                                <i class="bi bi-clock-history text-success"></i>
                            </div>
                            <h3>4</h3>
                            <p>Total Shifts</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-lg-2">
                    <div class="card stat-card">
                        <div class="card-body text-center">
                            <div class="stat-icon bg-green-light">
                                <i class="bi bi-check2-circle text-green"></i>
                            </div>
                            <h3>7</h3>
                            <p>Present Today</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-lg-2">
                    <div class="card stat-card">
                        <div class="card-body text-center">
                            <div class="stat-icon bg-danger-light">
                                <i class="bi bi-x-circle text-danger"></i>
                            </div>
                            <h3>1</h3>
                            <p>Absent Today</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-lg-2">
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
            </div>
        </div>

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
