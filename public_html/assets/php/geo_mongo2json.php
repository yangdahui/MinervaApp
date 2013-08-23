 <?php
        // Config  
        $dbhost = 'localhost';
        $dbname = 'data';
        $task_id = 2;
        // Connect to test database  
        $m = new Mongo("mongodb://$dbhost");
        $db = $m->$dbname;

        // select a collection (analogous to a relational database's table)
        $collection = $db->libya;

        //count the number of items in this collection
        echo '<h3>The entire collection has ', $collection->count(), ' tweets';

        // condition $query
        $nullgeolat = "0.00000";

        $query = array("geo_lat" => array('$ne' => $nullgeolat));

        $cursor = $collection->find($query)->limit(1000);
        
        //count the number of items in this query
        echo '; This query returns ', $cursor->count(), ' geo-tagged tweets</h3>';

        echo '<center><h4>The 1000 samples are as follows</h3></center><hr>';
            
        echo '<table cellpadding="0" cellspacing="0" class="db-table">';
        echo '<tr>
                <th>Index</th>
                <th>Lat </th>
                <th>Long </th>
                <th>Tweet </th>
               </tr>';
        
        // iterate geo info with tweets
        $index = 1;
                
        foreach ($cursor as $document) {
            echo '<tr>';
            echo '<td>',$index,'</td>';
            $index++;
            echo '<td>',$document["geo_lat"],'</td>';
            echo '<td>',$document["geo_long"],'</td>';
            echo '<td>',$document["tweet_text"],'</td>';
            echo '<tr>';
            
           // echo $document["tweet_id"],' ',$document["tweet_text"],' ',$document["geo_lat"],'',$document["geo_long"];
            
        }

        ?>


    </body>
</html>
