<?PHP

echo '<pre>';

$manager = new MongoDB\Driver\Manager("mongodb://127.0.0.1:27017");

// Construct and execute the listDatabases command
$listdatabases = new MongoDB\Driver\Command(["listDatabases" => 1]);
$result        = $manager->executeCommand("admin", $listdatabases);

$databases     = $result->toArray()[0];

foreach ($databases->databases as $database) {
    echo $database->name, "\n";

    // Construct and execute the listCollections command for each database
    $listcollections = new MongoDB\Driver\Command(["listCollections" => 1]);
    $result          = $manager->executeCommand($database->name, $listcollections);

    /* The command returns a cursor, which we can iterate on to access
     * information for each collection. */
    $collections     = $result->toArray();

    foreach ($collections as $collection) {
        echo "\t * ", $collection->name, "\n";
    }
}

?>