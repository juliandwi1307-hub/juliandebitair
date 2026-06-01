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

            if (!isset($data['id'], $data['now'])) {
                $this->warn("Invalid payload: {$message}");
                return;
            }

            $penggunaId = (int) $data['id'];
            $nowValue = (int) $data['now'];

            $pengguna = Pengguna::find($penggunaId);

            if (!$pengguna) {
                $this->warn("Pengguna id={$penggunaId} not found, skipping.");
                return;
            }

            // Cari log terakhir untuk mengecek apakah sudah berganti bulan
            $latestLog = \App\Models\SensorLog::where('pengguna_id', $penggunaId)
                ->orderBy('created_at', 'desc')
                ->first();

            if (!$latestLog) {
                // Jika belum ada log sama sekali, set meter_awal ke nilai now saat ini
                $pengguna->meter_awal = $nowValue;
            } else {
                $logMonth = $latestLog->created_at->format('Y-m');
                $currentMonth = date('Y-m');
                
                // Jika berganti bulan, log awal bulanan (meter_awal) diganti dengan log paling terbaru (meter_akhir sebelumnya)
                if ($logMonth !== $currentMonth) {
                    $pengguna->meter_awal = $pengguna->meter_akhir;
                }
            }

            // Update meter_akhir dengan nilai now terbaru
            $pengguna->meter_akhir = $nowValue;
            $pengguna->save();

            // Simpan ke sensor_logs sebagai log lanjutan
            \App\Models\SensorLog::create([
                'pengguna_id' => $penggunaId,
                'meter_awal' => $pengguna->meter_awal,
                'meter_akhir' => $nowValue,
            ]);

            $this->info("Meteran updated & logged for pengguna_id={$penggunaId}, awal={$pengguna->meter_awal}, akhir={$nowValue}");
        }, MqttClient::QOS_AT_LEAST_ONCE);

        $mqtt->loop(true);
        $mqtt->disconnect();
    }
}
