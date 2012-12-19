This is a preliminary README file culled from emails sent to early moteLab
deployers.  It can and will be modified as necessary.

I) what you need

without being too specific: a web server that supports php, a mysql server,
and some extra disk space.  you also need a significant amount of control
over each (ability to modify web server configurations, create databases,
etc).

II) what's provided

i've tarred up the current version of moteweb that we have running here.
this version is by no means complete, and i'm planning on continuing
development work until some of the more crucial functionality is completed.
at some point you'll probably want a tree that you can update as i make
changes, but i figure that this would be simpler to start.

III) what you need to do

1. to start, unpack the archive and put the files somewhere that your
webserver can get it.  try loading the main page (index.php) and make sure
that that works: it should even without the database set up.

2. you need to figure out where to put the root of your user tree.  this is
where all user uploaded files and job information will be kept.  as such, it
needs to be readable/writable by whatever user your web server runs under. 

NB: i should have mentioned this beforehand: there are two files that you
will likely need to edit heavily: /nav/sitespecific.php and
/util/sitespecific.perl.  these files contain settings such as the location
of the root of your user tree, names of database tables, and so on.  i've
tried to distill all of anything that could vary across distributions here...
we'll see how successful i've been.

3. now, examine tables.dump that i've thrown into your distro and create the
required mysql tables.  the various functions of various tables should be
somewhat clear... query if it's not.  modify /nav/sitespecific.php as
necessary to reflect changes in the database and/or table names (i'm less
than certain that table name changes will be properly supported, so i don't
suggest it).

4. next, you need to create the first user.  it should be an admin user, and
i'm guessing that most of the fields in the auth table are self-explanatory.
the php authentication module uses MD5 hashes, so you can use mysql's MD5
function to store the password field.  

in addition, you should create a user for the webserver to use.  the
username/password that this uses is specified in /nav/sitespecific.php.  i
suggest that you provide this user with only local access.

5. once you can log in, go to the 'zone admin' page and create your first
zone, then try uploading a file, make sure that works, and then
go through creating and scheduling a job.  nothing will actually run now
since we haven't done the daemon configuration, but getting the web stuff
working is somewhat independent.  i would spend a good deal of time here even
if things _seem_ to work... check that the uploaded file has the right
permissions, make sure that the database entries look right, etc.

5.1.  at this point in order for anything to work you need to get the
necessary info into the motes table.  again, self-explanatory.  a lot of the
fields aren't currently used: the important ones are active, ip_addr, and
moteid.

6. once you get through (5), you are 99% of the way.  the last thing to do is
set up the job-daemon.  if you are setting this up on a windows machine, i'm
not exactly sure how to do it.  if you are setting up on *nix, you eventually
want it running as a cron job as root.  now, this suddenly sounds somewhat
dangerous to me, and i'm guessing that it will work if run as a cron job as
'nobody' (or whatever your webserver runs under), so i'd try that first.
note that as of right now the cron job does not do _anything_ destructive (no
deletes, etc), so the worst thing that could happen is that it could scatter
some spurious files into odd places.  hopefully that makes you feel better
:-).

when setting up the job-daemon you want to make sure that you make necessary
modifications to /util/sitespecific.pl.  it has a lot of the same things as
/nav/sitespecific.php.  

eventually the cron job has to be run from the same directory as the script
lives because of the way that perl picks up the sitespecific.pl file (if you
know how to fix this please do tell)

7.  once you think that you've made the necessary modificiations to
sitespecific.pl, schedule a job and while it's supposed to be running, cd
to the /util/ directory and, as root, run the job-daemon.  you should see a
big spew of output as the job-daemon runs, tries to reprogram things, etc.
hopefully from the output and the reaction of your web-enabled motes it
should be obvious whether things worked or not, and, if not, what the
offending commands were.

IV) the end
