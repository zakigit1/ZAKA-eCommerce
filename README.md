<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://github.com/zakigit1/ZAKA-eCommerce/blob/main/public/static_images/Screenshot_2025-01-21_210140-removebg-preview.png" width="400" alt="Laravel Logo"></a></p>



<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# ZAKA-eCommerce

ZAKA-eCommerce is a robust multi-vendor e-commerce platform built with Laravel, designed to facilitate seamless online transactions between vendors and customers. This platform empowers multiple vendors to manage their products and sales within a unified system, providing a comprehensive solution for online marketplaces.

## Table of Contents

- [Project Overview](#project-overview)
- [Features](#features)
- [Screenshots](#screenshots)
- [Prerequisites and Installation](#prerequisites-and-installation)
- [Development Setup](#development-setup)
- [Directory Structure](#directory-structure)
- [Contributing Guidelines](#contributing-guidelines)
- [Troubleshooting](#troubleshooting)
- [License Information](#license-information)
- [Contact and Support](#contact-and-support)

## Project Overview

ZAKA-eCommerce is developed using the Laravel framework, adhering to the Model-View-Controller (MVC) architecture. The frontend is crafted with Laravel's Blade templating system, ensuring a clean separation of concerns and facilitating maintainable code.

**Tech Stack:**

- **Backend Framework:** Laravel 9.x
- **PHP Version:** 8.1 or higher
- **Database:** MySQL 5.7 or higher
- **Frontend:** Blade templating engine
- **Package Management:** Composer for PHP dependencies, NPM for frontend assets

## Features

- **Vendor Management:** Allows multiple vendors to register, manage their profiles, and oversee their product listings.
- **Product Management:** Vendors can perform CRUD (Create, Read, Update, Delete) operations on their products, including setting prices, descriptions, and stock levels.
- **User Roles and Permissions:** Differentiated access levels for administrators, vendors, and customers, ensuring secure and appropriate access to platform features.
- **Shopping Cart Functionality:** Customers can add products to a cart, modify quantities, and proceed to checkout seamlessly.
- **Order Management System:** Comprehensive order tracking for both vendors and customers, including order status updates and history.
- **Payment Gateway Integration:** Supports multiple payment gateways, including PayPal and Stripe, for secure transactions.
- **Responsive Design:** Optimized for desktops, tablets, and mobile devices to ensure a consistent user experience across all platforms.

## Screenshots

![Dashboard](screenshots/dashboard.png)
*Admin Dashboard Overview*

![Product Listings](screenshots/product_listings.png)
*Vendor Product Listings*

![Vendor Portal](screenshots/vendor_portal.png)
*Vendor Management Interface*

![User Journey](screenshots/user_journey.png)
*Customer Shopping Experience*

## Prerequisites and Installation

**Prerequisites:**

- **PHP:** Ensure PHP 8.1 or higher is installed.
- **Composer:** PHP dependency manager.
- **Node.js and NPM:** For managing frontend assets.
- **Database:** MySQL 5.7 or higher.

**Installation Steps:**

1. **Clone the Repository:**

   ```bash
   git clone https://github.com/zakigit1/ZAKA-eCommerce.git
   ```

2. **Navigate to the Project Directory:**

   ```bash
   cd ZAKA-eCommerce
   ```

3. **Install PHP Dependencies:**

   ```bash
   composer install
   ```

4. **Install Frontend Dependencies:**

   ```bash
   npm install
   ```

5. **Copy and Configure Environment Variables:**

   ```bash
   cp .env.example .env
   ```

   Update the `.env` file with your database credentials and other necessary configurations.

6. **Generate Application Key:**

   ```bash
   php artisan key:generate
   ```

7. **Run Database Migrations and Seeders:**

   ```bash
   php artisan migrate --seed
   ```

## Development Setup

1. **Compile Assets:**

   ```bash
   npm run dev
   ```

2. **Start Development Server:**

   ```bash
   php artisan serve
   ```

3. **Access the Application:**

   Open your browser and navigate to `http://localhost:8000`.

## Directory Structure

- **`app/`**: Contains the core application code, including models, controllers, and services.
- **`resources/views/`**: Blade templates for the frontend.
- **`routes/`**: Application route definitions.
- **`public/`**: Publicly accessible files, including assets.
- **`database/`**: Migrations and seeders for database setup.

## Contributing Guidelines

We welcome contributions to enhance ZAKA-eCommerce. Please adhere to the following guidelines:

- **Coding Standards:** Follow PSR-12 coding standards.
- **Best Practices:** Adhere to Laravel's best practices for development.
- **Pull Requests:** Ensure your PRs are descriptive and reference any relevant issues.
- **Development Workflow:** Use feature branches and ensure all tests pass before submitting a PR.

## Troubleshooting

- **Common Issues:**
  - Ensure all dependencies are correctly installed.
  - Verify environment variables are properly configured.
  - Check file permissions, especially for the `storage/` and `bootstrap/cache/` directories.

- **Debugging Tips:**
  - Enable debugging in the `.env` file by setting `APP_DEBUG=true`.
  - Review the Laravel logs located in `storage/logs/laravel.log` for error details.

## License Information

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for more details. 
