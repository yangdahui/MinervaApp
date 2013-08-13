
var pointarray, heatmap;

var taxiData = [
    new google.maps.LatLng(38.882551, -77.035368),
    new google.maps.LatLng(38.882745, -77.034586),
    new google.maps.LatLng(38.882842, -77.033688),
    new google.maps.LatLng(38.882919, -77.032815),
    new google.maps.LatLng(38.882992, -77.032112),
    new google.maps.LatLng(38.883100, -77.031461),
    new google.maps.LatLng(38.891385, -77.031312),
    new google.maps.LatLng(38.891405, -77.030776),
    new google.maps.LatLng(38.891288, -77.030528),
    new google.maps.LatLng(38.891113, -77.030441),
    new google.maps.LatLng(38.891027, -77.030395),
    new google.maps.LatLng(38.891094, -77.030311),
    new google.maps.LatLng(38.891211, -77.030183),
    new google.maps.LatLng(38.891060, -77.039334),
    new google.maps.LatLng(38.890538, -77.038718),
    new google.maps.LatLng(38.890095, -77.038086),
    new google.maps.LatLng(38.889644, -77.037360),
    new google.maps.LatLng(38.889254, -77.036844),
    new google.maps.LatLng(38.888855, -77.036397),
    new google.maps.LatLng(38.888483, -77.035963),
    new google.maps.LatLng(38.888015, -77.035365),
    new google.maps.LatLng(38.887558, -77.034735),
    new google.maps.LatLng(38.887472, -77.034323),
    new google.maps.LatLng(38.887630, -77.034025),
    new google.maps.LatLng(38.887767, -77.033987),
    new google.maps.LatLng(38.887486, -77.034452),
    new google.maps.LatLng(38.886977, -77.035043),
    new google.maps.LatLng(38.886583, -77.035552),
    new google.maps.LatLng(38.886540, -77.035610),
    new google.maps.LatLng(38.886516, -77.035659),
    new google.maps.LatLng(38.886378, -77.035707),
    new google.maps.LatLng(38.886044, -77.035362),
    new google.maps.LatLng(38.885598, -77.034715),
    new google.maps.LatLng(38.885321, -77.034361),
    new google.maps.LatLng(38.885207, -77.034236),
    new google.maps.LatLng(38.885751, -77.034062),
    new google.maps.LatLng(38.885996, -77.033881),
    new google.maps.LatLng(38.886092, -77.033830),
    new google.maps.LatLng(38.885998, -77.033899),
    new google.maps.LatLng(38.885114, -77.034365),
    new google.maps.LatLng(38.885022, -77.034441),
    new google.maps.LatLng(38.884823, -77.034635),
    new google.maps.LatLng(38.884719, -77.034629),
    new google.maps.LatLng(38.885069, -77.034176),
    new google.maps.LatLng(38.885500, -77.033650),
    new google.maps.LatLng(38.885770, -77.033291),
    new google.maps.LatLng(38.885839, -77.033159),
    new google.maps.LatLng(38.882651, -77.030628),
    new google.maps.LatLng(38.882616, -77.030599),
    new google.maps.LatLng(38.882702, -77.030470),
    new google.maps.LatLng(38.882915, -77.030192),
    new google.maps.LatLng(37.801740, -77.032905),
    new google.maps.LatLng(37.801069, -77.032785),
    new google.maps.LatLng(37.800345, -77.032649),
    new google.maps.LatLng(38.899633, -77.032603),
    new google.maps.LatLng(38.899750, -77.031700),
    new google.maps.LatLng(38.899885, -77.030854),
    new google.maps.LatLng(38.899209, -77.030607),
    new google.maps.LatLng(38.895656, -77.030395),
    new google.maps.LatLng(38.895203, -77.030304),
    new google.maps.LatLng(38.870467, -77.039801),
    new google.maps.LatLng(38.870090, -77.038904),
    new google.maps.LatLng(38.869657, -77.038103),
    new google.maps.LatLng(38.869132, -77.037276),
    new google.maps.LatLng(38.868564, -77.036469),
    new google.maps.LatLng(38.867980, -77.035745),
    new google.maps.LatLng(38.867380, -77.035299),
    new google.maps.LatLng(38.866604, -77.035297),
    new google.maps.LatLng(38.865838, -77.035200),
    new google.maps.LatLng(38.865139, -77.035139),
    new google.maps.LatLng(38.864457, -77.035094),
    new google.maps.LatLng(38.863716, -77.035142),
    new google.maps.LatLng(38.862932, -77.035398),
    new google.maps.LatLng(38.862126, -77.035813),
    new google.maps.LatLng(38.861344, -77.036215),
    new google.maps.LatLng(38.860556, -77.036495),
    new google.maps.LatLng(38.899732, -77.036484),
    new google.maps.LatLng(38.898910, -77.036228),
    new google.maps.LatLng(38.898182, -77.035695),
    new google.maps.LatLng(38.897676, -77.035118),
    new google.maps.LatLng(38.897039, -77.034346),
    new google.maps.LatLng(38.896335, -77.033719),
    new google.maps.LatLng(38.895503, -77.033406),
    new google.maps.LatLng(38.894665, -77.033242),
    new google.maps.LatLng(38.893837, -77.033172),
    new google.maps.LatLng(38.892986, -77.033112),
    new google.maps.LatLng(38.891266, -77.033355)
];


