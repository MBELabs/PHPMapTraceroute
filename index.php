<?php
/* #################################
 * PHPMapTraceroute
 *
 * 2012-2013 MBE, MBELabs.ch
 *
 * v0.2b
 */#################################

$route = array();
$jsnodelist = array();
$jspathlist = array();

include("core/core.php");

if (isset($_GET['basehost'])) {
    $srvip = $_GET['basehost'];
} else {
    $srvip = $_SERVER['HTTP_HOST'];
}

//debug_print($route);
//debug_print($jsnodelist);
?>
<html>
    <head>
        <title>PHPMapTraceroute</title>
        <link rel="stylesheet" href="css/styles.css" type="text/css" />
        <script type="text/javascript" src="js/jquery-1.9.0.min.js"></script>

        <?php
        if (!isset($_GET['tracehost'])) {

            $remoteip = get_ip();

            echo('</head>
                    <body>
                        <form action="" method="get">
                            <img src="img/server_m.png" /><br/>
                            <h1>PHPMapTraceroute</h1>
                            <h2>Your IP : ' . $remoteip . '</h2>
                            <input class="txt" type="text" name="tracehost" placeholder="Host" /><br/>
                            <!--<input class="txt" type="text" name="basehost" placeholder="Base IP" />--><br/>
                            <input class="btn" type="submit" value="Trace"/>
              <p id="maxmindcopy">This product includes GeoLite data created by MaxMind, available from <br/><a href="http://www.maxmind.com" target"_blank">http://www.maxmind.com</a></p>
                        </form>
                    </body>
                </html>');
        } else {
            traceHost($_GET['tracehost']);
            ?>
            <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
            <script type="text/javascript" src="js/gmap3.min.js"></script>
            <script>
                var nodesList= [
    <?php
    $nbrlist = count($jsnodelist);
    $i = 1;
    foreach ($jsnodelist as $list) {
        echo($list);
        if ($i != $nbrlist) {
            echo(",\r\n");
        }
        $i++;
    }
    ?>
        ];
        var pathList= [
    <?php
    $nbrlist = count($jspathlist);
    $i = 1;
    foreach ($jspathlist as $list) {
        echo($list);
        if ($i != $nbrlist) {
            echo(",\r\n");
        }
        $i++;
    }
    ?>
        ];
            </script>
            <script src="js/scripts.js"></script>
        </head>
        <body>
            <div id="trace"></div>
        </body>
    </html>
    <?php
}
?>