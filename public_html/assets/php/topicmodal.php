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
            
            function taskidselection(taskid){
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
        echo '<h4><p>This collection has ',$collection->count(),' documents</p></h4>';

                
        // condition $query
 
        $query = array("task_id"=>$taskidselected);
        
        $cursor = $collection->find($query);
        
        //count the number of items in this query
        echo '<h4><p>This query has ',$cursor->count(),'records </p></h4>';   

        echo '<table cellpadding="0" cellspacing="0" class="db-table">';
        echo '<tr>
            <th>Task </th>
            <th>Date </th>
            <th>Topic </th>
            <th>Proportion </th>
            </tr>';
        
        // iterate through the results
        foreach ($cursor as $document) {
            echo '<tr>';
            echo '<td>',$document["task_id"],'</td>';
            echo '<td>',$document["textfile"]["month"],'-',$document["textfile"]["day"],'-', $document["textfile"]["year"],'</td>';  
            echo '<td>',$document["topic"]["id"],'</td>';
            echo '<td>',$document["topic"]["proportion"],'</td>'; 
            echo '</tr>';
        }

        echo '</table><br />';
                        
        ?>
        
        
    </body>
</html>
