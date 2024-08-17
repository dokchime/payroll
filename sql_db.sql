CREATE TABLE
    `ministry_parast` (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        description TEXT NOT NULL,
        address VARCHAR(255) NOT NULL,
        logo VARCHAR(255)
    );

CREATE TABLE
    `units` (
        id INT AUTO_INCREMENT PRIMARY KEY,
        ministry_id INT NOT NULL,
        name VARCHAR(255) NOT NULL,
        description TEXT NOT NULL,
        address VARCHAR(255) NOT NULL,
        FOREIGN KEY (ministry_id) REFERENCES ministries (id) ON DELETE CASCADE
    );

-- Assuming 'users' table
CREATE TABLE
    users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(255) NOT NULL,
        password VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        categ_id INT,
        FOREIGN KEY (categ_id) REFERENCES privileges (categ_id)
    );

-- Assuming 'privileges' table
CREATE TABLE
    privileges (
        categ_id INT AUTO_INCREMENT PRIMARY KEY,
        categ_name VARCHAR(255) NOT NULL
    );

CREATE TABLE
    `salary_structure` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `struct_name` VARCHAR(255) NOT NULL,
        `description` VARCHAR(255) NOT NULL
    );

CREATE TABLE
    association (
        `id` INT PRIMARY KEY AUTO_INCREMENT,
        `name` VARCHAR(100) UNIQUE,
        `description` TEXT,
        `dues_type` ENUM ('fixed', 'percentage'),
        `fixed_amount` DECIMAL(10, 2),
        `percentage_of_gross` DECIMAL(5, 2)
    );

CREATE TABLE
    staff_dues (
        id INT PRIMARY KEY AUTO_INCREMENT,
        staff_id varchar(20),
        association_id INT,
        join_date DATE,
        exit_date DATE,
        is_active BOOLEAN DEFAULT TRUE,
        FOREIGN KEY (psno) REFERENCES staff_infor (staff_id),
        FOREIGN KEY (association_id) REFERENCES Association (association_id)
    );

CREATE TABLE
    banks (
        id INT AUTO_INCREMENT PRIMARY KEY,
        bank_name VARCHAR(255) NOT NULL,
        sort_code VARCHAR(50) NOT NULL
    );

CREATE TABLE
    privileges (
        categ_id INT AUTO_INCREMENT PRIMARY KEY,
        categ_name VARCHAR(255) NOT NULL
    );

CREATE TABLE
    staff_personal_info (
        `id` INT (20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `path` VARCHAR(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
        `sect` INT (10) DEFAULT NULL,
        `acct` VARCHAR(5) COLLATE utf8mb4_general_ci DEFAULT NULL,
        `status` VARCHAR(25) COLLATE utf8mb4_general_ci DEFAULT NULL,
        `subh` INT (10) DEFAULT NULL,
        `staff_id` VARCHAR(20) COLLATE utf8mb4_general_ci NOT NULL,
        `title` VARCHAR(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
        `fullname` VARCHAR(50) NOT NULL,
        `first_name` VARCHAR(25) NOT NULL,
        `middle_name` VARCHAR(25) DEFAULT NULL,
        `surname` VARCHAR(20) NOT NULL,
        `phone_number` VARCHAR(15) DEFAULT NULL,
        `sex` VARCHAR(7) DEFAULT NULL,
        `date_of_birth` VARCHAR(25) DEFAULT NULL,
        `local_govt` INT (20) DEFAULT NULL,
        `state` INT (20) DEFAULT NULL,
        FOREIGN KEY (`local_govt`) REFERENCES `lga` (`id`),
        FOREIGN KEY (`state`) REFERENCES `states` (`state_id`)
    );

CREATE TABLE
    staff_emp_info (
        id INT (20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        staff_id VARCHAR(20) NOT NULL,
        date_of_resign VARCHAR(20) DEFAULT NULL,
        date_of_employment INT (20) DEFAULT NULL,
        rank VARCHAR(20) DEFAULT NULL,
        minist_parast_id INT (250) DEFAULT NULL,
        acc_number VARCHAR(20) DEFAULT NULL,
        grade_level VARCHAR(10) DEFAULT NULL,
        step VARCHAR(10) DEFAULT NULL,
        bank_id INT (10) DEFAULT NULL,
        FOREIGN KEY (`minist_parast_id`) REFERENCES `ministry_parast` (`id`),
        FOREIGN KEY (`bank_id`) REFERENCES `ministry_parast` (`id`)
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;