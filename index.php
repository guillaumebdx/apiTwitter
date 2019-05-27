<?php
ini_set('display_errors', 1);
require_once 'vendor/autoload.php';
require_once 'parameters.php';

use Abraham\TwitterOAuth\TwitterOAuth;

$connection = new TwitterOAuth($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);

//$content    = $connection->get("account/verify_credentials");
// echo "<pre>";
// var_dump($content);
// echo "</pre>";

// $connection->post("statuses/update", ["status" => "hello world API"]);
if (!isset($_GET['action']) || $_GET['action'] !== 'run') {
    echo '<a href="?action=run">RUN</a> <br />';
}
$result = $connection->get("search/tweets", [
    "q"              => "roboadvisor", 
    "result_type"    => "recent", 
    "count"          => "30",
    "extended_tweet" => "full_text",
//      "lang"           => "fr",
]);

foreach ($result->statuses as $status) {
    if (isset($_GET['action']) && $_GET['action'] === 'run') {
        echo 'Followed';
         $connection->post("friendships/create", ["screen_name" => $status->user->screen_name]);
    }
    $date = new DateTime($status->created_at);
    echo '<img src="' . $status->user->profile_image_url . '"> ' . $date->format("d-m-Y H:i:s") . ' @' . $status->user->name . ' ' . $status->user->screen_name . ' ' .  $status->text . ' (' . $status->lang . ') </br>';
}
// echo "<pre>";
// var_dump($result->statuses);
// echo "</pre>";
