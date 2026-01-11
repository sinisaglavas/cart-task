# Simple E-commerce Shopping Cart

A simple e-commerce shopping cart application built with **Laravel 12** and **Livewire**.  
The application allows authenticated users to browse products, manage a persistent shopping cart, place orders, and includes background jobs and scheduled reports.

---

## Features

- User authentication (Laravel Breeze + Livewire)
- Product listing with stock management
- Persistent shopping cart per authenticated user (database-based)
- Add, update, and remove cart items
- Checkout process with order and order items
- Low stock email notification using Laravel Jobs & Queue
- Daily sales report sent via scheduled command (cron)
- Tailwind CSS for basic styling
- Clean and simple Laravel best practices

---

## Tech Stack

- **Backend:** Laravel 12
- **Frontend:** Livewire
- **Styling:** Tailwind CSS
- **Database:** MySQL
- **Queue:** Database queue driver
- **Mail:** Log mailer (for local testing)
- **Version Control:** Git & GitHub

---

## Installation & Setup

### 1. Clone the repository
```bash
git clone <repository-url>
cd cart-task
```
### 2. Install dependencies
```bash
composer install
npm install
npm run build
```
### 3. Configure environment
```bash
cp .env.example .env
php artisan key:generate
```
#### Set your database credentials in .env (example):
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cart_task
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=log
QUEUE_CONNECTION=database
```
### 4. Run migrations & seeders
```bash
php artisan migrate --seed
```
### 5. Run the application
```bash
php artisan serve
```
### Usage
Main pages (authenticated)

- `/products` — browse products and add to cart
- `/cart` — update cart quantities, remove items, and checkout


### Queue: Low Stock Notification

When a product’s stock drops below the configured threshold, a queued job sends an email to the admin (admin@example.com).

### Start the queue worker
```bash
php artisan queue:work
```
### Where to see emails (local)
This project uses MAIL_MAILER=log, so emails are written to:
```pgsql
storage/logs/laravel.log
```
### Scheduler: Daily Sales Report

A scheduled command sends a daily sales report to the admin with:

* products sold that day
* total quantity per product
* total revenue per product

### Run manually
```bash
php artisan report:daily-sales
```
### Test scheduler locally
```bash
php artisan schedule:work
```
In production, Laravel Scheduler should be run via cron (e.g. * * * * * php artisan schedule:run), and the command is scheduled to run every evening.

### Notes

* Emails use the log mailer for local testing.

* The implementation is production-ready and can be switched to SMTP or a mail service provider by changing .env.

### Demo / Walkthrough

A short Loom video walkthrough is provided with the submission, demonstrating:

* product browsing

* cart operations

* checkout flow

* low stock notification (queue)

* daily sales report (command/scheduler)

### Author

Developed by Siniša Glavaš as part of a hiring practical task.
