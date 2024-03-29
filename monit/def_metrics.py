# vim: set fileencoding=utf-8 sw=4 ts=4 et:

import multiprocessing
from urllib.request import urlopen
from subprocess import check_output

# To be adapted to your platform
nb_cpu = multiprocessing.cpu_count()
path_rrd = '/var/lib/monit'

metrics = {
    'temp':    { 'rrd': path_rrd+'/temp.rrd', },
    'pitemp':  { 'rrd': path_rrd+'/pitemp.rrd', },
    'uptime':  { 'rrd': path_rrd+'/uptime.rrd', },
    'memory':  { 'rrd': path_rrd+'/memory.rrd', },
    'cpuload': { 'rrd': [ path_rrd+'/cpuload-%d.rrd' % i for i in range(nb_cpu) ], },
    'network': { 'rrd': [ path_rrd+'/net_bytes.rrd', path_rrd+'/net_packets.rrd', ], },
    'disk':    { 'rrd': path_rrd+'/disk.rrd', },
    'nginx':   { 'rrd': [ path_rrd+'/nginx_act.rrd', path_rrd+'/nginx_hist.rrd' ], },
    'ping':    { 'rrd': path_rrd+'/ping.rrd', },
}

def _get_temp():
    try:
        with open('/sys/bus/w1/devices/28-00000458fd58/w1_slave', 'r') as f:
            if f.readline().strip().endswith('YES'):
                return '%.2f' % (float(f.readline().split('=')[-1].strip())/1000, )
            else:
                return 'U'
    except:
        return 'U'

def _get_pitemp():
    try:
        with open('/sys/class/thermal/thermal_zone0/temp', 'r') as f:
            return '%.2f' % (float(f.read().strip())/1000, )
    except:
        return 'U'

def _get_uptime():
    with open('/proc/uptime', 'r') as f:
        return '%.2f' % (float(f.read().split()[0].strip())/86400, )

def _get_memory():
    with open('/proc/meminfo', 'r') as f:
        for line in f:
            if line.startswith('SwapFree'):
                swap = str(int(line.split()[1])*1024)
            elif line.startswith('MemFree'):
                mem = str(int(line.split()[1])*1024)
        return (mem, swap)
    return ('U', 'U', )

def _get_cpuload():
    with open('/proc/stat', 'r') as f:
        cpu_lst = [ 'cpu%d' % i for i in range(nb_cpu) ]
        result = []
        for line in f:
            tmp = line.split()
            if tmp[0] in cpu_lst:
                result.append(tuple( tmp[i] for i in range(1, 6) ))
        return result
    return ( ( 'U', ) * 5, ) * nb_cpu

def _get_network():
    with open('/proc/net/dev', 'r') as f:
        for line in f:
            if line.strip().startswith('eth0'):
                tmp = line.strip().split()
                # I/O bytes, I/O packets
                return [ (tmp[1], tmp[9]), (tmp[2], tmp[10]) ]
    return [ ('U', 'U'), ('U', 'U') ]

def _get_disk():
    with open('/proc/diskstats', 'r') as f:
        for line in f:
            tmp = line.strip().split()
            if tmp[2] == 'mmcblk0':
                # read/write
                return (tmp[6], tmp[10])
    return ('U', 'U', )

def _get_nginx():
    try:
        f = urlopen('http://localhost/nginx_status')
        for line in f.readlines():
            if line.startswith(' '):
                # conn. accepted, handled, and requests
                hist = line.strip().split()
            elif line.startswith('Reading'):
                # Reading: 0 Writing: 1 Waiting: 0
                tmp = line.strip().split()
                act = [ tmp[n] for n in (1, 3, 5) ]
        return act, hist
    except:
        return ['U', 'U', 'U'], ['U', 'U', 'U']

def _get_ping():
    cmd = [ 'ping', '-n', '-c3', '-q', 'www.google.com' ]
    try:
        for line in check_output(cmd).decode('utf-8').splitlines():
            if line.startswith('rtt '):
                tmp = line.split('=')[1].strip().split('/')
                return (tmp[0], tmp[2])
    except:
        return ('U', 'U')
    else:
        return ('U', 'U')
