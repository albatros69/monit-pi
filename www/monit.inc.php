<?php

$path_rrd = '/var/lib/monit';
$now = date('Y-m-d H\\\\:i\\\\:s');

$periods = array(
    'daily' => array('--start', '-36h', '--step', '300'),
    'weekly' => array('--start', '-8d', '--step', '1800'),
    'monthly' => array('--start', '-5w', '--step', '7200'),
    'yearly' => array('--start', '-14months', '--step', '86400'),
);

$rrds = array(
    'temp' => array('title' => 'Home temperature',
                    'graph' => array('-v', '°C', "DEF:temp=$path_rrd/temp.rrd:temp:AVERAGE:step=300", 'COMMENT:      ', 'COMMENT:Maximum ', 'COMMENT:Average ', 'COMMENT:Minimum  ', 'COMMENT:Current  ', "COMMENT:Generated $now\l", 'LINE1:temp#FFAE00:t° ', 'GPRINT:temp:MAX:%5.1lf °C', 'GPRINT:temp:AVERAGE:%5.1lf °C', 'GPRINT:temp:MIN:%5.1lf °C', 'GPRINT:temp:LAST:%5.1lf °C\l')
    ),
    'pitemp' => array('title' => 'Raspberry temperature',
                      'graph' => array('-v', '°C', "DEF:temp=$path_rrd/pitemp.rrd:temp:AVERAGE:step=300", 'COMMENT:      ', 'COMMENT:Maximum ',    'COMMENT:Average ', 'COMMENT:Minimum  ', 'COMMENT:Current  ', "COMMENT:Generated $now\l", 'LINE1:temp#FF0000:t° ', 'GPRINT:temp:MAX:%5.1lf °C', 'GPRINT:temp:AVERAGE:%5.1lf °C', 'GPRINT:temp:MIN:%5.1lf °C', 'GPRINT:temp:LAST:%5.1lf °C\l')
    ),
    'uptime' => array('title' => 'Uptime',
                      'graph' => array('-v', 'day', "DEF:uptime=$path_rrd/uptime.rrd:uptime:AVERAGE:step=300", "COMMENT:Generated $now\l", 'LINE1:uptime#FFAE00:')
    ),
    'memory' => array('title' => 'Memory and Swap',
                      'graph' => array('-v', 'bytes', '--base', '1024', '--alt-autoscale-max', "DEF:ram=$path_rrd/memory.rrd:ram:AVERAGE:step=300", "DEF:swap=$path_rrd/memory.rrd:swap:AVERAGE:step=300", 'COMMENT:            ', 'COMMENT:Maximum ', 'COMMENT:Average ', 'COMMENT:Minimum  ', 'COMMENT:Current ', "COMMENT:Generated $now\l", 'AREA:ram#00FF00:Free RAM  ', 'GPRINT:ram:MAX:%5.1lf %SB', 'GPRINT:ram:AVERAGE:%5.1lf %SB', 'GPRINT:ram:MIN:%5.1lf %SB', 'GPRINT:ram:LAST:%5.1lf %SB\l', 'LINE1:swap#0000FF:Free swap ', 'GPRINT:swap:MAX:%5.1lf %SB', 'GPRINT:swap:AVERAGE:%5.1lf %SB', 'GPRINT:swap:MIN:%5.1lf %SB', 'GPRINT:swap:LAST:%5.1lf %SB\l')
    ),
    'cpuload' => array('title' => 'CPU Load',
                       'graph' => array('-v', '%', '--alt-autoscale-max', "DEF:rawuser=$path_rrd/cpuload.rrd:user:AVERAGE:step=300", "DEF:rawnice=$path_rrd/cpuload.rrd:nice:AVERAGE:step=300", "DEF:rawsystem=$path_rrd/cpuload.rrd:system:AVERAGE:step=300", 'CDEF:user=100,rawuser,*', 'CDEF:nice=100,rawnice,*', 'CDEF:system=100,rawsystem,*', 'COMMENT:         ', 'COMMENT:Maximum ', 'COMMENT:Average ', 'COMMENT:Minimum  ', 'COMMENT:Current  ', "COMMENT:Generated $now\l", 'AREA:user#FF0000:User  ', 'GPRINT:user:MAX:%6.2lf %%', 'GPRINT:user:AVERAGE:%6.2lf %%', 'GPRINT:user:MIN:%6.2lf %%', 'GPRINT:user:LAST:%6.2lf %%\l', 'AREA:nice#FFAE00:Nice  :STACK', 'GPRINT:nice:MAX:%6.2lf %%', 'GPRINT:nice:AVERAGE:%6.2lf %%', 'GPRINT:nice:MIN:%6.2lf %%', 'GPRINT:nice:LAST:%6.2lf %%\l', 'AREA:system#B048B5:System:STACK', 'GPRINT:system:MAX:%6.2lf %%', 'GPRINT:system:AVERAGE:%6.2lf %%', 'GPRINT:system:MIN:%6.2lf %%', 'GPRINT:system:LAST:%6.2lf %%\l')
    ),
    'net_bytes' => array('title' => 'Network usage (bytes)',
                         'graph' => array('-v', 'B/s', '--alt-autoscale-max', "DEF:in=$path_rrd/net_bytes.rrd:input:AVERAGE:step=300", "DEF:out=$path_rrd/net_bytes.rrd:output:AVERAGE:step=300", 'VDEF:inpct=in,95,PERCENT', 'VDEF:outpct=out,95,PERCENT', 'COMMENT:          ', 'COMMENT:Maximum    ', 'COMMENT:Average    ', 'COMMENT:Minimum    ', 'COMMENT:Current', "COMMENT:Generated $now\l", 'AREA:in#00FF00:Input ', 'GPRINT:in:MAX:%6.2lf %SB/s', 'GPRINT:in:AVERAGE:%6.2lf %SB/s', 'GPRINT:in:MIN:%6.2lf %SB/s', 'GPRINT:in:LAST:%6.2lf %SB/s\l', 'LINE1:out#0000FF:Output', 'GPRINT:out:MAX:%6.2lf %SB/s', 'GPRINT:out:AVERAGE:%6.2lf %SB/s', 'GPRINT:out:MIN:%6.2lf %SB/s', 'GPRINT:out:LAST:%6.2lf %SB/s\l', 'LINE1:inpct#FF0000:in 95%tile\:', 'GPRINT:inpct:%5.2lf %SB/s', 'LINE1:outpct#FFAE00:out 95%tile\:','GPRINT:outpct:%5.2lf %SB/s\c'),
    ),
    'net_packets' => array('title' => 'Network usage (packets)',
                           'graph' => array('-v', 'p/s', '--alt-autoscale-max', "DEF:in=$path_rrd/net_packets.rrd:input:AVERAGE:step=300", "DEF:out=$path_rrd/net_packets.rrd:output:AVERAGE:step=300", 'VDEF:inpct=in,95,PERCENT', 'VDEF:outpct=out,95,PERCENT', 'COMMENT:          ', 'COMMENT:Maximum    ', 'COMMENT:Average    ', 'COMMENT:Minimum    ', 'COMMENT:Current', "COMMENT:Generated $now\l", 'AREA:in#00FF00:Input ', 'GPRINT:in:MAX:%6.2lf %Sp/s', 'GPRINT:in:AVERAGE:%6.2lf %Sp/s', 'GPRINT:in:MIN:%6.2lf %Sp/s', 'GPRINT:in:LAST:%6.2lf %Sp/s\l', 'LINE1:out#0000FF:Output', 'GPRINT:out:MAX:%6.2lf %Sp/s', 'GPRINT:out:AVERAGE:%6.2lf %Sp/s', 'GPRINT:out:MIN:%6.2lf %Sp/s', 'GPRINT:out:LAST:%6.2lf %Sp/s\l', 'LINE1:inpct#FF0000:in 95%tile\:', 'GPRINT:inpct:%5.2lf %Sp/s', 'LINE1:outpct#FFAE00:out 95%tile\:','GPRINT:outpct:%5.2lf %Sp/s\c'),
    ),
    'disk' => array('title' => 'Disk usage',
                    'graph' => array('-v', 'B/s', '--base', '1024', '--logarithmic', '--units=si', '--alt-autoscale-max', "DEF:rawread=$path_rrd/disk.rrd:read:AVERAGE:step=300", "DEF:rawwrite=$path_rrd/disk.rrd:write:AVERAGE:step=300", 'CDEF:read=1024,rawread,*', 'CDEF:write=1024,rawwrite,*', 'COMMENT:           ', 'COMMENT:Maximum   ', 'COMMENT:Average   ', 'COMMENT:Minimum   ', 'COMMENT:Current  ', "COMMENT:Generated $now\l", 'AREA:read#00FF00:Read  ', 'GPRINT:read:MAX:%5.1lf %SB/s', 'GPRINT:read:AVERAGE:%5.1lf %SB/s', 'GPRINT:read:MIN:%5.1lf %SB/s', 'GPRINT:read:LAST:%5.1lf %SB/s\l', 'LINE1:write#0000FF:Write ', 'GPRINT:write:MAX:%5.1lf %SB/s', 'GPRINT:write:AVERAGE:%5.1lf %SB/s', 'GPRINT:write:MIN:%5.1lf %SB/s', 'GPRINT:write:LAST:%5.1lf %SB/s\l')
    ),
    'nginx_act' => array('title' => 'Nginx activity (active connections)',
                         'graph' => array("DEF:read=$path_rrd/nginx_act.rrd:read:AVERAGE:step=300", "DEF:write=$path_rrd/nginx_act.rrd:write:AVERAGE:step=300", "DEF:wait=$path_rrd/nginx_act.rrd:wait:AVERAGE:step=300", 'COMMENT:            ', 'COMMENT:Maximum    ', 'COMMENT:Average    ', 'COMMENT:Minimum     ', 'COMMENT:Current', "COMMENT:Generated $now\l", 'AREA:read#FF0000:Reading', 'GPRINT:read:MAX:%5.0lf %S', 'GPRINT:read:AVERAGE:%5.0lf %S', 'GPRINT:read:MIN:%5.0lf %S', 'GPRINT:read:LAST:%5.0lf %S\l', 'AREA:write#FF8000:Writing:STACK', 'GPRINT:write:MAX:%5.0lf %S', 'GPRINT:write:AVERAGE:%5.0lf %S', 'GPRINT:write:MIN:%5.0lf %S', 'GPRINT:write:LAST:%5.0lf %S\l', 'AREA:wait#FFFF00:Waiting:STACK', 'GPRINT:wait:MAX:%5.0lf %S', 'GPRINT:wait:AVERAGE:%5.0lf %S', 'GPRINT:wait:MIN:%5.0lf %S', 'GPRINT:wait:LAST:%5.0lf %S\l'),
    ),
    'nginx_hist' => array('title' => 'Nginx activity (connection rate)',
                          'graph' => array('-v', '#/minute', "DEF:rawaccept=$path_rrd/nginx_hist.rrd:accept:AVERAGE:step=300", 'CDEF:accept=60,rawaccept,*', "DEF:rawhandled=$path_rrd/nginx_hist.rrd:handled:AVERAGE:step=300", 'CDEF:handled=60,rawhandled,*', "DEF:rawreq=$path_rrd/nginx_hist.rrd:req:AVERAGE:step=300", 'CDEF:req=60,rawreq,*', 'COMMENT:            ', 'COMMENT:Maximum    ', 'COMMENT:Average    ', 'COMMENT:Minimum     ', 'COMMENT:Current', "COMMENT:Generated $now\l", 'AREA:handled#FF0000:Handled ', 'GPRINT:handled:MAX:%5.0lf %S', 'GPRINT:handled:AVERAGE:%5.0lf %S', 'GPRINT:handled:MIN:%5.0lf %S', 'GPRINT:handled:LAST:%5.0lf %S\l', 'LINE1:accept#0000FF:Accepted', 'GPRINT:accept:MAX:%5.0lf %S', 'GPRINT:accept:AVERAGE:%5.0lf %S', 'GPRINT:accept:MIN:%5.0lf %S', 'GPRINT:accept:LAST:%5.0lf %S\l', 'LINE1:req#000000:Requests', 'GPRINT:req:MAX:%5.0lf %S', 'GPRINT:req:AVERAGE:%5.0lf %S', 'GPRINT:req:MIN:%5.0lf %S', 'GPRINT:req:LAST:%5.0lf %S\l'),
    ),
    'ping' => array('title' => 'Network Latency',
                    'graph' => array('-v', 'ms', "DEF:mini=$path_rrd/ping.rrd:min:AVERAGE:step=300", "DEF:maxi=$path_rrd/ping.rrd:max:AVERAGE:step=300", 'COMMENT:           ', 'COMMENT:Maximum  ', 'COMMENT:Average  ', 'COMMENT:Minimum   ', 'COMMENT:Current  ', "COMMENT:Generated $now\l", 'AREA:mini#00FF00:Minimum', 'GPRINT:mini:MAX:%6.1lf ms', 'GPRINT:mini:AVERAGE:%6.1lf ms', 'GPRINT:mini:MIN:%6.1lf ms', 'GPRINT:mini:LAST:%6.1lf ms', 'COMMENT:   @IP \: 82.228.205.254\l', 'LINE1:maxi#0000FF:Maximum', 'GPRINT:maxi:MAX:%6.1lf ms', 'GPRINT:maxi:AVERAGE:%6.1lf ms', 'GPRINT:maxi:MIN:%6.1lf ms', 'GPRINT:maxi:LAST:%6.1lf ms\l'),
    ),
);
?>