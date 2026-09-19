# Multi-Role Inventory & Order Management REST API

This project is a Laravel REST API for a small e-commerce inventory and order management system.

The project has two types of users:

* Admin
* Customer

Laravel Sanctum is used for authentication and role middleware is used to protect admin and customer routes.

## Features

### Authentication

* Customer registration
* Admin and customer login
* Sanctum token authentication
* Role based access

### Product Management

Admin can:

* Add product
* Update product
* Delete product
* View products

Customer can:

* View all products
* View single product

Product fields include:

* Name
* Description
* Price
* Stock quantity
* Category
* Image

Product images are uploaded using Laravel storage.

### Order Management

Customer can:

* Create an order
* Add one or more products in an order
* View their own orders

When an order is placed:

1. Product stock is checked.
2. If enough stock is available, the order is created.
3. Order total is calculated.
4. Product stock is reduced automatically.
5. Order status is set to `pending`.

If stock is not available, the order is not created.

Admin can view all orders and update order status.

Order status can be:

* pending
* shipped
* delivered
* cancelled
  
## Low Stock Products

An Admin-only API is available to view products with low stock.

```text
GET /api/products/low-stock
```

This API returns products whose available stock is less than **5**.

This endpoint can only be accessed by Admin users.


## Technologies Used

* Laravel
* PHP
* MySQL
* Laravel Sanctum
* Postman

## Setup

First install the project dependencies:

```bash
composer install
```

Create `.env` file from `.env.example` and add the database details.

Then run:

```bash
php artisan key:generate
php artisan migrate
php artisan storage:link
php artisan serve
```

The API will run on:

```text
http://127.0.0.1:8000
```

## API Endpoints

### Authentication

| Method | URL             | Description       |
| ------ | --------------- | ----------------- |
| POST   | `/api/register` | Register customer |
| POST   | `/api/login`    | Login             |

### Products

| Method    | URL                  | Access    |
| --------- | -------------------- | --------- |
| GET       | `/api/products`      | All users |
| GET       | `/api/products/{id}` | All users |
| POST      | `/api/products`      | Admin     |
| PUT/PATCH | `/api/products/{id}` | Admin     |
| DELETE    | `/api/products/{id}` | Admin     |

### Customer Orders

| Method | URL           | Access   |
| ------ | ------------- | -------- |
| POST   | `/api/orders` | Customer |
| GET    | `/api/orders` | Customer |

### Admin Orders

| Method | URL                             | Access |
| ------ | ------------------------------- | ------ |
| GET    | `/api/admin/orders`             | Admin  |
| PATCH  | `/api/admin/orders/{id}/status` | Admin  |

## Authentication

After login, the API returns a token.

For protected APIs, the token is sent in the Authorization header:

```text
Bearer YOUR_TOKEN
```

## Image Upload

Product images are uploaded using `form-data` in Postman.

The image is stored in:

```text
storage/app/public/products
```

The image path is stored in the products table.

## Postman Testing

I tested the API endpoints using Postman.

The Postman collection contains:

### Admin

* Register Admin
* Login Admin
* Create Product
* Update Product
* Delete Product
* View All Orders
* Update Order Status

### Customer

* Register Customer
* Login Customer
* View Products
* View Single Product
* Create Order
* My Orders

The Postman collection is also exported as a JSON file.

# Test Credentials

## Admin

Email: ab@gmail.com
Password: 111

## Project Flow

```text
Register / Login
       |
       v
Sanctum Token
       |
       v
   Role Check
    /       \
 Admin     Customer
   |           |
   v           v
Products    Products
   |           |
   |           v
   |       Create Order
   |           |
   |       Check Stock
   |           |
   |       Reduce Stock
   |           |
   |       Pending Order
   |
   v
View Orders
   |
   v
Update Order Status
```

## Project Structure

Main files used in this project:

```text
app/
 ├── Http/Controllers/
 │    ├── AuthController.php
 │    ├── ProductController.php
 │    └── OrderController.php
 │
 ├── Http/Middleware/
 │    └── RoleMiddleware.php
 │
 └── Models/
      ├── User.php
      ├── Product.php
      ├── Order.php
      └── OrderItem.php

routes/
 └── api.php

database/
 └── migrations/
```

## Author

Abhishek Chauhan
