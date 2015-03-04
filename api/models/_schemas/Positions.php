<?php
return 'CREATE TABLE IF NOT EXISTS `positions` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(48) NOT NULL,
    `lid` INT(11) NOT NULL,
    `sid` INT(11) NOT NULL,
    `is_hot` BOOL NOT NULL DEFAULT FALSE,
    PRIMARY KEY (`id`)
);';