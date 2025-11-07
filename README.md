# TrackMyCash

TrackMyCash is a personal finance management API that helps users track their income and expenses efficiently.

## Install

```
git clone git@github.com:pierrenoel/TrackMyCash.git
composer install
```

## Endpoints

| Method     | Endpoint        | Controller / Method            | Required Parameters                                       | Description                                                     |
| ---------- | --------------- | ------------------------------ | --------------------------------------------------------- | --------------------------------------------------------------- |
| **GET**    | `/categories`   | `CategoryController@index`     | _None_                                                    | Retrieve a list of all categories.                              |
| **GET**    | `/category`     | `CategoryController@show`      | `id`                                                      | Retrieve a single category by its ID.                           |
| **POST**   | `/categories`   | `CategoryController@store`     | `name`, `user_id`                                         | Create a new category associated with a user.                   |
| **DELETE** | `/categories`   | `CategoryController@delete`    | `id`                                                      | Delete a category by its ID.                                    |
| **GET**    | `/transactions` | `TransactionController@index`  | _None_                                                    | Retrieve a list of all transactions.                            |
| **POST**   | `/transactions` | `TransactionController@store`  | `type`, `amount`, `description`, `user_id`, `category_id` | Create a new transaction associated with a user and a category. |
| **DELETE** | `/transactions` | `TransactionController@delete` | `id`                                                      | Delete a transaction by its ID.                                 |

## Database

```
users
 ├── id
 ├── name
 ├── email
 ├── password

categories
 ├── id
 ├── name
 ├── user_id

transactions
 ├── id
 ├── user_id
 ├── category_id
 ├── type (income | expense)
 ├── amount
 ├── description
 ├── date
```

## Schema

```SQLITE
CREATE TABLE Users (
id INTEGER PRIMARY KEY AUTOINCREMENT,
name VARCHAR(50) NOT NULL,
email VARCHAR(100) UNIQUE NOT NULL,
password VARCHAR(50) NOT NULL
);

CREATE TABLE Categories(
id INTEGER PRIMARY KEY AUTOINCREMENT,
name VARCHAR(50) NOT NULL,
user_id int NOT NULL,
FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE Transactions(
id INTEGER PRIMARY KEY AUTOINCREMENT,
user_id int NOT NULL,
category_id int NOT NULL,
type VARCHAR(50) CHECK(type IN ("income","expense")) NOT NULL,
amount REAL NOT NULL,
description TEXT NOT NULL,
date DATETIME NOT NULL,
FOREIGN KEY (user_id) REFERENCES Users(id) ON DELETE CASCADE,
FOREIGN KEY (category_id) REFERENCES Categories(id)ON DELETE CASCADE
);
```
