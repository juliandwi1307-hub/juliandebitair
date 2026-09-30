<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;

class TestMqttPublish extends Command
{
    protected $signature = 'test:mqtt {id} {now} {--valve=}';
    protected $description = 'Simulate sending waterflow data to MQTT';

    public function handle()
    {
        $settings = (new ConnectionSettings)
            ->setUsername(config('mqtt.username'))
            ->setPassword(config('mqtt.password'))
            ->setUseTls(true)
            ->setTlsSelfSignedAllowed(false);

        // Tambahkan akhiran acak pada client_id agar tidak bentrok dengan listener
        $clientId = config('mqtt.client_id') . '_test_' . uniqid();
        $mqtt = new MqttClient(config('mqtt.host'), config('mqtt.port'), $clientId);
        $mqtt->connect($settings, true);

        $payload = [
            'id' => (int) $this->argument('id'),
            'now' => (int) $this->argument('now')
        ];
        
        if ($this->option('valve')) {
            $payload['valve'] = $this->option('valve');
        }

        $mqtt->publish('user/waterflow', json_encode($payload), 1);
        $this->info("Berhasil mengirim data sensor simulasi: " . json_encode($payload));
        
        $mqtt->disconnect();
    }
}
