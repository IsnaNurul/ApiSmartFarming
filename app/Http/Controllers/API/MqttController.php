<?php

namespace App\Http\Controllers\API;
// use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use PhpMqtt\Client\ConnectionSettings;
use PhpMqtt\Client\Facades\MQTT;
use PhpMqtt\Client\MqttClient;
use BeyondCode\LaravelWebSockets\Facades\WebSocketsRouter;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Request;

class MqttController extends Controller
{

    // public function getData()
    // {
    //     $server   = 'broker.emqx.io';
    //     $port     = 1883;
    //     $clientId = "mqttx_46c5cf03"; // ganti client ID
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
    //         ->setLastWillTopic('bitanic/BT01')
    //         ->setLastWillMessage('client disconnect')
    //         ->setLastWillQualityOfService(0);

    //     $mqtt = new MqttClient($server, $port, $clientId, $mqtt_version);

    //     try {
    //         $mqtt->connect($connectionSettings, $clean_session);

    //         $mqtt->subscribe('bitanic/BT01', function ($topic, $message) use (&$data, $loop, $mqtt) {
    //             $data = $message;
    //             $loop++;
    //             $mqtt->interrupt();
    //         }, 0);

    //         if ($loop == 0) {
    //             $mqtt->loop(true);
    //         }

    //         $respon = [
    //             'status' => 'success',
    //             'data' => json_decode($data)
    //         ];

    //         return response()->json($respon);
    //         $mqtt->disconnect();
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

    //     set_time_limit(300);

    //     $server = 'broker.emqx.io';
    //     $port = 1883;
    //     $clientId = "mqttx_46c5cf03"; // change client ID
    //     $username = null;
    //     $password = null;
    //     $clean_session = false;
    //     $mqtt_version = MqttClient::MQTT_3_1_1;

    //     $loop = 0;
    //     $data = null;

    //     $connectionSettings = (new ConnectionSettings)
    //         ->setUsername($username)
    //         ->setPassword($password)
    //         ->setKeepAliveInterval(5)
    //         ->setLastWillTopic('bitanic/' . $requestId)
    //         ->setLastWillMessage('client disconnect')
    //         ->setLastWillQualityOfService(0);

    //     $mqtt = new MqttClient($server, $port, $clientId, $mqtt_version);

    //     try {

    //         $mqtt->connect($connectionSettings, $clean_session);

    //         $mqtt->subscribe('bitanic', function ($topic, $message) use (&$data, &$loop, $mqtt, $requestId) {
    //             $temporaryData = json_decode($message);
    //             if ($temporaryData && isset($temporaryData->ID) && $temporaryData->ID === $requestId) {
    //                 $data = $temporaryData;
    //             }
    //             $loop++;
    //             $mqtt->interrupt();
    //         }, 0);

    //         $mqtt->loop(true);

    //         if ($loop > 0) {
    //             $respon = [
    //                 'status' => 'success',
    //                 'data' => $data
    //             ];
    //         } else {
    //             $respon = [
    //                 'status' => 'failed',
    //                 'message' => 'Topic not found or no data received'
    //             ];
    //         }

    //         $mqtt->disconnect(); // Disconnect after retrieving data
    //         return response()->json($respon);
    //     } catch (Exception $e) {

    //         error_log($e->getMessage());

    //         $respon = [
    //             'status' => 'timeout',
    //             'data' => null
    //         ];
    //         return response()->json($respon);
    //     }
    // }

    // public function ControlMotor1($requestId, $motor1)
    // {
    //     // Define your MQTT parameters
    //     $server = 'broker.emqx.io';
    //     $port = 1883;
    //     $clientId = "mqttx_46c5cf03"; // Change the client ID
    //     $username = null;
    //     $password = null;

    //     // Create an MQTT client instance
    //     $mqtt = new MqttClient($server, $port, $clientId);

    //     try {
    //         // Connect to the MQTT broker
    //         $mqtt->connect();

    //         // Define the MQTT topic to publish to
    //         $topic = 'bitanic/' . $requestId; // Change to your desired topic name

    //         // Define the message to send
    //         $message = 'MOTOR1,' . $motor1 . ',*';

    //         // Publish the message to the MQTT topic
    //         $mqtt->publish($topic, $message, 0);

    //         // Disconnect from the MQTT broker
    //         $mqtt->disconnect();

    //         // Return a success response
    //         $response = [
    //             'status' => 'success',
    //             'message' => 'Message sent to MQTT topic.',
    //         ];
    //     } catch (Exception $e) {
    //         // Handle any exceptions that occur during the MQTT operation
    //         $response = [
    //             'status' => 'error',
    //             'message' => 'Failed to send message to MQTT topic.',
    //         ];
    //     }
    //     return response()->json($response, 200);
    // }

    // public function ControlMotor2($requestId, $motor2)
    // {
    //     // Define your MQTT parameters
    //     $server = 'broker.emqx.io';
    //     $port = 1883;
    //     $clientId = "mqttx_46c5cf03"; // Change the client ID
    //     $username = null;
    //     $password = null;

    //     // Create an MQTT client instance
    //     $mqtt = new MqttClient($server, $port, $clientId);

    //     try {
    //         // Connect to the MQTT broker
    //         $mqtt->connect();

    //         // Define the MQTT topic to publish to
    //         $topic = 'bitanic/' . $requestId; // Change to your desired topic name

    //         // Define the message to send
    //         $message = 'MOTOR2,' . $motor2 . ',*';

    //         // Publish the message to the MQTT topic
    //         $mqtt->publish($topic, $message, 0);

    //         // Disconnect from the MQTT broker
    //         $mqtt->disconnect();

