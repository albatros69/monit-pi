<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title>Monitoring of <?php echo gethostname();?></title>
        <meta http-equiv="refresh" content="300" />
        <meta http-equiv="pragma" content="no-cache" />
        <meta http-equiv="cache-control" content="no-cache" />
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    </head>

    <style>
        img { width: 100%; height: auto; max-width: 700px; }
        div.graph { display: inline-block; margin-right: 1em; }
    </style>

    <body>
<?php
include('monit.inc.php');

if (isset($_GET['graph']) && in_array($_GET['graph'], array_keys($rrds)))
    $graph = $_GET['graph'];

if (isset($_GET['period']) && in_array($_GET['period'], array_keys($periods)))
    $period = $_GET['period'];

echo '<h1>Monitoring of '.gethostname()."</h1>\n";

if (isset($graph)) {
    echo "<h2>{$rrds[$graph]['title']}</h2>\n";
    foreach (array_keys($periods) as $p) {
        echo '<div class="graph"><h3>'.ucfirst($p)." graph</h3>\n";
        echo "<p><a href='${_SERVER['PHP_SELF']}?period=$p'><img src='graph.php?graph=$graph&amp;period=$p'></a></p></div>\n";
    }
}
elseif (isset($period)) {
    echo '<h2>'.ucfirst($period)." graphs</h2>\n";
    foreach ($rrds as $g => $v) {
        echo "<div class=\"graph\"><h3>{$v['title']}</h3>\n";
        echo "<p><a href='${_SERVER['PHP_SELF']}?graph=$g'><img src='graph.php?graph=$g&amp;period=$period'></a></p></div>\n";
    }
}
else {
    echo "<ul>\n<li>Monitoring summary: ";
    foreach (array_keys($periods) as $p)
        echo " <a href='{$_SERVER['PHP_SELF']}?period=$p'>$p</a>";
    echo "</li>\n";
    foreach ($rrds as $g => $v)
        echo "<li><a href='${_SERVER['PHP_SELF']}?graph=$g'>{$v['title']}</a></li>\n";
      
}    

?>
    </body>
</html>
