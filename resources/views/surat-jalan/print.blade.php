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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 11pt;
            line-height: 1.5;
            color: #333;
            padding: 15px;
            max-width: 800px;
            margin: 0 auto;
        }
        
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        
        .header h1 {
            font-size: 16pt;
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }
        
        .header p {
            font-size: 9pt;
            color: #666;
        }
        
        .document-title {
            text-align: center;
            margin: 15px 0;
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
        }
        
        .document-title h2 {
            font-size: 14pt;
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }
        
        .nomor-surat {
            text-align: center;
            font-size: 10pt;
            margin-bottom: 15px;
            font-weight: bold;
        }
        
        .section {
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            background-color: #fafafa;
        }
        
        .section-title {
            font-weight: bold;
            font-size: 10pt;
            margin-bottom: 8px;
            color: #555;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }
        
        .info-item {
            display: flex;
            margin-bottom: 5px;
        }
        
        .info-label {
            width: 40%;
            font-weight: 600;
            color: #555;
            font-size: 10pt;
        }
        
        .info-value {
            flex: 1;
            color: #333;
            font-size: 10pt;
        }
        
        .penumpang-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 5px;
            margin-top: 8px;
        }
        
        .penumpang-item {
            background-color: #fff;
            padding: 5px 8px;
            border: 1px solid #ddd;
            border-radius: 3px;
            font-size: 9pt;
        }
        
        .summary-box {
            background-color: #e9ecef;
            padding: 10px;
            border-radius: 5px;
            margin: 15px 0;
            text-align: center;
        }
        
        .signature-section {
            margin-top: 30px;
            page-break-inside: avoid;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        
        .signature-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 20px;
        }
        
        .signature-box {
            text-align: center;
            border: 1px solid #ddd;
            padding: 15px 10px;
            border-radius: 5px;
            background-color: #fafafa;
        }
        
        .signature-title {
            font-size: 9pt;
            margin-bottom: 40px;
            color: #666;
        }
        
        .signature-name {
            font-weight: bold;
            border-bottom: 1px solid #333;
            padding-bottom: 2px;
            font-size: 10pt;
        }
        
        .signature-role {
            font-size: 8pt;
            color: #666;
            margin-top: 3px;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 8pt;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        
        .status-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 9pt;
            font-weight: bold;
        }
        
        .status-aktif {
            background-color: #d1ecf1;
            color: #0c5460;
        }
        
        .status-selesai {
            background-color: #d4edda;
            color: #155724;
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
        <h1>PT. GADING GADJAH MADA</h1>
        <p>Jl.Albisindo Raya No. 09 Ds. Gondosari, Kec. Gebog, Kab. Kudus | Telp: (021) 12345678</p>
    </div>
    
    <!-- Judul Dokumen -->
    <div class="document-title">
        <h2>SURAT JALAN KENDARAAN</h2>
        <div class="nomor-surat">No: {{ $suratJalan->nomor_surat }}</div>
    </div>
    
    <!-- Summary Box -->
    <div class="summary-box">
        <strong>{{ $suratJalan->kendaraan->nama_kendaraan }} ({{ $suratJalan->kendaraan->plat_nomor }})</strong><br>
        <span>{{ $suratJalan->tanggal_berangkat->format('d M Y') }} - {{ $suratJalan->tanggal_kembali->format('d M Y') }}</span><br>
        <span class="status-badge status-{{ $suratJalan->status }}">{{ strtoupper($suratJalan->status) }}</span>
    </div>
    
    <!-- Informasi Utama -->
    <div class="info-grid">
        <!-- Kendaraan & Perjalanan -->
        <div class="section">
            <div class="section-title">Kendaraan & Perjalanan</div>
            <div class="info-item">
                <span class="info-label">Kendaraan:</span>
                <span class="info-value">{{ $suratJalan->kendaraan->nama_kendaraan }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Plat Nomor:</span>
                <span class="info-value"><strong>{{ $suratJalan->kendaraan->plat_nomor }}</strong></span>
            </div>
            <div class="info-item">
                <span class="info-label">Jenis:</span>
                <span class="info-value">{{ $suratJalan->kendaraan->jenis }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Keperluan:</span>
                <span class="info-value">{{ $suratJalan->keperluan }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Tujuan:</span>
                <span class="info-value">{{ $suratJalan->tujuan }}</span>
            </div>
        </div>

        <!-- Personel -->
        <div class="section">
            <div class="section-title">Personel Terlibat</div>
            <div class="info-item">
                <span class="info-label">Pemohon:</span>
                <span class="info-value">{{ $suratJalan->user->name }}</span>
            </div>
            @if($suratJalan->driver)
            <div class="info-item">
                <span class="info-label">Driver:</span>
                <span class="info-value"><strong>{{ $suratJalan->driver->name }}</strong></span>
            </div>
            @endif
            <div class="info-item">
                <span class="info-label">Disetujui:</span>
                <span class="info-value">{{ $suratJalan->approver->name }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Tanggal Dibuat:</span>
                <span class="info-value">{{ $suratJalan->created_at->format('d M Y, H:i') }}</span>
            </div>
        </div>
    </div>
    
    <!-- Jadwal Perjalanan -->
    <div class="section">
        <div class="section-title">Jadwal Perjalanan</div>
        <div class="info-item">
            <span class="info-label">Berangkat:</span>
            <span class="info-value"><strong>{{ $suratJalan->tanggal_berangkat->format('d M Y, H:i') }} WIB</strong></span>
        </div>
        <div class="info-item">
            <span class="info-label">Kembali:</span>
            <span class="info-value"><strong>{{ $suratJalan->tanggal_kembali->format('d M Y, H:i') }} WIB</strong></span>
        </div>
        <div class="info-item">
            <span class="info-label">Durasi:</span>
            <span class="info-value">{{ $suratJalan->tanggal_berangkat->diffInDays($suratJalan->tanggal_kembali) + 1 }} hari</span>
        </div>
    </div>
    
    <!-- Daftar Penumpang -->
    @if($suratJalan->penumpang)
    <div class="section">
        <div class="section-title">Daftar Penumpang</div>
        @php
            $penumpangList = array_filter(array_map('trim', preg_split('/[\n,]+/', $suratJalan->penumpang)));
        @endphp
        <div class="penumpang-grid">
            @foreach($penumpangList as $index => $penumpang)
            <div class="penumpang-item">{{ $index + 1 }}. {{ $penumpang }}</div>
            @endforeach
        </div>
        <div style="margin-top: 10px; text-align: center; font-weight: bold; color: #555;">
            Total: {{ count($penumpangList) }} orang
        </div>
    </div>
    @endif
    
    @if($suratJalan->catatan)
    <div class="section">
        <div class="section-title">Catatan Khusus</div>
        <div style="background-color: #fff; padding: 8px; border-radius: 3px; border: 1px solid #ddd;">
            {{ $suratJalan->catatan }}
        </div>
    </div>
    @endif
    
    <!-- Tanda Tangan -->
    <div class="signature-section">
        <div style="text-align: center; margin-bottom: 15px; font-size: 10pt; color: #666;">
            Mengetahui dan Menyetujui:
        </div>
        
        <div class="signature-grid">
            <div class="signature-box">
                <div class="signature-title">Pemohon</div>
                <div class="signature-name">{{ $suratJalan->user->name }}</div>
                <div class="signature-role">Pemohon Kendaraan</div>
            </div>
            
            @if($suratJalan->driver)
            <div class="signature-box">
                <div class="signature-title">Driver</div>
                <div class="signature-name">{{ $suratJalan->driver->name }}</div>
                <div class="signature-role">Pengemudi</div>
            </div>
            @endif
            
            <div class="signature-box">
                <div class="signature-title">Menyetujui</div>
                <div class="signature-name">{{ $suratJalan->approver->name }}</div>
                <div class="signature-role">{{ $suratJalan->approver->roles->pluck('name')->map(fn($role) => ucwords(str_replace('_', ' ', $role)))->first() }}</div>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <div class="footer">
        <p>Dokumen ini dicetak pada {{ now()->format('d F Y, H:i') }} WIB</p>
        <p>{{ $suratJalan->nomor_surat }} - Sistem Transportasi Kendaraan</p>
    </div>
</body>
</html>
