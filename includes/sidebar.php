<div class="sidebar" id="sidebar">

    <div class="sidebar-brand d-flex align-items-center mb-4">
        <img src="<?= ROOT_URL ?>assets/image/ShiftTrack-logo-Transparent.png" alt="Logo" class="sidebar-logo me-2">
        <div>
            <h5 class="mb-0 sidebar-title">ShiftTrack</h5>
            <small class="text-white-50">HR Management</small>
        </div>
    </div>


    <ul class="nav flex-column">

        <li class="nav-item">
            <a href="<?= ROOT_URL ?>dashboard.php" class="nav-link">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </li>

        <li class="nav-item">
            <a href="<?= ROOT_URL ?>department/departments.php" class="nav-link">
                <i class="bi bi-diagram-3"></i> Departments
            </a>
        </li>

        <li class="nav-item">
            <a href="<?= ROOT_URL ?>employee/employees.php" class="nav-link">
                <i class="bi bi-people"></i> Employees
            </a>
        </li>

        <li class="nav-item">
            <a href="<?= ROOT_URL ?>shift/shifts.php" class="nav-link">
                <i class="bi bi-clock-history"></i> Shifts
            </a>
        </li>

        <li class="nav-item">
            <a href="<?= ROOT_URL ?>assignment/assignments.php" class="nav-link">
                <i class="bi bi-card-checklist"></i> Assignments
            </a>
        </li>

        <li class="nav-item">
            <a href="<?= ROOT_URL ?>attendance/attendances.php" class="nav-link">
                <i class="bi bi-calendar-check"></i> Attendance
            </a>
        </li>

        <li class="nav-item">
            <a href="<?= ROOT_URL ?>holiday/holidays.php" class="nav-link">
                <i class="bi bi-calendar-event"></i> Holidays
            </a>
        </li>

        <li class="nav-item">
            <a href="<?= ROOT_URL ?>report/reports.php" class="nav-link">
                <i class="bi bi-bar-chart"></i> Reports
            </a>
        </li>

    </ul>
</div>

<!-- Overlay for mobile -->
<div id="overlay"></div>
