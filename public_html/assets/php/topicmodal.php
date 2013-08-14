<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Retrieve Topic Modelling Results From Mongodb</title>

        <style type="text/css">
            table.db-table 		{ border-right:1px solid #ccc; border-bottom:1px solid #ccc; }
            table.db-table th	{ background:#eee; padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc; }
            table.db-table td	{ padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc; }
        </style>     

        <script language="javascript" type="text/javascript">

            function taskidselection(taskid) {
                document.location = 'topicmodal.php?taskid=' + taskid;
            }

        </script>

    </head>
    <body>
        <h1>
            Retrieve Topic Modelling Results From Mongodb
        </h1>

        <form name="frm1" id="frm1">
            <select name="taskid" id="catid" onChange="taskidselection(this.value);">
                <option value="" selected="selected">---Select Task ID---</option>
                <option value="1">Task 1</option>
                <option value="2">Task 2</option>
            </select>
        </form>

        <?php
        // Config  
        $dbhost = '10.5.34.11';
        $dbname = 'result';
//      $task_id = 2;
        // Connect to test database  
        $m = new Mongo("mongodb://$dbhost");
        $db = $m->$dbname;

        // select a collection (analogous to a relational database's table)
        $collection = $db->topicmodeling;

        // taskid from selection
        $taskidselected = intval($_GET["taskid"]);

        //count the number of items in this collection
        echo '<h4><p>This collection has ', $collection->count(), ' documents</p></h4>';


        // condition $query

        $query = array("task_id" => $taskidselected);

        $cursor = $collection->find($query);

        //count the number of items in this query
        echo '<h4><p>This query has ', $cursor->count(), ' records </p></h4>';


        $proportionarray = array();

        // iterate proportion
        foreach ($cursor as $document) {
            array_push($proportionarray, $document["topic"]["proportion"]);
        }


//        // topic keywords list 
//         echo '<h3> Proportion List by Day</h3>';
//         echo '<ul>';
//        
//        for($dayindex = 0; $dayindex<= 613;$dayindex++){
//            echo '<li>Day ',$dayindex,': ';
//            for ($topicindex = 0; $topicindex < 20; $topicindex++) {
//                echo $proportionarray[$topicindex + 20*$dayindex],' ';
//            }
//            echo '</li>';
//        }
//        echo '</ul>';
        //$proportionarraybytopic["topic x"][day(0-612)]

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

        for ($topicindex = 0; $topicindex < $topiccount; $topicindex++) {

            $topicname = "topic " . (string) $topicindex;

            for ($dayindex = 0; $dayindex < $daycount; $dayindex++) {
                array_push($proportionarraybytopic[$topicname], $proportionarray[$dayindex + $daycount * $topicindex]);
            }
        }

        echo json_encode($proportionarraybytopic);


//        echo '<table cellpadding="0" cellspacing="0" class="db-table">';
//        echo '<tr>
//            <th>Date </th>
//            <th>Topic </th>    
//            <th>Proportion </th>
//            </tr>';
//        
//        // iterate through the results
//        foreach ($cursor as $document) {
//            echo '<tr>';
//            echo '<td>',$document["textfile"]["month"],'-',$document["textfile"]["day"],'-', $document["textfile"]["year"],'</td>';  
//            echo '<td>',$document["topic"]["id"],'</td>';
//            echo '<td>',$document["topic"]["proportion"],'</td>'; 
//            echo '</tr>';
//        }
//
//        echo '</table><br />';
        ?>


    </body>
</html>
