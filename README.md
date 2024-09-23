# PHP To-Do List Web Application

A simple PHP web application that allows users to register, log in and manage their personal to-do lists.

## Installation Steps

### 1. Clone/Download the repository

Clone or Download as ZIP this repository to your PC.

### 2. Install PHP/SQL/Composer

Make sure to install:

1. [PHP](https://www.php.net/downloads.php)
2. SQL Database, for instance, [MySQL](https://dev.mysql.com/downloads/installer/).
3. [Composer](https://getcomposer.org/download/) for managing PHP dependencies.

### 3. Create the Database

Create an account for your MySQL DB and CREATE DATABASE ToDo_Example

### 4. Configure Environment Variables

Create and edit a ```.env``` file according to your DB. 
You can take the code form ```.env.example``` file. For example:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ToDo_Example
DB_USERNAME=root
DB_PASSWORD=1234
```
### 5. Migrate the Database

After configuring the ```.env``` file, run the following command to create the necessary tables in your DB:
```bash
php artisan migrate
```

### 6. Serve the Application

Start the PHP server by running:
```bash
php artisan serve
```
This command will launch the server at ```http://127.0.0.1:8000/``` by default.

### 7. Register, Log in, and Use To-Do List

Create a new account, log in into your new account and enjoy your To-Do List :)

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/license/MIT).
