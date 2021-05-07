# Budge App

Budge app is an open source budgeting application that takes the annoyance out of keeping track of your money. 

## Table of Contents

[Installation](https://github.com/allenjd3/budge_php#Installation)

## Installation

#### 1. Clone repo

```
git clone git@github.com:allenjd3/budge_php.git
```
#### 2. Install Dependencies

```
cd budge_php

composer install

npm install && npm run dev
```

#### 3. Generate Key

```
php artisan key:generate
```

#### 4. Set up DB

```
cp .env.example .env
```

Modify .env to your DB credentials. For quick start, change driver to sqlite and comment out the other DB environment variables then-

```
touch database/database.sqlite

php artisan migrate
```



