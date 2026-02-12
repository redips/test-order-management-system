# Order Management System

A comprehensive web application for order management built with Symfony backend and Twig templates with HTML, CSS, and JavaScript frontend. This application allows users to create, view, modify, delete orders, and generate printable order summaries.
This is just a little demo project as test for a job interview, it's not intended to be complete in any part, it just shows the use of some OOP
and good practices and patterns.  
You should be crazy using this software in production, anyway I must warn that the project is just a try and is not intended to be a finished app,
DO NOT USE IT IN PRODUCTION!!! 😅

## Features

- **CRUD Operations**: Complete Create, Read, Update, Delete functionality for orders
- **RESTful API**: Well-structured REST API endpoints for all order operations
- **Search & Filter**: Advanced filtering by customer code, customer name, order number, and date range
- **Responsive UI**: Clean, intuitive Bootstrap 5 based user interface
- **Dockerized**: Fully containerized with Docker Compose
- **Tested**: Unit and integration tests for backend and frontend
- **Code Quality**: Linting with PHP CS Fixer for code consistency
- **Design Patterns**: MVC, Repository pattern, SOLID principles

## Technology Stack

### Backend

- **Framework**: Symfony 7.4
- **Database**: MariaDB 10.11
- **ORM**: Doctrine ORM
- **Testing**: PHPUnit 10.5
- **Code Quality**: PHP CS Fixer

### Frontend

- **Templates**: Twig
- **CSS Framework**: Bootstrap 5.3
- **Icons**: Bootstrap Icons
- **JavaScript**: Vanilla JS (ES6+)

### Infrastructure

- **Containerization**: Docker & Docker Compose, having some issues with Docker compose in my local PC I used DDEV
- **Web Server**: Nginx
- **PHP**: PHP 8.2-FPM

## Prerequisites

- Docker Desktop (or Docker Engine + Docker Compose)
- Git
- Minimum 4GB RAM available for Docker

## Installation & Setup

### 1. Clone the Repository

```bash
git clone <repository-url>
cd order-management-system
```

### 2. Build and Start Docker Containers

```bash
docker-compose up -d --build
```

but if you are ok with DDEV, you can use:

```bash
ddev start
```

This will start three containers:

- `order_management_php` - PHP 8.2-FPM
- `order_management_nginx` - Nginx web server
- `order_management_db` - MySQL 8.0 database

### 3. Install Dependencies

```bash
docker-compose exec php composer install
```

or with DDEV:

```bash
ddev composer install
```

### 4. Run Database Migrations

```bash
docker-compose exec php php bin/console doctrine:migrations:migrate --no-interaction
```

or with DDEV:

```bash
ddev exec bin/console doctrine:migrations:migrate --no-interaction
```

### 5. Access the Application

Open your browser and navigate to:

- **Web Interface**: http://localhost:8080
- **API Base URL**: http://localhost:8080/api

## Project Structure

```shell
order-management-system/
├── config/                 # Symfony configuration files
│   ├── packages/          # Bundle configurations
│   ├── routes.yaml        # Routing configuration
│   └── services.yaml      # Service container configuration
├── docker/                # Docker configuration
│   ├── nginx/            # Nginx configuration
│   └── php/              # PHP Dockerfile
├── migrations/           # Database migrations
├── public/              # Public web directory
│   └── index.php        # Application entry point
├── src/
│   ├── Controller/      # Controllers
│   │   ├── Api/        # API Controllers
│   │   └── OrderController.php  # Web Controllers
│   ├── Entity/         # Doctrine entities
│   │   ├── Order.php
│   │   └── OrderProduct.php
│   ├── Repository/     # Doctrine repositories
│   │   ├── OrderRepository.php
│   │   └── OrderProductRepository.php
│   └── Kernel.php      # Symfony kernel
├── templates/          # Twig templates
│   ├── base.html.twig
│   └── order/         # Order templates
│       ├── index.html.twig
│       ├── create.html.twig
│       ├── show.html.twig
│       ├── edit.html.twig
│       └── print.html.twig
├── tests/             # Test files
│   ├── Controller/    # Controller tests
│   └── Repository/    # Repository tests
├── .env               # Environment variables
├── .php-cs-fixer.php  # PHP CS Fixer configuration
├── composer.json      # PHP dependencies
├── docker-compose.yml # Docker Compose configuration
├── phpunit.xml.dist   # PHPUnit configuration
└── README.md          # This file
```

## Database Schema

### Order Table

- `id` (INT, PRIMARY KEY, AUTO_INCREMENT)
- `order_number` (VARCHAR, UNIQUE)
- `customer_code` (VARCHAR)
- `customer_name` (VARCHAR)
- `created_at` (TIMESTAMP)

### Order_Product Table

- `id` (INT, PRIMARY KEY, AUTO_INCREMENT)
- `order_id` (INT, FOREIGN KEY → Order.id)
- `product_code` (VARCHAR)
- `product_name` (VARCHAR)
- `price` (DECIMAL 10,2)
- `quantity` (INT)
- `created_at` (TIMESTAMP)

## API Documentation

Base URL: `http://localhost:8080/api`

### Endpoints

#### 1. List All Orders

```http
GET /api/orders
```

**Query Parameters:**

- `customerCode` (optional) - Filter by customer code
- `customerName` (optional) - Filter by customer name
- `orderNumber` (optional) - Filter by order number
- `dateFrom` (optional) - Filter orders from date (YYYY-MM-DD)
- `dateTo` (optional) - Filter orders to date (YYYY-MM-DD)

