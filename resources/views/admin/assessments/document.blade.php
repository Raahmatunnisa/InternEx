<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dokumen Nilai - {{ $assessment->internship->student->name ?? 'Mahasiswa' }}</title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            color: #1e293b;
            background: #f1f5f9;
            margin: 0;
            padding: 32px 16px;
        }
        .toolbar {
            max-width: 780px;
            margin: 0 auto 16px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
        .toolbar button, .toolbar a {
            border: none;
            padding: 9px 16px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }
        .btn-print { background: #4f46e5; color: #fff; }
        .btn-back { background: #e2e8f0; color: #334155; }
        .sheet {
            max-width: 780px;
            margin: 0 auto;
            background: #fff;
            padding: 48px 56px;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .doc-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 3px solid #4f46e5;
            padding-bottom: 16px;
            margin-bottom: 28px;
        }
        .doc-header .brand {
            font-size: 20px;
            font-weight: 800;
            color: #4f46e5;
        }
        .doc-header .tagline {
            font-size: 11px;
            color: #94a3b8;
            margin-top: 2px;
        }
        .doc-header .doc-title {
            text-align: right;
        }
        .doc-header .doc-title h1 {
            font-size: 16px;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: .04em;
        }
        .doc-header .doc-title p {
            margin: 2px 0 0;
            font-size: 12px;
            color: #94a3b8;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 6px 24px;
            font-size: 13.5px;
            margin-bottom: 28px;
        }
        .info-grid dt { color: #94a3b8; }
        .info-grid dd { margin: 0 0 8px; font-weight: 600; }
        table.scores {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
            font-size: 13.5px;
        }
        table.scores th, table.scores td {
            border: 1px solid #e2e8f0;
            padding: 10px 12px;
            text-align: left;
        }
        table.scores th {
            background: #f8fafc;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .03em;
            color: #64748b;
        }
        table.scores td.num { text-align: right; }
        .final-box {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #eef2ff;
            border: 1px solid #c7d2fe;
            border-radius: 10px;
            padding: 16px 20px;
            margin-bottom: 36px;
        }
        .final-box .label { font-size: 13px; color: #4338ca; font-weight: 600; }
        .final-box .value { font-size: 26px; font-weight: 800; color: #3730a3; }
        .final-box .grade { font-size: 13px; color: #4338ca; margin-top: 2px; }
        .grade-range {
            margin-bottom: 32px;
        }
        .grade-range .heading {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .03em;
            color: #64748b;
            margin-bottom: 8px;
            font-weight: 600;
        }
        table.grade-range-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12.5px;
        }
        table.grade-range-table th, table.grade-range-table td {
            border: 1px solid #e2e8f0;
            padding: 7px 10px;
            text-align: center;
        }
        table.grade-range-table th {
            background: #f8fafc;
            font-size: 10.5px;
            text-transform: uppercase;
            color: #64748b;
        }
        table.grade-range-table td.active-grade {
            background: #eef2ff;
            color: #3730a3;
            font-weight: 700;
        }
        .signature {
            display: flex;
            justify-content: flex-end;
            margin-top: 48px;
        }
        .signature .block { text-align: center; font-size: 13px; }
        .signature .block .place-date { margin-bottom: 56px; color: #475569; }
        .signature .block .name { font-weight: 700; border-top: 1px solid #1e293b; padding-top: 6px; min-width: 200px; }
        .footer-note {
            margin-top: 32px;
            font-size: 11px;
            color: #94a3b8;
            text-align: center;
        }

        @media print {
            body { background: #fff; padding: 0; }
            .toolbar { display: none; }
            .sheet { box-shadow: none; border-radius: 0; padding: 0; max-width: 100%; }
        }
    </style>
</head>
<body>
    <div class="toolbar">
        <a href="{{ route('admin.assessments.index') }}" class="btn-back">&larr; Kembali</a>
        <button type="button" class="btn-print" onclick="window.print()">Cetak / Unduh PDF</button>
    </div>

    <div class="sheet">
        <div class="doc-header">
            <div>
                <div class="brand">InternX</div>
                <div class="tagline">Kontribusi. Berkembang. Berdampak.</div>
            </div>
            <div class="doc-title">
                <h1>Dokumen Nilai Magang</h1>
                <p>Dicetak {{ now()->translatedFormat('d M Y H:i') }}</p>
            </div>
        </div>

        <dl class="info-grid">
            <div>
                <dt>Nama Mahasiswa</dt>
                <dd>{{ $assessment->internship->student->name ?? '-' }}</dd>
            </div>
            <div>
                <dt>Email</dt>
                <dd>{{ $assessment->internship->student->email ?? '-' }}</dd>
            </div>
            <div>
                <dt>Mentor Pembimbing</dt>
                <dd>{{ $assessment->internship->mentor->name ?? '-' }}</dd>
            </div>
            <div>
                <dt>Periode Magang</dt>
                <dd>{{ $assessment->internship->period->name ?? '-' }}</dd>
            </div>
            <div>
                <dt>Program</dt>
                <dd>{{ $assessment->internship->program ?? '-' }}</dd>
            </div>
            <div>
                <dt>Instansi</dt>
                <dd>{{ $assessment->internship->institution ?? '-' }}</dd>
            </div>
        </dl>

        <table class="scores">
            <thead>
                <tr>
                    <th>Komponen Penilaian</th>
                    <th class="num">Bobot</th>
                    <th class="num">Nilai</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Kehadiran</td>
                    <td class="num">10%</td>
                    <td class="num">{{ number_format((float) $assessment->attendance_score, 2) }}</td>
                </tr>
                <tr>
                    <td>Logbook / Aktivitas Harian</td>
                    <td class="num">20%</td>
                    <td class="num">{{ number_format((float) $assessment->logbook_score, 2) }}</td>
                </tr>
                <tr>
                    <td>Laporan Akhir</td>
                    <td class="num">50%</td>
                    <td class="num">{{ number_format((float) $assessment->final_report_score, 2) }}</td>
                </tr>
                <tr>
                    <td>Presentasi</td>
                    <td class="num">20%</td>
                    <td class="num">{{ number_format((float) $assessment->presentation_score, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <div class="final-box">
            <div>
                <div class="label">Nilai Akhir</div>
                <div class="grade">Grade {{ $assessment->grade }} &middot; IPK {{ number_format((float) $assessment->grade_point, 1) }}</div>
            </div>
            <div class="value">{{ number_format((float) $assessment->final_score, 2) }}</div>
        </div>

        <div class="grade-range">
            <div class="heading">Rentang Nilai (Grade)</div>
            <table class="grade-range-table">
                <thead>
                    <tr>
                        <th>Grade</th><th>A</th><th>AB</th><th>B</th><th>BC</th><th>C</th><th>D</th><th>E</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Rentang Nilai</td>
                        <td class="{{ $assessment->grade === 'A' ? 'active-grade' : '' }}">87&ndash;100</td>
                        <td class="{{ $assessment->grade === 'AB' ? 'active-grade' : '' }}">78&ndash;86,99</td>
                        <td class="{{ $assessment->grade === 'B' ? 'active-grade' : '' }}">69&ndash;77,99</td>
                        <td class="{{ $assessment->grade === 'BC' ? 'active-grade' : '' }}">60&ndash;68,99</td>
                        <td class="{{ $assessment->grade === 'C' ? 'active-grade' : '' }}">51&ndash;59,99</td>
                        <td class="{{ $assessment->grade === 'D' ? 'active-grade' : '' }}">41&ndash;50,99</td>
                        <td class="{{ $assessment->grade === 'E' ? 'active-grade' : '' }}">0&ndash;40,99</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="signature">
            <div class="block">
                <div class="place-date">{{ now()->translatedFormat('d M Y') }}</div>
                <div class="name">{{ $assessment->internship->mentor->name ?? 'Mentor Pembimbing' }}</div>
                <div>Mentor Pembimbing</div>
            </div>
        </div>

        <p class="footer-note">Dokumen ini dihasilkan otomatis oleh sistem InternX dan sah tanpa tanda tangan basah.</p>
    </div>

    @if($autoPrint)
        <script>
            window.addEventListener('load', function () {
                setTimeout(function () { window.print(); }, 300);
            });
        </script>
    @endif
</body>
</html>
