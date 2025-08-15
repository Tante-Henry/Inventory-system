# Inventory System

## Project Purpose
The Inventory System is a web-based application that helps small shops and offices track products, suppliers, and stock levels.
It is built with PHP and MySQL and designed to run on a local XAMPP stack.

## Features
- Manage products, categories, suppliers, and stock transactions.
- Import and export records in CSV format for quick bulk edits.
- WhatsApp integration to send stock alerts or purchase confirmations.
- Language toggle allowing users to switch the interface language.

## XAMPP Setup and Database Import
1. Install [XAMPP](https://www.apachefriends.org/) and start Apache and MySQL from the control panel.
2. Copy this project folder into the `htdocs` directory inside your XAMPP installation.
3. Visit `http://localhost/phpmyadmin` and create a database named `inventory`.
4. Import the SQL dump located at `database/inventory.sql`.
5. Browse to `http://localhost/inventory-system` to access the application.

## Default Admin Credentials
- **Username:** `admin`
- **Password:** `admin123`

## Directory Layout
```
inventory-system/
├── app/            # PHP source code (controllers, models)
├── public/         # Web root containing index.php and assets
├── database/       # SQL dump file
├── storage/        # Uploaded CSVs and temporary files
└── README.md
```

## Starting the Application
1. Ensure Apache and MySQL are running in XAMPP.
2. Navigate to `http://localhost/inventory-system` in your browser.
3. Log in using the default admin credentials.

## Additional Notes
- **CSV Import/Export:** Product and supplier data can be imported or exported as CSV files for backups or bulk updates.
- **WhatsApp Integration:** Use the WhatsApp icon next to an order to prefill a message and send it directly to a contact.
- **Language Toggle:** Select a language from the navigation bar to switch the interface without reloading data.

