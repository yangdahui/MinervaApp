<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <title>Epidemics Outbreak and Spread Detection System</title>
  <script type="text/javascript" src="http://www.google.com/jsapi"></script>
  <script type="text/javascript">
    google.load('visualization', '1', {packages: ['geochart']});

    function drawVisualization() {
      var data = new google.visualization.arrayToDataTable(
	  <?php
			// Config  
			$dbhost = 'localhost';  
			$dbname = 'test';  
			  
			// Connect to test database  
			$m = new Mongo("mongodb://$dbhost");  
			$db = $m->$dbname;  
			  
			// select the collection  
			$collection = $db->libya_geotagged;  
			
			$query = array('location.country_code' => 'US');
			// pull a cursor query  
			$cursor = $collection->find($query);  
			
			$state_freq = array();
			$state_pscore = array();
			
			foreach ($cursor as $document) {
				$state_name = $document["location"]["state_name"];
				@$negative_score = $document["sentiment"]["negative"];
				//echo $state_code . "||" . $positive_score . "<br>";
				@$state_total_nscore[$state_name] += $negative_score;
				@$state_freq[$state_name] += 1;
			}
			
			
			$append = "";
			$string = "[['State', 'Average Negative Ratio']";
			
			$obj = new ArrayObject( $state_total_nscore );
			$it = $obj->getIterator();
			foreach ($it as $key=>$val) {
				$name = $key;
				
				$freq = round($val/($state_freq[$name]+0.001),2);
				
				$append = $append . ",['" . $name ."', " . $freq . "]"; 
			}
			
			$string = $string . $append . "]";
			echo $string;
	?>
	  );
      
      var geochart = new google.visualization.GeoChart(
          document.getElementById('visualization'));
      geochart.draw(data, {region: 'US', width: 300, height: 180, backgroundColor: 'white', colors:['white','#ad1313'], resolution: 'provinces'});
    }
    

    google.setOnLoadCallback(drawVisualization);
  </script>
</head>
<body style="font-family: Arial;border: 0 none;">
<div align="center" id="visualization"></div>
</body>
</html>