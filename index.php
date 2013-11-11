<?php
$sites = array("all", "chiptune", "cover", "game", "ocr");
?>
<h2>Bookmarklets:</h2>
<ul>
<?php foreach ($sites as $site) { ?>
<li><a href="javascript:(function () { var newScript = document.createElement('script'); newScript.type = 'text/javascript'; newScript.src = 'http://blha303.com.au/rainwave/<?php echo $site; ?>/?callback'; document.getElementsByTagName('body')[0].appendChild(newScript);})();"><?php echo $site; ?>.rainwave.cc</a></li>
<?php } ?>
</ul>
