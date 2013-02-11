<?php

/* #################################
 * PHPMapTraceroute
 *
 * 2012-2013 MBE, MBELabs.ch
 *
 * v0.2b
 */#################################

include("inc/geoip/geoipcity.inc");

function debug_print($data) {
    echo('<pre>');
    print_r($data);
    echo('</pre>');
}

function getLocation($ip) {

    global $route;

    $num = count($route);
    $gi = geoip_open("inc/geoip/GeoLiteCity.dat", GEOIP_STANDARD);
    $data = geoip_record_by_addr($gi, $ip);

    $route[$num]['ip'] = $ip;
    $route[$num]['latitude'] = $data->latitude;
    $route[$num]['longitude'] = $data->longitude;

    geoip_close($gi);
    
}

function traceHost($host) {

    global $route;
    global $srvip;

    if (stristr(PHP_OS, 'WIN')) {
        // Win
        exec("tracert $host", $trace);
    } else {
        // Other
        exec("traceroute $host", $trace);
    }
    
    //debug_print($trace);
    
    $rawnodes = array();
    foreach ($trace as $host) {
        if (stristr(PHP_OS, 'WIN')) {
            // Win
            preg_match("#\[[0-9.]+\]#", $host, $rawnodes[]);
        } else {
            preg_match("#\([0-9.]+\)#", $host, $rawnodes[]);
        }
    }
    
        //debug_print($rawnodes);
        
    $nodes = array();
    $i = 0;
    //$nodes[] = $srvip;
    if (stristr(PHP_OS, 'WIN')) {
        // Win
        foreach ($rawnodes as $tmpnode) {
            if (isset($tmpnode[0])) {
                if ($i >= 2) {
                    $nodes[] = substr($tmpnode[0], 1, strlen($tmpnode[0]) - 2);
                }
                $i++;
            }
        }
    } else {
        // Other
        foreach ($rawnodes as $tmpnode) {
            if (isset($tmpnode[0])) {
                if ($i >= 3) {
                    $nodes[] = substr($tmpnode[0], 1, strlen($tmpnode[0]) - 2);
                }
                $i++;
            }
        }
    }
    //debug_print($nodes);
    global $jsnodelist;
    global $jspathlist;
    
    foreach ($nodes as $node) {
        getLocation($node);
    }

    foreach ($route as $jsnode) {
        $jsnodelist[] = "{lat:" . $jsnode['latitude'] . ",lng:" . $jsnode['longitude'] . "}";
        $jspathlist[] = "[" . $jsnode['latitude'] . "," . $jsnode['longitude'] . "]";
    }
}

function get_ip() {
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

?>