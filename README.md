# Cyberbullying Detection - Laravel web Application

A Laravel web application that provides a user interface for cyberbullying text classification.

## What it does
- Provides a simple form for users to input text
- Sends text to the Flask API for prediction
- Displays result: "Cyberbullying" or "Not Cyberbullying"

## Tech Stack
- PHP, Laravel, Blade Templates

## Requirements
- PHP 8+
- Composer
- Flask API running on http://127.0.0.1:5000

## How to run
1. Install dependencies: `composer install`
2. Copy `.env.example` to `.env` and run `php artisan key:generate`
3. Run: `php artisan serve`
4. Make sure Flask API is running first

## Related Repositories
- ML Models & Training: [FYP-Cyberbullying-Text-Classification](https://github.com/jenous11/FYP-Cyberbullying-Test-Classification)
- Flask API: [FYP-Cyberbullying-Flask-API](https://github.com/jenous11/FYP-Cyberbullying-Flask-API)
