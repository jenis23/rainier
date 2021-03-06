<?php
  $_DISPLAYNEW = false;
  $_DISPLAYLOGIN = false;
  include "nav/default_top.php";
?>
<p>
<font style="font-size:18px"> <strong>Can I get an account on
WSU's <font style="font-size:18px;color:#800000">Rainier</font>?</strong></font>
<p>
Yes, accounts are available for academic use only. You can request an account
<a href="user-signup.php">here</a>.
<p>
<font style="font-size:18px"> <strong>How do I control my
<font style="font-size:18px;color:#800000">Rainier</font> job?</strong></font>
<p>
We now offer a single point of control through a "master" serial forwarer
running on <tt>Rainier.eecs.harvard.edu</tt> on port 20000. Every packet sent
by every mote running on the lab will be routed through this port, and any
packet sent to this port with the destination field in the header set
properly will be routed to the correct Rainier node.
<p>
<font style="font-size:18px"><strong>Where do I get the Python code to
communicate with the Serial Forwarder multiplexer running <font
style="font-size:18px;color:#800000">Rainier</font>?</strong></font>
<p>
To simply the process of communicating with your Rainier job we have
implemented a Serial Forwarder multiplexer. It runs on port 20000 during your
job, and speaks a variant of the TinyOS 2.x Serial Forwarder protocol with an
extra addressing bit determining which Rainier node to route the message to.
<p>
Using this requires a modified version of the TinyOS 2.x Python toolchain
available here:
<pre>
    % svn export http://senseless.eecs.harvard.edu/repos/Rainier/trunk/python/
</pre>
<p>
Once you download our <tt>RainierMoteIF.py</tt>, it serves as a drop in
replacement for <tt>MoteIF.py</tt>:
<pre>
    import RainierMoteIF
    ...
    self.mif = RainierMoteIF.RainierMoteIF()
</pre>
<p>
We have defined a special <tt>Rainier@&lt;host&gt;:&lt;port&gt;</tt> source
which you need to use to connect to the Serial Forwarder multiplexer:
<pre>
    self.mif.addSource("Rainier@Rainier.eecs.harvard.edu")
</pre>
<p>
You can also add the standard <tt>moteif</tt> source as well. Communicating
with this is similar to what you are used to, with the addition of selecting
the Rainier node at send time:
<pre>
    # Rather than:
    # self.mif.sendMsg(&lt;source&gt;, &lt;dest&gt;, &lt;type&gt;, &lt;gid&gt;, &lt;message&gt;)
    # we provide:
    self.mif.sendMsg(&lt;source&gt;, &lt;dest&gt;, &lt;type&gt;, &lt;gid&gt;, &lt;message&gt;, &lt;Rainier_dest&gt;)
</pre>
<p>The difference between the <tt>dest</tt> and <tt>Rainier_dest</tt> fields
in the example above is that the <tt>Rainier_dest</tt> field is used to route
to the node on Rainier, and is stripped on arrival. The <tt>dest</tt> field
is used to set the destination field in the AM message itself. This
divergence is needed to, for example, send a message to Rainier Node 5 to
send to node 6 (using <tt>BaseStation</tt> for example):
<pre>
    self.mif.sendMsg(self.source, 0x6, m.get_amType(), 0xFF, m, 0x5)
</pre>
<p>
The sample code below has more examples of how to use the Rainier Python
support.
<p>
Also note that the old Serial Forwarder instances running on
<tt>Rainier.eecs.harvard.edu:&lt;20000 + Node ID&gt;</tt> are still enabled.
<p>
<font style="font-size:18px"><strong>Do you have an example of how to use 
<font style="font-size:18px;color:#800000">Rainier</font>?</strong></font>
<p>
Glad you asked! Take a look at some sample code we ginned up. We have two
sample applications: TestSerial simply sends at a fixed rate to the serial
port. You can get it here:
<pre>
    % svn export http://senseless.eecs.harvard.edu/repos/Rainier/trunk/apps/TestSerial
</pre>
<p>
The second application illustrates two-way communication with the motes.
<pre>
    % svn export http://senseless.eecs.harvard.edu/repos/Rainier/trunk/apps/TestMultiSF
</pre>
<p>
There is a <tt>README</tt> file in the directory and the code there should
show you how to:
<ul>
<li>Write a Rainier application that dumps data to the serial port.
<li>Write a Python driver script that controls the job while it's running on
the lab.
<li>Write a Python script that takes the pickled Python output and interprets
it properly.
</ul>
<p>
Note that we are using Python in these examples. You can do similar things
using the Java TinyOS support, but we like Python and hopefully you do too.
Hope this helps.
<p>
<font style="font-size:18px"><strong>How do I get access to
the <font style="font-size:18px;color:#800000">Rainier</font> source?</strong></font>
<p>
Access to the Rainier source is available through Subversion. You can
checkout or export (anonymous users do not have write access) the sources here:
<pre>
    % svn [co,export] http://senseless.eecs.harvard.edu/repos/Rainier/trunk
