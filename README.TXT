REQUIREMENTS

- Web server (http://www.apache.org), with PHP support
- PHP with mysql support (http://www.php.net http://www.mysql.com)
- Perl with DBI module (ftp://ftp.demon.co.uk/pub/perl/db) (Optional, Required for quests)
- Mysql Server
- Any EqEmu 0.8.0 database

INSTALLATION:
With the Feb 2012 complete overhaul of this tool, the installation instructions are very simple.

1. Unpack the zip file to a location you can access from a browser ( such as /var/www/html/ ).
2. Edit the ../includes/config.php file and fill in your database, host, username, and password information.
3. Edit the config options to your liking.

Note: When setting a user in the config, it is highly recommended that the user only have SELECT priviledges in MySQL.  No other priviledges are required by this tool.

Note 2: Some of the features such as quest data, maps, csv, and others were not tested/adjusted for this revamp and may not work.