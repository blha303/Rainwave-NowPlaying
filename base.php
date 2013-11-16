<?php
if (!isset($site)) {
  $site = array('ocr', '2');
}
header("Access-Control-Allow-Origin: *");
$pagecontent = file_get_contents("http://".$site[0].".rainwave.cc/");
preg_match_all("/PRELOADED_APIKEY = '(.*?)'/", $pagecontent, $matches);
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
$result = json_decode(file_get_contents($url, false, $context), true);
$songinfo = $result[3]["sched_current"]["song_data"][0];
$artists = array();
foreach($songinfo["artists"] as $item) {
  $artists[] = $item["artist_name"];
}
$out = sprintf("%s - %s (from %s)",
               implode(", ", $artists),
               $songinfo["song_title"],
               $songinfo["album_name"]);
if(isset($_GET['callback'])){
    header('Content-Type: text/javascript');
    $callback = preg_replace('/\W+/', '', $_GET['callback']); #sanitize
    print $callback . "window.open('".$songinfo["song_url"]."'); alert(" . json_encode($out) . ");";
} else if (isset($_GET['shell'])) {
    header("Content-Type: text/plain");
    print "    ".$out."
    ".$songinfo["song_url"];
} else if (isset($_GET['stream'])) {
    header("Content-Type: text/plain"); ?>
<?php echo $out; ?>
<?php echo $songinfo["song_url"]; ?> http://<?php echo $site[0]; ?>.rainwave.cc/<?php
} else {
    header("Content-Type: text/plain");
    print $out." ".$songinfo["song_url"];
}
