
# Task Management System
This is a simple task management system built using Laravel. 
It allows users to create, update, and delete tasks.
Also assign tasks to users.

## Installation Steps

### 1. Clone the repository

- git clone https://github.com/Marina-Nabil-dev/task-management
- cd task-management


### 2. Install dependencies

- composer install

### 3. Configure environment variables
- Copy `.env.example` to `.env`
- Update the variables with your configuration

### 4. Run migrations
- php artisan migrate --seed

### 5. Start the development server
- php artisan serve

## Testing
- php artisan test

## Usage
To Run the queue jobs
- php artisan queue:work


The application should now be running at `http://localhost:8000`
