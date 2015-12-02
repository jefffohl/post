CREATE TABLE comments(
	id INT NOT NULL AUTO_INCREMENT,
	body TEXT,
	date_modified TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	date_posted TIMESTAMP NOT NULL DEFAULT 0,
	userid INT NOT NULL,
	postid INT NOT NULL,
	FOREIGN KEY (userid) REFERENCES users(id),
	FOREIGN KEY (postid) REFERENCES posts(id),
	CONSTRAINT pk_id PRIMARY KEY (id)
)
ENGINE = INNODB;