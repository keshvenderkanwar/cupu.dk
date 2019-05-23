<div align="center">
    <div  id="map" style="width:100%;height:580px;margin-left: 15px;"></div>
</div>
<script>
    function myMap() {
        var myCenter = new google.maps.LatLng(55.6979808, 12.4234662);
        var mapCanvas = document.getElementById("map");
        var mapOptions = {center: myCenter, zoom: 12};
        var map = new google.maps.Map(mapCanvas, mapOptions);
        var bounds = new google.maps.LatLngBounds();
<?php foreach ($Units as $value) {

    ?>
            var marker = new google.maps.Marker({
                position: <?php echo "{lat: " . $value["Lat"] . ", lng: " . $value["Lng"] . "}" ?>,
//                label: <?php // echo "\"" . $value["SerialNo"] . "\"" ?>,
                map: map
            });
                <?php if($ErrorCodes[$value["SerialNo"]] == 0){
                        ?>
                             marker.setIcon('https://maps.google.com/mapfiles/ms/icons/green-dot.png');
                        <?php
                    }else{
                        ?>
                            marker.setIcon('https://maps.google.com/mapfiles/ms/icons/red-dot.png');
                        <?php
                    }
                ?>
            var infowindow = new google.maps.InfoWindow({
                content: <?php echo "\"SerialNo: " . $value["SerialNo"] . "\"" ?>
            });
            infowindow.open(map, marker);
            bounds.extend(marker.position);
<?php }
?>
        map.fitBounds(bounds);
    }
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCwMXYpJKgkMy6i-ttccnmSZwdmmSJzZew&v=3&callback=myMap"></script>
<!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCf1McAIOUYaqzjscsaLUxZ84AonzDkXP4&v=3&callback=myMap"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCR6vEPDTSPn0jAojG82kKcC44qeBfMofU&v=3&callback=myMap"></script>
<script src="https://maps.googleapis.com/maps/api/js?sensor=true&v=3&callback=myMap"></script>-->