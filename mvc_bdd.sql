SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `mvc_bdd` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ;
USE `mvc_bdd` ;

-- -----------------------------------------------------
-- Table `mvc_bdd`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mvc_bdd`.`users` ;

CREATE  TABLE IF NOT EXISTS `mvc_bdd`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `login` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL ,
  `password` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `mvc_bdd`.`posts`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mvc_bdd`.`posts` ;

CREATE  TABLE IF NOT EXISTS `mvc_bdd`.`posts` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL ,
  `slug` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL ,
  `content` TEXT CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL ,
  `created` DATETIME NULL ,
  `online` INT NULL ,
  `type` INT NULL ,
  `user_id` INT NULL ,
  `postscol` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `mvc_bdd`.`configs`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mvc_bdd`.`configs` ;

CREATE  TABLE IF NOT EXISTS `mvc_bdd`.`configs` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL ,
  `value` TEXT CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
