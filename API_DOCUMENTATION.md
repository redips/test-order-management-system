# Order Management System - API Documentation

## Overview

This document provides comprehensive documentation for the Order Management System REST API. The API follows RESTful principles and returns JSON responses.

**Base URL**: `http://localhost:8080/api`

**API Version**: 1.0

**Content Type**: `application/json`

## Authentication

Currently, the API does not require authentication. All endpoints are publicly accessible.

## Response Format

All API responses follow a consistent format:

### Success Response
```json
{
  "success": true,
  "data": { ... },
  "message": "Optional success message"
}
```

### Error Response
```json
{
  "success": false,
  "message": "Error description",
  "errors": ["Optional array of validation errors"]
}
```

## HTTP Status Codes

| Code | Description |
|------|-------------|
| 200 | OK - Request successful |
| 201 | Created - Resource created successfully |
| 400 | Bad Request - Invalid request data |
| 404 | Not Found - Resource not found |
| 500 | Internal Server Error - Server error |

## Endpoints

### 1. List Orders

Retrieve a list of all orders with optional filtering.

**Endpoint**: `GET /api/orders`

**Query Parameters**:

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| customerCode | string | No | Filter by customer code (partial match) |
| customerName | string | No | Filter by customer name (partial match) |
| orderNumber | string | No | Filter by order number (partial match) |
| dateFrom | date | No | Filter orders from this date (YYYY-MM-DD) |
| dateTo | date | No | Filter orders until this date (YYYY-MM-DD) |

**Example Request**:
```bash
curl -X GET "http://localhost:8080/api/orders?customerCode=CUST001&dateFrom=2024-01-01"
```

**Success Response** (200 OK):
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "orderNumber": "ORD-2024-001",
      "customerCode": "CUST001",
      "customerName": "Acme Corporation",
      "createdAt": "2024-02-05 10:30:00",
      "totalAmount": 299.98,
      "products": [
        {
          "id": 1,
          "productCode": "LAPTOP-001",
          "productName": "Business Laptop",
          "price": "149.99",
          "quantity": 2,
          "subtotal": 299.98
        }
      ]
    },
    {
      "id": 2,
      "orderNumber": "ORD-2024-002",
      "customerCode": "CUST001",
      "customerName": "Acme Corporation",
      "createdAt": "2024-02-05 14:45:00",
      "totalAmount": 89.99,
      "products": [
        {
          "id": 2,
          "productCode": "MOUSE-001",
          "productName": "Wireless Mouse",
          "price": "29.99",
          "quantity": 3,
          "subtotal": 89.97
        }
      ]
    }
  ]
}
```

---

### 2. Get Order by ID

Retrieve details of a specific order.

**Endpoint**: `GET /api/orders/{id}`

**Path Parameters**:

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| id | integer | Yes | Order ID |

**Example Request**:
```bash
curl -X GET "http://localhost:8080/api/orders/1"
```

**Success Response** (200 OK):
```json
{
  "success": true,
  "data": {
    "id": 1,
    "orderNumber": "ORD-2024-001",
    "customerCode": "CUST001",
    "customerName": "Acme Corporation",
    "createdAt": "2024-02-05 10:30:00",
    "totalAmount": 299.98,
    "products": [
      {
        "id": 1,
        "productCode": "LAPTOP-001",
        "productName": "Business Laptop",
        "price": "149.99",
        "quantity": 2,
        "subtotal": 299.98
      }
    ]
  }
}
```

**Error Response** (404 Not Found):
```json
{
  "success": false,
  "message": "Order not found"
}
```

---

### 3. Create Order

Create a new order with products.

**Endpoint**: `POST /api/orders`

**Headers**:
```
Content-Type: application/json
```

**Request Body**:

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| orderNumber | string | Yes | Unique order number |
| customerCode | string | Yes | Customer code |
| customerName | string | Yes | Customer name |
| products | array | Yes | Array of product objects |
| products[].productCode | string | Yes | Product code |
| products[].productName | string | Yes | Product name |
| products[].price | decimal | Yes | Unit price (must be positive) |
| products[].quantity | integer | Yes | Quantity (must be positive) |

**Example Request**:
```bash
curl -X POST "http://localhost:8080/api/orders" \
  -H "Content-Type: application/json" \
  -d '{
    "orderNumber": "ORD-2024-003",
    "customerCode": "CUST002",
    "customerName": "Tech Solutions Inc",
    "products": [
      {
        "productCode": "LAPTOP-001",
        "productName": "Business Laptop",
        "price": "149.99",
        "quantity": 1
      },
      {
        "productCode": "MOUSE-001",
        "productName": "Wireless Mouse",
        "price": "29.99",
        "quantity": 2
      }
    ]
  }'
