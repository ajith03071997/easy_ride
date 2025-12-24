@echo off
echo Setting up Internet Cafe Admin System...

echo.
echo Step 1: Installing PHP dependencies...
composer install

echo.
echo Step 2: Creating .env file...
if not exist .env (
    copy .env.example .env
    echo .env file created from .env.example
) else (
    echo .env file already exists
)

echo.
echo Step 3: Generating application key...
php artisan key:generate

echo.
echo Step 4: Running database migrations...
php artisan migrate

echo.
echo Step 5: Seeding database with sample data...
php artisan db:seed

echo.
echo Setup completed successfully!
echo.
echo You can now start the server with: php artisan serve
echo Then visit: http://localhost:8000
echo Login with: admin / 12345678
echo.
pause
