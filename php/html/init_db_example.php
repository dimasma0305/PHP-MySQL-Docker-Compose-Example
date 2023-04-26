<?php
echo "code:<br/>";
highlight_file(__FILE__);
echo "output:<br/>";
# Initialize Database
$host = getenv('DB_HOST');
$user = getenv('DB_USER');
$pass = getenv('DB_PASSWORD');
$dbname = getenv('DB_NAME');
$port = getenv('DB_PORT');

$conn = mysqli_connect($host, $user, $pass, $dbname, $port);

// Check if the "books" table exists in the database
$result = mysqli_query($conn, "SHOW TABLES LIKE 'books'");
$tableExists = mysqli_num_rows($result) > 0;

if ($tableExists) {
    echo "The database has already been initialized.";
} else {
    echo "Initializing the database...";
    // Run the SQL script to initialize the database
    $sqlScript = file_get_contents('init.sql');
    mysqli_multi_query($conn, $sqlScript);
    echo "Done!";
}

mysqli_close($conn);
?>
