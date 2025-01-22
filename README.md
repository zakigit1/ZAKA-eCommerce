<div align="center">
  <img src="https://github.com/zakigit1/ZAKA-eCommerce/blob/main/public/static_images/Screenshot_2025-01-21_210140-removebg-preview.png" alt="ZAKA-eCommerce Logo" width="200"/>

  # ZAKA-eCommerce

  [![Laravel Version](https://img.shields.io/badge/Laravel-9.x-red.svg)](https://laravel.com)
  [![PHP Version](https://img.shields.io/badge/PHP-8.1+-blue.svg)](https://php.net)
  [![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)
  [![Contributors](https://img.shields.io/github/contributors/zakigit1/ZAKA-eCommerce)](https://github.com/zakigit1/ZAKA-eCommerce/graphs/contributors)

  A robust multi-vendor e-commerce platform built with Laravel
</div>

## 🚀 Quick Start

```bash
git clone https://github.com/zakigit1/ZAKA-eCommerce.git
cd ZAKA-eCommerce
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

## 🌟 Demo

Experience ZAKA-eCommerce in action at our [live demo](https://demo.zaka-ecommerce.com).

Demo credentials:
- **Admin:** admin@demo.com / password
- **Vendor:** vendor@demo.com / password
- **Customer:** customer@demo.com / password

## 📋 Table of Contents

- [System Requirements](#-system-requirements)
- [Features](#-features)
- [Installation](#-installation)
- [Configuration](#-configuration)
- [Development Setup](#-development-setup)
- [Security](#-security)
- [Testing](#-testing)
- [Deployment](#-deployment)
- [Contributing](#-contributing)
- [Support](#-support)
- [License](#-license)

## 💻 System Requirements

| Requirement | Version |
|------------|---------|
| PHP        | ≥ 8.1   |
| MySQL      | ≥ 5.7   |
| Node.js    | ≥ 14.x  |
| NPM        | ≥ 6.x   |
| Composer   | ≥ 2.0   |

## ✨ Features

- **Vendor Management**
  - Multi-vendor support
  - Individual vendor dashboards
  - Commission management
  - Performance analytics

- **Product Management**
  - CRUD operations
  - Bulk import/export
  - Category management
  - Inventory tracking

- **User Experience**
  - Responsive design
  - Advanced search
  - Shopping cart
  - Wishlist functionality

- **Payment & Orders**
  - Multiple payment gateways
  - Order tracking
  - Invoice generation
  - Refund management

## 📥 Installation

1. **Clone the Repository:**
   ```bash
   git clone https://github.com/zakigit1/ZAKA-eCommerce.git
   ```

2. **Install Dependencies:**
   ```bash
   composer install
   npm install
   ```

3. **Environment Setup:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database Setup:**
   ```bash
   php artisan migrate --seed
   ```

5. **Storage Link:**
   ```bash
   php artisan storage:link
   ```

## ⚙️ Configuration

Key environment variables to configure in `.env`:

```env
APP_URL=http://localhost
DB_DATABASE=zaka_ecommerce
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io

QUEUE_CONNECTION=redis
CACHE_DRIVER=redis

STRIPE_KEY=your_stripe_key
STRIPE_SECRET=your_stripe_secret
```

## 🛠 Development Setup

1. **Compile Assets:**
   ```bash
   npm run dev
   ```

2. **Start Server:**
   ```bash
   php artisan serve
   ```

3. **Watch for Changes:**
   ```bash
   npm run watch
   ```

## 🔒 Security

- XSS Protection
  - HTML Purifier integration
  - Strict CSP policies
- CSRF Protection
  - Auto CSRF token verification
- SQL Injection Prevention
  - Parameterized queries
  - Query builder usage
- Rate Limiting
  - API throttling
  - Login attempt limits
- Regular Security Updates
  - Dependency scanning
  - Automated security patches

## 🧪 Testing

```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature

# Generate code coverage report
php artisan test --coverage-html reports/
```

## 🚀 Deployment

**Production Server Requirements:**
- PHP-FPM
- Nginx/Apache
- Redis (recommended)
- SSL Certificate

**Deployment Steps:**
1. Set up production environment
2. Configure web server
3. Set up SSL
4. Configure caching
5. Set up queue workers

Detailed deployment guide available in our [documentation](docs/deployment.md).

## 👥 Contributing

We welcome contributions! Please see our [Contributing Guide](CONTRIBUTING.md) for details.

**Contribution Steps:**
1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Open a Pull Request

## 🤝 Support

### Community Support
- GitHub Issues
- [Discord Community](https://discord.gg/zaka-ecommerce)
- [Stack Overflow](https://stackoverflow.com/questions/tagged/zaka-ecommerce)

### Commercial Support
For enterprise support and customization, contact us at:
- Email: support@zaka-ecommerce.com
- Website: https://zaka-ecommerce.com/enterprise

## 👨‍💻 Contributors

<div align="center">
  <a href="https://github.com/zakigit1/ZAKA-eCommerce/graphs/contributors">
    <img src="https://contrib.rocks/image?repo=zakigit1/ZAKA-eCommerce" />
  </a>
</div>

Special thanks to all our contributors who help make this project better!

## 📄 License

ZAKA-eCommerce is open-sourced software licensed under the [MIT license](LICENSE).

---

<div align="center">
  <p>Built with ❤️ by the ZAKA-eCommerce Team</p>
  <p>
    <a href="https://zaka-ecommerce.com">Website</a> •
    <a href="https://docs.zaka-ecommerce.com">Documentation</a> •
    <a href="https://twitter.com/ZAKAeCommerce">Twitter</a>
  </p>
</div>
