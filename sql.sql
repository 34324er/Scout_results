CREATE DATABASE student_management;

USE student_management;

CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    code VARCHAR(50) NOT NULL,
    grade VARCHAR(10) NOT NULL,
    assessment VARCHAR(10) NOT NULL,
    status VARCHAR(50) NOT NULL
);
