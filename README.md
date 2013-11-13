monit-pi
========

Monitoring of a Raspberry PI


These scripts are intended to give you some insights about the usage
of your Raspberry. If you also have hooked on it some probes via GPIO
e.g., you can follow the evolution of the metrics (for instance your
home temperature).

There are two parts to make this happen:
   - Python scripts (in the ./monit/ directory) which gathers all the
     metrics;
   - PHP scripts (in the ./www/ directory) to view the different graphics.

All the metrics are defined in the ./monit/def_metrics.py file. All the
RRDs databases are defined in the ./monit/def_rrds.py file. If you feel
the need to modify the look and shape of the graphics, you should look
into the ./www/monit.inc.php.

If you need help or insights about RRD, a good starting point but also
references can be found here: http://oss.oetiker.ch/rrdtool/doc/index.en.html


INSTALL
=======
   - Install the RRD API for PHP and Python. On Raspbian, the packages are
     php5-rrd and python-rrdtool;
   - Create a directory (e.g. "/var/lib/monit") where you will store the 
     RRD files (the metric  historial databases);
   - Modify the variable "path_rrd" in ./monit/def_metrics.py and 
     ./www/monit.inc.php (beginning of the file) to reflect your choice;
   - Make this directory Read/Write for the user that will launch the 
     Python script and Read-Only for the user owning the webserver process 
     that will serve the graphics (see below steps);
   - Add in your crontab an entry to launch the Python scripts every 5 min. 
     For instance, you can create a file in /etc/cron.d/, with the following 
     content:

     */5 * * * *     pi      /usr/bin/python /home/pi/monit/monit.py

   - Make the PHP scripts available from a webserver able to interpret PHP 
     (Apache, nginx, or any other choice). To test, you can also launch 
     "php -S localhost:10005" in the directory where the scripts reside.
   - Make sure the user owning the webserver process have write access to
     the directory ./www/cache where we will store the PNG files to avoid
     generating them at each request.

That's all Folks!
