<?php
$type = 'mysql'; // Specifies the database type
$server = 'localhost'; // `localhost` means it's on the same machine as the server
$db = 'phpbook-1'; // The database name to connect to
$port = ''; // Port is usually 3306 for XAMPP
$charset = 'utf8mb4'; // UTF-8 encoding using 4 bytes of data per character

$username = 'cmsUser';
$password = 'cmsUser'; // TODO: Implement project variables

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Set the error mode to throw exceptions
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Set the default fetch mode to return ass. arrays
    PDO::ATTR_EMULATE_PREPARES => false, // Disables emulation of prepared statements
];

// DON'T change below this line
$dsn = "$type:host=$server;dbname=$db;port=$port;charset=$charset"; // Create DSN string (Data Source Name) which specifies the details of the db connection
try {
    $pdo = new PDO($dsn, $username, $password, $options);           // Create PDO object
} catch (PDOException $e) {                                         // If exception thrown
    throw new PDOException($e->getMessage(), $e->getCode());        // Re-throw exception
}
