# Authors:

Emilian Spasov FN. 62617
Harut Partamian FN. 62560

# WEB Gallery

This is an image gallery project for the FMI WEB course.

- Install XAMPP
- Pull this repository

# Restore DB from the web_gallery.sql script

1. Get to the root dir of mysql in your command prompt
2. Login to MySQL (ex. mysql -u root -p)
3. source setup_tables.sql

# Run project

Open {your_project_root_folder}/client/index.php in XAMPP with running Apache and MySQL

# Test User credentials:

username: test_user
password: password123

# Setup

1. Install MySQL from the official website [more info here](https://dev.mysql.com/doc/refman/8.0/en/installing.html)
2. Install XAMPP from the official website [more info here](https://www.apachefriends.org/download.html)
3. Run SQL server and Apache server from XAMPP
4. Clone this repository into (XAMPP directory)/htdocs
5. Source "setup_tables.sql" into your MySQL instance. (You might need to update "config.php" according to your instance e.g username, password, image directory etc.)
6. Open http://localhost/gallery/client/index.php and you should be able to see the project in your browser