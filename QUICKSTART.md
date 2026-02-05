# Quick Start Guide

Get the Order Management System up and running in 5 minutes!

## Prerequisites

- Docker Desktop installed and running
- Git (optional, if cloning from repository)

## Steps

### 1. Get the Code

If cloning from repository:
```bash
git clone <repository-url>
cd order-management-system
```

If you have the files locally, just navigate to the directory:
```bash
cd order-management-system
```

### 2. Start the Application

```bash
docker-compose up -d --build
```

Wait for containers to start (approximately 1-2 minutes).

### 3. Install Dependencies

```bash
docker-compose exec php composer install
```

### 4. Setup Database

```bash
docker-compose exec php php bin/console doctrine:migrations:migrate --no-interaction
```

### 5. Access the Application

Open your browser and go to:
```
http://localhost:8080
```

## First Steps

### Create Your First Order

1. Click "Create Order" button
2. Fill in order details:
   - Order Number: `ORD-001`
   - Customer Code: `CUST-001`
   - Customer Name: `John Doe`
3. Add products using "Add Product" button:
   - Product Code: `PROD-001`
   - Product Name: `Sample Product`
   - Price: `29.99`
   - Quantity: `2`
4. Click "Create Order"

### View Orders

- Click "Orders" in the navigation
- Use filters to search orders
- Click on any order to view details

### Edit an Order

- Open an order
- Click "Edit" button
- Modify fields
- Click "Update Order"

### Print an Order

- Open an order
- Click "Print" button
- Use your browser's print function

## API Usage

### List Orders
```bash
curl http://localhost:8080/api/orders
```

### Create Order via API
```bash
curl -X POST http://localhost:8080/api/orders \
  -H "Content-Type: application/json" \
  -d '{
    "orderNumber": "API-001",
    "customerCode": "CUST-API",
    "customerName": "API Customer",
    "products": [{
      "productCode": "PROD-001",
      "productName": "API Product",
      "price": "99.99",
      "quantity": 1
    }]
  }'
```

## Stopping the Application

```bash
docker-compose down
```

To stop and remove all data (including database):
```bash
docker-compose down -v
```

## Troubleshooting

### Port Already in Use

Edit `docker-compose.yml` and change ports:
```yaml
nginx:
  ports:
    - "8081:80"  # Change from 8080 to 8081
```

### Database Connection Failed

```bash
docker-compose restart database
docker-compose exec php php bin/console doctrine:migrations:migrate --no-interaction
```

### Clear Cache

```bash
docker-compose exec php php bin/console cache:clear
```

## Next Steps

- Read the full [README.md](README.md) for detailed documentation
- Check [API_DOCUMENTATION.md](API_DOCUMENTATION.md) for API reference
- Run tests: `docker-compose exec php composer test`
- Check code quality: `docker-compose exec php composer lint`

## Getting Help

If you encounter issues:
1. Check container logs: `docker-compose logs`
2. Verify containers are running: `docker-compose ps`
3. Restart containers: `docker-compose restart`
4. Review troubleshooting section in README.md

## Default Credentials

No authentication is required for this application.

## Default Ports

- Web Application: 8080
- MySQL Database: 3307 (external access)

Enjoy using the Order Management System!
