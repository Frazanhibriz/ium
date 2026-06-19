// api/hasil.js — Vercel Serverless Function (Node.js)
// Reads captured data from /tmp/data.txt and returns the admin HTML page.

const fs = require('fs');

function escapeHtml(str) {
    return String(str)
        .replace(/&/g,  '&amp;')
        .replace(/</g,  '&lt;')
        .replace(/>/g,  '&gt;')
        .replace(/"/g,  '&quot;')
        .replace(/'/g,  '&#39;');
}

module.exports = (req, res) => {
    // ── Read log entries ───────────────────────────────────────────────
    let entries = [];
    let count   = 0;

    try {
        const raw = fs.readFileSync('/tmp/data.txt', 'utf8');
        entries = raw.split('\n').filter(l => l.trim()).reverse();
        count   = entries.length;
    } catch (_) {
        // File not yet created — no entries
    }

    const logRows = entries.length === 0
        ? '<p class="log-empty">Belum ada data tersimpan.</p>'
        : entries.map(e => `<div class="log-entry">${escapeHtml(e)}</div>`).join('');

    // ── Build full HTML response ───────────────────────────────────────
    const html = `<!DOCTYPE html>
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

            <div class="stats-card">
                <div class="stats-left">
                    <span class="badge-total">Total Terjebak</span>
                    <div class="stats-count">${count} Siswa</div>
                    <div class="stats-label">Siswa yang memasukkan data ke form phishing.</div>
                </div>
                <div class="stats-icon">📊</div>
            </div>

            <div class="log-section">
                <h2 class="log-title">Log Aktivitas Terakhir</h2>
                <div class="log-list">${logRows}</div>
            </div>

            <div style="text-align:center; margin-bottom:40px;">
                <a href="/" class="btn-home">Kembali ke Beranda</a>
            </div>

        </div>
    </main>
</body>
</html>`;

    res.setHeader('Content-Type', 'text/html; charset=utf-8');
    res.end(html);
};
