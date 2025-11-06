<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Jalan - {{ $suratJalan->nomor_surat }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 12pt;
            line-height: 1.6;
            color: #000;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            border-bottom: 3px solid #000;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        
        .header h1 {
            font-size: 24pt;
            font-weight: bold;
            margin-bottom: 5px;
            text-transform: uppercase;
        }
        
        .header p {
            font-size: 10pt;
            color: #666;
        }
        
        .document-title {
            text-align: center;
            margin: 20px 0;
        }
        
        .document-title h2 {
            font-size: 18pt;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 10px;
        }
        
        .nomor-surat {
            text-align: center;
            font-size: 11pt;
            margin-bottom: 20px;
        }
        
        .section {
            margin-bottom: 20px;
        }
        
        .section-title {
            font-weight: bold;
            font-size: 12pt;
            margin-bottom: 10px;
            border-bottom: 2px solid #333;
            padding-bottom: 5px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        
        table.info-table td {
            padding: 8px;
            vertical-align: top;
        }
        
        table.info-table td:first-child {
            width: 30%;
            font-weight: bold;
        }
        
        table.info-table td:nth-child(2) {
            width: 5%;
        }
        
        .penumpang-list {
            margin-top: 10px;
        }
        
        .penumpang-list ol {
            padding-left: 20px;
        }
        
        .penumpang-list li {
            margin-bottom: 5px;
        }
        
        .signature-section {
            margin-top: 40px;
            page-break-inside: avoid;
        }
        
        .signature-box {
            width: 45%;
            display: inline-block;
            text-align: center;
            vertical-align: top;
        }
        
        .signature-box.right {
            float: right;
        }
        
        .signature-space {
            height: 80px;
            margin: 20px 0;
        }
        
        .footer {
            position: fixed;
            bottom: 20px;
            left: 20px;
            right: 20px;
            text-align: center;
            font-size: 9pt;
            color: #666;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }
        
        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 10pt;
            font-weight: bold;
        }
        
        .status-aktif {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status-selesai {
            background-color: #cce5ff;
            color: #004085;
        }
        
        @media print {
            body {
                padding: 0;
            }
            
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Header Perusahaan -->
    <div class="header">
        <h1>PT. SISTEM TRANSPORTASI KENDARAAN</h1>
        <p>Jl. Contoh Alamat No. 123, Jakarta | Telp: (021) 12345678 | Email: info@sistemstk.com</p>
    </div>
    
    <!-- Judul Dokumen -->
    <div class="document-title">
        <h2>SURAT JALAN</h2>
    </div>
    
    <div class="nomor-surat">
        <strong>Nomor: {{ $suratJalan->nomor_surat }}</strong>
    </div>
    
    <!-- Informasi Surat -->
    <div class="section">
        <table class="info-table">
            <tr>
                <td>Tanggal Dibuat</td>
                <td>:</td>
                <td>{{ $suratJalan->created_at->format('d F Y') }}</td>
            </tr>
            <tr>
                <td>Status</td>
                <td>:</td>
                <td>
                    <span class="status-badge status-{{ $suratJalan->status }}">
                        {{ strtoupper($suratJalan->status) }}
                    </span>
                </td>
            </tr>
        </table>
    </div>
    
    <!-- Informasi Kendaraan -->
    <div class="section">
        <div class="section-title">INFORMASI KENDARAAN</div>
        <table class="info-table">
            <tr>
                <td>Nama Kendaraan</td>
                <td>:</td>
                <td>{{ $suratJalan->kendaraan->nama_kendaraan }}</td>
            </tr>
            <tr>
                <td>Plat Nomor</td>
                <td>:</td>
                <td><strong>{{ $suratJalan->kendaraan->plat_nomor }}</strong></td>
            </tr>
            <tr>
                <td>Jenis Kendaraan</td>
                <td>:</td>
                <td>{{ $suratJalan->kendaraan->jenis }}</td>
            </tr>
        </table>
    </div>
    
    <!-- Informasi Pemohon -->
    <div class="section">
        <div class="section-title">INFORMASI PEMOHON</div>
        <table class="info-table">
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td>{{ $suratJalan->user->name }}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>:</td>
                <td>{{ $suratJalan->user->email }}</td>
            </tr>
        </table>
    </div>
    
    <!-- Informasi Driver -->
    @if($suratJalan->driver)
    <div class="section">
        <div class="section-title">INFORMASI DRIVER</div>
        <table class="info-table">
            <tr>
                <td>Nama Driver</td>
                <td>:</td>
                <td><strong>{{ $suratJalan->driver->name }}</strong></td>
            </tr>
            <tr>
                <td>Email</td>
                <td>:</td>
                <td>{{ $suratJalan->driver->email }}</td>
            </tr>
        </table>
    </div>
    @endif
    
    <!-- Detail Perjalanan -->
    <div class="section">
        <div class="section-title">DETAIL PERJALANAN</div>
        <table class="info-table">
            <tr>
                <td>Keperluan</td>
                <td>:</td>
                <td>{{ $suratJalan->keperluan }}</td>
            </tr>
            <tr>
                <td>Tujuan</td>
                <td>:</td>
                <td>{{ $suratJalan->tujuan }}</td>
            </tr>
            <tr>
                <td>Tanggal Berangkat</td>
                <td>:</td>
                <td><strong>{{ $suratJalan->tanggal_berangkat->format('d F Y, H:i') }} WIB</strong></td>
            </tr>
            <tr>
                <td>Tanggal Kembali</td>
                <td>:</td>
                <td><strong>{{ $suratJalan->tanggal_kembali->format('d F Y, H:i') }} WIB</strong></td>
            </tr>
        </table>
    </div>
    
    <!-- Daftar Penumpang -->
    @if($suratJalan->penumpang)
    <div class="section">
        <div class="section-title">DAFTAR PENUMPANG</div>
        <div class="penumpang-list">
            @php
                $penumpangList = array_filter(array_map('trim', preg_split('/[\n,]+/', $suratJalan->penumpang)));
            @endphp
            <ol>
                @foreach($penumpangList as $penumpang)
                <li>{{ $penumpang }}</li>
                @endforeach
            </ol>
            <p style="margin-top: 10px;">
                <strong>Total Penumpang: {{ count($penumpangList) }} orang</strong>
            </p>
        </div>
    </div>
    @else
    <div class="section">
        <div class="section-title">DAFTAR PENUMPANG</div>
        <p style="color: #999; font-style: italic;">Data penumpang tidak tersedia</p>
    </div>
    @endif
    
    @if($suratJalan->catatan)
    <div class="section">
        <div class="section-title">CATATAN</div>
        <p>{{ $suratJalan->catatan }}</p>
    </div>
    @endif
    
    <!-- Tanda Tangan -->
    <div class="signature-section">
        <table style="width: 100%; margin-top: 40px;">
            <tr>
                <td style="width: 33%; text-align: center; vertical-align: top;">
                    <p>Pemohon,</p>
                    <div style="height: 80px;"></div>
                    <p><strong><u>{{ $suratJalan->user->name }}</u></strong></p>
                </td>
                @if($suratJalan->driver)
                <td style="width: 33%; text-align: center; vertical-align: top;">
                    <p>Driver,</p>
                    <div style="height: 80px;"></div>
                    <p><strong><u>{{ $suratJalan->driver->name }}</u></strong></p>
                </td>
                @endif
                <td style="width: 33%; text-align: center; vertical-align: top;">
                    <p>Disetujui Oleh,</p>
                    <div style="height: 80px;"></div>
                    <p><strong><u>{{ $suratJalan->approver->name }}</u></strong></p>
                    <p style="font-size: 10pt;">{{ $suratJalan->approver->roles->pluck('name')->map(fn($role) => ucwords(str_replace('_', ' ', $role)))->first() }}</p>
                </td>
            </tr>
        </table>
    </div>
    
    <!-- Footer -->
    <div class="footer">
        <p>Dokumen ini dicetak pada {{ now()->format('d F Y, H:i') }} WIB</p>
        <p>{{ $suratJalan->nomor_surat }} - Sistem Transportasi Kendaraan</p>
    </div>
</body>
</html>
