CREATE TABLE
    ministries (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        description TEXT NOT NULL,
        address VARCHAR(255) NOT NULL,
        logo VARCHAR(255)
    );

CREATE TABLE
    units (
        id INT AUTO_INCREMENT PRIMARY KEY,
        ministry_id INT NOT NULL,
        name VARCHAR(255) NOT NULL,
        description TEXT NOT NULL,
        address VARCHAR(255) NOT NULL,
        FOREIGN KEY (ministry_id) REFERENCES ministries (id) ON DELETE CASCADE
    );

-- Assuming 'users' table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    categ_id INT,
    FOREIGN KEY (categ_id) REFERENCES privileges(categ_id)
);

-- Assuming 'privileges' table
CREATE TABLE privileges (
    categ_id INT AUTO_INCREMENT PRIMARY KEY,
    categ_name VARCHAR(255) NOT NULL
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
        psno varchar(20),
        association_id INT,
        join_date DATE,
        exit_date DATE,
        is_active BOOLEAN DEFAULT TRUE,
        FOREIGN KEY (psno) REFERENCES staff_infor (staff_id),
        FOREIGN KEY (association_id) REFERENCES Association (association_id)
    );

CREATE TABLE banks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    bank_name VARCHAR(255) NOT NULL,
    sort_code VARCHAR(50) NOT NULL
);

CREATE TABLE privileges (
    categ_id INT AUTO_INCREMENT PRIMARY KEY,
    categ_name VARCHAR(255) NOT NULL
);