</pre>
<p>
If you are interested in contributing to Rainier development we can provide
you with your own development branch.
Please email <tt>Rainier-admin AT eecs DOT harvard DOT edu</tt>.
<p>
The current version supports <a href="http://www.moteiv.com">moteiv.com</a>
TMote Sky motes connected through TMote Connect backchannel boards. Older
versions are available that support Mica2 and MicaZ platforms. Ask us.
<p>
<font style="font-size:18px"><strong>What's up with the <font
style="font-style:18px;color:#800000">Rainier</font> <a
href="motes-info.php">maps</a>?</strong></font>
<p>
Data displayed on the maps is collected periodically by a connectivity
program consisting of mote binaries and a driver script. The locations of
the nodes are fixed and the assignment between node ID and location should
also not change.
<p>
<font style="font-size:18px"><strong>Why can't I upload my executable to <font
style="font-style:18px;color:#800000">Rainier</font>?</strong></font>
<p>
Probably because it wasn't properly compiled. To upload your executable to
Rainier, ensure that:
<p>
<ol>
<li>It was compiled for the <tt>tmote</tt> or <tt>telosb</tt> platforms:
<pre>
  % make telosb
</pre>
<li>It was compiled against TinyOS 2.x:
<pre>
  % echo $TOSDIR
  /home/werner/tinyos/tinyos-2.1/tos
</pre>
Or something akin to that.
<li>It was compiled without using <tt>TOSBOOT</tt>. This used to be the
default on earlier version of TinyOS 2.x but was removed later. In any case,
if our checker is still complaining and you are following the above two
steps, try:
<pre>
  % TINYOS_NP= make telosb
</pre>
</ol>
<p>
<font style="font-size:18px"><strong>My job ran on <font
style="font-style:18px;color:#800000">Rainier</font> but
the files I downloaded don't contain any data. What gives?</strong></font>
<p>
There are a number of reasons that this can happen, including but not
limited to:
<ol>
<li>Your application doesn't actually send any packets to the serial port.
These are the only packets that Rainier will automatically parse and log, and
this is the first thing you should check.<br><br>
<li>Rainier couldn't understand the MIG-generated class file you uploaded.
Maybe this is because it wasn't actually a MIG-generated class file? 

We include several files in your download archive that should allow you to
debug these problems. To tell
whether Rainier successfully parsed the classfile you uploaded look at the
file named <em>DBLOGGER.CLASSES</em> in your download archive. It should look
something like:<blockquote style="background-color:#ccc;padding:10px"><pre>
    EXTRACTED MESSAGE CLASSES:
      CLASS 1.
        CLASSNAME: ReceiverMsgT
        AM ID: 132
        FIELD 1.
          NAME: sourceaddr
          INDEX: 1
          ISARRAY: false
          TYPE: int
          SIZE: 2
    ...
</pre>
</blockquote>
You should check this output to make sure that it matches the format of the
class files that you uploaded and the messages that your application sends to
the serial port.
<br><br>
The download archive also contains a file named <em>DBLOGGERS.ERRORS</em>
which lists error produces by the database logger during its operation, which
may help you identify motes that it could not connect to or class files that
it was unable to parse.
<br><br>
<li>The packets that you're application is sending don't match the
MIG-generated class file you uploaded. In this case, look at the
<em>dblogger.log</em> file described above and make sure the format of the
packets looks correct.
</ol>
<p>
The easiest way to get past this problem is to debug
<strong>locally</strong>. Once you can get it working on your desktop,
double-check that all the executables and class files that you are using successfully are the
ones you've uploaded to Rainier, then feel free to email for help.
<br><br>
Note that we now try to catch these sorts of errors when you upload your
class file, meaning that hopefully if Rainier allows you to upload a class
file it should work with your database logger.
<p>
<font style="font-size:18px"><strong>The connectivity maps you draw for
<font style="font-style:18px;color:#800000">Rainier</font> look cool. Can I get
access to the raw data used to create the graphics?</strong></font>
<p>
Yes. Periodically we run a small experiment that aims to record an aggregate
connectivity level between each pair of nodes on Rainier.  The experiment
runs for as long as an hour and as briefly as five minutes, depending on
system availability. The way that this is done is we cycle through the
network one node at a time and have it send a packet. Nodes that receive the
packet record that fact and the RSSI level associated with the reception.
Choosing one node at a time minimizes the internal interference since no
other nodes should be transmitting, however other sources of interference
typical to an indoor office environment (802.11 traffic, monitor radiation,
etc.) are present at levels that vary throughout the day.
<p>
All data from each connectivity experiment is logged and can be retrieved by
Rainier users through the database instance running on
Rainier.eecs.harvard.edu. Account holders have access to this database, and
read-only access to the table auth.connectivity, which holds the raw
information logged during each connectivity experiment.
<p>
The format of the table is that each run of the experiment that measures
connectivity is grouped by the groupno field, so selecting the
highest-numbered set will retrieve the latest run. The rest should be self
explanatory.  Each row in the set has a tomote field, a frommote field, and
records the number of samples sent from the tomote to the frommote (elided
rows can be assumed to have numheard=0), and also records the total summed
RSSI.
<p>
<font style="font-size:18px"><strong>Is there a way to collect power profile
information on <font style="font-style:18px;color:#800000">Rainier</font>?</strong></font>
<p>
Yes! We have a Keithley Digital Multimeter hooked up to Mote 118.  If you
check the box on the "Options" panel during job creation or editing, it will
enable the Keithley during your jobs run.  A file called "powerManage.log"
will be included in the archive provided when your job ends, and contains
current readings taken by this device.
<p>
<font style="font-size:18px"> <strong>Where can I get more information about
TinyOS?</strong></font>
<p>
Try <a href="http://tinyos.net/">tinyos.net</a>. We are unable to assist you
with TinyOS debugging. Sorry.
<?php
  include "nav/default_bot.php";
?>
