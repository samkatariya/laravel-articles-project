# Laravel Articles Project

This project is a Laravel application that fetches and displays articles from the Times of India RSS feed.

## Installation and Setup

### Requirements
- PHP 7.4+
- Composer
- Laravel 8.x
- Node.js & npm (for frontend dependencies)

### Steps to Install
1. Clone the repository:
    ```bash
    git clone https://github.com/samkatariya/laravel-articles-project.git
    cd laravel-articles-project
    ```

2. Install Composer dependencies:
    ```bash
    composer install
    ```

3. Copy the `.env.example` file to `.env`:
    ```bash
    cp .env.example .env
    ```

4. Generate the application key:
    ```bash
    php artisan key:generate
    ```

5. Set up your database in the `.env` file.

6. Run migrations (if any):
    ```bash
    php artisan migrate
    ```

7. Install Node.js dependencies:
    ```bash
    npm install
    ```

8. Compile the assets:
    ```bash
    npm run dev
    ```

### Running the Application
Start the development server:
```bash
php artisan serve
