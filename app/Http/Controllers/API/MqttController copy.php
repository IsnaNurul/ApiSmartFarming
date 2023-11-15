<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use phpMQTT;

use PhpMqtt\Client\Facades\MQTT;
// use PhpMqtt\Client\MqttClient;
// use PhpMqtt\Client\Exceptions\ConnectingToBrokerFailedException;

class MqttController extends Controller
{
    //
    function getData(){
        $mqttServer = 'mqtt://broker.emqx.io';
        $mqttPort = 1883;
        $mqttClientId = 'mqttx_46c5cf03';
        $mqttTopic = 'bitanic';
        $data = null;           

        try {
            // $mqttClient = new phpMQTT($mqttServer, $mqttPort, $mqttClientId);
            // if ($mqttClient->connect(true, NULL, NULL, NULL, 'clean')) {
            //     $topics[$mqttTopic] = ['qos' => 0, 'function' => function ($topic, $message) use (&$data) {
            //         // Di sini, Anda dapat melakukan apa pun dengan data yang diterima dari MQTT,
            //         // seperti memprosesnya atau mengirimkannya sebagai respons API.
            //         // Contoh sederhana, kita hanya mengambil pesan pertama
            //         $data = $message;
            //     }];
            //     $mqttClient->subscribe($topics, 0);
            //     $mqttClient->loop();
            //     $mqttClient->disconnect();
            // }

                MQTT::connect($mqttServer, $mqttPort, function($mqtt) use ($mqttClientId, $mqttTopic) {
                $mqtt->subcribe($mqttTopic, function($topic, $message) use ($mqtt) {
                    $data = [
                        'topic' => $topic,
                        'message' => $message,
                    ];
    
                    $mqtt->close();
                    return response()->json($data);
                }, 0);
            }, $mqttClientId);

        } catch (\Throwable $e) {
            return response()->json(['error' => 'An error occurred while fetching data from MQTT']);
        }
            return response()->json(['data' => $data]);
        } 
    }