
# Pizza Order System

This web application allows users to place online orders for pizza. It is built using the Laravel framework.

## Features

- Browse menu items and prices
- User authentication and authorization system
- Add items to cart and place order
- View order history
- Manageable User Information
- Admin panel to manage menu and view order statistics


## Prerequisites

- PHP >= 8.0
- MySQL
- Composer
## Installation

1. Clone the repository: `git clone https://github.com/Piccolo27/pizza-order-system.git`

2. Navigate to the project directory: `cd pizza-order-system`

3. Install dependencies: `composer install`

4. Copy the example environment file and set the correct database credentials: `cp .env.example .env`

5. Generate an application key: `php artisan key:generate`

6. Run the database migrations: `php artisan migrate`

7. If you want to load sample data, run the seeders: `php artisan db:seed`
    
## Usage

1. Start the development server: `php artisan serve`

2. Navigate to `http://localhost:8000` in your browser
## Admin Panel

To access the admin panel, go to `http://localhost:8000/loginPage` and log in with the following credentials:

- Email: `admin@gmail.com`
- Password: `admin123`
## Build With

- Laravel - A PHP Web Framework
- MySQL - A relational database management system
- Bootstrap - A CSS framework for styling and layout
- Jquery - A JavaScript Library