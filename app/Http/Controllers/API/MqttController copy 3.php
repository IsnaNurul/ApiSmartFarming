<?php

namespace App\Http\Controllers\API;
// use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use PhpMqtt\Client\ConnectionSettings;
use PhpMqtt\Client\MqttClient;

class MqttController extends Controller
{      
    public function getData()
    {
        $server   = 'broker.emqx.io';
        $port     = 1883;
        $clientId = "mqttx_46c5cf03"; // ganti client ID
        $username = null;
        $password = null;
        $clean_session = false;
        $mqtt_version = MqttClient::MQTT_3_1_1;

        $loop = 0;
        $data = "";

        $connectionSettings = (new ConnectionSettings)
            ->setUsername($username)
            ->setPassword($password)
            ->setKeepAliveInterval(5)
            ->setLastWillTopic('bitanic/BT01')
            ->setLastWillMessage('client disconnect')
            ->setLastWillQualityOfService(0);

        $mqtt = new MqttClient($server, $port, $clientId, $mqtt_version);

        try {
            $mqtt->connect($connectionSettings, $clean_session);

            $mqtt->subscribe('bitanic/BT01', function ($topic, $message) use (&$data, $loop, $mqtt) {
                $data = $message;
                $loop++;
                $mqtt->interrupt();
            }, 0);

            if ($loop == 0) {
                $mqtt->loop(true);
            }

            $respon = [
                'status' => 'success',
                'data' => json_decode($data)
            ];

            return response()->json($respon);
            $mqtt->disconnect();

        } catch (Exception $e) {
            $respon = [
                'status' => 'gagal',
                'data' => null
            ];
            return response()->json($respon);
        }
    }

    // public function getIdData($requestId)
    // {
    //     $server   = 'broker.emqx.io';
    //     $port     = 1883;
    //     $clientId = "mqttx_46c5cf03"; // change client ID
    //     $username = null;
    //     $password = null;
    //     $clean_session = false;
    //     $mqtt_version = MqttClient::MQTT_3_1_1;

    //     $loop = 0;
    //     $data = "";

    //     $connectionSettings = (new ConnectionSettings)
    //         ->setUsername($username)
    //         ->setPassword($password)
    //         ->setKeepAliveInterval(5)
    //         ->setLastWillTopic('amico/'.$requestId)
    //         ->setLastWillMessage('client disconnect')
    //         ->setLastWillQualityOfService(0);

    //     $mqtt = new MqttClient($server, $port, $clientId, $mqtt_version);

    //     try {
    //         if (!$requestId) {
    //             return response()->json(['status' => 'gagal']);
    //         }
            
    //         $mqtt->connect($connectionSettings, $clean_session);


    //         $mqtt->subscribe('amico/' .$requestId, function ($topic, $message) use (&$data, $loop, $mqtt, $requestId) {
    //             $temporaryData = json_decode($message);
    //             // dump($temporaryData);
    //             if ($temporaryData->ID === $requestId) {
    //                 $data = $temporaryData;
    //                 $loop++;
    //                 $mqtt->interrupt();
    //             } else{
    //                 return response()->json(['status' => 'gagal']);
    //             }
    //             $loop++;
    //             $mqtt->interrupt();
    //         }, 0);

    //         // dd($data);

    //         if ($loop == 0) {
    //             $mqtt->loop(true);
    //         }

    //         $respon = [
    //             'status' => 'success',
    //             'data' => $data
    //         ];
    //         $mqtt->disconnect(); // Disconnect after retrieving data
    //         return response()->json($respon);

    //     } catch (Exception $e) {
    //         $respon = [
    //             'status' => 'gagal',
    //             'data' => null
    //         ];
    //         return response()->json($respon);
    //     }
    // }

    // public function getIdData($requestId)
    // {
    //     $server   = 'broker.emqx.io';
    //     $port     = 1883;
    //     $clientId = "mqttx_46c5cf03"; // change client ID
    //     $username = null;
    //     $password = null;
    //     $clean_session = false;
    //     $mqtt_version = MqttClient::MQTT_3_1_1;

    //     $loop = 0;
    //     $data = "";

    //     $connectionSettings = (new ConnectionSettings)
    //         ->setUsername($username)
    //         ->setPassword($password)
    //         ->setKeepAliveInterval(5)
    //         ->setLastWillTopic('bitanic/'.$requestId)
    //         ->setLastWillMessage('client disconnect')
    //         ->setLastWillQualityOfService(0);

    //     $mqtt = new MqttClient($server, $port, $clientId, $mqtt_version);

    //     try {
    //         if (!$requestId) {
    //             return response()->json(['status' => 'gagal']);
    //         }

    //         set_time_limit(30);
            
    //         $mqtt->connect($connectionSettings, $clean_session);

    //         $mqtt->subscribe('bitanic', function ($topic, $message) use (&$data, $loop, $mqtt, $requestId) {
    //             $temporaryData = json_decode($message);
    //             // dump($temporaryData);
    //             if ($temporaryData->ID === $requestId) {
    //                 $data = $temporaryData;
    //                 $loop++;
    //                 $mqtt->interrupt();
    //             } else{
    //                 return response()->json(['status' => 'gagal']);
    //             }
    //             $loop++;
    //             $mqtt->interrupt();
    //         }, 0);