    //         // Return a success response
    //         $response = [
    //             'status' => 'success',
    //             'message' => 'Message sent to MQTT topic.',
    //         ];
    //     } catch (Exception $e) {
    //         // Handle any exceptions that occur during the MQTT operation
    //         $response = [
    //             'status' => 'error',
    //             'message' => 'Failed to send message to MQTT topic.',
    //         ];
    //     }
    //     return response()->json($response);
    // }

    public function getData()
    {
        $server = 'broker.hivemq.com';
        $port = 1883;
        $clientId = "IrigasiTetes"; // ganti client ID
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
            ->setLastWillTopic('IrigasiTetes')
            ->setLastWillMessage('client disconnect')
            ->setLastWillQualityOfService(0);

        $mqtt = new MqttClient($server, $port, $clientId, $mqtt_version);

        try {
            $mqtt->connect(
                $connectionSettings,
                $clean_session
            );

            $mqtt->subscribe('IrigasiTetes', function ($topic, $message) use (&$data, $loop, $mqtt) {
                $data = $message;
                $loop++;
                $mqtt->interrupt();
            }, 0);

            if ($loop == 0) {
                $mqtt->loop(true);
            }

            $mqtt->disconnect();

            // Parse the MQTT response
            $responseArray = explode(',', $data);

            $respon = [
                'status' => 'success',
                'data' => [
                    'IrigasiTetes' => $responseArray[0],
                    'Value1' => $responseArray[1],
                    'Status1' => $responseArray[2],
                    'Value2' => $responseArray[3],
                    'Status2' => $responseArray[4],
                    'Status3' => $responseArray[5],
                    'Status4' => $responseArray[6],
                ]
            ];

            return response()->json($respon);
        } catch (Exception $e) {
            $respon = [
                'status' => 'gagal',
                'data' => null
            ];
            return response()->json($respon);
        }
    }


    public function getIdData($requestId)
    {
        set_time_limit(300);

        $server = 'broker.hivemq.com';
        $port = 1883;
        $clientId = "IrigasiTetes"; // ganti client ID
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
            ->setLastWillTopic($requestId)
            ->setLastWillMessage('client disconnect')
            ->setLastWillQualityOfService(0);

        $mqtt = new MqttClient($server, $port, $clientId, $mqtt_version);

        try {
            $mqtt->connect($connectionSettings, $clean_session);

            $mqtt->subscribe('IrigasiTetes', function ($topic, $message) use (&$data, &$loop, $mqtt, $requestId) {
                $temporaryData = explode(',', $message);
                if (count($temporaryData) === 7 && $temporaryData[0] === $requestId) {
                    $data = [
                        'ID' => $temporaryData[0],
                        'KELEMBAPAN_TANAH' => $temporaryData[1],
                        'STATUS_TANAH' => $temporaryData[2],
                        'JARAK_AIR' => $temporaryData[3],
                        'STATUS_POMPA_DORONG' => $temporaryData[4],
                        'STATUS_POMPA_HISAP' => $temporaryData[5],
                        'Status4' => $temporaryData[6],
                    ];
                }
                $loop++;
                $mqtt->interrupt();
            }, 0);

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
            error_log($e->getMessage());
            $respon = [
                'status' => 'timeout',
                'data' => null
            ];
            return response()->json($respon);
        }
    }


    public function ControlMotor1($requestId, $motor1)
    {
        // Define your MQTT parameters
        $server   = 'broker.hivemq.com';
        $port     = 1883;
        $clientId = "IrigasiTetes"; // ganti client ID
        $username = null;
        $password = null;
        $clean_session = false;
        $mqtt_version = MqttClient::MQTT_3_1_1;

        // Create an MQTT client instance
        $mqtt = new MqttClient($server, $port, $clientId);

        try {
            // Connect to the MQTT broker
            $mqtt->connect();

            // Define the MQTT topic to publish to
            $topic = $requestId; // Change to your desired topic name

            // Define the message to send
            $message = 'MOTOR1,' . $motor1 . ',*';

            // Publish the message to the MQTT topic
            $mqtt->publish($topic, $message, 0);

            // Disconnect from the MQTT broker
            $mqtt->disconnect();

            // Return a success response
            $response = [
                'status' => 'success',
                'message' => 'Message sent to MQTT topic.',
            ];
        } catch (Exception $e) {
            // Handle any exceptions that occur during the MQTT operation
            $response = [
                'status' => 'error',
                'message' => 'Failed to send message to MQTT topic.',
            ];
        }
        return response()->json($response, 200);
    }

    public function ControlMotor2($requestId, $motor2)
    {
        // Define your MQTT parameters
        $server   = 'broker.hivemq.com';
        $port     = 1883;
        $clientId = "IrigasiTetes"; // ganti client ID
        $username = null;
        $password = null;
        $clean_session = false;
        $mqtt_version = MqttClient::MQTT_3_1_1;

        // Create an MQTT client instance
        $mqtt = new MqttClient($server, $port, $clientId);

        try {
            // Connect to the MQTT broker
            $mqtt->connect();

            // Define the MQTT topic to publish to
            $topic = $requestId; // Change to your desired topic name

            // Define the message to send
            $message = 'MOTOR2,' . $motor2 . ',*';

            // Publish the message to the MQTT topic
            $mqtt->publish($topic, $message, 0);

            // Disconnect from the MQTT broker
            $mqtt->disconnect();

            // Return a success response
            $response = [
                'status' => 'success',
                'message' => 'Message sent to MQTT topic.',
            ];
        } catch (Exception $e) {
            // Handle any exceptions that occur during the MQTT operation
            $response = [
                'status' => 'error',
                'message' => 'Failed to send message to MQTT topic.',
            ];
        }
        return response()->json($response);
    }
}
