#! /usr/bin/python
# vim: set fileencoding=utf-8 sw=4 ts=4 et:

import rrdtool, os
from def_rrds import rrds
import def_metrics
from def_metrics import metrics

for m in metrics:
    if isinstance(metrics[m]['rrd'], list):
        # multiples rrds
        for i,f in enumerate(metrics[m]['rrd']): 
            if not os.path.isfile(f):
                rrdtool.create(f, rrds[m][i])
    else:
        if not os.path.isfile(metrics[m]['rrd']):
            rrdtool.create(metrics[m]['rrd'], rrds[m])

    values = getattr(def_metrics, '_get_'+m)()
    #print m, repr(values)
    if isinstance(metrics[m]['rrd'], list):
        # multiples rrds
        for i,f in enumerate(metrics[m]['rrd']):
            rrdtool.update(f, 'N:'+':'.join(values[i]))
    else:
        if isinstance(values, str) or isinstance(values, unicode):
            rrdtool.update(metrics[m]['rrd'], 'N:%s' % values)
        else: # tuple
            rrdtool.update(metrics[m]['rrd'], 'N:'+':'.join(values))
