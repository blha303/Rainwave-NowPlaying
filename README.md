Rainwave-NowPlaying
===================

Requirements
------------

* Python 2.6-7 (recommended)
* Apache 2 (recommended)
* PHP

Setup
------

* Use Apache. Untested with any other web server
* Clone the repository into a web-accessible directory
* Run update.sh in the background. I use screen to see the output, you can probably use some kind of daemon thing I don't know about.
* You should be able to access all info after the first time the script runs.

To stop update.sh, use `touch /tmp/stahp`. You'll need to delete this file before running update.sh again, or the script won't start.

If you have any questions, leave an issue here, or join [irc.esper.net #blha303](http://webchat.esper.net/?channels=blha303)