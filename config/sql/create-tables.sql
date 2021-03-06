CREATE TABLE `app_users` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`username` VARCHAR(255),
	`email_address` VARCHAR(255) NOT NULL,
	`password` VARCHAR(50) NOT NULL,
	`created` DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
	`updated` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `email_address` (`email_address`)
);

CREATE TABLE `app_lists` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`list_name` VARCHAR(255) NOT NULL,
	`description` TEXT,
	`created` DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
	`updated` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
	`complete` BOOLEAN DEFAULT 0 NOT NULL,
	`user_id` INT NOT NULL,
	PRIMARY KEY (`id`),
	FOREIGN KEY (`user_id`)
		REFERENCES app_users(`id`)
		ON DELETE CASCADE
);

CREATE TABLE `app_list_items` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`value` VARCHAR(255) NOT NULL,
	`created` DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
	`updated` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
	`active` BOOLEAN DEFAULT 1 NOT NULL,
	`complete` BOOLEAN DEFAULT 0 NOT NULL,
	`deleted` BOOLEAN DEFAULT 0 NOT NULL,
	`list_id` INT NOT NULL,

	PRIMARY KEY (`id`),
	FOREIGN KEY (`list_id`)
		REFERENCES app_lists(`id`)
		ON DELETE CASCADE
);