DROP DATABASE IF EXISTS `db_test_data`;

CREATE DATABASE `db_test_data`;
use `db_test_data`;

DELIMITER // 
CREATE FUNCTION customRand(startValue INT, endValue INT)
	RETURNS INTEGER
begin
	RETURN floor(startValue + rand() * (endValue - startValue));
end;
CREATE PROCEDURE books () 
begin 
	DECLARE i INT DEFAULT 1; 
	WHILE i<=50 DO 
		insert into `books` (`title`) values (CONCAT('Book #',i)); 
	SET i=i+1;
	END WHILE;
end;
CREATE PROCEDURE users () 
begin 
	DECLARE i INT DEFAULT 1; 
	WHILE i<=100 DO 
		insert into `users` (`first_name`, `last_name`, `age`) values (CONCAT('First',i), CONCAT('Last',i), customRand(10,70)); 
	SET i=i+1; 
	END WHILE;
end;
CREATE PROCEDURE user_book () 
begin 
	DECLARE i INT DEFAULT 1; 
	DECLARE end_val INT;
	DECLARE r INT DEFAULT 1; 
	WHILE i<=100 DO
		set end_val = customRand(1,50);
		set r=1;
		WHILE r<=end_val DO
			insert into `users_books` (`user_id`, `book_id`) values (i, r);
		SET r=r+1; 
		END WHILE; 
	SET i=i+1; 
	END WHILE;
end;
//
DELIMITER ;
#DB structure
CREATE TABLE `books` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) not null,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;
CREATE TABLE `users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) not null,
  `last_name` varchar(255) not null,
  `age` int(3) not null,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;
CREATE TABLE `users_books` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) not null,
  `book_id` int(11) not null,
  PRIMARY KEY (`id`),
  INDEX `users_books_user_idx` (`user_id` ASC) ,
  CONSTRAINT `users_books_user_idx`
    FOREIGN KEY (`user_id` )
    REFERENCES `users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  INDEX `users_books_book_idx` (`book_id` ASC) ,
  CONSTRAINT `users_books_book_idx`
    FOREIGN KEY (`book_id` )
    REFERENCES `books` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

call books();
call users();
call user_book();

