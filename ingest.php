<?php
require "/predis/autoload.php";
echo "passed require\n\n";
Predis\Autoloader::register();
echo "Hello There\n\n";
// since we connect to default setting localhost
// and 6379 port there is no need for extra
// configuration. If not then you can specify the
// scheme, host and port to connect as an array
// to the constructor.
try {
	echo "connect to redis";
    $redis = new Predis\Client();
    echo "Successfully connected to Redis";
$redis->set("I 2 love Php!", "Also Redis now!");
$value = $redis->get("I 2 love Php!");
echo $value;
}
catch (Exception $e) {
    echo "Couldn't connected to Redis";
    echo $e->getMessage();
}
echo "what the heck";
?>
