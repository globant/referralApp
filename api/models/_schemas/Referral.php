<?php
return 'CREATE TABLE IF NOT EXISTS `referral` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(80) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `linkedin` VARCHAR(80),
    `portfolio` VARCHAR(100),
    `technology` VARCHAR(100) NOT NULL,
    `eid` INT(11) NOT NULL,
    `country` VARCHAR(100) NOT NULL,
    `city` VARCHAR(100) NOT NULL,
    `whyGoodReferral` VARCHAR(100),
    `cv_path` VARCHAR(100),
    PRIMARY KEY (`id`)
);';