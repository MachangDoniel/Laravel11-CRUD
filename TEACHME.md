# Laravel Project Setup Guide

## Prerequisites

Before you start, make sure you have the following installed:

- PHP >= 8.0
- Composer (for managing PHP dependencies)
- Node.js (for managing frontend dependencies)
- MySQL or another database server (depending on the `.env` file configuration)
- Git (for cloning the repository)

## 1. Clone the Repository

Clone the repository to your local machine using Git:

```bash
git clone https://github.com/MachangDoniel/Laravel11-CRUD.git
cd Laravel11-CRUD
```

## 2. Install PHP Dependencies

Run the following command to install PHP dependencies using Composer:

```bash
composer install
```

## 3. Install Frontend Dependencies

If your project uses frontend assets (e.g., JavaScript, CSS), install the necessary dependencies:

```bash
npm install   
```
or `yarn install` if you're using Yarn

## 4. Set Up Environment Variables

1. Copy the `.env.example` file to `.env`:

   ```bash
   cp .env.example .env
   ```

2. Update the `.env` file with your local or server configurations. Specifically, you'll need to fill in the following details:

   - **Database Configuration**:
     ```
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1      # or your database server address
     DB_PORT=3306           # default MySQL port
     DB_DATABASE=your_db_name
     DB_USERNAME=your_db_user
     DB_PASSWORD=your_db_password
     ```

   - **Application Key**: Laravel needs an application key for encryption. If you haven't already generated one, you can use the command:
     ```bash
     php artisan key:generate
     ```

   - **Mail Configuration** (if your app sends emails):
     ```
     MAIL_MAILER=smtp
     MAIL_HOST=smtp.mailtrap.io  # Example for Mailtrap, replace with your actual SMTP server
     MAIL_PORT=587
     MAIL_USERNAME=your_mail_username
     MAIL_PASSWORD=your_mail_password
     MAIL_ENCRYPTION=tls
     ```

   - **API Keys and Other Credentials**: If your application uses third-party services (e.g., Stripe, Google APIs), make sure to add those keys in the `.env` file as well.

## 5. Set Up the Database

1. Create a database in MySQL or your preferred database service. Ensure it matches the `DB_DATABASE` field in your `.env` file.

2. Run the migrations to set up the database schema:

   ```bash
   php artisan migrate
   ```

   This will create the necessary tables and structures in your database.

## 6. Seed the Database (Optional)

If you need sample data for development or testing, you can run the database seeder:

```bash
php artisan db:seed
```

## 7. Run the Application

To run the application locally, use Laravel's built-in server:

```bash
php artisan serve
```

This will start the server at [http://127.0.0.1:8000](http://127.0.0.1:8000), and you should be able to access the application in your browser.

go to  [http://127.0.0.1:8000/products](http://127.0.0.1:8000/products) to view tha product lists.

## 8. Additional Commands

- **Clear Cache**: If you make changes to the `.env` file or configuration, you might need to clear the cache:
  ```bash
  php artisan config:clear
  php artisan cache:clear
  ```

- **Queue Processing** (if using queues):
  ```bash
  php artisan queue:work
  ```

## 9. Troubleshooting

- If you encounter errors with the database connection, ensure that your `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` in the `.env` file are correct.
- If you run into any permissions issues with directories (e.g., storage), you can change the permissions using:
  ```bash
  sudo chmod -R 775 storage
  sudo chmod -R 775 bootstrap/cache
  ```

---