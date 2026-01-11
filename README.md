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
