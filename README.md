# Prisoner Record Management System

## Description
This is a **Prisoner Record Management System** built with **Laravel**, **Livewire**, and **Alpine.js**. It includes features such as authorization, CRUD operations, an audit trail, and dynamic charts for visualizing data trends. The system is designed to efficiently manage prisoner records with a modern and responsive interface.

## Features
* **Role-based Authorization** for secure access control.
* **CRUD Operations** for prisoner records management.
* **Audit Trail** to monitor system activities.
* **Dynamic Charts** for visualizing prisoner data.
* **Real-time UI Updates** powered by Livewire and Alpine.js.

## Prerequisites
* **PHP** >= 8.0
* **Composer**
* **Laravel >= 10**
* **MySQL** (or another database supported by Laravel)

## Installation
1. **Clone the repository** or **download the ZIP file**:
   ```bash
   git clone https://github.com/yourusername/prisoner-record-management.git
   cd prisoner_record
2. **Copy .env example**
   ```bash
   copy .env.example .env
   cp .env.example .env
3. **Install Composer**
   ```bash
   composer install
4. **Install npm**
   ```bash
   npm install
   npm run build/npm run dev
5. **Generate application key**
   ```bash
   php artisan key:generate
6. **Run migrations to set up the database:**
   ```bash
    php artisan migrate
7. **Run storage:link**
   ```bash
   php artisan storage:link
8. **Start the development server**
   ```bash
   php artisan serve
9. **Click the generated link and then run the site**





## Default Login Details (No need to seed data as it is generated via the public construct in the login controller)
* Email: test@example.com
* Password: Reymart1234

## Usage
* Log in with the admin credentials provided above.
* Manage prisoner records, view audit trails, and analyze data using dynamic charts.
* Manage User and permission with the superadmin role

## Contact
* **Developer**: Reymart A. Calicdan
* **Email**: reymart.calicdan06@gmail.com
* **Github Profile:** https://github.com/Reymart221111
