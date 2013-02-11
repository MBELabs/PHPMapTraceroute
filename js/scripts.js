/*#################################
 * PHPMapTraceroute
 * 
 * 2012-2013 MBE, MBELabs.ch
 * 
 * v0.2b
 *#################################
 */

$(function(){
    $("#trace").gmap3({
        map:{
            center:[47.1724,8.5174],
            zoom: 6,
            mapTypeId: google.maps.MapTypeId.TERRAIN
        },
        polyline:{
            options:{
                strokeColor: "#FF9900",
                strokeOpacity: 1.0,
                strokeWeight: 2,
                clickable: false,
                geodesic: true,
                path: pathList
            }
        },
        marker: {
            values:nodesList,
            options: {
                icon: new google.maps.MarkerImage('img/server_0.png')
            },
            cluster:{
                radius:50,
                // This style will be used for clusters with more than 0 markers
                0: {
                    content: '<div class="cluster cluster-1">CLUSTER_COUNT</div>',
                    width: 64,
                    height: 64
                },
                // This style will be used for clusters with more than 20 markers
                5: {
                    content: '<div class="cluster cluster-2">CLUSTER_COUNT</div>',
                    width: 64,
                    height: 64
                }
            }

        }
    
    });
});