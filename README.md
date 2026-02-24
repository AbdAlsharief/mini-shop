# Mini Shop

Mini Shop is a robust, multi-role e-commerce platform built with **Laravel 12**. It features a hierarchical administrative structure allowing for global management, administrative oversight of merchants, and merchant-specific product management.

## 🚀 Key Features

* **Hierarchical Role System**:
    * **Customer**: Browse products, manage a cart, and track personal orders.
    * **Merchant**: Manage personal product listings through a dedicated admin panel.
    * **Admin**: Oversee merchant accounts and general store operations.
    * **Master Admin**: The highest level of authority, capable of managing administrators and the entire platform ecosystem.
* **Comprehensive Shopping Flow**: Includes product browsing, detailed product views, a persistent cart system, and secure checkout for authenticated users.
* **Administrative Dashboards**:
    * **Merchant Portal**: Full CRUD operations for products.
    * **Admin Portal**: Tools to create and manage merchant users.
    * **Master Portal**: High-level management of system administrators.
* **Profile Management**: Dedicated space for users to update personal information and security settings.

## 🛠️ Tech Stack

* **Framework**: [Laravel 12.x](https://laravel.com)
* **Authentication**: [Laravel Breeze](https://laravel.com/docs/breeze)
* **Environment**: PHP 8.2+
* **Testing**: [Pest PHP](https://pestphp.com)
* **Frontend**: Vite, Tailwind CSS

## 📥 Installation

The project includes a streamlined setup script.

1.  **Clone the repository**:
    ```bash
    git clone <repository-url>
    cd mini-shop
    ```

2.  **Run the Setup Command**:
    This automated script handles dependency installation, environment configuration, key generation, and migrations:
    ```bash
    composer run setup
    ```

3.  **Start the Development Servers**:
    Launch the application, queue listener, and Vite compiler simultaneously:
    ```bash
    npm run dev
    ```

## 🛣️ Routing Structure

The application is organized into clear routing segments:

* **Public/Shop**: Main storefront, cart, and product details.
* **User/Customer**: Protected routes for checkout, order history, and profile management.
* **Merchant Panel**: Product management for authorized users under the `/admin/products` prefix.
* **Admin Panel**: Merchant management under the `/admin/merchants` prefix.
* **Master Admin**: System oversight under the `/master/admins` prefix.

## 🧪 Testing

To run the full test suite using Pest:

```bash
composer run test
