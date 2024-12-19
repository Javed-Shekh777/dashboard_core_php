<?php
include "db.php";

$studentTable = "student";
$teacherTable = "teacher";
$userTable = "user";
$notification = "notification";




$query1 = "CREATE TABLE IF NOT EXISTS $dbName.$studentTable (
    studentId VARCHAR(12) PRIMARY KEY,
    studentName VARCHAR(40) NOT NULL, 
    fatherName VARCHAR(40) NOT NULL, 
    motherName VARCHAR(20) NOT NULL, 
    dob date NOT NULL,
    gender ENUM('Male', 'Female') DEFAULT 'Male',
    class VARCHAR(50) NOT NULL,
    section VARCHAR(20) NOT NULL DEFAULT 'A',
    email VARCHAR(40) NOT NULL,
    phone VARCHAR(13) NOT NULL,
    address TEXT,
    profileImage VARCHAR(40) NOT NULL,
    email_verified TINYINT(1) DEFAULT 0,
    verification_token VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);";

$query2 = "CREATE TABLE IF NOT EXISTS $dbName.$teacherTable (
    teacherId VARCHAR(12) PRIMARY KEY,
    teacherName VARCHAR(40) NOT NULL, 
    dob date NOT NULL,
    gender ENUM('Male', 'Female') DEFAULT 'Male',
    subject VARCHAR(50) NOT NULL,
    email VARCHAR(40) NOT NULL,
    phone VARCHAR(13) NOT NULL,
    address TEXT,
    profileImage VARCHAR(40),
    certificate VARCHAR(40) NOT NULL,
    education VARCHAR(40) NOT NULL,
    email_verified TINYINT(1) DEFAULT 0,
    verification_token VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);";


$query3 = "CREATE TABLE IF NOT EXISTS $dbName.$userTable (
    userId VARCHAR(12) PRIMARY KEY,
    username VARCHAR(40) NOT NULL, 
    email VARCHAR(40) UNIQUE NOT NULL, 
    password VARCHAR(20) NOT NULL, 
    profileImage VARCHAR(40), 
    role ENUM('student', 'admin','parent','teacher') NOT NULL DEFAULT 'student',
    email_verified TINYINT(1) DEFAULT 0,
    verification_token VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);";


$query4 = "CREATE TABLE IF NOT EXISTS $dbName.$notification (
    id int AUTO_INCREMENT PRIMARY KEY,
    operation VARCHAR(40),
    message VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);";





$result1 = mysqli_query($conn, $query1);
$result2 = mysqli_query($conn, $query2);
$result3 = mysqli_query($conn, $query3);
$result4 = mysqli_query($conn, $query4);
 





if (!$result1 || !$result2 || !$result3 || !$result4) {
    echo $result1 . "</br>" . "Something went wrong while creating table ";
    mysqli_close($conn);
}
