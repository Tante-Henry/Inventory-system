# Inventory System

## Project Purpose
The Inventory System is a simple web application for managing items in a small shop or office.
It is built with PHP and MySQL and focuses on basic create, read, update, and delete (CRUD) operations.

## Features
- Create, view, update, and delete items.
- Built with PHP and MySQL.

## Setup
1. Configure your database connection in `config/app.php`.
2. Run the database migrations:
   ```bash
   mysql -u <user> -p < scripts/db_migrations.sql
   ```
3. Seed initial data:
   ```bash
   mysql -u <user> -p < scripts/seeders.sql
   ```
4. Start the development server:
   ```bash
   php -S localhost:8000 -t public
   ```

## Directory Layout
```
inventory-system/
├── app/        # PHP source code
├── assets/     # Frontend assets
├── config/     # Application configuration
├── public/     # Web root
├── scripts/    # SQL scripts for database setup
└── README.md
```

## Starting the Application
Navigate to `http://localhost:8000` in your browser after starting the server.

