## Laravel API with Best Practices
Welcome to the Laravel API repository! This project showcases a robust implementation of a RESTful API using Laravel, adhering to best practices. It features secure authentication with Laravel Sanctum, comprehensive API documentation with OpenAPI/Swagger, and polymorphic relationships for flexible data modeling.

## Features
Laravel Sanctum Authentication: 

Secure authentication for your API using Laravel Sanctum, ensuring safe access to protected routes.

OpenAPI/Swagger Integration: 

Detailed API documentation powered by OpenAPI/Swagger, providing a clear and interactive interface for developers.

Polymorphic Relationships: 

Flexible data modeling with Laravel's polymorphic relationships, allowing Category to belong to both Post and Product models.

Best Practices: 

Follows Laravel's best practices, including:
Clean and organized code structure.
Exception handling and transaction management.
Use of repositories and service classes for better code separation.
Comprehensive API responses.

## Installation
Clone the repository:

`git clone https://github.com/shahzadthathal/laravel-api`

`cd laravel-api`

# Install dependencies:

`composer install`

# Environment setup:

`cp .env.example .env`

`php artisan key:generate`

Configure your database settings in the .env file.
Also update `L5_SWAGGER_CONST_HOST` variable for swagger url if needed.


# Run migrations:

`php artisan migrate --seed`

# Serve the application:

`php artisan serve`

# API Documentation:

Access the interactive API documentation at `/api/swagger`

`http://127.0.0.1:8000/api/swagger`

# API Authentication:

Register a user: `/api/register`

Login a user: `/api/login`

Protected Routes:

Accessible only with a valid Sanctum token.

Examples: `/api/categories (store, update, delete)`

Public Routes:

Accessible without authentication.
Examples: `/api/categories (index, show)`


# Generate Swagger Documentation:
`cd laravel-api`
`php artisan l5-swagger:generat`


# Contributing
Contributions are welcome! Please open an issue or submit a pull request for any improvements, bug fixes, or new features.

# License
This project is licensed under the MIT License. See the LICENSE file for details.