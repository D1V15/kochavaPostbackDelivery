<?php
require "/predis/autoload.php";
Predis\Autoloader::register();
// since we connect to default setting localhost
// and 6379 port there is no need for extra
// configuration. If not then you can specify the
// scheme, host and port to connect as an array
// to the constructor.
class postbackObject {
    public $method = "";
    public $url  = "";
    public $key = "";
    public $value = "";
}
$postback = array(endpoint=> array(method=>"GET", url=>"http://sample_domain_endpoint.com/data?key={key}&value={value}&foo={bar}"), data=> array(key=>"Azureus", value=>"Dendrobates"));
//v = file_get_contents('php://input');
//$inputJSON = json_decode($entityBody);
$method = $postback["endpoint"]["method"];
$url = $postback["endpoint"]["url"];
$data = $postback["data"];


echo "</br>";
try {
    $redis = new Predis\Client();
    echo "Successfully connected to Redis";
    echo "</br>";
    echo "</br>";
    //for ($x = 0; $x <= 10; $x++) {
    $newObject = new postbackObject();
    $newObject->method = $method;
    $newObject->url = $url;
    $newObject->key = $data["key"];
    $newObject->value = $data["value"];
    $temp = json_encode($newObject);
    $redis->rPush("postbackObject", $temp);
    //}

    echo $redis->lPop("postbackObject");
    echo "</br>";
}
catch (Exception $e) {
    echo "Couldn't connected to Redis";
    echo "</br>";
    echo $e->getMessage();
    echo "</br>";
}

?>
