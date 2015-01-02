<?php
return 'CREATE TABLE IF NOT EXISTS `user` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `password` VARCHAR(80) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `points` INT(11),
    `name` VARCHAR(100),
    `lid` INT(11),
    PRIMARY KEY (`id`)
);';