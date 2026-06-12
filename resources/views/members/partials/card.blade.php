<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>

<style>
    .card-wrap {
        max-width: 390px;
        margin: 0 auto;
    }

    .id-card {
        width: 340px;
        height: 620px;
        margin: 0 auto;
        border-radius: 32px;
        overflow: hidden;
        position: relative;
        background: #fffdf3;
        box-shadow: 0 35px 80px rgba(6, 78, 59, .28);
    }

    .top-bg {
        position: absolute;
        inset: 0 0 auto 0;
        height: 210px;
        background: linear-gradient(135deg, #022c22, #047857, #65a30d);
    }

    .gold-line {
        position: absolute;
        top: 188px;
        left: -20px;
        width: 390px;
        height: 10px;
        background: #d4af37;
        transform: rotate(-6deg);
        z-index: 2;
    }

    .white-wave {
        position: absolute;
        top: 160px;
        left: -30px;
        width: 420px;
        height: 95px;
        background: #fffdf3;
        transform: rotate(-6deg);
        z-index: 1;
    }

    .brand {
        position: relative;
        z-index: 5;
        padding: 24px;
        color: white;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .logo-box {
        width: 58px;
        height: 58px;
        background: white;
        border: 3px solid #d4af37;
        border-radius: 18px;
        padding: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .logo-box img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .brand-title {
        margin-left: 12px;
    }

    .brand-title small {
        color: #d4af37;
        font-weight: 900;
        letter-spacing: 2px;
        font-size: 9px;
    }

    .brand-title h2 {
        font-size: 14px;
        line-height: 1.2;
        font-weight: 900;
        margin: 3px 0 0;
    }

    .badge {
        border: 1px solid #d4af37;
        color: #d4af37;
        border-radius: 999px;
        padding: 6px 10px;
        font-size: 9px;
        font-weight: 900;
        letter-spacing: 1px;
        background: rgba(255,255,255,.12);
    }

    .photo-area {
        position: relative;
        z-index: 6;
        margin-top: 48px;
        display: flex;
        justify-content: center;
    }

    .photo-frame {
        width: 140px;
        height: 155px;
        border-radius: 26px;
        border: 4px solid #d4af37;
        background: white;
        padding: 7px;
        box-shadow: 0 20px 35px rgba(2, 44, 34, .25);
    }

    .photo-frame img,
    .photo-placeholder {
        width: 100%;
        height: 100%;
        border-radius: 18px;
        object-fit: cover;
        background: #ecfccb;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #047857;
    }

    .info {
        position: relative;
        z-index: 6;
        text-align: center;
        padding: 16px 24px 0;
    }

    .member-code {
        font-size: 10px;
        font-weight: 900;
        letter-spacing: 2px;
        color: #047857;
    }

    .name {
        margin-top: 5px;
        font-size: 22px;
        font-weight: 900;
        color: #0f172a;
        line-height: 1.15;
    }

    .nim {
        margin-top: 5px;
        font-size: 12px;
        font-weight: 800;
        color: #64748b;
    }

    .info-grid {
        margin-top: 16px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
    }

    .info-box {
        background: #ecfccb;
        border-radius: 18px;
        padding: 11px;
        text-align: left;
    }

    .info-box small {
        font-size: 8px;
        font-weight: 900;
        color: #94a3b8;
    }

    .info-box p {
        margin: 3px 0 0;
        font-size: 11px;
        font-weight: 900;
        color: #0f172a;
        line-height: 1.2;
    }

    .qr-card {
        position: absolute;
        left: 24px;
        right: 24px;
        bottom: 74px;
        z-index: 20;
        background: #ffffff;
        border-radius: 24px;
        padding: 12px;
        display: flex;
        gap: 12px;
        align-items: center;
        box-shadow: 0 18px 35px rgba(15, 23, 42, .18);
        border: 1px solid rgba(212, 175, 55, .35);
    }

    .qr-box {
        width: 116px;
        height: 116px;
        flex-shrink: 0;
        background: #ffffff;
        border-radius: 18px;
        padding: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .qr-box svg {
        width: 100% !important;
        height: 100% !important;
        display: block;
    }

    .qr-text small {
        color: #047857;
        font-weight: 900;
        letter-spacing: 1px;
        font-size: 9px;
    }

    .qr-text p {
        margin: 4px 0 0;
        font-size: 11px;
        font-weight: 800;
        color: #64748b;
        line-height: 1.35;
    }

    .qr-text b {
        display: block;
        margin-top: 8px;
        font-size: 12px;
        color: #064e3b;
    }

    .footer-card {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(90deg, #022c22, #047857, #022c22);
        color: white;
        padding: 15px 22px;
        z-index: 7;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .footer-card small {
        color: #d4af37;
        font-weight: 900;
        letter-spacing: 1.5px;
        font-size: 9px;
    }

    .footer-card p {
        margin: 3px 0 0;
        font-size: 10px;
        font-weight: 700;
        color: rgba(255,255,255,.8);
    }
</style>

<div id="memberCard" class="id-card">

    <div class="top-bg"></div>
    <div class="white-wave"></div>
    <div class="gold-line"></div>

    <div class="brand">
        <div style="display:flex;align-items:center;">
            <div class="logo-box">
                <img src="{{ asset('logo.png') }}" onerror="this.style.display='none'">
            </div>

            <div class="brand-title">
                <small>AHWALUNA LIBRARY</small>
                <h2>Ma'had Aly<br>Kebon Jambu</h2>
            </div>
        </div>

        <div class="badge">MEMBER</div>
    </div>

    <div class="photo-area">
        <div class="photo-frame">
            @if($member->photo)
                <img src="{{ asset($member->photo) }}">
            @else
                <div class="photo-placeholder">
                    <i data-lucide="user-round" style="width:64px;height:64px;"></i>
                </div>
            @endif
        </div>
    </div>

    <div class="info">
        <div class="member-code">{{ $member->member_code }}</div>
        <div class="name">{{ $member->name }}</div>
        <div class="nim">NIM: {{ $member->nim ?? '-' }}</div>

        <div class="info-grid">
            <div class="info-box">
                <small>PROGRAM</small>
                <p>{{ $member->program_study ?? 'Mahasantri' }}</p>
            </div>

            <div class="info-box">
                <small>ANGKATAN</small>
                <p>{{ $member->class_year ?? '-' }}</p>
            </div>
        </div>
    </div>

    <div class="qr-card">
        <div class="qr-box">
            {!! QrCode::size(160)->margin(1)->generate($member->member_code) !!}
        </div>

        <div class="qr-text">
            <small>SCAN QR</small>
            <p>Identifikasi anggota perpustakaan.</p>
            <b>AHWALUNA</b>
        </div>
    </div>

    <div class="footer-card">
        <div>
            <small>ILMU • ADAB • AMAL</small>
            <p>Berlaku selama anggota aktif</p>
        </div>

        <i data-lucide="shield-check"
           style="width:28px;height:28px;color:#d4af37;"></i>
    </div>

</div>

<script>
function downloadCard() {
    const card = document.getElementById('memberCard');

    html2canvas(card, {
        scale: 4,
        backgroundColor: null,
        useCORS: true
    }).then(canvas => {
        const link = document.createElement('a');
        link.download = 'kartu-anggota-{{ $member->member_code }}.png';
        link.href = canvas.toDataURL('image/png');
        link.click();
    });
}
</script>
