<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            padding: 20px;
            background: #f5f5f5;
        }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #4CAF50;
            padding-bottom: 20px;
        }
        
        .header h1 {
            color: #4CAF50;
            font-size: 28px;
            margin-bottom: 10px;
        }
        
        .info-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
            padding: 15px;
            background: #f9f9f9;
            border-radius: 4px;
        }
        
        .info-item {
            padding: 8px 0;
        }
        
        .info-label {
            font-weight: 600;
            color: #555;
            margin-bottom: 4px;
        }
        
        .info-value {
            color: #333;
            font-size: 14px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        table thead {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
            color: white;
        }
        
        table th {
            padding: 12px;
            text-align: left;
            font-weight: 600;
            border: none;
        }
        
        table td {
            padding: 10px 12px;
            border-bottom: 1px solid #ddd;
        }
        
        table tbody tr:hover {
            background: #f5f5f5;
        }
        
        table tbody tr:nth-child(even) {
            background: #fafafa;
        }
        
        .total-section {
            margin-top: 20px;
            padding: 15px;
            background: #e8f5e9;
            border-left: 4px solid #4CAF50;
            border-radius: 4px;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            font-size: 14px;
        }
        
        .total-row.grand-total {
            font-weight: 700;
            font-size: 16px;
            color: #4CAF50;
            border-top: 2px solid #4CAF50;
            padding-top: 12px;
        }
        
        .empty-message {
            text-align: center;
            padding: 40px;
            color: #999;
        }
        
        .footer {
            text-align: right;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            font-size: 12px;
            color: #666;
        }
        
        @media print {
            body {
                background: white;
                padding: 0;
            }
            
            .container {
                box-shadow: none;
                padding: 0;
            }
            
            .no-print {
                display: none !important;
            }
        }
        
        .action-buttons {
            text-align: center;
            margin: 20px 0;
        }
        
        .btn {
            padding: 10px 20px;
            margin: 0 5px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: 0.3s;
        }
        
        .btn-print {
            background: #4CAF50;
            color: white;
        }
        
        .btn-print:hover {
            background: #45a049;
        }
        
        .btn-download {
            background: #2196F3;
            color: white;
        }
        
        .btn-download:hover {
            background: #0b7dda;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ request('jenis') === 'produksi' ? 'Laporan Produksi' : 'Laporan Keuangan' }}</h1>
            <p style="color: #666; font-size: 14px;">{{ now()->format('d F Y H:i:s') }}</p>
        </div>
        
        <div class="action-buttons no-print">
            <button class="btn btn-print" onclick="window.print()">🖨️ Cetak / Simpan PDF</button>
        </div>
        
        {!! $content !!}
        
        <div class="footer">
            <p>Laporan ini dibuat secara otomatis oleh sistem Mansita</p>
            <p>Tanggal Cetak: {{ now()->format('d/m/Y H:i') }}</p>
        </div>
    </div>
    
    <script>
        // Auto-print on page load (optional)
        // window.print();
    </script>
</body>
</html>
