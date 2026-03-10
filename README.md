# 🐕 Animal Food Management System

*Updated for Laravel 12 and current codebase (March 2026).* 

A comprehensive web-based management system designed for animal food businesses, built with Laravel 12, featuring inventory management, sales tracking, customer management, and comprehensive audit logging.

![Laravel](https://img.shields.io/badge/Laravel-12.x-red?style=flat-square&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2+-blue?style=flat-square&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-orange?style=flat-square&logo=mysql)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.x-blue?style=flat-square&logo=tailwindcss)

## 📋 Table of Contents

- [Features](#-features)
- [System Requirements](#-system-requirements)
- [Installation Guide](#-installation-guide)
- [Configuration](#-configuration)
- [Database Setup](#-database-setup)
- [Default Accounts](#-default-accounts)
- [Usage Guide](#-usage-guide)
- [Module Documentation](#-module-documentation)
- [Troubleshooting](#-troubleshooting)
- [Contributing](#-contributing)
- [License](#-license)

## 🚀 Features

### 📦 **Inventory Management**
- ✅ Product catalog with categories and brands
- ✅ Real-time stock tracking and alerts
- ✅ Expiry date monitoring
- ✅ SKU generation and barcode support
- ✅ Supplier management with contact details
- ✅ Low stock and expiring product alerts
- ✅ Purchase order entry and goods receiving
- ✅ Purchase return processing with approval workflow

### 💰 **Sales & Billing**
- ✅ Point of Sale (POS) system
- ✅ Invoice generation and printing
- ✅ Sales reporting and analytics
- ✅ Customer order tracking
- ✅ Returns and refunds management
- ✅ Sales targets and performance tracking
- ✅ Payment collection and reconciliation
- ✅ Customer dues and statement reports

### 👥 **Customer Management**
- ✅ Customer database with contact information
- ✅ Purchase history tracking
- ✅ Customer segmentation and status management
- ✅ Bulk operations and export functionality
- ✅ Dues, payments and statement generation

### 🏢 **Supplier Management**
- ✅ Supplier database with comprehensive details
- ✅ Contact person management
- ✅ Supplier status and blacklist functionality
- ✅ Tax information and notes
- ✅ Purchase order and return tracking

### 📊 **Reports & Analytics**
- ✅ Sales reports with filtering options
- ✅ Inventory reports and stock analysis
- ✅ Customer behavior analytics
- ✅ Financial reporting
- ✅ Supplier, purchase and payment analytics
- ✅ Custom customer statement and aging reports
- ✅ Export to CSV/PDF formats

### 🔐 **User Management & Security**
- ✅ Role-based access control (Super Admin, Admin, Cashier)
- ✅ User authentication and authorization
- ✅ Password management and security
- ✅ Session management

### 📝 **Audit Logging**
- ✅ Comprehensive activity tracking
- ✅ Change history with before/after values
- ✅ User action monitoring
- ✅ System security and compliance
- ✅ Audit log filtering and export

### 🎨 **Modern UI/UX**
- ✅ Responsive design (Mobile, Tablet, Desktop)
- ✅ Dark/Light mode support
- ✅ Intuitive admin dashboard
- ✅ Real-time notifications
- ✅ Modern Tailwind CSS styling

## 🖥️ System Requirements

### Minimum Requirements
- **PHP**: 8.2 or higher (8.3 recommended)
- **Web Server**: Apache 2.4+ or Nginx 1.18+
- **Database**: MySQL 8.0+ or MariaDB 10.4+
- **Node.js / npm**: Node 18+ and npm 9+ (for building front-end assets)
- **Memory**: 512MB RAM minimum (2GB recommended)
- **Storage**: 1GB free space minimum

### Recommended Requirements
- **PHP**: 8.3
- **Web Server**: Nginx 1.20+
- **Database**: MySQL 8.0+
- **Memory**: 4GB RAM
- **Storage**: 5GB free space
- **SSL Certificate**: For production deployment

### PHP Extensions Required
```
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- Ctype PHP Extension
- JSON PHP Extension
- BCMath PHP Extension
- Fileinfo PHP Extension
- GD Library (for image processing)
```

## 🛠️ Installation Guide

### 1. Clone the Repository

```bash
# Clone the repository
git clone https://github.com/yourusername/animal-food-system.git
cd animal-food-system

# Or download and extract the ZIP file
```

### 2. Install Dependencies

You can run the application locally with the built-in Laravel Sail environment or install the requirements manually.

**With Sail (Docker)**
```bash
# install dependencies and start the container
composer install --ignore-platform-reqs
./vendor/bin/sail up -d

# inside the container
sail npm install
sail npm run dev
sail php artisan migrate --seed
```

**Manual setup**
```bash
# Install PHP dependencies via Composer
composer install

# Install Node.js dependencies
npm install

# Build assets
npm run build
```

### 3. Environment Configuration

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Configure Environment Variables

Edit the `.env` file with your settings:

```env
# Application Settings
APP_NAME="Animal Food Management System"
APP_ENV=production
APP_KEY=base64:your-generated-key
APP_DEBUG=false
APP_URL=http://your-domain.com

# Database Configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=animal_food_db
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Mail Configuration (Optional)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"

# Cache & Session
CACHE_DRIVER=file
SESSION_DRIVER=file
SESSION_LIFETIME=120

# Queue Driver
QUEUE_CONNECTION=sync
```

### 5. Database Setup

```bash
# Create database (MySQL example)
mysql -u root -p
CREATE DATABASE animal_food_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;

# Run migrations
php artisan migrate

# Seed the database with sample data
php artisan db:seed
```

### 6. Storage & Permissions

```bash
# Create storage link
php artisan storage:link

# Set proper permissions (Linux/Mac)
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# For Windows, ensure the web server has write access to:
# - storage/
# - bootstrap/cache/
# - public/storage/
```

### 7. Web Server Configuration

#### Apache Configuration

Create `.htaccess` in the public directory:
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ index.php [QSA,L]
</IfModule>
```

#### Nginx Configuration

```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /path/to/animal-food-system/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

## ⚙️ Configuration

### Application Settings

#### User Roles Configuration
The system supports three user roles:

1. **Super Administrator**: Full system access
2. **Administrator**: Most features except user management
3. **Cashier**: Limited to sales and basic operations

#### Default Settings
```php
// config/app.php - Key settings to review
'timezone' => 'UTC', // Change to your timezone
'locale' => 'en',
'fallback_locale' => 'en',
```

#### Database Configuration
```php
// config/database.php - MySQL optimization
'mysql' => [
    'strict' => true,
    'engine' => 'InnoDB',
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
],
```

## 💾 Database Setup

### Migration Commands

```bash
# Fresh installation
php artisan migrate:fresh --seed

# Step-by-step migration
php artisan migrate
php artisan db:seed

# Reset database (WARNING: This will delete all data)
php artisan migrate:reset
php artisan migrate --seed
```

### Database Structure

The system includes the following main tables:

| Table | Description |
|-------|-------------|
| `users` | System users and authentication |
| `products` | Product catalog and inventory |
| `categories` | Product categories |
| `suppliers` | Supplier information |
| `customers` | Customer database |
| `orders` | Customer orders |
| `order_items` | Order line items |
| `sales` | Sales transactions |
| `inventory_transactions` | Stock movement tracking |
| `audit_logs` | System activity logging |
| `bill_headers` | Invoice headers |
| `sales_targets` | Sales performance targets |

## 👤 Default Accounts

After running the seeders, the following accounts are available (change credentials immediately in production):

### Super Administrator
- **Email**: `admin@example.com`
- **Password**: `password`
- **Role**: Super Administrator

### Administrator (example)
- **Email**: `test@example.com`
- **Password**: `password`
- **Role**: Administrator

### Cashier (example)
- **Email**: `cashier@example.com`
- **Password**: `password`
- **Role**: Cashier

> ⚠️ **Security Notice**: Change these default passwords immediately in production!

## 📖 Usage Guide

### Getting Started

1. **Login**: Access the system at `http://your-domain.com/login`
2. **Dashboard**: View key metrics and system overview
3. **Navigation**: Use the sidebar menu to access different modules

### Quick Start Checklist

#### Initial Setup (Administrator)
- [ ] Change default passwords
- [ ] Add your suppliers
- [ ] Create product categories
- [ ] Add your product inventory
- [ ] Set up user accounts for staff
- [ ] Configure system settings

#### Daily Operations (Cashier)
- [ ] Process customer sales
- [ ] Check stock levels
- [ ] Update inventory when receiving goods
- [ ] Generate daily sales reports

### Navigation Overview

#### Main Sections
1. **Dashboard** - System overview and key metrics
2. **Products** - Inventory management
3. **Sales** - Point of sale and sales management
4. **Orders** - Customer order processing
5. **Customers** - Customer database
6. **Suppliers** - Supplier management
7. **Categories** - Product categorization
8. **Reports** - Analytics and reporting
9. **Billing** - Invoice management
10. **Users** - User account management
11. **Audit Logs** - System activity tracking
12. **Settings** - System configuration

## 📚 Module Documentation

### 🏠 Dashboard Module

The dashboard provides a comprehensive overview of your business:

**Key Metrics Cards:**
- Total sales (today, week, month)
- Product counts and low stock alerts
- Customer statistics
- Recent activities

**Charts & Analytics:**
- Sales trend graphs
- Top-selling products
- Customer activity
- Inventory status

### 📦 Products Module

**Features:**
- Add/Edit/Delete products
- Bulk operations
- Stock management
- Expiry date tracking
- Image uploads
- Category assignment
- Supplier linking

**Product Fields:**
- Name, Description, SKU
- Category and Brand
- Price and Unit
- Stock Quantity
- Expiry Date
- Supplier Information
- Status (Active/Inactive)

**Operations:**
```php
// Adding a product programmatically
$product = Product::create([
    'name' => 'Premium Dog Food',
    'category_id' => 1,
    'price' => 25.99,
    'stock_quantity' => 100,
    'unit' => 'kg',
    'supplier_id' => 1,
    'status' => 'active'
]);
```

### 💰 Sales Module

**Point of Sale Features:**
- Barcode scanning
- Product search
- Customer selection
- Discount application
- Tax calculation
- Multiple payment methods
- Receipt printing

**Sales Workflow:**
1. Select customer (or create new)
2. Add products to cart
3. Apply discounts if applicable
4. Process payment
5. Generate receipt
6. Update inventory

### 👥 Customer Management

**Customer Features:**
- Complete contact information
- Purchase history
- Status management (Active/Inactive)
- Bulk operations
- Export functionality

**Customer Fields:**
- Personal information (Name, Email, Phone)
- Address details
- Purchase history
- Account status
- Notes

### 🏢 Supplier Management

**Supplier Features:**
- Comprehensive supplier database
- Contact person management
- Status and blacklist functionality
- Tax information
- Audit trail

**Supplier Fields:**
- Company information
- Primary and secondary contacts
- Address and tax details
- Status and blacklist flags
- Notes and comments

### 📊 Reports Module

**Available Reports:**
- Sales reports (daily, weekly, monthly)
- Inventory reports
- Customer analytics
- Supplier performance
- Financial summaries

**Report Features:**
- Date range filtering
- Export to CSV/PDF
- Customizable columns
- Visual charts
- Print functionality

### 📝 Audit Logs Module

**Tracking Features:**
- All CRUD operations
- User authentication events
- System configuration changes
- Data modifications with before/after values

**Audit Information:**
- Action type (Created, Updated, Deleted)
- User information
- Timestamp and IP address
- Changed fields with old/new values
- Context and description

**Usage Examples:**
```php
// Manual audit logging
$product->audit('price_updated', 'Product price updated by bulk operation');

// Automatic logging via Auditable trait
$product->update(['price' => 29.99]); // Automatically logged
```

### 🔐 User Management

**User Roles:**
1. **Super Administrator**
   - Full system access
   - User management
   - System configuration
   - All module access

2. **Administrator**
   - Most system features
   - Limited user management
   - Cannot modify super admins

3. **Cashier**
   - Sales operations
   - Basic customer management
   - View-only access to reports

**User Management Features:**
- Role assignment
- Password management
- Account status control
- Activity monitoring

## 🔧 API Documentation

Currently the public API surface is limited. Only a few endpoints exist for authentication and client-side validation. All other functionality is accessed via the web routes described earlier.

### Available Endpoints

#### Authentication
```bash
POST /api/login
{
    "email": "user@example.com",
    "password": "password"
}
```
Returns a Sanctum token which must be supplied in subsequent requests:
```
Authorization: Bearer {token}
```

#### User Info
```bash
GET /api/user
```
Requires `auth:sanctum` middleware.

#### Email Validation
```bash
POST /api/validate-email
{
    "email": "test@example.com"
}
```
Returns JSON indicating whether the email is already taken.

> ⚠️ No dedicated product or sales APIs exist by default; these routes were previously documented but have not been implemented in this codebase. Use the web interface or extend the API if needed.

## 🐛 Troubleshooting

### Common Issues & Solutions

#### 1. Installation Issues

**Issue**: Composer dependencies fail to install
```bash
# Solution: Update Composer and PHP
composer self-update
php -m | grep -E 'openssl|pdo|mbstring'
```

**Issue**: NPM build fails
```bash
# Solution: Clear cache and reinstall
npm cache clean --force
rm -rf node_modules package-lock.json
npm install
npm run build
```

#### 2. Database Issues

**Issue**: Migration fails
```bash
# Check database connection
php artisan tinker
DB::connection()->getPdo();

# Reset migrations if needed
php artisan migrate:rollback --step=5
php artisan migrate
```

**Issue**: Foreign key constraint errors
```bash
# Disable foreign key checks temporarily
php artisan tinker
DB::statement('SET FOREIGN_KEY_CHECKS=0;');
// Run your operations
DB::statement('SET FOREIGN_KEY_CHECKS=1;');
```

#### 3. Permission Issues

**Issue**: Storage permissions (Linux/Mac)
```bash
sudo chown -R www-data:www-data storage bootstrap/cache
chmod -R 755 storage bootstrap/cache
```

**Issue**: Asset loading fails
```bash
# Regenerate storage link
php artisan storage:link --force

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

#### 4. Performance Issues

**Issue**: Slow loading
```bash
# Enable caching
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optimize Composer autoloader
composer install --optimize-autoloader --no-dev
```

### Debug Mode

For development, enable debug mode in `.env`:
```env
APP_DEBUG=true
APP_ENV=local
```

**For production, always set:**
```env
APP_DEBUG=false
APP_ENV=production
```

### Log Files

Check log files for errors:
- `storage/logs/laravel.log`
- Web server error logs
- Database logs

### Performance Optimization

#### For Production:

```bash
# Optimize caching
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optimize Composer
composer install --optimize-autoloader --no-dev

# Enable OPcache in PHP
# Add to php.ini:
opcache.enable=1
opcache.memory_consumption=512
opcache.max_accelerated_files=65406
```

#### Database Optimization:

```sql
-- Add indexes for better performance
CREATE INDEX idx_products_category ON products(category_id);
CREATE INDEX idx_sales_date ON sales(created_at);
CREATE INDEX idx_audit_logs_model ON audit_logs(model_type, model_id);
```

## 🚀 Deployment

### Production Deployment Checklist

- [ ] Set `APP_ENV=production` and `APP_DEBUG=false`
- [ ] Configure production database
- [ ] Set up SSL certificate
- [ ] Configure web server (Apache/Nginx)
- [ ] Set proper file permissions
- [ ] Enable caching
- [ ] Set up backup strategy
- [ ] Configure monitoring
- [ ] Test all functionality
- [ ] Change default passwords

### Backup Strategy

```bash
# Database backup
mysqldump -u username -p animal_food_db > backup_$(date +%Y%m%d).sql

# File backup
tar -czf files_backup_$(date +%Y%m%d).tar.gz storage/ public/storage/

# Automated backup script (add to crontab)
0 2 * * * /path/to/backup-script.sh
```

## 🤝 Contributing

We welcome contributions! Please follow these guidelines:

### Development Setup

1. Fork the repository
2. Create a feature branch: `git checkout -b feature/new-feature`
3. Make your changes
4. Write tests if applicable
5. Run tests: `php artisan test`
6. Commit changes: `git commit -m "Add new feature"`
7. Push to branch: `git push origin feature/new-feature`
8. Create a Pull Request

### Code Standards

- Follow PSR-12 coding standards
- Write meaningful commit messages
- Add comments for complex logic
- Update documentation when needed
- Include tests for new features

### Testing

```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature

# Generate coverage report
php artisan test --coverage
```

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🆘 Support

### Getting Help

1. **Documentation**: Check this README and inline documentation
2. **Issues**: Create an issue on GitHub for bugs
3. **Discussions**: Use GitHub Discussions for questions
4. **Email**: Contact support@yourcompany.com

### Reporting Bugs

When reporting bugs, please include:
- PHP version
- Laravel version
- Database type and version
- Steps to reproduce
- Error messages
- Screenshots if applicable

### Feature Requests

Submit feature requests through GitHub Issues with:
- Clear description of the feature
- Use case explanation
- Expected behavior
- Any mockups or examples

## 🙏 Acknowledgments

- **Laravel Framework**: For the excellent foundation
- **Tailwind CSS**: For the modern UI framework
- **Alpine.js**: For interactive components
- **Chart.js**: For data visualization
- **Contributors**: Thanks to all contributors

## 📚 Additional Resources

### Learning Resources
- [Laravel Documentation](https://laravel.com/docs)
- [PHP Documentation](https://www.php.net/docs.php)
- [MySQL Documentation](https://dev.mysql.com/doc/)
- [Tailwind CSS Documentation](https://tailwindcss.com/docs)

### Recommended Tools
- **IDE**: PhpStorm, VS Code
- **Database**: MySQL Workbench, phpMyAdmin
- **API Testing**: Postman, Insomnia
- **Version Control**: Git, GitHub Desktop

---

<p align="center">
Made with ❤️ for animal food businesses worldwide
</p>

<p align="center">
<strong>Animal Food Management System</strong><br>
Streamlining operations, one transaction at a time.
</p>
"# AnimalFood" 
