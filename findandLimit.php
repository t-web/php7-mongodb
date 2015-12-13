<?PHP
	header('Content-Type: text/html; charset=utf-8');
	echo '<pre>';

	echo "<b>Old way</b>\n\n";

	$connection = new Mongo('mongodb://127.0.0.1', array("replicaSet" => false) );

	$collection = $connection->selectDB( "oferty" );
	$database = $collection->selectCollection( "eml" );

	$cursor = $database->find()->limit(3);

	foreach ( $cursor as $val ) {
		print_r($val);
	}


	//#################################################
	//#################################################

	echo "\n\n<b>New way</b>\n\n";

	$connection = new MongoDB\Driver\Manager("mongodb://127.0.0.1:27017");

	$opt = ['limit' => 2,'sort' => ['eml' => -1] ];

	$query = new MongoDB\Driver\Query([],$opt);
	try {

		$cursor = $connection->executeQuery("oferty.eml", $query); 

		$rows =  $cursor->toArray();
		
		foreach ( $rows as $data ) {
			 print_r( (array) $data );
		}


	} catch (MongoDB\Driver\Exception\Exception $e) {
	    echo $e->getMessage(), "\n";
	}


?>