```

**Success Response** (201 Created):
```json
{
  "success": true,
  "message": "Order created successfully",
  "data": {
    "id": 3,
    "orderNumber": "ORD-2024-003",
    "customerCode": "CUST002",
    "customerName": "Tech Solutions Inc",
    "createdAt": "2024-02-05 16:20:00",
    "totalAmount": 209.97,
    "products": [
      {
        "id": 3,
        "productCode": "LAPTOP-001",
        "productName": "Business Laptop",
        "price": "149.99",
        "quantity": 1,
        "subtotal": 149.99
      },
      {
        "id": 4,
        "productCode": "MOUSE-001",
        "productName": "Wireless Mouse",
        "price": "29.99",
        "quantity": 2,
        "subtotal": 59.98
      }
    ]
  }
}
```

**Error Response** (400 Bad Request):
```json
{
  "success": false,
  "message": "Validation failed",
  "errors": [
    "Order number is required",
    "Price must be positive"
  ]
}
```

---

### 4. Update Order

Update an existing order.

**Endpoint**: `PUT /api/orders/{id}`

**Path Parameters**:

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| id | integer | Yes | Order ID |

**Headers**:
```
Content-Type: application/json
```

**Request Body**: Same structure as Create Order

**Example Request**:
```bash
curl -X PUT "http://localhost:8080/api/orders/1" \
  -H "Content-Type: application/json" \
  -d '{
    "orderNumber": "ORD-2024-001-UPDATED",
    "customerCode": "CUST001",
    "customerName": "Acme Corporation Ltd",
    "products": [
      {
        "productCode": "LAPTOP-001",
        "productName": "Business Laptop Pro",
        "price": "199.99",
        "quantity": 1
      }
    ]
  }'
```

**Success Response** (200 OK):
```json
{
  "success": true,
  "message": "Order updated successfully",
  "data": {
    "id": 1,
    "orderNumber": "ORD-2024-001-UPDATED",
    "customerCode": "CUST001",
    "customerName": "Acme Corporation Ltd",
    "createdAt": "2024-02-05 10:30:00",
    "totalAmount": 199.99,
    "products": [
      {
        "id": 5,
        "productCode": "LAPTOP-001",
        "productName": "Business Laptop Pro",
        "price": "199.99",
        "quantity": 1,
        "subtotal": 199.99
      }
    ]
  }
}
```

**Error Response** (404 Not Found):
```json
{
  "success": false,
  "message": "Order not found"
}
```

---

### 5. Delete Order

Delete an existing order.

**Endpoint**: `DELETE /api/orders/{id}`

**Path Parameters**:

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| id | integer | Yes | Order ID |

**Example Request**:
```bash
curl -X DELETE "http://localhost:8080/api/orders/1"
```

**Success Response** (200 OK):
```json
{
  "success": true,
  "message": "Order deleted successfully"
}
```

**Error Response** (404 Not Found):
```json
{
  "success": false,
  "message": "Order not found"
}
```

---

## Data Models

### Order Model

```json
{
  "id": "integer (auto-generated)",
  "orderNumber": "string (unique, required)",
  "customerCode": "string (required)",
  "customerName": "string (required)",
  "createdAt": "datetime (auto-generated)",
  "totalAmount": "decimal (calculated)",
  "products": "array of OrderProduct"
}
```

### OrderProduct Model

```json
{
  "id": "integer (auto-generated)",
  "productCode": "string (required)",
  "productName": "string (required)",
  "price": "decimal (required, positive)",
  "quantity": "integer (required, positive)",
  "subtotal": "decimal (calculated: price * quantity)"
}
```

## Validation Rules

### Order
- `orderNumber`: Required, must be unique, max 255 characters
- `customerCode`: Required, max 255 characters
- `customerName`: Required, max 255 characters

### OrderProduct
- `productCode`: Required, max 255 characters
- `productName`: Required, max 255 characters
- `price`: Required, must be positive, decimal (10,2)
- `quantity`: Required, must be positive integer

## Examples

### Creating an Order with Multiple Products

```bash
curl -X POST "http://localhost:8080/api/orders" \
  -H "Content-Type: application/json" \
  -d '{
    "orderNumber": "ORD-2024-100",
    "customerCode": "CUST100",
    "customerName": "Enterprise Client",
    "products": [
      {
        "productCode": "PROD-001",
        "productName": "Product A",
        "price": "99.99",
        "quantity": 5
      },
      {
        "productCode": "PROD-002",
        "productName": "Product B",
        "price": "49.99",
        "quantity": 3
      },
      {
        "productCode": "PROD-003",
        "productName": "Product C",
        "price": "29.99",
        "quantity": 10
      }
    ]
  }'
```

### Filtering Orders by Date Range

```bash
curl -X GET "http://localhost:8080/api/orders?dateFrom=2024-02-01&dateTo=2024-02-28"
```

### Searching Orders by Customer

```bash
curl -X GET "http://localhost:8080/api/orders?customerName=Acme"
```

## Error Handling

The API uses standard HTTP status codes and provides detailed error messages:

- **400 Bad Request**: Invalid input data, validation errors
- **404 Not Found**: Resource does not exist
- **500 Internal Server Error**: Unexpected server error

All error responses include a `success: false` field and a descriptive `message`.

## Rate Limiting

Currently, there is no rate limiting implemented. This may be added in future versions.

## Versioning

The current API version is 1.0. Future versions will be accessible via URL versioning (e.g., `/api/v2/orders`).

## Testing the API

### Using cURL

See example requests throughout this documentation.

### Using Postman

1. Import the collection from the repository
2. Set base URL to `http://localhost:8080/api`
3. Use the predefined requests

### Using JavaScript (Fetch API)

```javascript
// Create order
fetch('http://localhost:8080/api/orders', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json'
  },
  body: JSON.stringify({
    orderNumber: 'ORD-2024-001',
    customerCode: 'CUST001',
    customerName: 'Test Customer',
    products: [
      {
        productCode: 'PROD001',
        productName: 'Test Product',
        price: '29.99',
        quantity: 2
      }
    ]
  })
})
.then(response => response.json())
.then(data => console.log(data));
```

## Support

For issues, questions, or contributions:
- Create an issue in the repository
- Contact the development team
- Review the main README.md for setup instructions

---

**Last Updated**: February 5, 2026  
**API Version**: 1.0
