<?php 
  global $_DISPLAYNEW;
  $_DISPLAYNEW = true;
  global $_DISPLAYMOTD;
  $_DISPLAYMOTD = true;
  include "nav/default_top.php" ?>

<p>

<font style="font-size:18px;" color="#800000">
  <strong>Rainier</strong>
</font>
is a experimental wireless sensor network deployed in 
<a href="http://netlab.encs.vancouver.wsu.edu/">
WSU Netlab</a>, 
the <a href="http://ecs.vancouver.wsu.edu/">
School of Engineering & Computer Science</a> building at 
<a href="http://www.vancouver.wsu.edu">Washinton State University - Vancouver</a>.
Rainier provides a public, permanent testbed for development and testing of
sensor network applications via an intuitive web-based interface.  Registered
users can upload executables, associate those executables with motes to
create a job, and schedule the job to be run on Rainier.  
During the job all messages and other data are logged to a database which is
presented to the user upon job completion and then can be used for processing
and visualization.  
In addition, simple visualization tools are provided via the
web interface for viewing data while the job is running. 
Rainier will facilitate research in sensor network programming environments,
communication protocols, system design, and applications. 

<!--<div style="float:right;padding-right:10px;padding-bot"><img
src="img/tmote.jpg"></div>
-->
<p>
<font style="font-size:18px;" color="#800000">
  <strong>Hardware</strong>
</font>
<br>
We have deployed several Micaz and TelosB sensor "motes". 

<p>
Each mote is powered from wall power (rather than batteries) and is
connected to the departmental Ethernet, which facilitates direct capture
of data and uploading of new programs. The Ethernet connection is used
as a debugging and reprogramming feature only, as nodes will generally
communicate via radio.


<p>
<font style="font-size:18px;" color="#800000">
  <strong>Software</strong>
</font>
<br>
Nodes run the <a href="http://www.tinyos.net">TinyOS</a> operating
system and are programmed in the 

<a href="http://nescc.sourceforge.net">NesC</a> programming language, a
component-oriented variant of C. Typically, you will be able to
prototype your application either using the
<a
href="http://docs.tinyos.net/index.php/TOSSIM">TOSSIM</a>
simulation environment or with a handful of motes on your desktop. 
You then use the Rainier web interface to upload your program to the
building-wide network.
<?php 
  include "nav/default_bot.php" 
?>
