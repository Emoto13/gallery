# Authors:

Emilian Spasov FN. 62617
Harut Partamian FN. 62560

# WEB Gallery

This is an image gallery project for the FMI WEB course.
The main idea is to have a web page with user registration and login. Each user is able to save his images on the page.
There are options for uploading images, splitting images into albums (also automatically on some criteria), merging albums, and deleting images/albums.

# Project content

The project folder contains code and documentation(in ProjectDocumentation.docx).
The project is in a client-server style. The client folder holds client-side files like html, js and css. The server folder holds server-side logic and the images folder with already uploaded images.

# Prerequisites

- Installed XAMPP
- Pull this repo

# Restore DB from the web_gallery.sql script

1. Get to the root dir of mysql in your command prompt
2. Login to MySQL (ex. mysql -u root -p)
3. source {path_to_web_gallery.sql}

# Run project

Open {your_project_root_folder}/client/index.php in XAMPP with running Apache and MySQL

# Speifications on uploading an image

1. Hash the image content
2. Check whether the hash is present on the server. For the check -> we have an image_map.json file storing the info in {image_hash: path_to_image} format

3.1. If image content is absent, upload the file to the server and take the path from the newly uploaded.
Parse the metadata so that we can give the information to the Image model
Create an Image and ImageInstance with the expected data

3.2. If image content is present, take the image path from the JSON by the hash key
Get the image that has this path. Create a new ImageInstance with FK to this Image.
Increase number_instances of the Image.

# Test User credentials:

username: test_user
password: password123

# Setup

1. Install MySQL from the official website [more info here](https://dev.mysql.com/doc/refman/8.0/en/installing.html)
2. Install XAMPP from the official website [more info here](https://www.apachefriends.org/download.html)
3. Run SQL server and Apache server from XAMPP
4. Clone this repository into (XAMPP directory)/htdocs
5. Source "web_gallery.sql" into your MySQL instance. (You might need to update "config.php" accordin to your instance e.g username, password etc.)
6. Open http://localhost/gallery/client/index.php and you should be able to see the project in your browser