CREATE TABLE posts(
	id INT NOT NULL AUTO_INCREMENT,
	title VARCHAR(255),
	body TEXT,
	author VARCHAR(255),
	tags VARCHAR(2040),
	date_modified TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	date_posted TIMESTAMP NOT NULL DEFAULT 0,
	CONSTRAINT pk_id PRIMARY KEY (id)
);