<?php
$sites = array("all", "chiptune", "cover", "game", "ocr");
?>
<a href="https://github.com/blha303/Rainwave-NowPlaying"><img style="position: absolute; top: 0; right: 0; border: 0;" src="https://s3.amazonaws.com/github/ribbons/forkme_right_red_aa0000.png" alt="Fork me on GitHub"></a>
<h2>Bookmarklets:</h2>
<ul>
<?php foreach ($sites as $site) { ?>
<li><a href="javascript:(function () { var newScript = document.createElement('script'); newScript.type = 'text/javascript'; newScript.src = 'http://blha303.com.au/rainwave/<?php echo $site; ?>/?callback'; document.getElementsByTagName('body')[0].appendChild(newScript);})();"><?php echo $site; ?>.rainwave.cc</a></li>
<?php } ?>
</ul>
<h2>Data</h2>
<?php foreach ($sites as $site) { ?>
<h3><?php echo $site; ?></h3>
<ul>
<li><a href="<?php echo $site; ?>/">Text track info</a></li>
<li><a href="<?php echo $site; ?>/?callback">Javascript for bookmarklets</a></li>
<li><a href="<?php echo $site; ?>/?stream">Track info with attribution, for livestreams</a></li>
<li><a href="<?php echo $site; ?>.json">JSON info</a> (or <a href="<?php echo $site; ?>/?json">here</a>, but this is slower)</li>
<li><a href="<?php echo $site; ?>/?frame">IFrame-compatible song/album art display (use &amp;linkcolor and &amp;bgcolor to set colors for your site)</a></li>
</ul>
<?php } ?>
