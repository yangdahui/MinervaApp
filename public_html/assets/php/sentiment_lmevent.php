<html>
    <head>
        <script type='text/javascript' src='http://www.google.com/jsapi'></script>
        <script type='text/javascript'>

            google.load('visualization', '1', {'packages': ['annotatedtimeline']});
            google.setOnLoadCallback(drawChart);

            var chart;
            var data;

            // Date (yy, mm, dd), mm is the number + 1, e.g. 0 represents janunary
            function drawChart() {
                data = new google.visualization.DataTable(
<?php
// Config  
$dbhost = '10.5.34.11';
$dbname = 'result';
$task_id = 2;

// Connect to test database  
$m = new Mongo("mongodb://$dbhost");

$db = $m->$dbname;

// select the collection  
$collection = $db->sentiment;


//get the max and min of lm events statistics
$temp_cursor = $collection->find();
$mean_statistics = array();
$sum_statistics = array();
$median_statistics = array();
$eventcount_statistics = array();
$count = 0;
foreach ($temp_cursor as $document) {
    if ($count == 0) {
        $mean_statistics["max"] = $document["lm_events"]["mean"];
        $mean_statistics["min"] = $document["lm_events"]["mean"];

        $sum_statistics["max"] = $document["lm_events"]["sum"];
        $sum_statistics["min"] = $document["lm_events"]["sum"];

        $median_statistics["max"] = $document["lm_events"]["median"];
        $median_statistics["min"] = $document["lm_events"]["median"];

        $eventcount_statistics["max"] = $document["lm_events"]["count"];
        $eventcount_statistics["min"] = $document["lm_events"]["count"];
    } else {
        if ($document["lm_events"]["mean"] > $mean_statistics["max"])
            $mean_statistics["max"] = $document["lm_events"]["mean"];
        if ($document["lm_events"]["mean"] < $mean_statistics["min"])
            $mean_statistics["min"] = $document["lm_events"]["mean"];

        if ($document["lm_events"]["sum"] > $sum_statistics["max"])
            $sum_statistics["max"] = $document["lm_events"]["sum"];
        if ($document["lm_events"]["sum"] < $sum_statistics["min"])
            $sum_statistics["min"] = $document["lm_events"]["sum"];

        if ($document["lm_events"]["median"] > $median_statistics["max"])
            $median_statistics["max"] = $document["lm_events"]["median"];
        if ($document["lm_events"]["median"] < $median_statistics["min"])
            $median_statistics["min"] = $document["lm_events"]["median"];

        if ($document["lm_events"]["count"] > $eventcount_statistics["max"])
            $eventcount_statistics["max"] = $document["lm_events"]["count"];
        if ($document["lm_events"]["count"] < $eventcount_statistics["min"])
            $eventcount_statistics["min"] = $document["lm_events"]["count"];
    }
    $count++;
}

// get the results from one task  
$query = array("task_id" => 2);

// pull a cursor query  
$cursor = $collection->find($query);

$append = "";
//string is in json format
//right now, I only consider epidemics "listeria" ,"influenza" and "swine flu"

//format a string as json, as input of chart

$string = "{ cols: [{id: '', label: 'Date', type: 'date'},
                    {id: '', label: 'raw-mpqa', type: 'number'},
                    {id: '', label: 'title2', type: 'string'},
                    {id: '', label: 'text2', type: 'string'},
                    {id: '', label: 'raw-afinn', type: 'number'},
                    {id: '', label: 'title3', type: 'string'},
                    {id: '', label: 'text3', type: 'string'},
                    {id: '', label: 'raw-liwc', type: 'number'},
                    {id: '', label: 'title4', type: 'string'},
                    {id: '', label: 'text4', type: 'string'},
                    {id: '', label: 'topic-mpqa', type: 'number'},
                    {id: '', label: 'title5', type: 'string'},
                    {id: '', label: 'text5', type: 'string'},
                    {id: '', label: 'topic-afinn', type: 'number'},
                    {id: '', label: 'title6', type: 'string'},
                    {id: '', label: 'text6', type: 'string'},
                    {id: '', label: 'topic-liwc', type: 'number'},
                    {id: '', label: 'title7', type: 'string'},
                    {id: '', label: 'text7', type: 'string'},
                    {id: '', label: 'mean', type: 'number'},
                    {id: '', label: 'title8', type: 'string'},
                    {id: '', label: 'text8', type: 'string'},
                    {id: '', label: 'sum', type: 'number'},
                    {id: '', label: 'title9', type: 'string'},
                    {id: '', label: 'text9', type: 'string'},
                    {id: '', label: 'median', type: 'number'},
                    {id: '', label: 'title9', type: 'string'},
                    {id: '', label: 'text9', type: 'string'},
                    {id: '', label: 'eventcount', type: 'number'},
                    {id: '', label: 'title10', type: 'string'},
                    {id: '', label: 'text10', type: 'string'}],
                    rows: [";

//iterate through the mongodb results
foreach ($cursor as $document) {
    $count = 0;
    
    $year = $document["date"]["year"];
    $month = $document["date"]["month"];
    $day = $document["date"]["day"];
    
    $append = $append . "{c:[{v: new Date(" . $year . ", " . ($month - 1) . ", " . $day . ")}";

    $append = $append . ", {v: " . $document["sentiment"]["raw"]["mpqa-positive"] . "}, {v: undefined}, {v: undefined}";
    $append = $append . ", {v: " . $document["sentiment"]["raw"]["afinn-positive"] . "}, {v: undefined}, {v: undefined}";
    $append = $append . ", {v: " . $document["sentiment"]["raw"]["liwc-positive"] . "}, {v: undefined}, {v: undefined}";
    
    $append = $append . ", {v: " . $document["sentiment"]["topic"]["mpqa-positive"] . "}, {v: undefined}, {v: undefined}";
    $append = $append . ", {v: " . $document["sentiment"]["topic"]["afinn-positive"] . "}, {v: undefined}, {v: undefined}";
    $append = $append . ", {v: " . $document["sentiment"]["topic"]["liwc-positive"] . "}, {v: undefined}, {v: undefined}";

    $append = $append . ", {v: " . round(($document["lm_events"]["mean"] - $mean_statistics["min"]) / ($mean_statistics["max"] - $mean_statistics["min"]), 2) . "}, {v: undefined}, {v: undefined}";
    $append = $append . ", {v: " . round(($document["lm_events"]["sum"] - $sum_statistics["min"]) / ($sum_statistics["max"] - $sum_statistics["min"]), 2) . "}, {v: undefined}, {v: undefined}";
    $append = $append . ", {v: " . round(($document["lm_events"]["median"] - $median_statistics["min"]) / ($median_statistics["max"] - $median_statistics["min"]), 2) . "}, {v: undefined}, {v: undefined}";
    $append = $append . ", {v: " . round(($document["lm_events"]["count"] - $eventcount_statistics["min"]) / ($eventcount_statistics["max"] - $eventcount_statistics["min"]), 2) . "}, {v: undefined}, {v: undefined}";

    $append = $append . "]},";
}
$string = $string . $append . "] }";
echo $string;

?>
);

                chart = new google.visualization.AnnotatedTimeLine(document.getElementById('chart_div'));
                chart.draw(data, {thickness: 1, displayExactValues: true});

            }

            function redraw(checkboxes) {

            }

            function handleClick(checkboxes) {
                var hidecolumns = new Array();
                var showcolumns = new Array();

                hidecolumns.push(0);
                showcolumns.push(0);


                if (checkboxes.rawmpqa.checked) {
                    for (var i = 1; i <= 3; i++)
                        showcolumns.push(i);
                }
                else {
                    for (var i = 1; i <= 3; i++)
                        hidecolumns.push(i);
                }

                if (checkboxes.rawafinn.checked) {
                    for (var i = 4; i <= 6; i++)
                        showcolumns.push(i);
                }
                else {
                    for (var i = 4; i <= 6; i++)
                        hidecolumns.push(i);
                }

                if (checkboxes.rawliwc.checked) {
                    for (var i = 7; i <= 9; i++)
                        showcolumns.push(i);
                }
                else {
                    for (var i = 7; i <= 9; i++)
                        hidecolumns.push(i);
                }

                if (checkboxes.topicmpqa.checked) {
                    for (var i = 10; i <= 12; i++)
                        showcolumns.push(i);
                }
                else {
                    for (var i = 10; i <= 12; i++)
                        hidecolumns.push(i);
                }

                if (checkboxes.topicafinn.checked) {
                    for (var i = 13; i <= 15; i++)
                        showcolumns.push(i);
                }
                else {
                    for (var i = 13; i <= 15; i++)
                        hidecolumns.push(i);
                }

                if (checkboxes.topicliwc.checked) {
                    for (var i = 16; i <= 18; i++)
                        showcolumns.push(i);
                }
                else {
                    for (var i = 16; i <= 18; i++)
                        hidecolumns.push(i);
                }

                if (checkboxes.mean.checked) {
                    for (var i = 19; i <= 21; i++)
                        showcolumns.push(i);
                }
                else {
                    for (var i = 19; i <= 21; i++)
                        hidecolumns.push(i);
                }

                if (checkboxes.sum.checked) {
                    for (var i = 22; i <= 24; i++)
                        showcolumns.push(i);
                }
                else {
                    for (var i = 22; i <= 24; i++)
                        hidecolumns.push(i);
                }

                if (checkboxes.median.checked) {
                    for (var i = 25; i <= 27; i++)
                        showcolumns.push(i);
                }
                else {
                    for (var i = 25; i <= 27; i++)
                        hidecolumns.push(i);
                }

                if (checkboxes.eventcount.checked) {
                    for (var i = 28; i <= 30; i++)
                        showcolumns.push(i);
                }
                else {
                    for (var i = 28; i <= 30; i++)
                        hidecolumns.push(i);
                }

                var view = new google.visualization.DataView(data);
                view.setColumns(showcolumns);
                chart.draw(view, {thickness: 1, displayExactValues: true});

            }

        </script>
    </head>

    <body>
        <div id='control'>
