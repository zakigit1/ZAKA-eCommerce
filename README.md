<div align="center">
  <img src="https://github.com/zakigit1/ZAKA-eCommerce/blob/main/public/static_images/zaka_eco_logo.png" alt="ZAKA-eCommerce Logo" width="200"/>

  # ZAKA-eCommerce

  [![Laravel Version](https://img.shields.io/badge/Laravel-10.x-red.svg)](https://laravel.com)
  [![PHP Version](https://img.shields.io/badge/PHP-8.1+-blue.svg)](https://php.net)
  [![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)
  [![Contributors](https://img.shields.io/github/contributors/zakigit1/ZAKA-eCommerce)](https://github.com/zakigit1/ZAKA-eCommerce/graphs/contributors)

  A robust multi-vendor e-commerce platform built with Laravel
  <img src="https://github.com/zakigit1/ZAKA-eCommerce/blob/main/public/zaka_images/thumbnail/ZAKA-nail.png" alt="ZAKA-eCommerce nail"/>
  <img src="https://github.com/zakigit1/ZAKA-eCommerce/blob/main/public/zaka_images/thumbnail/ZAKA-nail1.png" alt="ZAKA-eCommerce nail1"/>
  <img src="https://github.com/zakigit1/ZAKA-eCommerce/blob/main/public/zaka_images/thumbnail/ZAKA-nail2.png" alt="ZAKA-eCommerce nail2"/>

</div>





## 🚀 Quick Start

```bash
git clone https://github.com/zakigit1/ZAKA-eCommerce.git
cd ZAKA-eCommerce
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```


## 📋 Table of Contents

- [System Requirements](#-system-requirements)
- [Features](#-features)
- [Installation](#-installation)
- [Configuration](#-configuration)
<!-- - [Development Setup](#-development-setup)
- [Security](#-security)
- [Testing](#-testing)
- [Deployment](#-deployment) -->
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

### **🔹 Multi-Vendor System**  
- Full **multi-vendor support** with individual **vendor dashboards**  
- **Commission-based earnings** with flexible rate management  
- **Vendor performance analytics** for sales insights  

### **🔹 Product & Inventory Management**  
- **CRUD operations** for products, categories, and attributes  
- **Bulk product import/export** for easy data migration  
- **Inventory tracking** with stock alerts and management tools  

### **🔹 Seamless User Experience**  
- **Responsive design** for an optimal experience across all devices  
- **Advanced search & filtering** for effortless product discovery  
- **Wishlist & shopping cart functionality** with real-time updates  

### **🔹 Order & Payment Processing**  
- **Multiple payment gateways** integration for secure transactions  
- **Real-time order tracking** for customers and vendors  
- **Automated invoice generation** and multi-currency support  
- **Refund & withdrawal management** with secure processing  

### **🔹 Real-Time Features & Automation**  
- **Live chat system** powered by **Pusher** for instant communication  
- **AJAX-powered interactions** to enhance performance and avoid page reloads  
- **Automated notifications** for orders, payments, and updates  

### **🔹 Admin Dashboard & Control**  
- **Centralized admin panel** for managing vendors, products, and transactions  
- **Detailed reporting & analytics** to monitor sales and platform performance  
- **Blog management system** to enhance SEO and customer engagement  


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
   
6. **Start the Development Server:**
   ```bash
   php artisan serve
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

<!-- 
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
-->

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
- [Stack Overflow](https://stackoverflow.com/questions/tagged/zaka-ecommerce)

<!--
### Commercial Support
For enterprise support and customization, contact us at:
- Email: support@zaka-ecommerce.com
-->

## 👨‍💻 Contributors

<div align="center">
  <a href="https://github.com/zakigit1/ZAKA-eCommerce/graphs/contributors">
    <img src="https://contrib.rocks/image?repo=zakigit1/ZAKA-eCommerce" />
  </a>
</div>

Special thanks to all our contributors who helped make this project better!

## 📄 License

ZAKA-eCommerce is open-sourced software licensed under the [MIT license](LICENSE).

---

<div align="center">
  <p>Built with ❤️ by Mohammed Ilyes Zakaria BOUSBAA</p>
    <!--
  <p>
    <a href="https://zaka-ecommerce.com">Website</a> •
  </p>
    -->
</div>
