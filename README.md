# <img src='https://cdn.icon-icons.com/icons2/2107/PNG/64/file_type_vue_icon_130078.png' width='32' style='margin-right: -6px;'/>ue 3, <img src='https://avatars.githubusercontent.com/u/47703742?s=200&v=4' width='32' style='margin-right: 4px;'/> Inertia.js, <img src='https://cdn.icon-icons.com/icons2/2108/PNG/64/laravel_icon_130892.png' style='margin-right: 5px;' width='28px'> Laravel, and <img src="https://i2.wp.com/www.primefaces.org/wp-content/uploads/2019/12/primevue-logo.png?fit=300%2C300&ssl=1" width="32"/> PrimeVue CRUD tasks dashboard with 🔐 Laravel's Breeze Authentification, 🗄️ DB seeding and client side 🔎 search functionality, 📑 pagination and 🏷️ sorting.

### Description 📜

**_Vue.js 3_**, **_Inertia.js_**, **_Laravel_** and **_PrimeVue_** **_CRUD_** tasks application with **_Laravel's Breeze authentification_**, **_DB Seeding_** and client side **_search functionality_**, **_pagination_** and **_sorting_**.<br>
Users need to _register_ and _authenticate_ using **Laravel Breeze** to gain access to the application’s features. Once authenticated, users can perform **_CRUD_** (**_Create_**, **_Read_**, **_Update_**, **_Delete_**) operations on **tasks** and **search** for tasks by **title**, and **description**. The application ensures secure **_access_** to these functionalities thanks to **_Laravel's Breeze_**.

<hr/>

### 📽️ [Demonstration](https://www.youtube.com/watch?v=kx9QkhIohJs)

<hr/>

### 💻 Stack: <br/>

<img src='https://cdn.icon-icons.com/icons2/2107/PNG/64/file_type_vue_icon_130078.png' width='24' style='margin-right: 2px;'/>[Vue 3](https://vuejs.org/)<br/>
<img src='https://avatars.githubusercontent.com/u/47703742?s=200&v=4' width='24' style='margin-right: 4px;'/>[Inertia.js](https://inertiajs.com/)<br>
<img src='https://cdn.icon-icons.com/icons2/2108/PNG/64/php_icon_130857.png' width='22' style='margin-right: 2px;'/>[PHP](https://www.php.net/)<br/>
<img src='https://cdn.icon-icons.com/icons2/2108/PNG/64/laravel_icon_130892.png' style='margin-right: 5px;' width='20px'>[Laravel](https://laravel.com/)<br/>
<img src="https://i2.wp.com/www.primefaces.org/wp-content/uploads/2019/12/primevue-logo.png?fit=300%2C300&ssl=1" width="22px"/> [PrimeVue](https://primevue.org/)<br>
<img src="https://cdn.icon-icons.com/icons2/2699/PNG/512/tailwindcss_logo_icon_167923.png" width="22px"/> [Tailwindcss](https://tailwindcss.com/)<br>
<img src="https://cdn.icon-icons.com/icons2/2415/PNG/512/typescript_plain_logo_icon_146316.png" width="20"/> [TypeScript](https://www.typescriptlang.org/)<br/>

## Table of Contents

-   Installation
-   Configuration
-   Database Seeding
-   Routes
-   Running the Project
-   User Permissions
-   Authorization Errors

## Installation

1. Clone the repository:

    ```bash
    git clone <repository-url>
    cd <repository-directory>
    ```

2. Install dependencies:
    ```bash
    composer install
    npm install
    ```

## Configuration

1. Generate an application key:

    ```bash
    php artisan key:generate
    ```

2. Copy the `.env.example` file to `.env`:

    ```bash
    cp .env.example .env
    ```

3. Configure the database connection in the `.env` file:
    ```env
    DB_CONNECTION=your_database_driver
    DB_HOST=your_database_host
    DB_PORT=your_database_port
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_username
    DB_PASSWORD=your_database_password
    ```

## Database Seeding

1. Run the database migrations and seed the database:

    ```bash
    php artisan migrate
    php artisan db:seed --class=DatabaseSeeder
    ```

    This will create two **users**: one user with **name:** '**_Admin_**' and **email**: **_admin@example.com_**
    and one with: **name**: '**_Test User_**' and **email**: **_testuser@example.com_**. Both users will have '**_Test123._**' as a '**password**'.
    Also this will generate 5 random _tasks_ that will be assigned randomly between these two _users_.

## Routes

The following routes are defined in the project:

-   **Authentication Routes**:

    -   `GET /register` - Show registration form
    -   `POST /register` - Register a new user
    -   `GET /login` - Show login form
    -   `POST /login` - Login a user
    -   `GET /forgot-password` - Show forgot password form
    -   `POST /forgot-password` - Send password reset link
    -   `GET /reset-password/{token}` - Show reset password form
    -   `POST /reset-password` - Reset password
    -   `GET /verify-email` - Show email verification notice
    -   `GET /verify-email/{id}/{hash}` - Verify email
    -   `POST /email/verification-notification` - Resend verification email
    -   `GET /confirm-password` - Show confirm password form
    -   `POST /confirm-password` - Confirm password
    -   `PUT /password` - Update password
    -   `POST /logout` - Logout a user (protected route)

-   **Task Routes (protected routes)**:

    -   `GET /tasks` - Get all tasks
    -   `POST /tasks` - Create a new task
    -   `GET /tasks/{id}/{slug}` - Get a task by ID
    -   `PUT /tasks/{id}` - Update a task by ID
    -   `DELETE /tasks/{id}` - Delete a task by ID

-   **Profile Routes (protected routes)**:
    -   `GET /profile` - Show profile edit form
    -   `PATCH /profile` - Update profile
    -   `DELETE /profile` - Delete profile

## Running the Project

1. Serve the application:

    - Back-End:

    ```bash
    php artisan serve
    ```

    - Front-End:

    ```bash
    npm run dev
    ```

2. The application will be available at `http://127.0.0.1:8000`.

## User Permissions

Each user can only access, edit, view, and delete their own tasks and profile. This ensures that user data is kept private and secure.

## Authorization Errors

If you encounter an authorization error, please ensure that you are logged in with the correct credentials. Common authorization errors include:

-   **_Unauthorized access_**: You do not have permission to access this resource.
-   **_Invalid token_**: Your session has expired. Please log in again.

---

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

-   [Simple, fast routing engine](https://laravel.com/docs/routing).
-   [Powerful dependency injection container](https://laravel.com/docs/container).
-   Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
-   Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
-   Database agnostic [schema migrations](https://laravel.com/docs/migrations).
-   [Robust background job processing](https://laravel.com/docs/queues).
-   [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

-   **[Vehikl](https://vehikl.com/)**
-   **[Tighten Co.](https://tighten.co)**
-   **[WebReinvent](https://webreinvent.com/)**
-   **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
-   **[64 Robots](https://64robots.com)**
-   **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
-   **[Cyber-Duck](https://cyber-duck.co.uk)**
-   **[DevSquad](https://devsquad.com/hire-laravel-developers)**
-   **[Jump24](https://jump24.co.uk)**
-   **[Redberry](https://redberry.international/laravel/)**
-   **[Active Logic](https://activelogic.com)**
-   **[byte5](https://byte5.de)**
-   **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
