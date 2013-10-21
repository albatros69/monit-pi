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

$output = "cache/$graph-$period.png";
$options = array_merge(array('-a', 'PNG', '-w', '600', '-h', '200'), $periods[$period], array_map('utf8_encode', $rrds[$graph]['graph']));

//print_r($options);

$time = explode(' ', microtime());
if (!file_exists($output) || ($time[1]-filemtime($output) > $periods[$period][3])) {
    rrd_graph($output, $options);
}

header('Content-Type: image/png');
header('Content-Length: '.@filesize($output));
readfile($output);
exit();

?>