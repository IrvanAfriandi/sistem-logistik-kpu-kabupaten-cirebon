<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Sorlip</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .container { width: 100%; }
        .header { text-align: center; margin-bottom: 20px; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { border: 1px solid #000; padding: 8px; text-align: left; }
    </style>
</head>
<body>

    <div class="header">
        <h2>Laporan Sorlip</h2>
        <p>Komisi Pemilihan Umum Kabupaten Cirebon</p>
    </div>

    <div class="container">
        <p><strong>Nama Petugas:</strong> {{ $petugas->nama }}</p>
        <p><strong>Kelompok:</strong> {{ $petugas->kelompok_sorlip->nama_kelompok }}</p>
        <p><strong>Total Box Disorlip:</strong> {{ $total_box_disorlip }}</p>
        <p><strong>Total Surat Suara Disorlip:</strong> {{ $total_surat_suara_disorlip }}</p>

        <h4>Detail Box yang Disorlip</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nomor Box</th>
                    <th>Jenis Surat Suara</th>
                    <th>Jumlah Disorlip</th>
                    <th>Waktu Selesai Sorlip</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sorlip_data as $index => $data)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $data->box_id->nomor_box }}</td>
                    <td>{{ $data->box_id->jenis_surat->nama_jenis_surat_suara ?? 'Tidak Diketahui' }}</td>
                    <td>{{ $data->isi_setelah_disorlip }}</td>
                    <td>{{ $data->waktu_selesai }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>
</html>
