<?php

// Config  
$dbhost = 'localhost';
$dbname = 'result';
$task_id = 2;

// Connect to test database  
$m = new Mongo("mongodb://$dbhost");
$db = $m->$dbname;

// select a collection (analogous to a relational database's table)
$collection = $db->topicmodeling;

// condition $query

$query = array("task_id" => $task_id);

$cursor = $collection->find($query);

$proportionarray = array();

$datearray = array();

// iterate proportion
foreach ($cursor as $document) {
    array_push($proportionarray, $document["topic"]["proportion"]);
}

$proportionarraybytopic = array(
    "topic 0" => array(),
    "topic 1" => array(),
    "topic 2" => array(),
    "topic 3" => array(),
    "topic 4" => array(),
    "topic 5" => array(),
    "topic 6" => array(),
    "topic 7" => array(),
    "topic 8" => array(),
    "topic 9" => array(),
    "topic 10" => array(),
    "topic 11" => array(),
    "topic 12" => array(),
    "topic 13" => array(),
    "topic 14" => array(),
    "topic 15" => array(),
    "topic 16" => array(),
    "topic 17" => array(),
    "topic 18" => array(),
    "topic 19" => array()
);

//      var_dump($proportionarraybytopic);

$daycount = 613;
$topiccount = 20;

//create date array for x value
for ($dayindex = 0; $dayindex < $daycount; $dayindex++) {
        array_push($datearray, $dayindex+1);
}

//var_dump($datearray);

for ($topicindex = 0; $topicindex < $topiccount; $topicindex++) {

    $topicname = "topic ".(string) $topicindex;

    for ($dayindex = 0; $dayindex < $daycount; $dayindex++) {
        array_push($proportionarraybytopic[$topicname], $proportionarray[$topicindex + $dayindex * $topiccount]);
    }
}

//echo json_encode($proportionarraybytopic);

$keyfieldname = "key";
$valuefieldname = "values";

$exportdata ="[";


for ($topicindex = 0; $topicindex < $topiccount; $topicindex++) {

    $topicname = "topic ".(string)$topicindex;

    $exportdata = $exportdata ."{\"" . $keyfieldname . "\":\"" .$topicname."\",";
    
    $exportdata = $exportdata . "\"".$valuefieldname. "\":";
 
    $exportdata = $exportdata ."[";
    
    for($dayindex = 0; $dayindex<$daycount; $dayindex++){
        
       $exportdata = $exportdata . "[" . $datearray[$dayindex].",";
       $exportdata = $exportdata . $proportionarraybytopic[$topicname][$dayindex]."]".",";
    }
    
    $exportdata= rtrim($exportdata, ",");
    
    $exportdata = $exportdata ."]";
    
    $exportdata = $exportdata ."},";

}

$exportdata= rtrim($exportdata, ",");

$exportdata =$exportdata."];";

echo $exportdata;


?>

