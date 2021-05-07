# Budge App

Budge app is an open source budgeting application that takes the annoyance out of keeping track of your money. 

A live version of this site can be viewed here- [Budge App](https://budgeapp.net)

## Table of Contents

- [Installation](#installation)
- [Overview](#1-overview)
- [Funds](#2-funds)
- [Transactions](#3-transactions)
- [Creating a New Month](#4-creating-a-new-month)
- [Teams](#5-teams)

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

## Features

#### 1. Overview

I like to think of budgeting in two phases- The planning phase and the doing phase. When planning, the money is all theoretical, when doing the money is actual. 

The planning widget is on the left side of the page when you create a new month. Total planned is updated by adding a planned income. This is your total amount you are expecting to receive for the month. At the bottom of the planning widget, you will notice the total planned remaining. This is updated as you add new categories and budget items. Ultimatelly you will want your total planned remaining to be 0 to account for all the money you are expecting to receive for the month.

The Paid widget is on the right side of the page when you create a new month. The total paid adds all of your paychecks together to get your actual paid amount. The amount left is the total paid minus the transactions and the planned fund amount.

#### 2. Funds

A fund is like its own little bank account. When you create a new item, you have the option to make it a fund. If you do this, you will have a new text box to enter your "Fund per Month" This is a flat amount that will get charged to the paid widget. Any transactions that you assign to a fund is not subtracted from your total. If you spend less than your fund amount, it will be rolled over to the next month. If you spend more than your fund amount the negative value will be rolled over to the next month. This is a way to plan savings for certain items. 

#### 3. Transactions

Transactions have their own page. Adding a transaction is pretty self explanatory. To edit a transaction, click on the transaction in the table and it will fill in the values in the add transaction form, change what you need to change and click update to edit. 

You can also filter transactions by item type. Select the item in the drop down and select filter. This will show you a sneak peak of the item from the dashboard page and all the transactions associated with that item. 

#### 4. Creating a New Month

Creating a new month after you already have a month is as easy as selecting one from the drop down menus on the dashboard that you haven't created yet. It will take you to the create new month pane. If you would like to copy over information from a previous month, select it from the dropdown and click **Create New Month**

If you select a month that already exists, you will jump to that month.

#### 5. Teams

Teams are default with budgeapp!

When you create your first user, you are automatically assigned to a team. This will allow you to invite other users to your team. This is really convenient for families- both parents can be budgeting at the same time! Family fun night!


