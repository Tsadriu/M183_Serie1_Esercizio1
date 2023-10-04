<?php

/**
 * Creates a database connection using mysqli.
 * If connection fails, the program stops execution.
 * @return mysqli An instance of 'mysqli' that represents the connection to the database
 * @throws Exception If the connection to the database fails, it throws an exception with the connection error.
 *
 */
function createDbConnection()
{
    $hostname = "localhost";
    $username = "admin";
    $password = "98hq0STS][3HRn@0";
    $dbname = "m183";

    $conn = new mysqli($hostname, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}