    //         // dd($data);

    //         if ($loop == 0) {
    //             $mqtt->loop(true);
    //         }

    //         $respon = [
    //             'status' => 'success',
    //             'data' => $data
    //         ];
    //         $mqtt->disconnect(); // Disconnect after retrieving data
    //         return response()->json($respon);

    //     } catch (Exception $e) {
    //         // Handle the exception, e.g., log it
    //         error_log($e->getMessage());

    //         // Return a JSON response indicating the timeout error
    //         $respon = [
    //             'status' => 'timeout',
    //             'data' => null
    //         ];
    //         return response()->json($respon);
    //     }
    // }

    // public function getIdData($requestId)
    // {
    //     $server = 'broker.emqx.io';
    //     $port = 1883;
    //     $clientId = "mqttx_46c5cf03"; // change client ID
    //     $username = null;
    //     $password = null;
    //     $clean_session = false;
    //     $mqtt_version = MqttClient::MQTT_3_1_1;

    //     $loop = 0;
    //     $data = "";

    //     $connectionSettings = (new ConnectionSettings)
    //         ->setUsername($username)
    //         ->setPassword($password)
    //         ->setKeepAliveInterval(5)
    //         ->setLastWillTopic('bitanic/' . $requestId)
    //         ->setLastWillMessage('client disconnect')
    //         ->setLastWillQualityOfService(0);

    //     $mqtt = new MqttClient($server, $port, $clientId, $mqtt_version);

    //     try {
    //         if (!$requestId) {
    //             return response()->json(['status' => 'gagal', 'message' => 'Invalid request ID']);
    //         }

    //         // Set a longer maximum execution time (e.g., 120 seconds) to avoid the error
    //         set_time_limit(30);

    //         $mqtt->connect($connectionSettings, $clean_session);

    //         $mqtt->subscribe('bitanic', function ($topic, $message) use (&$data, $loop, $mqtt, $requestId) {
    //             $temporaryData = json_decode($message);
    //             if ($temporaryData && isset($temporaryData->ID) && $temporaryData->ID === $requestId) {
    //                 $data = $temporaryData;
    //                 $loop++;
    //                 $mqtt->interrupt();
    //             } else {
    //                 // Handle the case when the topic is incorrect or the message is not as expected
    //                 $mqtt->interrupt();
    //                 $errorResponse = [
    //                     'status' => 'gagal',
    //                     'message' => 'Invalid topic or message format'
    //                 ];
    //                 return response()->json($errorResponse);
    //             }
    //             $loop++;
    //             $mqtt->interrupt();
    //         }, 0);

    //         if ($loop == 0) {
    //             $mqtt->loop(true);
    //         }

    //         if ($data) {
    //             $respon = [
    //                 'status' => 'success',
    //                 'data' => $data
    //             ];
    //         } else {
    //             $respon = [
    //                 'status' => 'failed',
    //             ];
    //         }

    //         $mqtt->disconnect(); // Disconnect after retrieving data
    //         return response()->json($respon);
    //     } catch (Exception $e) {
    //         // Handle the exception, e.g., log it
    //         error_log($e->getMessage());

    //         // Return a JSON response indicating the timeout error
    //         $respon = [
    //             'status' => 'timeout',
    //             'data' => null
    //         ];
    //         return response()->json($respon);
    //     }
    // }

    public function getIdData($requestId)
    {
        $server = 'broker.emqx.io';
        $port = 1883;
        $clientId = "mqttx_46c5cf03"; // change client ID
        $username = null;
        $password = null;
        $clean_session = false;
        $mqtt_version = MqttClient::MQTT_3_1_1;

        $loop = 0;
        $data = null;

        $connectionSettings = (new ConnectionSettings)
            ->setUsername($username)
            ->setPassword($password)
            ->setKeepAliveInterval(5)
            ->setLastWillTopic('bitanic/' . $requestId)
            ->setLastWillMessage('client disconnect')
            ->setLastWillQualityOfService(0);

        $mqtt = new MqttClient($server, $port, $clientId, $mqtt_version);

        try {

            $mqtt->connect($connectionSettings, $clean_session);

            $mqtt->subscribe('bitanic', function ($topic, $message) use (&$data, &$loop, $mqtt, $requestId) {
                $temporaryData = json_decode($message);
                if ($temporaryData && isset($temporaryData->ID) && $temporaryData->ID === $requestId) {
                    $data = $temporaryData;
                }
                $loop++;
                $mqtt->interrupt();
            }, 0);
            
            // Tambahkan logika untuk menentukan apa yang harus dilakukan jika topik tidak ada
            $mqtt->loop(true);
            
            if ($loop > 0) {
                $respon = [
                    'status' => 'success',
                    'data' => $data
                ];
            } else {
                $respon = [
                    'status' => 'failed',
                    'message' => 'Topic not found or no data received'
                ];
            }

            $mqtt->disconnect(); // Disconnect after retrieving data
            return response()->json($respon);
        } catch (Exception $e) {
            // Handle the exception, e.g., log it
            error_log($e->getMessage());

            // Return a JSON response indicating the timeout error
            $respon = [
                'status' => 'timeout',
                'data' => null
            ];
            return response()->json($respon);
        }
    }




}
