ALTER TABLE users CHANGE name firstname VARCHAR(64) NOT NULL;
ALTER TABLE users ADD COLUMN lastname VARCHAR(64);
ALTER TABLE users ADD COLUMN class VARCHAR(32) NOT NULL;
ALTER TABLE users MODIFY COLUMN lastname VARCHAR(64) AFTER firstname;
ALTER TABLE users engine=innodb;
ALTER TABLE posts engine=innodb;

UPDATE users SET lastname='Fohl',class="Administrator" WHERE id=1;