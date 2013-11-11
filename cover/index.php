<?php
$site = array("cover", "3");
include('../base.php');
header("Access-Control-Allow-Origin: *");
$pagecontent = file_get_contents("http://cover.rainwave.cc/");
preg_match_all("/PRELOADED_APIKEY = '(.*?)'/", $pagecontent, $matches);
$url = "http://cover.rainwave.cc/sync/3/init";
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
$result = json_decode(file_get_contents($url, false, $context), true);
$songinfo = $result[3]["sched_current"]["song_data"][0];
$artists = array();
foreach($songinfo["artists"] as $item) {
  $artists[] = $item["artist_name"];
}
$out = sprintf("%s - %s (from %s) %s",
               implode(", ", $artists),
               $songinfo["song_title"],
               $songinfo["album_name"],
               $songinfo["song_url"]);
if(isset($_GET['callback'])){
    header('Content-Type: text/javascript');
    $callback = preg_replace('/\W+/', '', $_GET['callback']); #sanitize
    print $callback . "(alert(" . json_encode($out) . "));";
} else {
    header("Content-Type: text/plain");
    print $out;
}
