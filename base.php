<?php
# This file is called by the scripts in the subfolders, allowing easy addition of future streams.
# If $site isn't set, it means this script isn't called properly. So everything doesn't break, just load
# the ocr info.
if (!isset($site)) {
  $site = array('ocr', '2');
}
# This script is called from bookmarklets.
header("Access-Control-Allow-Origin: *");

# Get anonymous API key. TODO: Use registered api key
$pagecontent = file_get_contents("http://".$site[0].".rainwave.cc/");
preg_match_all("/PRELOADED_APIKEY = '(.*?)'/", $pagecontent, $matches);

# Build POST request. PHP be trippin.
$url = "http://".$site[0].".rainwave.cc/sync/".$site[1]."/init";
$data = array('refresh' => 'full',
              'user_id' => '1',
              'key' => $matches[1][0],
              'in_order' => 'true');
$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data),
    ),
);
$context  = stream_context_create($options);

# Get data
$result = json_decode(file_get_contents($url, false, $context), true);
# Get song info from data
$songinfo = $result[3]["sched_current"]["song_data"][0];

# To print artists nicely if there's more than one.
# I don't know if this is necessary, but songinfo returns a list of artists.
$artists = array();
foreach($songinfo["artists"] as $item) {
  $artists[] = $item["artist_name"];
}

# Build output string
$out = sprintf("%s - %s (from %s)",
               implode(", ", $artists),
               $songinfo["song_title"],
               $songinfo["album_name"]);

# Options: ?callback for javascript, ?shell for my raspberry pi running on a TV with a heap of overscan,
# and ?stream for putting in your stream. example: http://b3.lc.pe/Rybl.jpg (top left)
# NEW: ?json. Returns song info in json form, same as how I got it, except without needing an API key.
# Note to self, ask Rob about this.
# NEW: ?frame. Returns html box you can use in an iframe. Params for this: &bgcolor=color, &linkcolor=color
# If no options are provided, returns the regular text version
if(isset($_GET['callback'])){
    # Set content type
    header('Content-Type: text/javascript');
    # Get desired callback name if provided, and sanitize it
    $callback = preg_replace('/\W+/', '', $_GET['callback']); #sanitize
    # Print data
    print $callback . "window.open('".$songinfo["song_url"]."'); alert(" . json_encode($out) . ");";
} else if (isset($_GET['shell'])) {
    # Set content type
    header("Content-Type: text/plain");
    # Mmm, indentation. Can you tell I'm a Python programmer?
    print "    ".$out."
    ".$songinfo["song_url"];
} else if (isset($_GET['stream'])) {
    # Set content type
    header("Content-Type: text/plain");
    # Today I learned about PHP_EOL.
    echo $out.PHP_EOL;
    echo $songinfo["song_url"]." http://".$site[0].".rainwave.cc/";
} else if (isset($_GET['json'])) {
    # Possibly bad. Need to talk with Rainwave people about this.
    header("Content-Type: application/json");
    echo json_encode($songinfo);
} else if (isset($_GET['frame'])) {
    if (isset($_GET['bgcolor'])) {
        $bgcolor = preg_replace('/\W+/', '', $_GET['bgcolor']);
    } else {
        $bgcolor = "#fff";
    }
    if (isset($_GET['linkcolor'])) {
        $linkcolor = preg_replace('/\W+/', '', $_GET['linkcolor']);
    } else {
        $linkcolor = "default";
    }
    # Don't need to set the header, text/html is just fine
    echo "
<style>
a { text-decoration: none; color: ".$linkcolor." }
body { background-color: ".$bgcolor." }
img { max-width: 75%; max-height: 80% }
</style>
<center>
    <a href='".$songinfo["song_url"]."'>
        <img src='http://".$site[0].".rainwave.cc".$songinfo["album_art"]."' align='top' width='75%'><br>
        <b>".implode(", ", $artists)."</b> - <b>".$songinfo["song_title"]."</b><br>
        <i>(from ".$songinfo["album_name"].")</i>
    </a>
</center>";
} else {
    # Set content type
    header("Content-Type: text/plain");
    # Print the info.
    print $out." ".$songinfo["song_url"];
}
