<?PHP
	header('Content-Type: text/html; charset=utf-8');
	echo '<pre>';

	$connection = new Mongo('mongodb://127.0.0.1', array("replicaSet" => false) );

	$collection = $connection->selectDB( "oferty" );
	$database = $collection->selectCollection( "eml" );

	$cursor = $database->findOne(array('_id' => new MongoId('519ce449d87459c40b000011')));

	echo "<b>Old way</b>\n\n";

	print_r( $cursor );

	//#################################################
	//#################################################

	echo "\n\n<b>New way</b>\n\n";

	$connection = new MongoDB\Driver\Manager("mongodb://127.0.0.1:27017");

	$query = new MongoDB\Driver\Query(['_id' => new MongoDB\BSON\ObjectID('519ce449d87459c40b000011') ]);
	try {

		$cursor = $connection->executeQuery("oferty.eml", $query); 

		$rows = (array) $cursor->toArray()[0];
		print_r($rows);


	} catch (MongoDB\Driver\Exception\Exception $e) {
	    echo $e->getMessage(), "\n";
	}


?>