google.maps.visualRefresh = true;

var map;
var markers = [];

function initialize() {
    var myLatlng = new google.maps.LatLng(38.89, -77.03);

    var mapOptions = {
        zoom: 8,
        center: myLatlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById('googlemap-canvas'),
            mapOptions);

    // heatmap with taxiData pointarray 
    pointArray = new google.maps.MVCArray(taxiData);

    heatmap = new google.maps.visualization.HeatmapLayer({
        data: pointArray
    });

    heatmap.setOptions({radius: 30});

    // heatmap.setMap(map);       

    //
    // information box with event messages

    //content of message
    var contentString = '<div id="content">' +
            '<div id="siteNotice">' +
            '</div>' +
            '<h2 id="firstHeading" class="firstHeading">Anti-Gaddafi uprising</h1>' +
            '<div id="bodyContent">' +
            '<p>2012 January - Clashes erupt between former rebel forces in Benghazi \n\
        in sign of discontent with the pace and nature of change under the governing NTC. \n\
        The deputy head of the NTC, Abdel Hafiz Ghoga, resigns\n\</p>' +
            '</div>' +
            '</div>';

    //information windows   
    var infowindow = new google.maps.InfoWindow({
        content: contentString,
        maxWidth: 400
    });

    //attached infowindow with a geo-located marker
    var marker = new google.maps.Marker({
        position: myLatlng,
        map: map,
        title: 'event 1'
    });

    //endof information box with event messages
    //

    google.maps.event.addListener(marker, 'click', function() {
        infowindow.open(map, marker);
    });
    
    google.maps.event.addListener(map, 'click', function(event) {
        addMarker(event.latlng);
    });

}
//
//function toggleHeatmap() {
//    heatmap.setMap(heatmap.getMap() ? null : map);
//}


google.maps.event.addDomListener(window, 'load', initialize);




//add new marker into markers array
function addMarker(location) {
    marker = new google.maps.Marker({
        position: location,
        map: map
    });
    markers.push(marker);
}

//set markers array on map
function setMarkersOnMap(map) {
    for (var i = 0; i < markers.length; i++) {
        markers[i].setMap(map);
    }
}


function testfunction() {

    var minlat = 39.80;
    var maxlat = 39.90;

    var minlng= 79.00;
    var maxlng = 79.10;
   

    var lat = Math.floor(Math.random() * (maxlat - minlat + 1)) + minlat;
    var lng = (Math.floor(Math.random() * (maxlng - minlng + 1)) + minlng ) *(-1);

    //var myLatlng2 = new google.maps.LatLng(39.89, -79.03);
    var ramLatLng = new google.maps.LatLng(lat, lng);
    addMarker(ramLatLng);
    
}

