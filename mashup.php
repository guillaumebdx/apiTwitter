<?php
ini_set('display_errors', 1);
require_once 'vendor/autoload.php';
require_once 'parameters.php';

use Abraham\TwitterOAuth\TwitterOAuth;

$connection = new TwitterOAuth($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);

$politics = [
    "MLP_officiel" => "Marine Le Pen",
    "benoithamon"  => "Benoit Hamon",
    "EmmanuelMacron" => "Emmanuel Macron",
    "JLMelenchon" => "Jean Luc Mélenchon",
    "Anne_Hidalgo" => "Anne Hidalgo",
    "najatvb" => "Najat VB",
    "nk_m" => "NKM",
    "RoyalSegolene" => "@RoyalSegolene",
];
$links = [
    "et ",
    "sinon, ",
    "d'ailleurs, ",
    "mais ",
    "en sachant que ",
];
$randPolitic1 = array_rand($politics);
$firstTweets = $connection->get("statuses/user_timeline", [
    "screen_name"     => $randPolitic1,
    "count"           => 30,
    "exclude_replies" => true,
    "include_rts"     => false,
    "trim_user"       => false,
    "tweet_mode"      => "extended",
]);

$randPolitic2 = array_rand($politics);
while ($randPolitic2 === $randPolitic1) {
    $randPolitic2 = array_rand($politics);
}
$secondTweets = $connection->get("statuses/user_timeline", [
    "screen_name"     => $randPolitic2,
    "count"           => 30,
    "exclude_replies" => true,
    "include_rts"     => false,
    "trim_user"       => false,
    "tweet_mode"      => "extended",
]);
$firstTweet  = $firstTweets[rand(0, count($firstTweets) -1)];
$secondTweet = $secondTweets[rand(0, count($secondTweets) -1)];
$firstTweetSentences  = explode(". ", $firstTweet->full_text);
$secondTweetSentences = explode(". ", $secondTweet->full_text);
$numberSentence = 0;

if (count($secondTweetSentences) > 1) {
    $numberSentence = 1;
}

echo 'Mashup @' . $randPolitic1 . ' X ' . '@' . $randPolitic2 . ' : ' . clean($firstTweetSentences[0]) . $links[rand(0, count($links) -1)] . lcfirst(clean($secondTweetSentences[$numberSentence]));

function clean($sentence)
{
    $result = '';
    foreach (explode(" ", $sentence) as $word) {
        if (substr($word, 0, 3) != "htt") {
            $result .= $word . ' ';
        }
    }
    return $result;   
}