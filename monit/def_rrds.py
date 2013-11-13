# vim: set fileencoding=utf-8 sw=4 ts=4 et:

RRAs_avg = [
    'RRA:AVERAGE:0.5:6:700',
    'RRA:AVERAGE:0.5:24:775',
    'RRA:AVERAGE:0.5:288:797',
]

RRAs_max = [
    'RRA:MAX:0.5:6:700',
    'RRA:MAX:0.5:24:775',
    'RRA:MAX:0.5:288:797',
]

rrds = {
    'temp': [ 'DS:temp:GAUGE:600:U:U' ] + RRAs_avg,
    'pitemp': [ 'DS:temp:GAUGE:600:U:U' ] + RRAs_avg,
    'uptime': [ 'DS:uptime:GAUGE:600:U:U' ] + RRAs_avg,
    'memory': [ 'DS:ram:GAUGE:600:U:U', 'DS:swap:GAUGE:600:U:U' ] + RRAs_avg,
    'cpuload': [ 'DS:user:COUNTER:600:0:101', 'DS:nice:COUNTER:600:0:101', 'DS:system:COUNTER:600:0:101', 'DS:idle:COUNTER:600:0:101', 'DS:iowait:COUNTER:600:0:101' ] + RRAs_avg,
    'network': [
        [ 'DS:input:COUNTER:600:U:U', 'DS:output:COUNTER:600:U:U' ] + RRAs_avg + RRAs_max,
        [ 'DS:input:COUNTER:600:U:U', 'DS:output:COUNTER:600:U:U' ] + RRAs_avg + RRAs_max,
    ],
    'disk': [ 'DS:read:COUNTER:600:U:U', 'DS:write:COUNTER:600:U:U' ] + RRAs_avg,
    'nginx': [
        [ 'DS:read:GAUGE:600:U:U', 'DS:write:GAUGE:600:U:U', 'DS:wait:GAUGE:600:U:U' ] + RRAs_avg + RRAs_max,
        [ 'DS:accept:COUNTER:600:U:U', 'DS:handled:COUNTER:600:U:U', 'DS:req:COUNTER:600:U:U' ] + RRAs_avg + RRAs_max,
    ],
    'ping': [ 'DS:min:GAUGE:600:U:U', 'DS:max:GAUGE:600:U:U' ] + RRAs_avg,
}


