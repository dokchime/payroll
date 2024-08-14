CREATE TABLE `ministry_parast` (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        description TEXT NOT NULL,
        address VARCHAR(255) NOT NULL,
        logo VARCHAR(255)
);

CREATE TABLE `units` (
        id INT AUTO_INCREMENT PRIMARY KEY,
        ministry_id INT NOT NULL,
        name VARCHAR(255) NOT NULL,
        description TEXT NOT NULL,
        address VARCHAR(255) NOT NULL,
        FOREIGN KEY (ministry_id) REFERENCES ministries (id) ON DELETE CASCADE
    );

CREATE TABLE
    user_tb (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL
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

CREATE TABLE staff_dues (
        id INT PRIMARY KEY AUTO_INCREMENT,
        staff_id varchar(20),
        association_id INT,
        join_date DATE,
        exit_date DATE,
        is_active BOOLEAN DEFAULT TRUE,
        FOREIGN KEY (staff_id) REFERENCES `staff_personal_info` (staff_id),
        FOREIGN KEY (association_id) REFERENCES Association (id)
);

CREATE TABLE states (
    `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `state_name` VARCHAR(100) NOT NULL
);

CREATE TABLE lga (
    `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `lga_name` VARCHAR(100) NOT NULL,
    `state_id` INT(11) NOT NULL,
    FOREIGN KEY (`state_id`) REFERENCES `states` (`id`)
);

CREATE TABLE staff_personal_info (
    `id` INT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `path` VARCHAR(20) NULL,
    `sect` INT(10) NULL,
    `acct` VARCHAR(5) NULL,
    `status` VARCHAR(25) NULL,
    `subh` INT(10) NULL,
    `staff_id` VARCHAR(20) NOT NULL UNIQUE,
    `title` VARCHAR(15) NULL,
    `fullname` VARCHAR(50) NULL,
    `first_name` VARCHAR(25) NULL,
    `middle_name` VARCHAR(25) NULL,
    `surname` VARCHAR(20) NULL,
    `phone_number` VARCHAR(15) NULL,
    `sex` VARCHAR(7) NULL,
    `date_of_birth` VARCHAR(25) NULL,
    `local_govt` INT(20) NULL,
    `state` INT(20) NULL,
    FOREIGN KEY (`state`) REFERENCES `states` (`state_id`),
    FOREIGN KEY (`local_govt`) REFERENCES `lga` (`id`)
);

CREATE TABLE staff_emp_info (
    `id` INT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `staff_id` VARCHAR(20) NOT NULL UNIQUE,
    `date_of_resign` VARCHAR(20) NULL,
    `date_of_employment` INT(20) NULL,
    `rank` VARCHAR(20) NULL,
    `minist_parast_id` INT (250) NULL,
    `acc_number` VARCHAR(20) NULL,
    `grade_level` VARCHAR(10) NULL,
    `step` VARCHAR(10) NULL,
    `bank_id` INT(10) NULL,
    FOREIGN KEY (`staff_id`) REFERENCES `staff_personal_info` (`staff_id`),
    FOREIGN KEY (`minist_parast_id`) REFERENCES `ministry_parast` (`id`),
    FOREIGN KEY (`bank_id`) REFERENCES `pay_point` (`id`)
);


-- CREATE TABLE addon{
--     SA VARCHAR(10) NULL,
--     ARREARS VARCHAR(10) NULL,
--     ACC VARCHAR(20) NULL,
--     SORT VARCHAR(15) NULL,
--     BASIC VARCHAR(15) NULL,
--     NEWBASIC INT(15) NULL,
--     TAX VARCHAR(15) NULL,
--     TAXARR INT(15) NULL,
--     TAXABLE INT(15) NULL,
--     UNION_D VARCHAR(15) NULL,
--     UNION_W VARCHAR(15) NULL,
--     NHIS VARCHAR(15) NULL,
--     UNIONN INT(15) NULL,
--     ARR INT(15) NULL,
--     N_H_F VARCHAR(15) NULL,
--     NHFARR INT(15) NULL,
--     FLOAN VARCHAR(15) NULL,
--     INDUC VARCHAR(25) NULL,
--     HLOAN VARCHAR(15) NULL,
--     ANCOPSS_L_DED VARCHAR(25) NULL,
--     ANCOPSS_LEVY VARCHAR(25) NULL,
--     COEASU_SV VARCHAR(25) NULL,
--     ELOHEM_DUES VARCHAR(25) NULL,
--     IMAN_DUES VARCHAR(25) NULL,
--     MUSLIM_LEVY VARCHAR(10) NULL,
--     NUJ_TSBS VARCHAR(10) NULL,
--     SA_WELF VARCHAR(10) NULL,
--     DEV_LEVY VARCHAR(10) NULL,
--     NVMA_S_DUES VARCHAR(15) NULL,
--     JKDA_COE_DUES VARCHAR(25) NULL,
--     JKDA_DUES VARCHAR(25) NULL,
--     JUDGE_LEVY_DUES VARCHAR(25) NULL,
--     LMPCS VARCHAR(25) NULL,
--     MAGIS_DUES VARCHAR(25) NULL,
--     MDCAN_DUES VARCHAR(25) NULL,
--     MOWRENT_DUES VARCHAR(25) NULL,
--     NMA_DEV_DUES VARCHAR(25) NULL,
--     NMCS_SAVINGS VARCHAR(25) NULL,
--     NURSES_INVESTM VARCHAR(25) NULL,
--     NUT_LEVY VARCHAR(25) NULL,
--     NUT_ENDWELL VARCHAR(25) NULL,
--     NVMA_DUES VARCHAR(25) NULL,
--     PMPS_BOA VARCHAR(25) NULL,
--     PDP_LEV VARCHAR(25) NULL,
--     POL_OFF_DUES VARCHAR(15) NULL,
--     PAMCS VARCHAR(25) NULL,
--     ASUSS_LEVY VARCHAR(25) NULL,
--     ASCSN_RBSS VARCHAR(25) NULL,
--     PASAN VARCHAR(25) NULL,
--     NMA VARCHAR(15) NULL,
--     NUR_SCHEM VARCHAR(15) NULL,
--     NANNM_LEVY VARCHAR(15) NULL,
--     NANNM_LOAN VARCHAR(15) NULL,
--     REFUND INT(15) NULL,
--     TOTDED VARCHAR(15) NULL,
--     TRANS_ALL VARCHAR(15) NULL,
--     LTG VARCHAR(15) NULL,
--     MEAL VARCHAR(15) NULL,
--     UTALL VARCHAR(15) NULL,
--     FURNITURE VARCHAR(15) NULL,
--     DOM VARCHAR(15) NULL,
--     CALL_D VARCHAR(15) NULL,
--     RESEARCH VARCHAR(15) NULL,
--     RENT VARCHAR(15) NULL,
--     F_TRIP VARCHAR(15) NULL,
--     L_SOCIETY VARCHAR(15) NULL,
--     TEACHING VARCHAR(15) NULL,
--     JOURNALS VARCHAR(15) NULL,
--     IND_SUPERV VARCHAR(15) NULL,
--     DRIVER VARCHAR(15) NULL,
--     HAZARD VARCHAR(15) NULL,
--     HAZARD_T VARCHAR(15) NULL,
--     EXAMS VARCHAR(15) NULL,
--     HOM VARCHAR(15) NULL,
--     RESP VARCHAR(15) NULL,
--     P_SUPER VARCHAR(15) NULL,
--     T_PRACT VARCHAR(15) NULL,
--     ENTERTAIN VARCHAR(15) NULL,
--     PA VARCHAR(15) NULL,
--     NEWS_P VARCHAR(15) NULL,
--     MVM VARCHAR(15) NULL,
--     HARDSHIP VARCHAR(15) NULL,
--     CONSTIT VARCHAR(15) NULL,
--     LA VARCHAR(15) NULL,
--     RECESS VARCHAR(15) NULL,
--     MQ VARCHAR(15) NULL,
--     MV VARCHAR(25) NULL,
--     WORDROBE VARCHAR(15) NULL,
--     NETPAY VARCHAR(15) NULL,
--     GROSS VARCHAR(15) NULL,


--     AD VARCHAR(50) NULL,
--     ADP VARCHAR(50) NULL,
--     GRUP VARCHAR(15) NULL,
--     MK VARCHAR(15) NULL,
--     SHIFT VARCHAR(10) NULL,
--     TRUNCAT VARCHAR(5) NULL,
--     INCREM_DT VARCHAR(25) NULL
-- );
