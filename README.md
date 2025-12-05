**Employee Shift & Attendance Management System**

Overview

This project is a full-featured Employee Shift & Attendance Management System built using Pure PHP (OOP), MySQL, Bootstrap 5, HTML/CSS, and basic JavaScript.
All pages use normal POST/GET requests only

The system enables HR/Admin to manage employees, departments, shift assignments, daily attendance, holidays, and generate monthly reports.
Features

1. Dashboard

Total employees

Total shifts

Today's present/absent count

Pending manual corrections

Weekly attendance overview (static chart)

2. Departments

Add, edit, delete departments

Unique name validation

3. Employees

CRUD operations

Assign department

Validation (unique email, email format)

Employee profile with monthly attendance summary

4. Shifts

Create shift (name, start time, end time, grace minutes)

Overnight shifts supported (e.g., 22:00 → 06:00)

Validation rules: unique name, proper start/end times

5. Shift Assignment

Assign shifts using date ranges

Prevent overlapping date ranges for same employee

Track current active shift

6. Attendance

Manual check-in/check-out (server time)

Manual correction entry

Auto-calculations:

Late minutes

Overtime minutes

Status: Present, Absent, Half Day

Prevent duplicate attendance per date

Prevent checkout earlier than check-in (unless manual override)

7. Holidays

CRUD holidays

Holidays reflected in reports

8. Reports

Daily Attendance Register

Monthly employee summary

Department monthly summary

Export to CSV

9. Search & Filters

Search employees by name, email, phone

Filter attendance by department or shift
