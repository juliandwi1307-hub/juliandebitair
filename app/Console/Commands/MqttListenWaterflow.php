<?php

namespace App\Console\Commands;

use App\Models\Pengguna;
use App\Models\SensorLog;
use App\Models\Tagihan;
use App\Models\Tarif;
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

        $this->info('Connected to HiveMQ. Listening on /user/waterflow and user/waterflow...');

        $handler = function (string $topic, string $message) {
            $data = json_decode($message, true);

            // Skip heartbeat dan response valve (tidak ada field 'now')
            if (!isset($data['id'], $data['now'])) {
                $this->line("Skip: {$message}");
                return;
            }

            $penggunaId = (int) $data['id'];
            $nowValue   = (int) $data['now'];
            $valveValue = $data['valve'] ?? null;

            $pengguna = Pengguna::find($penggunaId);

            if (!$pengguna) {
                $this->warn("Pengguna id={$penggunaId} not found, skipping.");
                return;
            }

            $latestLog = SensorLog::where('pengguna_id', $penggunaId)
                ->orderBy('created_at', 'desc')
                ->first();

            if (!$latestLog) {
                // Belum ada log sama sekali, set awal ke now
                $pengguna->meter_awal = $nowValue;
            } elseif ($latestLog->created_at->format('Y-m') !== date('Y-m')) {
                // Berganti bulan, awal = akhir bulan lalu
                $pengguna->meter_awal = $pengguna->meter_akhir;
            } elseif ($pengguna->meter_awal > $nowValue) {
                // meter_awal tidak logis (lebih besar dari now), reset ke now
                $pengguna->meter_awal = $nowValue;
            }

            $pengguna->meter_akhir = $nowValue;

            if ($valveValue !== null) {
                $pengguna->water_status = ($valveValue === 'OPEN') ? 1 : 0;
            }

            $pengguna->save();

            SensorLog::create([
                'pengguna_id' => $penggunaId,
                'meter_awal'  => $pengguna->meter_awal,
                'meter_akhir' => $nowValue,
            ]);

            // Sinkronkan tagihan bulan ini dengan data meteran terbaru
            $bulanMap = [
                1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',
                7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'
            ];
            $bulanIni  = $bulanMap[(int) date('n')];
            $tahunIni  = (int) date('Y');
            $jumlah    = max(0, $nowValue - $pengguna->meter_awal);
            $hargaTarif = Tarif::first()?->harga ?? 0;
            $totalTagihan = $jumlah * $hargaTarif;

            $tagihan = Tagihan::where('pengguna_id', $penggunaId)
                ->where('bulan', $bulanIni)
                ->where('tahun', $tahunIni)
                ->first();

            if ($tagihan) {
                $tagihan->update([
                    'awal'    => $pengguna->meter_awal,
                    'akhir'   => $nowValue,
                    'jumlah'  => $jumlah,
                    'tagihan' => $totalTagihan,
                ]);
            }

            $this->info("[{$topic}] pengguna_id={$penggunaId}, awal={$pengguna->meter_awal}, akhir={$nowValue}, jumlah={$jumlah}, valve={$valveValue}");
        };

        $mqtt->subscribe('/user/waterflow', $handler, MqttClient::QOS_AT_LEAST_ONCE);
        $mqtt->subscribe('user/waterflow', $handler, MqttClient::QOS_AT_LEAST_ONCE);

        $mqtt->loop(true);
        $mqtt->disconnect();
    }
}
