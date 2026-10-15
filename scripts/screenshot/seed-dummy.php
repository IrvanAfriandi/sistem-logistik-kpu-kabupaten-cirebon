<?php

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

require dirname(__DIR__, 2) . '/vendor/autoload.php';

$app = require dirname(__DIR__, 2) . '/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

if (! app()->environment(['local', 'testing'])) {
    throw new RuntimeException('Screenshot seeding is restricted to local and testing environments.');
}

if (DB::connection()->getDriverName() !== 'sqlite') {
    throw new RuntimeException('Screenshot seeding requires an isolated SQLite database.');
}

if (DB::table('users')->exists() || DB::table('data_kecamatan')->exists()) {
    throw new RuntimeException('The screenshot database must be empty before seeding.');
}

$now = '2026-10-16 09:00:00';
$password = Hash::make('ScreenshotPass123!');

DB::transaction(function () use ($now, $password) {
    $kecamatanIds = [];
    for ($i = 1; $i <= 10; $i++) {
        $kecamatanIds[] = DB::table('data_kecamatan')->insertGetId([
            'nama_kecamatan' => sprintf('Kecamatan Contoh %02d', $i),
        ]);
    }

    $jenisIds = [];
    for ($i = 1; $i <= 8; $i++) {
        $jenisIds[] = DB::table('jenis_surat_suara')->insertGetId([
            'nama_jenis_surat_suara' => sprintf('Surat Suara Jenis %02d', $i),
        ]);
    }

    $adminId = DB::table('users')->insertGetId([
        'nama' => 'Admin Demo 01',
        'email' => 'admin@example.test',
        'password' => $password,
        'role' => 'Admin',
        'jenis_kelamin' => 'Laki-laki',
        'hak_pengawas' => 0,
        'created_at' => $now,
        'updated_at' => $now,
    ]);
    $ppkId = DB::table('users')->insertGetId([
        'nama' => 'PPK Demo 01',
        'email' => 'ppk@example.test',
        'password' => $password,
        'role' => 'PPK',
        'jenis_kelamin' => 'Perempuan',
        'hak_pengawas' => 1,
        'id_kecamatan' => $kecamatanIds[0],
        'created_at' => $now,
        'updated_at' => $now,
    ]);

    foreach (['Admin' => 7, 'PPK' => 7] as $role => $extraUsers) {
        for ($i = 2; $i <= $extraUsers + 1; $i++) {
            DB::table('users')->insert([
                'nama' => sprintf('%s Demo %02d', $role, $i),
                'email' => sprintf('%s-demo-%02d@example.test', strtolower($role), $i),
                'password' => $password,
                'role' => $role,
                'jenis_kelamin' => $i % 2 === 0 ? 'Laki-laki' : 'Perempuan',
                'hak_pengawas' => $role === 'PPK' ? 1 : 0,
                'id_kecamatan' => $role === 'PPK' ? $kecamatanIds[($i - 1) % count($kecamatanIds)] : null,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    $kelompokIds = [];
    for ($i = 1; $i <= 10; $i++) {
        $kelompokIds[] = DB::table('kelompok')->insertGetId([
            'nama_kelompok' => sprintf('Kelompok Contoh %02d', $i),
            'pengawas' => $ppkId,
        ]);
    }

    $petugasIds = [];
    for ($i = 1; $i <= 12; $i++) {
        $petugasIds[] = DB::table('petugas')->insertGetId([
            'nama' => sprintf('Petugas Contoh %02d', $i),
            'jenis_kelamin' => $i % 2 === 0 ? 'Laki-laki' : 'Perempuan',
            'alamat' => sprintf('Jalan Fiktif Nomor %d', $i),
            'umur' => 25 + ($i % 20),
            'nik' => 9000000000000000 + $i,
            'kelompok' => $kelompokIds[($i - 1) % count($kelompokIds)],
            'foto' => '',
        ]);
    }

    $boxIds = [];
    for ($i = 1; $i <= 12; $i++) {
        $boxIds[] = DB::table('surat_suara')->insertGetId([
            'nomor_box' => sprintf('BOX-TEST-%03d', $i),
            'jenis' => $jenisIds[($i - 1) % count($jenisIds)],
            'isi_awal' => 400 + $i * 10,
            'status_box' => ($i - 1) % 5,
            'ditambahkan_oleh' => 'Admin Demo 01',
            'waktu_ditambahkan' => $now,
            'waktu_terakhir_diedit' => $now,
        ]);
    }

    $kategoriIds = [];
    for ($i = 1; $i <= 8; $i++) {
        $kategoriIds[] = DB::table('kategori_rusak')->insertGetId([
            'nama_kerusakan' => sprintf('Kategori Rusak Contoh %02d', $i),
        ]);
    }

    $sorlipIds = [];
    for ($i = 1; $i <= 10; $i++) {
        $sorlipIds[] = DB::table('sorlip')->insertGetId([
            'id_box' => $boxIds[$i - 1],
            'petugas' => $petugasIds[$i - 1],
            'isi_setelah_disorlip' => $i === 1 ? null : 390 + $i,
            'waktu_dibuka' => $now,
            'dibuka_oleh' => 'PPK Demo 01',
            'waktu_selesai' => $i === 1 ? null : $now,
            'diselesaikan_oleh' => $i === 1 ? null : 'PPK Demo 01',
        ]);
    }

    foreach ($sorlipIds as $i => $sorlipId) {
        DB::table('surat_suara_rusak')->insert([
            'id_sorlip' => $sorlipId,
            'jumlah_rusak' => $i % 4,
            'kategori_rusak' => $kategoriIds[$i % count($kategoriIds)],
        ]);
    }

    $perlengkapanIds = [];
    for ($i = 1; $i <= 8; $i++) {
        $perlengkapanIds[] = DB::table('perlengkapan')->insertGetId([
            'nama_perlengkapan' => sprintf('Perlengkapan Contoh %02d', $i),
            'jumlah_tersimpan' => 100 + ($i * 25),
        ]);
    }

    $packingIds = [];
    for ($i = 1; $i <= 8; $i++) {
        $packingIds[] = DB::table('packing_box')->insertGetId([
            'id_box' => $boxIds[$i - 1],
            'mulai_packing_oleh' => 'PPK Demo 01',
            'waktu_mulai_packing' => $now,
            'selesai_packing_oleh' => $i % 2 === 0 ? 'PPK Demo 01' : null,
            'waktu_selesai_packing' => $i % 2 === 0 ? $now : null,
        ]);

        DB::table('packing_box_detail')->insert([
            'id_packing_box' => $packingIds[$i - 1],
            'kecamatan' => $kecamatanIds[$i - 1],
            'isi_dipakai' => 100 + ($i * 5),
            'sisa_isi_box' => 20 + $i,
        ]);
    }

    $kendaraanIds = [];
    for ($i = 1; $i <= 8; $i++) {
        $kendaraanIds[] = DB::table('kendaraan_logistik')->insertGetId([
            'nama_kendaraan' => sprintf('Kendaraan Contoh %02d', $i),
            'plat_nomor' => sprintf('TEST-LOG-%03d', $i),
            'status' => $i % 2 === 0 ? 'beroperasi' : 'standby',
            'foto' => '',
        ]);
    }

    $driverIds = [];
    for ($i = 1; $i <= 8; $i++) {
        $driverIds[] = DB::table('driver')->insertGetId([
            'nama_driver' => sprintf('Driver Contoh %02d', $i),
            'jenis_kelamin' => $i % 2 === 0 ? 'Laki-laki' : 'Perempuan',
            'umur' => 25 + $i,
            'no_telepon' => 9000000000 + $i,
            'alamat_driver' => sprintf('Alamat Fiktif %02d', $i),
            'status' => $i % 2 === 0 ? 'bekerja' : 'standby',
            'foto' => '',
        ]);
    }

    for ($i = 0; $i < 10; $i++) {
        DB::table('data_kebutuhan_surat_suara')->insert([
            'id_kecamatan' => $kecamatanIds[$i],
            'id_jenis_surat_suara' => $jenisIds[$i % count($jenisIds)],
            'jumlah_kebutuhan_surat_suara' => 500 + ($i * 25),
            'jumlah_surat_suara_terpenuhi' => 250 + ($i * 15),
        ]);
        DB::table('data_kebutuhan_perlengkapan')->insert([
            'id_kecamatan' => $kecamatanIds[$i],
            'id_perlengkapan' => $perlengkapanIds[$i % count($perlengkapanIds)],
            'jumlah_kebutuhan_perlengkapan' => 50 + $i,
            'jumlah_perlengkapan_terpenuhi' => 25 + $i,
        ]);
        DB::table('distribusi')->insert([
            'id_kecamatan' => $kecamatanIds[$i],
            'status_kebutuhan_surat_suara' => $i % 2 === 0 ? 'terpenuhi' : 'belum_terpenuhi',
            'status_kebutuhan_perlengkapan' => $i % 3 === 0 ? 'terpenuhi' : 'belum_terpenuhi',
            'status_distribusi' => ['belum_siap', 'dikirim', 'diterima'][$i % 3],
            'id_kendaraan' => $kendaraanIds[$i % count($kendaraanIds)],
            'id_driver' => $driverIds[$i % count($driverIds)],
        ]);
    }
});

fwrite(STDOUT, "Inserted synthetic screenshot records only.\n");
fwrite(STDOUT, "Admin: admin@example.test / ScreenshotPass123!\n");
fwrite(STDOUT, "PPK: ppk@example.test / ScreenshotPass123!\n");
