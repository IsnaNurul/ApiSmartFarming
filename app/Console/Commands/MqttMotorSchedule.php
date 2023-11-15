<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpMqtt\Client\Facades\MQTT;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

class MqttMotorSchedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mqtt:motor-schedule';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Receive data from schedule';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */

    public function handle()
    {
        echo "Mqtt start; \n";
        $mqtt = MQTT::connection();
        $mqtt->subscribe('bitanic', function (string $topic, string $message) {
            $data = json_decode($message);

            $skip = false;

            $now = now('Asia/Jakarta');

            $status = "($data->ID) Device series not recognized";

            echo "[$now]: $status \n";

            echo "$message \n";

        }, 1);
        $mqtt->loop(true);
    }
}
