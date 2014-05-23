<?php

require_once("postConfig.php"); // be sure to point this to the location of your postConfig.php file
$database = DB_NAME;
$sql = array();
$sql[] = "USE $database;";
$sql[] = "DROP TABLE IF EXISTS `posts`;";
$sql[] = "CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `body` text,
  `author` varchar(255) DEFAULT NULL,
  `tags` varchar(2040) DEFAULT NULL,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_posted` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=latin1;";
$sql[] = "DROP TABLE IF EXISTS `users`;";
$sql[] = "CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(64) NOT NULL,
  `lastname` varchar(64) NOT NULL,
  `username` varchar(64) NOT NULL,
  `password` varchar(32) NOT NULL,
  `email` varchar(64) NOT NULL,
  `class` varchar(32) NOT NULL,
  `commentsNotification` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;";
$sql[] = "DROP TABLE IF EXISTS `comments`;";
$sql[] = "CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `body` text,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_posted` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `userid` int(11) NOT NULL,
  `postid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  KEY `postid` (`postid`),
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `users` (`id`),
  CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`postid`) REFERENCES `posts` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=latin1;";

$sql[] = "DROP TABLE IF EXISTS `portfolio`;";
$sql[] = "CREATE TABLE `portfolio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `body` text,
  `categories` varchar(2040) DEFAULT NULL,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_posted` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `priority` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;";

$sql[] = "DROP TABLE IF EXISTS `portfolioimage`;";
$sql[] = "CREATE TABLE `portfolioimage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `imageurl` text,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_posted` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `portfolioid` int(11) NOT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  KEY `portfolioimage_ibfk_1` (`portfolioid`)
) ENGINE=InnoDB AUTO_INCREMENT=133 DEFAULT CHARSET=latin1;";

$sql[] = "DROP TABLE IF EXISTS `pages`;";
$sql[] = "CREATE TABLE `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_posted` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `body` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;";

$sql[] = "INSERT INTO users (firstname,lastname,username,email,password,commentsNotification,class) VALUES ('Post','Administrator','admin','admin@example.com','admin',1,'Administrator');";

echo "Attempting to create database, ".DB_NAME."...<br/>";

$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
if (!$link) {
    die('Could not connect: ' . mysql_error());
}

$createdb = 'CREATE DATABASE '.DB_NAME.';';
if (mysql_query($createdb, $link)) {
    echo "Database ".DB_NAME." created successfully...<br/>";
} else {
    echo 'Error creating database: ' . mysql_error() . "<br/>";
	die;
}

foreach ($sql as $query){
	if (mysql_query($query, $link)) {
	    echo "...<br/>";
	} else {
	    echo 'Error building database: ' . mysql_error() . "<br/>";
		die;
	}
}

mysql_close($link);


echo "Success!";

?>