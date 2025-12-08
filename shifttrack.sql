CREATE DATABASE IF NOT EXISTS shifttrack;
USE shifttrack;

CREATE TABLE departments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) UNIQUE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    phone VARCHAR(20),
    department_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (department_id) REFERENCES departments(id)
        ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE shifts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) UNIQUE NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    grace_minutes INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE employee_shifts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id INT NOT NULL,
    shift_id INT NOT NULL,
    effective_from DATE NOT NULL,
    effective_to DATE NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (employee_id) REFERENCES employees(id)
        ON DELETE CASCADE ON UPDATE CASCADE,

    FOREIGN KEY (shift_id) REFERENCES shifts(id)
        ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE attendance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id INT NOT NULL,
    date DATE NOT NULL,
    check_in TIME NULL,
    check_out TIME NULL,
    status ENUM('Present', 'Absent', 'On Leave', 'Half Day') NOT NULL DEFAULT 'Absent',
    late_minutes INT DEFAULT 0,
    overtime_minutes INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (employee_id) REFERENCES employees(id)
        ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE holidays (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date DATE UNIQUE NOT NULL,
    name VARCHAR(150) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE attendance_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    attendance_id INT NOT NULL,
    action ENUM('check_in', 'check_out', 'manual_edit') NOT NULL,
    time TIME NOT NULL,
    note TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (attendance_id) REFERENCES attendance(id)
        ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO departments (name) VALUES
('Human Resources'),
('Engineering'),
('Marketing'),
('Finance'),
('Operations');

INSERT INTO shifts (name, start_time, end_time, grace_minutes) VALUES
('Morning', '09:00:00', '17:00:00', 10),
('Evening', '14:00:00', '22:00:00', 5),
('Night', '22:00:00', '06:00:00', 0);

INSERT INTO employees (name, email, phone, department_id) VALUES
('John Doe', 'john@example.com', '9991112222', 1),
('Aarav Patel', 'aarav@example.com', '8882223333', 2),
('Priya Shah', 'priya@example.com', '7773334444', 3),
('Riya Mehta', 'riya@example.com', '6664445555', 2),
('Karan Desai', 'karan@example.com', '9995557777', 4),
('Nisha Singh', 'nisha@example.com', '8886661111', 1),
('Raj Malhotra', 'raj@example.com', '9007708800', 5),
('Mohan Kumar', 'mohan@example.com', '9090909090', 2),
('Sonal Jain', 'sonal@example.com', '7775556666', 3),
('Ankit Verma', 'ankit@example.com', '7008009001', 5);

INSERT INTO employee_shifts (employee_id, shift_id, effective_from) VALUES
(1, 1, '2025-01-01'),
(2, 2, '2025-01-05'),
(3, 1, '2025-01-03'),
(4, 3, '2025-01-02'),
(5, 1, '2025-01-01');

INSERT INTO holidays (date, name) VALUES
('2025-01-26', 'Republic Day'),
('2025-03-08', 'Women Day');

INSERT INTO attendance (employee_id, date, check_in, check_out, status, late_minutes, overtime_minutes)
VALUES
(1, '2025-01-10', '09:05:00', '17:30:00', 'Present', 5, 30),
(2, '2025-01-10', '14:10:00', '22:10:00', 'Present', 10, 10),
(3, '2025-01-10', NULL, NULL, 'Absent', 0, 0);
