# M183 > Serie 1 > Esercizio1

## Author
Fabio Oliveira de Sousa

This repository contains a fundamental authentication exercise conducted in PHP.

## Prerequisites

Before you start, ensure you have the following installed on your machine:

- [Xammp](https://www.apachefriends.org)
- Apache module
- MySQL module

The Apache and MySQL modules must be configured to your desired ports.

## Database Setup

In phpMyAdmin, create a new database and tables as follows:

- `users`:
  - `id` (PK, auto-increment)
  - `userName` (varchar)
  - `password` (varchar)
  - `creationDateTime` (datetime)

- `userposts`:
  - `id` (PK, auto-increment)
  - `post` (varchar)
  - `postCreationDate` (datetime)
  - `userId` (FK)

Note: It is critical to use the same table names as mentioned above. If you wish to use different table names, ensure they are renamed in the code as well.

## Usage

To launch the application:

1. Enable both the necessary services (Apache and MySQL)
2. Open your browser and enter the following in the address bar - "localhost:port/M183/M183_Serie_1_Esercizio_1/sign_up.php"

Enjoy the application!