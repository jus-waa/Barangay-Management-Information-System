# 🏘️ iBarangay — Barangay Management Information System (BMIS)

**iBarangay** is a web-based platform built by **Bit Builders** that automates day-to-day barangay (village-level local government) operations — from resident record-keeping to official document generation — replacing manual, paper-based workflows.

## Features

- **Role-based account management** — a permissions system (`roles`, `permissions`, `role_permissions`) controls which staff accounts can access which modules
- **Resident information management** — add, edit, search, and paginate through resident records, including household and demographic data
- **Document generation** — generate official barangay documents (e.g. clearances, indigency certificates, residency certificates) as PDFs using FPDF/FPDI, with cost tracking per document type
- **Transaction / print history** — track and review previously generated documents
- **Dashboard & reports** — visual analytics and reporting (via Chart.js) summarizing resident and transaction data
- **Secure authentication** — PHP sessions with hashed passwords (`password_hash` / `password_verify`) and prepared statements to prevent SQL injection
- **Session timeout handling** for idle users on sensitive pages

## Tech Stack

- **Frontend:** HTML, Tailwind CSS, JavaScript (jQuery, AJAX, Chart.js)
- **Backend:** PHP (procedural, PDO for database access)
- **Database:** MySQL
- **PDF Generation:** FPDF / FPDI
- **Build tooling:** esbuild, Tailwind CLI

## Requirements

- [XAMPP](https://www.apachefriends.org/) or an equivalent stack with:
  - Apache
  - PHP 7.4+
  - MySQL / phpMyAdmin
- [Node.js](https://nodejs.org/) (for building Tailwind CSS / bundling JS)

## Project Structure

```
Barangay-Management-Information-System/
├── src/
│   ├── backend/            # PHP backend logic (auth, CRUD, reports, uploads)
│   │   ├── connection.php  # PDO database connection
│   │   ├── login.php / signup.php / logout.php
│   │   ├── add.php / edit.php / delete.php
│   │   ├── pagination.php
│   │   ├── dashboardreport.php
│   │   └── helper.php      # Role-permission checks
│   ├── fpdf/ & fpdi/        # PDF generation libraries
│   ├── documents/           # Document templates
│   ├── dashboard.php
│   ├── residentpage.php
│   ├── generatedocuments.php
│   ├── printhistory.php
│   ├── accountmanagement.php
│   ├── controlpage.php      # Settings
│   └── loginpage.php / signuppage.php
├── frontend/
│   └── login.html
├── img/                     # UI assets and icons
├── script.js                # Shared frontend logic
├── tailwind.config.js
└── package.json
```

## Getting Started

### 1. Clone the repository
```bash
git clone https://github.com/jus-waa/Barangay-Management-Information-System.git
cd Barangay-Management-Information-System
```

### 2. Set up the server environment
Install [XAMPP](https://www.apachefriends.org/) (or equivalent Apache + PHP + MySQL stack) and move the project folder into your `htdocs` directory, or configure Apache to serve it directly.

### 3. Set up the database
- Start Apache and MySQL from your XAMPP/WAMP control panel.
- In phpMyAdmin, create a database named **`db_mis`**.
- Import your schema/data (a SQL dump is not currently included in this repo — you'll need to create the `users`, `roles`, `permissions`, `role_permissions`, and resident/document tables manually, matching the structure referenced in `src/backend/`).

By default, the app connects with:
```php
host: localhost
port: 3306
database: db_mis
user: root
password: (empty)
```
Update `src/backend/connection.php` if your local MySQL setup uses different credentials.

### 4. Install frontend dependencies & build CSS
```bash
npm install
npx tailwindcss -i ./src/input.css -o ./src/output.css --watch
```

### 5. Run the app
Visit the project in your browser via your local Apache server, e.g.:
```
http://localhost/Barangay-Management-Information-System/src/loginpage.php
```

## Security Notes

- Passwords are hashed using PHP's `password_hash()` and verified with `password_verify()`.
- Database queries use PDO prepared statements to guard against SQL injection.
- Access to modules is gated by a role/permission check (`hasPermission()`) rather than relying on the frontend alone.
- ⚠️ The default local database credentials (`root` / empty password) are meant for local development only — use proper credentials and restrict database access in any production deployment.

## Credits

Developed by **Bit Builders**.

## License

This project is licensed under the MIT License. You are free to use, modify, and distribute this software for personal or commercial projects, provided that the original copyright and license notice are included.
