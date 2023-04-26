# PHP-MySQL Docker Compose Example

This project provides a simple example of a web application built using PHP, Apache, and MySQL, all running in Docker containers. The purpose of this project is to demonstrate how to containerize a PHP application with a MySQL database using Docker Compose, as well as provide a starting point for building more complex web applications.

## Requirements

- Docker Engine
- Docker Compose

## Usage

1. Clone this repository to your local machine:

   ```bash
   git clone https://github.com/yourusername/php-apache-and-mysql-example.git
   ```

2. Navigate to the project directory:

   ```bash
   cd php-apache-and-mysql-example
   ```

3. Start the containers:

   ```bash
   docker-compose up -d
   ```

   This command will start the containers in the background. The `-d` flag tells Docker to run the containers in detached mode, which means they will run in the background and not show any output.

4. Open your web browser and go to `http://localhost:8080`. You should see a message that says "Welcome to PHP!".

5. To stop the containers, run the following command:

   ```bash
   docker-compose down
   ```

   This command will stop and remove the containers. Note that any data stored in the `./php` and `./db` directories will still be available on your local machine, as these directories are mounted as volumes in the containers. 

## Initialization

When the MySQL container starts up, it will execute the SQL script or shell script inside `/db/mysql-init/*`. The environment variables defined in the `docker-compose.yml` file will be used to create a new user with the username `myusername`, the password specified in `MYSQL_PASSWORD`, and a database named `book`.

Here's an example SQL script that creates a table named `books` with columns for `id`, `name`, and `price`:

```sql
CREATE TABLE books (
  id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  price DECIMAL(10, 2) NOT NULL,
  PRIMARY KEY (id)
);
```

And here's an example shell script that creates a new user and grants it all privileges on the `book` database:

```sh
#!/bin/bash

mysql -u root -p"$MYSQL_ROOT_PASSWORD" <<EOF
CREATE USER 'myusername'@'%' IDENTIFIED BY '$MYSQL_PASSWORD';
GRANT ALL PRIVILEGES ON book.* TO 'myusername'@'%';
FLUSH PRIVILEGES;
EOF
```

You can put this script in `/db/mysql-init` directory and it will automatically run during the start of the database container.

## Configuration

The PHP application connects to the MySQL database using the following environment variables:

- `DB_HOST`: The hostname of the MySQL container (`db` in this project).
- `DB_USER`: The username of the MySQL user (`myusername` in this project).
- `DB_PASSWORD`: The password of the MySQL user (`mypassword` in this project).
- `DB_NAME`: The name of the MySQL database (`book` in this project).
- `DB_PORT`: The port number of the MySQL container (`3306` in this project).

These environment variables can be set in the `docker-compose.yml` file or in a `.env` file in the project directory.

## Explanation of PHP Example

In the `./php/html` directory, there are two PHP scripts provided as examples for connecting to and initializing the database. These scripts demonstrate how to use environment variables that are already set in the `docker-compose.yml` file to connect to the MySQL container from the PHP container.

### `get_db_example.php`
This script retrieves data from the `books` table in the `book` database and displays it in the browser. It first gets the database connection parameters from the environment variables and creates a connection to the database using the `mysqli_connect()` function. It then runs a SQL query to retrieve all records from the `books` table and displays the results in the browser.

### `init_db_example.php`
This script checks if the `books` table already exists in the `book` database. If it does not, it runs the `init.sql` script to initialize the database with the necessary table and data. Like the previous script, it also gets the database connection parameters from the environment variables and creates a connection to the database using the `mysqli_connect()` function. It then runs a SQL query to check if the `books` table exists and initializes the database if it does not.

The values of the `DB_HOST`, `DB_USER`, `DB_PASSWORD`, `DB_NAME`, and `DB_PORT` environment variables are used in both scripts to connect to the MySQL container. If you need to change the database connection settings, you can modify the values of these environment variables in the `docker-compose.yml` file.

Using these scripts, you can connect your web application to the MySQL container and perform database operations. If you modify any PHP files in the `./php/html` directory, the changes will be reflected in the container at `/var/www/html` and you will see real-time updates in your web application.

## Directory Tree
```markdown
php-apache-and-mysql-example/
├── db                      # Contains files for configuring the MySQL database
│   └── mysql-init         # Contains initialization scripts for the MySQL database
│       ├── example.init_1.sh  # Example script for creating a new MySQL user
│       └── example.init_2.sql # Example script for initializing a new MySQL database
├── docker-compose.yml      # Defines the Docker services for running the PHP, Apache, and MySQL containers
├── LICENSE                 # Contains licensing information for the project
├── php                     # Contains files for configuring the PHP server
│   ├── dockerfile         # Defines the Docker image for the PHP server
│   └── html               # Contains PHP files for serving content
│       ├── get_db_example.php   # Example PHP script for querying the database
│       ├── index.php       # The main index file for the web application
│       ├── init_db_example.php  # Example PHP script for initializing the database
│       └── init.sql        # Example SQL script for initializing the database schema
└── README.md               # Contains documentation for the project
```

## Conclusion

This PHP-MySQL Docker Compose Example project provides a simple starting point for containerizing a PHP application with a MySQL database using Docker Compose. It can be used as a reference for building more complex web applications, or as a tool for learning how to use Docker Compose.