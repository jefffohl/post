<?php

/** put global configurations here */

/** The name of the database */
define('DB_NAME', 'DN_NAME');

/** MySQL database username */
define('DB_USER', 'DB_USER');

/** MySQL database password */
define('DB_PASSWORD', 'DB_PASSWORD');

/** MySQL hostname */
define('DB_HOST', 'DB_HOST');

/** Blog Title */
define('BLOG_TITLE', 'BLOG_TITLE');

/** Blog Author */
define('BLOG_AUTHOR', 'BLOG_AUTHOR');

/** Admin Email */
define('ADMIN_EMAIL', 'ADMIN_EMAIL');

/** Smarty template cache directory */
define('SMARTY_CACHE', '/path/to/cache/'); // usually in the /tmp directory

// The path to the application, relative to the document root. Be sure to include a slash '/' at the end of the path.
define('APP_LOCATION', '/path/to/app/');

// The path to the theme, relative to the document root. Be sure to include a slash '/' at the end of the path.
define('THEME_LOCATION', '/theme/');

date_default_timezone_set('America/Los_Angeles');

?>
