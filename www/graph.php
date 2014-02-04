<?php
include('monit.inc.php');

if (isset($_GET['graph']) && in_array($_GET['graph'], array_keys($rrds)))
    $graph = $_GET['graph'];
else {
    header('HTTP/1.1 404 Not found');
    exit();
}

if (isset($_GET['period']) && in_array($_GET['period'], array_keys($periods)))
    $period = $_GET['period'];
else
    $period = 'daily';

$output = "cache/$graph-$period.svg";
$options = array_merge(array('-a', 'SVG', '-w', '600', '-h', '200'), $periods[$period], array_map('utf8_encode', $rrds[$graph]['graph']));

//print_r($options);

if (!file_exists($output) || (time()-filemtime($output) > $periods[$period][3])) {
    rrd_graph($output, $options);
}

header('Content-Type: image/svg+xml');
//header('Content-Length: '.@filesize($output));
readfile($output);
flush();
exit();
