<?php
/*Developed By : Akshay N Shaju
Developed On : 14/03/18
Last Updated : --*/

//include required files
require_once "chatbot/Chatbot.php";
require_once "chatbot/Config.php";
require_once "chatbot/Database/Connection.php";
// initialize config
$config = new Config();
define("LOG", $config->log);
header(LOG ? "Content-Type: text/plain; charset=utf-8" : "Content-Type: application/json; charset=utf-8");
error_reporting(LOG ? E_ALL : JSON_ERROR_NONE);


$result = array(
    'status' => 'error',
    'type' => 'empty',
    'message' => 'empty message ...',
    'data' => 'empty',
);


// check request type
if (!isset($_REQUEST['requestType']) || !isset($_REQUEST['userInput'])) {
    $result['status'] = 'error';
    $result['type'] = $_REQUEST['requestType'];
    $result['message'] = 'requestType and userInput is required ...';
    $result['data'] = 'empty';
} else {


    $userId = isset($_REQUEST['userId']) ? $_REQUEST['userId'] : $_SERVER['REMOTE_ADDR'];
    LOG && print "userId : " . $userId . "\n";

    // initialize chatbot
    $chatbot = new Chatbot($config, $userId);


    // talk
    if ($_REQUEST['requestType'] == 'talk') {
        $agentq = file_get_contents('php://input');
        $agentjson = json_decode($agentq);
        $decagentq =  $agentjson->queryResult->queryText;
        $res = $chatbot->talk($decagentq);
        $data = $chatbot->getData();
        // $result['status'] = 'success';
        // $result['type'] = 'talk';
        $response['fulfillmentText'] = trim(preg_replace("/\s+/", " ", $res));
        $card['title'] = trim(preg_replace("/\s+/", " ", $res));
        // $card['imageUri'] = 'https://assistant.google.com/static/images/molecule/Molecule-Formation-stop.png';
        $data['card'] = $card;
        $response['fulfillmentMessages'] = array($data);
        } elseif ($_REQUEST['requestType'] == 'forget') {
        $chatbot->forget();
        $result['status'] = 'success';
        $result['type'] = 'forget';
        $result['message'] = 'forgetting completed ...';
        $result['data'] = 'empty';
    } else {
        $result['status'] = 'error';
        $result['type'] = $_REQUEST['requestType'];
        $result['message'] = 'invalid request type ...';
        $result['data'] = 'empty';
    }


}

if (LOG) {
    print "\n";
    print_r($result);
    print "\n";
} else {
    echo json_encode($response);
}



