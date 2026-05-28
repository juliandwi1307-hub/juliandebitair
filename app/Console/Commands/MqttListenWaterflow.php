<?php

namespace App\Console\Commands;

use App\Models\Tagihan;
use App\Models\Tarif;
use App\Models\Pengguna;
use Illuminate\Console\Command;
use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;

class MqttListenWaterflow extends Command
{
    protected $signature = 'mqtt:listen';
    protected $description = 'Listen to HiveMQ waterflow sensor topic';

    public function handle(): void
    {
        $settings = (new ConnectionSettings)
            ->setUsername(config('mqtt.username'))
            ->setPassword(config('mqtt.password'))
            ->setUseTls(true)
            ->setTlsSelfSignedAllowed(false);

        $mqtt = new MqttClient(config('mqtt.host'), config('mqtt.port'), config('mqtt.client_id'));
        $mqtt->connect($settings, true);

        $this->info('Connected to HiveMQ. Listening on user/waterflow...');

        $mqtt->subscribe('user/waterflow', function (string $topic, string $message) {
            $data = json_decode($message, true);

            if (!isset($data['id'], $data['last'], $data['now'])) {
                $this->warn("Invalid payload: {$message}");
                return;
            }

            $penggunaId = (int) $data['id'];

            if (!Pengguna::where('id', $penggunaId)->exists()) {
                $this->warn("Pengguna id={$penggunaId} not found, skipping.");
                return;
            }

            $bulan  = now()->translatedFormat('F');
            $tahun  = now()->year;
            $jumlah = $data['now'] - $data['last'];
            $tarif  = Tarif::first()->harga ?? 1500;
            $total  = $jumlah * $tarif;

            $tagihan = Tagihan::updateOrCreate(
                [
                    'pengguna_id' => $penggunaId,
                    'bulan'       => $bulan,
                    'tahun'       => $tahun,
                ],
                [
                    'awal'    => $data['last'],
                    'akhir'   => $data['now'],
                    'jumlah'  => $jumlah,
                    'tarif'   => $tarif,
                    'tagihan' => $total,
                    'status'  => 'belum lunas',
                ]
            );

            $action = $tagihan->wasRecentlyCreated ? 'created' : 'updated';
            $this->info("Tagihan {$action} for pengguna_id={$penggunaId}, jumlah={$jumlah}m³, total=Rp{$total}");
        }, MqttClient::QOS_AT_LEAST_ONCE);

        $mqtt->loop(true);
        $mqtt->disconnect();
    }
}
