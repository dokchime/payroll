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
        FOREIGN KEY (ministry_id) REFERENCES ministry_parast (id) ON DELETE CASCADE
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
        -- FOREIGN KEY (id) REFERENCES staff_personal_info (staff_id),
        FOREIGN KEY (association_id) REFERENCES association (id)
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
        `state` INT (20) DEFAULT NULL
        /*FOREIGN KEY (`local_govt`) REFERENCES `lga` (`id`),
        FOREIGN KEY (`state`) REFERENCES `states` (`state_id`)*/
    );

CREATE TABLE staff_emp_info (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    staff_id VARCHAR(20) NOT NULL,
    date_of_resign DATE DEFAULT NULL,
    date_of_employment DATE DEFAULT NULL,
    rank VARCHAR(20) DEFAULT NULL,
    minist_parast_id INT DEFAULT NULL,
    acc_number VARCHAR(20) DEFAULT NULL,
    grade_level VARCHAR(10) DEFAULT NULL,
    step VARCHAR(10) DEFAULT NULL,
    bank_id INT DEFAULT NULL,
    INDEX (staff_id),
    FOREIGN KEY (minist_parast_id) REFERENCES ministry_parast(id),
    FOREIGN KEY (bank_id) REFERENCES banks(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- ob-payroll Additions

CREATE TABLE `grade_based_additions` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `year` varchar(15) DEFAULT NULL,
 `month` varchar(15) DEFAULT NULL,
 `salary_structure_grades_id` int(11) DEFAULT NULL,
 `description` varchar(100) DEFAULT NULL,
 `amount` decimal(10,2) DEFAULT NULL,
 `is_active` tinyint(1) DEFAULT 1,
 PRIMARY KEY (`id`),
 KEY `salary_structure_grades_id` (`salary_structure_grades_id`),
 CONSTRAINT `grade_based_additions_ibfk_1` FOREIGN KEY (`salary_structure_grades_id`) REFERENCES `salary_structure_grades` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `grade_based_deductions` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `year` varchar(15) DEFAULT NULL,
 `month` varchar(15) DEFAULT NULL,
 `salary_structure_grades_id` int(11) DEFAULT NULL,
 `description` varchar(100) DEFAULT NULL,
 `amount` decimal(10,2) DEFAULT NULL,
 `is_active` tinyint(1) DEFAULT 1,
 PRIMARY KEY (`id`),
 KEY `salary_structure_grades_id` (`salary_structure_grades_id`),
 CONSTRAINT `grade_based_deductions_ibfk_1` FOREIGN KEY (`salary_structure_grades_id`) REFERENCES `salary_structure_grades` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `individual_based_additions` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `year` varchar(15) DEFAULT NULL,
 `month` varchar(15) DEFAULT NULL,
 `staff_id` varchar(20) DEFAULT NULL,
 `description` varchar(100) DEFAULT NULL,
 `amount` decimal(10,2) DEFAULT NULL,
 `is_active` tinyint(1) DEFAULT 1,
 PRIMARY KEY (`id`),
 KEY `staff_id` (`staff_id`),
 CONSTRAINT `individual_based_additions_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff_emp_info` (`staff_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `individual_based_deductions` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `year` varchar(15) DEFAULT NULL,
 `month` varchar(15) DEFAULT NULL,
 `staff_id` varchar(20) DEFAULT NULL,
 `description` varchar(100) DEFAULT NULL,
 `amount` decimal(10,2) DEFAULT NULL,
 `is_active` tinyint(1) DEFAULT 1,
 PRIMARY KEY (`id`),
 KEY `staff_id` (`staff_id`),
 CONSTRAINT `individual_based_deductions_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff_emp_info` (`staff_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `monthly_salary_schedule` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `year` varchar(15) DEFAULT NULL,
 `month` varchar(15) DEFAULT NULL,
 `salary_structure_grades_id` int(11) DEFAULT NULL,
 `staff_id` varchar(20) DEFAULT NULL,
 `grade_based_additions` varchar(15) DEFAULT NULL,
 `grade_based_deductions` varchar(15) DEFAULT NULL,
 `individual_based_additions` varchar(15) DEFAULT NULL,
 `individual_based_deductions` varchar(15) DEFAULT NULL,
 `net_take_home_pay` varchar(15) DEFAULT NULL,
 `due_date` varchar(15) DEFAULT NULL,
 `is_active` tinyint(1) DEFAULT 1,
 `comment`  varchar(250) DEFAULT NULL,
 PRIMARY KEY (`id`),
 KEY `staff_id` (`staff_id`),
 KEY `salary_structure_grades_id` (`salary_structure_grades_id`),
 CONSTRAINT `monthly_salary_schedule_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff_emp_info` (`staff_id`),
 CONSTRAINT `monthly_salary_schedule_ibfk_2` FOREIGN KEY (`salary_structure_grades_id`) REFERENCES `salary_structure_grades` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `salary_structure_details` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `salary_structure_grades_id` int(11) DEFAULT NULL,
 `annual_basic` varchar(15) DEFAULT NULL,
 `annual_gross` varchar(15) DEFAULT NULL,
 `monthly_basic` varchar(15) DEFAULT NULL,
 `monthly_gross` varchar(15) DEFAULT NULL,
 PRIMARY KEY (`id`),
 KEY `salary_structure_grades_id` (`salary_structure_grades_id`),
 CONSTRAINT `salary_structure_details_ibfk_1` FOREIGN KEY (`salary_structure_grades_id`) REFERENCES `salary_structure_grades` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `salary_structure_grades` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `salary_structure_id` int(11) DEFAULT NULL,
 `grade_level` varchar(10) DEFAULT NULL,
 `step` int(11) DEFAULT NULL,
 PRIMARY KEY (`id`),
 KEY `salary_structure_id` (`salary_structure_id`),
 CONSTRAINT `salary_structure_grades_ibfk_1` FOREIGN KEY (`salary_structure_id`) REFERENCES `salary_structure` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;