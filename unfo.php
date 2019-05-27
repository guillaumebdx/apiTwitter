<style>
.red {
  color: red;
} 
</style>
<?php
ini_set('display_errors', 1);
require_once 'vendor/autoload.php';
require_once 'parameters.php';

use Abraham\TwitterOAuth\TwitterOAuth;

$connection = new TwitterOAuth($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);
// cursor default -1 for beginning
$result = $connection->get("friends/list", [
    "screen_name"    => "veillefiscale", 
    "count"          => "100",
    "cursor"         => "-1",
]);
if (!isset($_GET['action']) || $_GET['action'] !== 'run') {
    echo '<a href="?action=run">RUN</a><br />';
}
$words = [
    'fin',
    'Fin',
    'tech',
    'Tech',
    'robo',
    'Robo',
    'banque',
    'Banque',
    'assurance',
    'Assurance',
    'react',
    'React',
    'symfony',
    'Symfony',
    'algo',
    'Algo',
    'cod',
    'Cod',
    'Bordeaux',
    'actif',
    
];

// var_dump($result->errors);

foreach ($result->users as $user) {
    $erase = "red";
    foreach ($words as $word) {
        if (strpos($user->description, $word) !== false) {
            $erase = "black";
        }
    }
    if ($user->status->lang !== "fr") {
        $erase = "red";
    }
//     echo "<pre>";
//     var_dump($user->status);
//     echo "<pre>";
    if ($erase === "red") {
        if (isset($_GET['action']) && $_GET['action'] === 'run') {
            echo 'Unfollowed';
                $connection->post("friendships/destroy", ["user_id" => $user->id]);
        }
    }
    echo '<img src="' . $user->profile_image_url . '"> <span class="' . $erase . '">' . $user->screen_name . ' </span>' . $user->name . ' '  . $erase . '<br/>';
}
echo 'next cursor = ' . $result->next_cursor_str;
?>
