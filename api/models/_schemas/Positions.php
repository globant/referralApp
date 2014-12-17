<?php
return 'CREATE TABLE IF NOT EXISTS `positions` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(48) NOT NULL,
    `location` VARCHAR(48) NOT NULL,
    `seniority` VARCHAR(24) NOT NULL,
    `is_hot` BOOL NOT NULL DEFAULT FALSE,
    PRIMARY KEY (`id`)
);';