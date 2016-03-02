<?php
require "/predis/autoload.php";
Predis\Autoloader::register();

class postbackObject {
    public $method = "";
    public $url  = "";
    public $key = "";
    public $value = "";
}

//v = file_get_contents('php://input');
//$inputJSON = json_decode($entityBody);

$postback = array(endpoint=> array(method=>"GET", url=>"http://sample_domain_endpoint.com/data?key={key}&value={value}&foo={bar}"), data=> array(key=>"Azureus", value=>"Dendrobates"));
$method = $postback["endpoint"]["method"];
$url = $postback["endpoint"]["url"];
$data = $postback["data"];

try {
    $redis = new Predis\Client();
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
