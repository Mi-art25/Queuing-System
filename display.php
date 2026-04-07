<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Queue Display — PSA Davao Del Sur</title>
  <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;600;700&family=Barlow:wght@400;600;700;900&display=swap" rel="stylesheet">
  <link href="../resources/output.css" rel="stylesheet">
  <style>
    body { font-family: 'Barlow', sans-serif; margin: 0; }
    .font-oswald { font-family: 'Oswald', sans-serif; }

    .bg-scene {
      background-image: url('images/bg.jpg');
      background-size: cover;
      background-position: center;
    }
    .card-regular  { background: linear-gradient(155deg, #2a5fd4 0%, #122d75 100%); }
    .card-priority { background: linear-gradient(155deg, #c03030 0%, #6e1212 100%); }

    .pop { animation: numPop 0.35s ease; }
    @keyframes numPop {
      0%   { transform: scale(0.7); opacity: 0.3; }
      65%  { transform: scale(1.07); }
      100% { transform: scale(1);   opacity: 1; }
    }

    /* Layout */
    body, html { width: 100%; height: 100%; overflow: hidden; }

    .main-wrapper {
      position: relative;
      z-index: 20;
      width: 100%;
      height: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      padding-top: 60px; /* room for top bar */
      padding-bottom: 6px;
      box-sizing: border-box;
    }

    .content-box {
      width: 100%;
      max-width: 1200px;
      padding: 0 1rem;
      display: flex;
      flex-direction: column;
      gap: 6px;
      /* let it shrink to fit the available height */
      max-height: 100%;
    }

    /* Cards row takes remaining space */
    .cards-row {
      height: 42vh;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 6px;
      flex: 1 1 auto;
      min-height: 0;
    }

    .queue-card {
      border-radius: 14px;
      overflow: hidden;
      border: 2px solid rgba(255,255,255,0.2);
      box-shadow: 0 20px 60px rgba(0,0,0,0.5);
      display: flex;
      flex-direction: column;
      min-height: 0;
    }

    .card-header {
      padding: 8px 16px;
      border-bottom: 1px solid rgba(255,255,255,0.2);
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-shrink: 0;
    }

    .card-body {
      flex: 1 1 auto;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 4px;
      padding: 12px;
      position: relative;
      min-height: 0;
    }

    .now-serving-label {
      color: rgba(255,255,255,0.75);
      font-size: 0.65rem;
      font-weight: 700;
      letter-spacing: 0.22em;
      text-transform: uppercase;
    }

    .serving-number {
      font-family: 'Oswald', sans-serif;
      color: #fff;
      font-weight: 700;
      line-height: 1;
      text-align: center;
      font-size: clamp(7rem, 22vh, 18rem);
      filter: drop-shadow(0 2px 8px rgba(0,0,0,0.5));
    }

    .card-sublabel {
      position: absolute;
      bottom: 10px;
      left: 16px;
      color: rgba(255,255,255,0.7);
      font-size: 0.6rem;
      font-weight: 700;
      letter-spacing: 0.18em;
      text-transform: uppercase;
    }

    /* Info row */
    .info-row {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 6px;
      flex-shrink: 0;
    }

    .info-box {
      background: rgba(0,0,0,0.70);
      border-radius: 12px;
      backdrop-filter: blur(8px);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 22px 8px;
    }

    .info-label {
      color: rgba(255,255,255,0.45);
      font-size: 0.55rem;
      font-weight: 700;
      letter-spacing: 0.2em;
      text-transform: uppercase;
      margin-bottom: 4px;
    }

    .info-number {
      font-family: 'Oswald', sans-serif;
      color: #fff;
      font-weight: 700;
      line-height: 1;
      font-size: clamp(1.8rem, 3.5vw, 3rem);
    }

    .border-blue { border: 1px solid rgba(96,165,250,0.3); }
    .border-red  { border: 1px solid rgba(248,113,113,0.3); }
  </style>
</head>
<body>

  <?php include 'loader.php'; ?>

  <!-- Background -->
  <div class="bg-scene fixed inset-0" style="z-index:0"></div>
  <div class="fixed inset-0" style="z-index:1; background:rgba(0,0,0,0.4)"></div>

  <!-- Character Left -->
  <div class="fixed bottom-0 left-0 pointer-events-none" style="z-index:30">
    <img src="images/char-left.png" alt="" style="display:block; height:22vh; min-height:140px; max-height:220px;" />
  </div>

  <!-- Character Right -->
  <div class="fixed bottom-0 right-0 pointer-events-none" style="z-index:30">
    <img src="images/amba4.png" alt="" style="display:block; height:22vh; min-height:140px; max-height:220px;" />
  </div>

  <!-- Top Bar -->
  <div class="fixed top-0 left-0 right-0" style="z-index:40; display:flex; align-items:center; justify-content:space-between; padding:12px 2rem;">
    <img src="images/logo_(2).png" alt="PSA Logo" style="height:65px; filter:drop-shadow(0 2px 10px rgba(0,0,0,0.9));" />
    <div id="clock" class="font-oswald" style="color:#fff; letter-spacing:0.12em; font-size:1.2rem; filter:drop-shadow(0 2px 8px rgba(0,0,0,0.9));"></div>
  </div>

  <!-- Main Content -->
  <div class="main-wrapper">
    <div class="content-box">

      <!-- Queue Cards -->
      <div class="cards-row">

        <!-- Regular Card -->
        <div class="queue-card card-regular">
          <div class="card-header">
            <span class="font-oswald" style="color:#fff; font-weight:700; letter-spacing:0.16em; text-transform:uppercase; font-size:1.1rem;">Regular</span>
          </div>
          <div class="card-body">
            <span class="now-serving-label">Now Serving</span>
            <div id="reg-current" class="serving-number">—</div>
            <span class="card-sublabel">Student / Regular</span>
          </div>
        </div>

        <!-- Priority Card -->
        <div class="queue-card card-priority">
          <div class="card-header">
            <span class="font-oswald" style="color:#fff; font-weight:700; letter-spacing:0.16em; text-transform:uppercase; font-size:1.1rem;">Priority</span>
          </div>
          <div class="card-body">
            <span class="now-serving-label">Now Serving</span>
            <div id="pri-current" class="serving-number">—</div>
            <span class="card-sublabel">Senior / PWD / Pregnant</span>
          </div>
        </div>

      </div>

      <!-- Info Row -->
      <div class="info-row">
        <div class="info-box border-blue">
          <span class="info-label">Up Next</span>
          <div id="reg-next" class="info-number">—</div>
        </div>
        <div class="info-box border-blue">
          <span class="info-label">In Queue</span>
          <div id="reg-count" class="info-number">0</div>
        </div>
        <div class="info-box border-red">
          <span class="info-label">Up Next</span>
          <div id="pri-next" class="info-number">—</div>
        </div>
        <div class="info-box border-red">
          <span class="info-label">In Queue</span>
          <div id="pri-count" class="info-number">0</div>
        </div>
      </div>

    </div>
  </div>

  <script>
    const API = 'api.php';

    function updateClock() {
      const now = new Date();
      document.getElementById('clock').textContent =
        now.toLocaleTimeString('en-PH', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
    }
    setInterval(updateClock, 1000);
    updateClock();

    // ── Text-to-Speech (Female Voice) ───────────────────────────────
    let femaleVoice = null;

    // Pick the best available female English voice
    function pickFemaleVoice() {
      const voices = window.speechSynthesis.getVoices();
      if (!voices.length) return;

      // Priority list: known female voice names across browsers/OS
      const femaleKeywords = [
        'female', 'woman', 'girl',
        'samantha', 'victoria', 'karen', 'moira', 'fiona',
        'susan', 'zira', 'hazel', 'catherine', 'anna',
        'linda', 'kate', 'emily', 'tessa', 'nicky',
        'google us english', 'google uk english female',
        'microsoft zira', 'microsoft hazel', 'microsoft susan',
        'microsoft linda', 'microsoft kate'
      ];

      // Try exact/partial name match first
      for (const keyword of femaleKeywords) {
        const match = voices.find(v => v.name.toLowerCase().includes(keyword));
        if (match) { femaleVoice = match; return; }
      }

      // Fallback: any English voice (browsers often default to female)
      const enVoice = voices.find(v => v.lang.startsWith('en'));
      if (enVoice) femaleVoice = enVoice;
    }

    // Voices load async — listen for the event and also try immediately
    window.speechSynthesis.onvoiceschanged = pickFemaleVoice;
    pickFemaleVoice();

    // Unlock TTS on first user interaction (browser policy)
    let ttsReady = false;
    function unlockTTS() {
      if (ttsReady) return;
      const u = new SpeechSynthesisUtterance('');
      window.speechSynthesis.speak(u);
      ttsReady = true;
    }
    document.addEventListener('click',   unlockTTS, { once: true });
    document.addEventListener('keydown', unlockTTS, { once: true });
    setTimeout(() => unlockTTS(), 1000);

    // Queue so announcements never overlap
    const ttsQueue = [];
    let   ttsBusy  = false;

    function processTTSQueue() {
      if (ttsBusy || ttsQueue.length === 0) return;
      ttsBusy = true;
      const text = ttsQueue.shift();
      const u = new SpeechSynthesisUtterance(text);
      u.lang   = 'en-PH';
      u.rate   = 0.88;
      u.pitch  = 1.1;   // slightly higher pitch reinforces female quality
      u.volume = 1;
      if (femaleVoice) u.voice = femaleVoice;
      u.onend  = () => { ttsBusy = false; processTTSQueue(); };
      u.onerror= () => { ttsBusy = false; processTTSQueue(); };
      window.speechSynthesis.speak(u);
    }

    function announce(number, label) {
      if (number == null || number === '—') return;
      // Announce twice for clarity in a noisy environment
      const text = `Now serving number ${number}, ${number}, ${label}.`;
      ttsQueue.push(text);
      processTTSQueue();
    }
    // ────────────────────────────────────────────────────────────────

    // Track last served numbers to detect Next AND Skip changes
    const lastServed = { reg: null, pri: null };

    function animateValue(id, value) {
      const el = document.getElementById(id);
      if (!el) return;
      const display = value != null ? String(value) : '—';
      if (el.textContent === display) return;
      el.classList.remove('pop');
      void el.offsetWidth;
      el.textContent = display;
      el.classList.add('pop');
    }

    function renderQueue(prefix, data) {
      const current = data.current;
      const label   = prefix === 'reg' ? 'Regular' : 'Priority';

      // Trigger announcement whenever current number changes
      // (covers both Next and Skip actions from admin)
      if (current != null && String(current) !== String(lastServed[prefix])) {
        lastServed[prefix] = current;
        announce(current, label);
      }

      animateValue(`${prefix}-current`, current);
      animateValue(`${prefix}-next`,    data.next);
      animateValue(`${prefix}-count`,   data.pending_count ?? 0);
    }

    async function fetchStatus() {
      try {
        const res  = await fetch(`${API}?action=status&_=${Date.now()}`);
        const data = await res.json();
        renderQueue('reg', data.regular);
        renderQueue('pri', data.priority);
      } catch(e) { console.error('Failed to fetch status', e); }
    }

    fetchStatus();
    setInterval(fetchStatus, 2000);
  </script>

</body>
</html>