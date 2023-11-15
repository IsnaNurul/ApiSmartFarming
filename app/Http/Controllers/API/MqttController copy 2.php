<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpMqtt\Client\Facades\MQTT;

class MqttController extends Controller
{      
    public function getData()
    {
        $mqttServer = 'broker.emqx.io';
        $mqttPort = 1883;
        $mqttClientId = 'mqttx_46c5cf03';
        $mqttTopic = 'bitanic';
        // $data = null;
        $connected = false;

        try {
            // Attempt to connect to the MQTT broker
            MQTT::connect($mqttServer, $mqttPort, function($mqtt) use ($mqttClientId, $mqttTopic, &$data, &$connected) {
                $mqtt->subscribe($mqttTopic, function($topic, $message) use ($mqtt, &$data, &$connected) {
                    $data = [
                        'topic' => $topic,
                        // 'message' => $message,
                    ];

                    // Set the connected flag to true when successfully subscribed
                    $connected = true;

                    // Close the MQTT connection
                    $mqtt->close();
                }, 0);
            }, $mqttClientId);

            // Wait for a short duration to allow the connection to establish (you can adjust the duration as needed)
            usleep(500000); // 500 milliseconds

            if (!$connected) {
                // Handle case when the connection was not successful
                return response()->json(['error' => 'MQTT connection failed.']);
            }
        } catch (\Throwable $e) {
            return response()->json(['error' => 'An error occurred while fetching data from MQTT']);
        }
        return response()->json(['data' => $data->topic]);
        
    }
}
