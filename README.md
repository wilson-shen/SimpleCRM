# SimpleCRM

#### A simple example to show admin CRUD on Company and Employee.

---

## To run this project

### 1. Clone this project
```bash
$ cd ~/YOUR_PREFERENCE_PATH
$ git clone git@github.com:wilson-shen/SimpleCRM.git
```

### 2. Setup your database schema
```bash
$ sudo mysql
mysql> CREATE DATABASE `simplecrm` CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_ci';
mysql> CREATE DATABASE `simplecrm_test` CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_ci';
mysql> exit;
```

### 3. Setup project
```bash
$ cd SimpleCRM
$ cp .env.example .env
$ cp .env.testing.example .env.testing
$ php artisan key:generate
# remember to copy the APP_KEY hash value from .env to .env.testing
```

### 4. Install dependencies
```bash
$ composer install
$ npm install
```

### 5. Setup the database
```bash
$ php artisan migrate

# Admin seeder (required in order to login)
$ php artisan db:seed AdminUserSeeder

# Company list seeder (optional)
$ php artisan db:seed CompanySeeder

# Employee list seeder (optional)
$ php artisan db:seed EmployeeSeeder
```

### 6. Run the project
```bash
# terminal 1 - node.js
$ npm run dev

# terminal 2 - php
$ php artisan serve
```

### 7. Test the project
```bash
$ vendor/bin/phpunit
```
