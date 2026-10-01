<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dokumen Logbook - <?php echo e($internship->student->name ?? 'Mahasiswa'); ?></title>
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
            max-width: 950px;
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
            max-width: 950px;
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
        .doc-header .brand { font-size: 20px; font-weight: 800; color: #4f46e5; }
        .doc-header .tagline { font-size: 11px; color: #94a3b8; margin-top: 2px; }
        .doc-header .doc-title { text-align: right; }
        .doc-header .doc-title h1 { font-size: 16px; margin: 0; text-transform: uppercase; letter-spacing: .04em; }
        .doc-header .doc-title p { margin: 2px 0 0; font-size: 12px; color: #94a3b8; }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 6px 24px;
            font-size: 13.5px;
            margin-bottom: 24px;
        }
        .info-grid dt { color: #94a3b8; }
        .info-grid dd { margin: 0 0 8px; font-weight: 600; }
        table.logbook-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
            font-size: 12px;
        }
        table.logbook-table th, table.logbook-table td {
            border: 1px solid #e2e8f0;
            padding: 8px 10px;
            text-align: left;
            vertical-align: top;
        }
        table.logbook-table th {
            background: #f8fafc;
            font-size: 10.5px;
            text-transform: uppercase;
            letter-spacing: .02em;
            color: #64748b;
        }
        table.logbook-table td.num { text-align: center; white-space: nowrap; }
        .summary-box {
            display: flex;
            gap: 24px;
            background: #eef2ff;
            border: 1px solid #c7d2fe;
            border-radius: 10px;
            padding: 14px 20px;
            margin-bottom: 28px;
            font-size: 13px;
            color: #3730a3;
        }
        .summary-box strong { font-size: 16px; }
        .signature {
            display: flex;
            justify-content: flex-end;
            margin-top: 40px;
        }
        .signature .block { text-align: center; font-size: 13px; }
        .signature .block .place-date { margin-bottom: 56px; color: #475569; }
        .signature .block .name { font-weight: 700; border-top: 1px solid #1e293b; padding-top: 6px; min-width: 200px; }
        .footer-note { margin-top: 32px; font-size: 11px; color: #94a3b8; text-align: center; }

        @media print {
            body { background: #fff; padding: 0; }
            .toolbar { display: none; }
            .sheet { box-shadow: none; border-radius: 0; padding: 0; max-width: 100%; }
            table.logbook-table { font-size: 11px; }
        }
    </style>
</head>
<body>
    <div class="toolbar">
        <a href="<?php echo e(route('admin.performance-monitoring.detail', $internship)); ?>" class="btn-back">&larr; Kembali</a>
        <button type="button" class="btn-print" onclick="window.print()">Cetak / Unduh PDF</button>
    </div>

    <div class="sheet">
        <div class="doc-header">
            <div>
                <div class="brand">InternX</div>
                <div class="tagline">Kontribusi. Berkembang. Berdampak.</div>
            </div>
            <div class="doc-title">
                <h1>Dokumen Logbook Harian</h1>
                <p>Dicetak <?php echo e(now()->translatedFormat('d M Y H:i')); ?></p>
            </div>
        </div>

        <dl class="info-grid">
            <div>
                <dt>Nama Mahasiswa</dt>
                <dd><?php echo e($internship->student->name ?? '-'); ?></dd>
            </div>
            <div>
                <dt>Email</dt>
                <dd><?php echo e($internship->student->email ?? '-'); ?></dd>
            </div>
            <div>
                <dt>Mentor Pembimbing</dt>
                <dd><?php echo e($internship->mentor->name ?? '-'); ?></dd>
            </div>
            <div>
                <dt>Periode Magang</dt>
                <dd><?php echo e($internship->period->name ?? '-'); ?></dd>
            </div>
            <div>
                <dt>Program</dt>
                <dd><?php echo e($internship->program ?? '-'); ?></dd>
            </div>
            <div>
                <dt>Instansi</dt>
                <dd><?php echo e($internship->institution ?? '-'); ?></dd>
            </div>
        </dl>

        <div class="summary-box">
            <div><strong><?php echo e($logbooks->count()); ?></strong> entri logbook disetujui mentor</div>
            <div>Periode <?php echo e($internship->start_date->translatedFormat('d M Y')); ?> &ndash; <?php echo e($internship->end_date->translatedFormat('d M Y')); ?></div>
        </div>

        <?php if($logbooks->isEmpty()): ?>
            <p style="text-align:center; color:#94a3b8; padding: 24px 0;">Belum ada entri logbook yang disetujui mentor.</p>
        <?php else: ?>
            <table class="logbook-table">
                <thead>
                    <tr>
                        <th style="width:90px;">Tanggal</th>
                        <th style="width:80px;">Jam</th>
                        <th style="width:150px;">Aktivitas</th>
                        <th>Deskripsi</th>
                        <th>Output</th>
                        <th>Kendala</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $logbooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $logbook): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="num"><?php echo e($logbook->date->format('d/m/Y')); ?></td>
                            <td class="num"><?php echo e($logbook->start_time->format('H:i')); ?>&ndash;<?php echo e($logbook->end_time->format('H:i')); ?></td>
                            <td><?php echo e($logbook->activity); ?></td>
                            <td><?php echo e($logbook->description); ?></td>
                            <td><?php echo e($logbook->output ?: '-'); ?></td>
                            <td><?php echo e($logbook->obstacle ?: '-'); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        <?php endif; ?>

        <div class="signature">
            <div class="block">
                <div class="place-date"><?php echo e(now()->translatedFormat('d M Y')); ?></div>
                <div class="name"><?php echo e($internship->mentor->name ?? 'Mentor Pembimbing'); ?></div>
                <div>Mentor Pembimbing</div>
            </div>
        </div>

        <p class="footer-note">Dokumen ini dihasilkan otomatis oleh sistem InternX dan hanya memuat entri logbook yang telah disetujui mentor.</p>
    </div>

    <?php if($autoPrint): ?>
        <script>
            window.addEventListener('load', function () {
                setTimeout(function () { window.print(); }, 300);
            });
        </script>
    <?php endif; ?>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\internx-laravel-updated last\internex-laravel\resources\views/admin/performance-monitoring/logbook-document.blade.php ENDPATH**/ ?>