**Response Example:**

```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "orderNumber": "ORD-2024-001",
      "customerCode": "CUST001",
      "customerName": "John Doe",
      "createdAt": "2024-02-05 10:30:00",
      "totalAmount": 159.98,
      "products": [
        {
          "id": 1,
          "productCode": "PROD001",
          "productName": "Product Name",
          "price": "79.99",
          "quantity": 2,
          "subtotal": 159.98
        }
      ]
    }
  ]
}
```

#### 2. Get Single Order

```http
GET /api/orders/{id}
```

**Response Example:**

```json
{
  "success": true,
  "data": {
    "id": 1,
    "orderNumber": "ORD-2024-001",
    "customerCode": "CUST001",
    "customerName": "John Doe",
    "createdAt": "2024-02-05 10:30:00",
    "totalAmount": 159.98,
    "products": [...]
  }
}
```

#### 3. Create Order

```http
POST /api/orders
Content-Type: application/json
```

**Request Body:**

```json
{
  "orderNumber": "ORD-2024-001",
  "customerCode": "CUST001",
  "customerName": "John Doe",
  "products": [
    {
      "productCode": "PROD001",
      "productName": "Product Name",
      "price": "79.99",
      "quantity": 2
    }
  ]
}
```

**Response Example:**

```json
{
  "success": true,
  "message": "Order created successfully",
  "data": {
    "id": 1,
    "orderNumber": "ORD-2024-001",
    ...
  }
}
```

#### 4. Update Order

```http
PUT /api/orders/{id}
Content-Type: application/json
```

**Request Body:** Same as Create Order

**Response Example:**

```json
{
  "success": true,
  "message": "Order updated successfully",
  "data": {...}
}
```

#### 5. Delete Order

```http
DELETE /api/orders/{id}
```

**Response Example:**

```json
{
  "success": true,
  "message": "Order deleted successfully"
}
```

### Error Responses

All endpoints return consistent error responses:

```json
{
  "success": false,
  "message": "Error description",
  "errors": ["Validation error 1", "Validation error 2"]
}
```

**HTTP Status Codes:**

- `200` - Success
- `201` - Created
- `400` - Bad Request (validation errors)
- `404` - Not Found
- `500` - Internal Server Error

## Running Tests

### Run All Tests

```bash
docker-compose exec php composer test
```

### Run Specific Test Suite

```bash
# Repository tests
docker-compose exec php php bin/phpunit tests/Repository

# API Controller tests
docker-compose exec php php bin/phpunit tests/Controller/Api
```

### Run with Coverage (requires Xdebug)

```bash
docker-compose exec php php bin/phpunit --coverage-html coverage
```

## Code Quality

### Run Linter (Dry Run)

```bash
docker-compose exec php composer lint
```

### Fix Code Style Issues

```bash
docker-compose exec php composer lint:fix
```

### Linting Rules

The project follows:

- PSR-12 coding standards
- Symfony coding standards
- Custom rules defined in `.php-cs-fixer.php`

## Development Commands

### Access PHP Container

```bash
docker-compose exec php bash
```

### Access MySQL Database

```bash
docker-compose exec database mysql -u symfony -psymfony order_management
```

### Clear Symfony Cache

```bash
docker-compose exec php php bin/console cache:clear
```

### Create New Migration

```bash
docker-compose exec php php bin/console make:migration
```

### View Logs

```bash
# All containers
docker-compose logs -f

# Specific container
docker-compose logs -f php
docker-compose logs -f nginx
docker-compose logs -f database
```

## Design Patterns Used

### 1. **MVC (Model-View-Controller)**

- **Models**: Entity classes (Order, OrderProduct)
- **Views**: Twig templates
- **Controllers**: OrderController, OrderApiController

### 2. **Repository Pattern**

- Encapsulates data access logic
- `OrderRepository` and `OrderProductRepository`
- Custom query methods for filtering

### 3. **Dependency Injection**

- Symfony's service container
- Constructor injection for all dependencies
- Auto-wiring enabled

### 4. **SOLID Principles**

**Single Responsibility Principle:**

- Separate controllers for web and API
- Dedicated repositories for data access
- Entity classes focused on data representation

**Open/Closed Principle:**

- Extendable through inheritance and interfaces
- Repository pattern allows easy extension

**Liskov Substitution Principle:**

- All repositories extend `ServiceEntityRepository`
- Consistent interface contracts

**Interface Segregation Principle:**

- Focused, specific interfaces
- No fat interfaces

**Dependency Inversion Principle:**

- Depend on abstractions (interfaces)
- High-level modules don't depend on low-level modules

## Troubleshooting

### Port Conflicts

If ports 8080 or 3307 are already in use:

Edit `docker-compose.yml`:

```yaml
nginx:
  ports:
    - "8081:80"  # Change 8080 to another port

database:
  ports:
    - "3308:3306"  # Change 3307 to another port
```

### Database Connection Issues

```bash
# Restart database container
docker-compose restart database

# Check database logs
docker-compose logs database
```

### Permission Issues

```bash
# Fix permissions
docker-compose exec php chown -R www-data:www-data var/
docker-compose exec php chmod -R 777 var/
```

## License

This project is licensed under the MIT License.

## Support

For issues and questions:

- Create an issue in the repository
- Contact the development team

## Acknowledgments

- Symfony Framework
- Bootstrap Team
- Docker Community
