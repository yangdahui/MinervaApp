<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Retrieve Topic Modelling Results From Mongodb</title>
        
        <style type="text/css">
           table.db-table 	{ border-right:1px solid #ccc; border-bottom:1px solid #ccc; }
           table.db-table th	{ background:#eee; padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc; }
           table.db-table td	{ padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc; }
        </style>     
        
         <script language="javascript" type="text/javascript">
            
            function taskidselection(taskid){
                    document.location = 'readkeywords.php?taskid=' + taskid;
            }
            
        </script>
        
    </head>
    <body>
        <h1>
            Retrieve Topic Keywords From Mongodb
        </h1>      
        
        <form name="frm1" id="frm1">
            <select name="taskid" id="catid" onChange="taskidselection(this.value);">
                <option value="" selected="selected">---Select Task ID---</option>
                <option value="1">Task 1, TFIDF: 2.0</option>
                <option value="2">Task 2, TFIDF: 1.5</option>
                <option value="3">Task 3, TFIDF: 1.0</option>
                <option value="4">Task 4, TFIDF: 2.0</option>
                <option value="5">Task 5, TFIDF: 1.5</option>
                <option value="6">Task 6, TFIDF: 1.0</option>
            </select>
        </form>
        
        <?php
        // connect
        try 
        {
                $m = new MongoClient();
                // select a database
                $db = $m->analysisresult;
        }
        catch ( MongoConnectionException $e ) 
        {
            echo '<p>Couldn\'t connect to mongodb, is the "mongo" process running?</p>';
            exit();
        }

        // select a collection (analogous to a relational database's table)
        $collection = $db->topickey;
        $topiccount = $collection->count();
        
        //count the number of items in this collection
        echo '<h4><p>This collection has ',$topiccount,' documents</p></h4>';
                               
        $taskidselected = intval($_GET["taskid"]);      
        
        $query = array("task_id"=>$taskidselected);
        
        // find everything in the collection
        $cursor = $collection->find($query);  
        
        //great table for keyword
        
        echo '<table cellpadding="0" cellspacing="0" class="db-table">';
        echo '<tr>
            <th>Task </th>
            <th>Topic </th>
            <th>Keyword </th>
            <th>Weight </th>
            </tr>';
       
         $keywordsarray = array();
         
        
        // iterate through the results
        foreach ($cursor as $document) {
            echo '<tr>';
            
            echo '<td>',$document["task_id"],'</td>';
            echo '<td>',$document["topic_id"],'</td>';
            
            echo '<td>',$document["keyword"],'</td>';
            
            array_push($keywordsarray,$document["keyword"]);
            
            echo '<td>',$document["weight"],'</td>'; 
            
            echo '</tr>';
        }

        echo '</table><br />';

       
        // topic keywords list 
         echo '<h3> Keywords list by topic</h3>';
         echo '<ul>';
        
        for($topicindex = 0; $topicindex<20;$topicindex++){
            echo '<li>Topic',$topicindex,': ';
            for ($keywordsindex = 0; $keywordsindex < 10; $keywordsindex++) {
                echo $keywordsarray[$keywordsindex+10*$topicindex],' ';
            }
            echo '</li>';
        }
        echo '</ul>';
        // end - topic keywords list 
        
        $counts = array_count_values($keywordsarray);
        arsort($counts);
        $list = array_keys($counts);
        
        var_dump($list);
        
       // keywords frequency 
        echo '<h2>Keywords Frequency</h2>';
        var_dump($counts);
        
        echo '<br /><br />';
        
//        for($i=0; $i<100; $i++)
//        {
//              echo $keywords[$i];
//              echo '<br />';
//        }
//        
//        var_dump($cursor);
         
        //convert data into json file
        
        $data = array();

        // iterate through the results
        foreach ($cursor as $document) {
            $data[] = $document;
        }
        
//        $dataobject =  json_encode($data);
//        
//        echo $dataobject;

//        
//        var_dump($dataobject['keyword']);
//        
////        foreach($dataobject->topic_id as $topic_id)
////        {
////            var_dump($topic_id);
////        }
//       
//
////        for ($i = 0;$i<$topiccount; $i++)
////        {
////           echo '<p>topic:',$i,'</p>';
////           
////        }
//        
?>
        
    </body>
</html>
