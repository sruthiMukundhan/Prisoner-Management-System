-- Drop existing tables if they exist (clean setup)
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS Visit;
DROP TABLE IF EXISTS Visitor;
DROP TABLE IF EXISTS Commits;
DROP TABLE IF EXISTS Crime;
DROP TABLE IF EXISTS Prisoner;
DROP TABLE IF EXISTS Section;
DROP TABLE IF EXISTS Officer_phone;
DROP TABLE IF EXISTS Officer;
DROP TABLE IF EXISTS Jailor_phone;
DROP TABLE IF EXISTS Deleted_jailors;
DROP TABLE IF EXISTS Lawyer;
DROP TABLE IF EXISTS Jailor;
DROP TABLE IF EXISTS Admin;

SET FOREIGN_KEY_CHECKS = 1;

-- =========================
-- ADMIN
-- =========================
CREATE TABLE Admin(
    Admin_id INT AUTO_INCREMENT PRIMARY KEY,
    Admin_uname VARCHAR(50) NOT NULL,
    Admin_pwd VARCHAR(255) NOT NULL,
    First_name VARCHAR(25) NOT NULL,
    Last_name VARCHAR(25) NOT NULL,
    Email VARCHAR(100),
    Created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =========================
-- JAILOR
-- =========================
CREATE TABLE Jailor(
    Jailor_id INT AUTO_INCREMENT PRIMARY KEY,
    Jailor_uname VARCHAR(50) NOT NULL,
    Jailor_pwd VARCHAR(255) NOT NULL,
    First_name VARCHAR(25) NOT NULL,
    Last_name VARCHAR(25) NOT NULL,
    Email VARCHAR(100),
    Date_of_birth DATE,
    Hire_date DATE,
    Status ENUM('Active','Inactive','Suspended') DEFAULT 'Active',
    Created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE Jailor_phone(
    Jailor_phone VARCHAR(15),
    Jailor_id INT,
    Phone_type ENUM('Primary','Secondary','Emergency') DEFAULT 'Primary',
    FOREIGN KEY (Jailor_id) REFERENCES Jailor(Jailor_id) ON DELETE CASCADE
);

-- =========================
-- LAWYER
-- =========================
CREATE TABLE Lawyer(
    Lawyer_id INT AUTO_INCREMENT PRIMARY KEY,
    Lawyer_uname VARCHAR(50) NOT NULL,
    Lawyer_pwd VARCHAR(255) NOT NULL,
    First_name VARCHAR(50),
    Last_name VARCHAR(50),
    Email VARCHAR(100),
    Phone VARCHAR(15),
    Created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO Lawyer (Lawyer_uname, Lawyer_pwd, First_name, Last_name, Email, Phone)
VALUES ('lawyer1', 'lawyer1', 'Arjun', 'Menon', 'arjun.menon@law.gov.in', '9998887776');

-- =========================
-- OFFICER
-- =========================
CREATE TABLE Officer(
    Officer_id INT AUTO_INCREMENT PRIMARY KEY,
    Officer_uname VARCHAR(50) NOT NULL,
    Officer_pwd VARCHAR(255) NOT NULL,
    First_name VARCHAR(25) NOT NULL,
    Last_name VARCHAR(25) NOT NULL,
    Title VARCHAR(50),
    Date_of_birth DATE,
    Email VARCHAR(100),
    Hire_date DATE,
    Department VARCHAR(50),
    Status ENUM('Active','Inactive','Suspended') DEFAULT 'Active',
    Created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE Officer_phone(
    Officer_phone VARCHAR(15),
    Officer_id INT,
    Phone_type ENUM('Primary','Secondary','Emergency') DEFAULT 'Primary',
    FOREIGN KEY (Officer_id) REFERENCES Officer(Officer_id) ON DELETE CASCADE
);

-- =========================
-- SECTION
-- =========================
CREATE TABLE Section(
    Section_id INT AUTO_INCREMENT PRIMARY KEY,
    Section_name VARCHAR(50),
    Capacity INT DEFAULT 50,
    Current_population INT DEFAULT 0,
    Security_level ENUM('Minimum','Medium','Maximum','Super Maximum') DEFAULT 'Medium',
    Jailor_id INT,
    FOREIGN KEY (Jailor_id) REFERENCES Jailor(Jailor_id) ON DELETE CASCADE
);

-- =========================
-- PRISONER
-- =========================
CREATE TABLE Prisoner(
    Prisoner_id INT AUTO_INCREMENT PRIMARY KEY,
    First_name VARCHAR(25),
    Last_name VARCHAR(25),
    Date_in DATE,
    Dob DATE,
    Height INT,
    Weight INT,
    Date_out DATE,
    Address TEXT,
    Section_id INT,
    Status_inout ENUM('in','out','transferred','released','escaped') DEFAULT 'in',
    Crime_category ENUM('Violent','Non-Violent','Drug-Related','White-Collar','Sexual') DEFAULT 'Non-Violent',
    Risk_level ENUM('Low','Medium','High','Maximum') DEFAULT 'Medium',
    Medical_conditions TEXT,
    Emergency_contact VARCHAR(100),
    FOREIGN KEY (Section_id) REFERENCES Section(Section_id)
);

-- =========================
-- CRIME
-- =========================
CREATE TABLE Crime(
    IPC INT PRIMARY KEY,
    Description TEXT,
    Category VARCHAR(50),
    Severity VARCHAR(50)
);

CREATE TABLE Commits(
    IPC INT,
    Prisoner_id INT,
    Conviction_date DATE,
    Sentence_length_months INT,
    Fine_amount DECIMAL(10,2),
    PRIMARY KEY (IPC, Prisoner_id),
    FOREIGN KEY (IPC) REFERENCES Crime(IPC) ON DELETE CASCADE,
    FOREIGN KEY (Prisoner_id) REFERENCES Prisoner(Prisoner_id) ON DELETE CASCADE
);

-- =========================
-- VISITOR & VISIT
-- =========================
CREATE TABLE Visitor(
    Aadhaar VARCHAR(12) PRIMARY KEY,
    First_name VARCHAR(25),
    Last_name VARCHAR(25),
    Phone VARCHAR(15),
    Email VARCHAR(100),
    Relationship_with_prisoner VARCHAR(50),
    Address TEXT
);

CREATE TABLE Visit(
    Visit_id INT AUTO_INCREMENT PRIMARY KEY,
    Visitor_aadhaar VARCHAR(12),
    Date_visit DATE,
    Time_slot VARCHAR(25),
    Prisoner_id INT,
    Status ENUM('Scheduled','Completed','Cancelled','No-Show') DEFAULT 'Scheduled',
    Notes TEXT,
    FOREIGN KEY (Visitor_aadhaar) REFERENCES Visitor(Aadhaar) ON DELETE CASCADE,
    FOREIGN KEY (Prisoner_id) REFERENCES Prisoner(Prisoner_id) ON DELETE CASCADE
);

-- =========================
-- DEFAULT ADMIN LOGIN
-- =========================
INSERT INTO Admin (Admin_uname, Admin_pwd, First_name, Last_name, Email)
VALUES ('admin', 'password', 'Tuhin', 'Chakrabarty', 'admin@prison.gov.in');