<!--            <P>Positive Sentiment Percentage</P>-->
            <form>
                <b>Sentiment:</b>
                <!--<input type="checkbox" name="influenza" onclick="handleClick(this.form)" />influenza-->
                <input type="checkbox" name="rawmpqa" onclick="handleClick(this.form)" />raw-mpqa
                <input type="checkbox" name="rawafinn" onclick="handleClick(this.form)" />raw-afinn
                <input type="checkbox" name="rawliwc" onclick="handleClick(this.form)" />raw-liwc
                
                <input type="checkbox" name="topicmpqa" onclick="handleClick(this.form)" />topic-mpqa
                <input type="checkbox" name="topicafinn" onclick="handleClick(this.form)" />topic-afinn
                <input type="checkbox" name="topicliwc" onclick="handleClick(this.form)" />topic-liwc

                <br><b>Lockheed Martin Event Index:</b>
                <input type="checkbox" name="mean" onclick="handleClick(this.form)" />mean
                <input type="checkbox" name="sum" onclick="handleClick(this.form)" />sum
                <input type="checkbox" name="median" onclick="handleClick(this.form)" />median
                <input type="checkbox" name="eventcount" onclick="handleClick(this.form)" />eventcount

            </form>
        </div>
        <div id='chart_div' style='width: 1100px; height: 300px;'></div>

    </body>
</html>