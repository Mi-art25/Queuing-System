<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Queue Admin</title>
  <link href="../resources/output.css" rel="stylesheet">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap');
    body { font-family: 'Inter', sans-serif; }
    .panel-reg  { background: linear-gradient(160deg, #2a5fd4 0%, #1a3a9e 100%); }
    .panel-pri  { background: linear-gradient(160deg, #b02828 0%, #6e1212 100%); }
    .box-reg    { background: rgba(10, 25, 100, 0.55); }
    .box-pri    { background: rgba(80, 10, 10, 0.55); }
    .reset-reg  { background: #1a3a9e; }
    .reset-pri  { background: #6e1212; }
    .btn-next-reg { background: rgba(255,255,255,0.92); color: #1a1a1a; }
    .btn-next-reg:hover { background: #fff; }
    .btn-next-pri { background: rgba(255,255,255,0.92); color: #1a1a1a; }
    .btn-next-pri:hover { background: #fff; }
    .btn-reset  { background: rgba(255,255,255,0.92); color: #1a1a1a; }
    .btn-reset:hover { background: #fff; }
    input[type=number] { background: rgba(255,255,255,0.12); color: #fff; }
    input[type=number]::placeholder { color: rgba(255,255,255,0.4); }
    input[type=number]::-webkit-inner-spin-button { opacity: 0; }
    .bg-scene {
      background-image: url('images/bg.jpg');
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
    }
  </style>
</head>
<body class="text-white min-h-screen">

  <?php include 'loader.php'; ?>

  <!-- Background -->
  <div class="bg-scene fixed inset-0" style="z-index:0"></div>
  <div class="fixed inset-0" style="z-index:1; background:rgba(0,0,0,0.4)"></div>

  <!-- Top Bar -->
  <div class="fixed top-0 left-0 right-0" style="z-index:40; display:flex; align-items:center; justify-content:space-between; padding:12px 2rem;">
    <img src="images/logo_(2).png" alt="PSA Logo" style="height:65px; filter:drop-shadow(0 2px 10px rgba(0,0,0,0.9));" />
    <a href="display.php" target="_blank" style="display:inline-flex; align-items:center; gap:8px; background:rgba(255,255,255,0.15); border:1px solid rgba(255,255,255,0.3); color:#fff; font-family:Inter,sans-serif; font-weight:700; font-size:0.8rem; letter-spacing:0.12em; text-transform:uppercase; text-decoration:none; padding:10px 20px; border-radius:999px; backdrop-filter:blur(8px);" onmouseover="this.style.background='rgba(255,255,255,0.25)'" onmouseout="this.style.background='rgba(255,255,255,0.15)'">
      <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
      Open Display
    </a>
  </div>

  <!-- Character Left -->
  <div class="fixed bottom-0 left-0 pointer-events-none" style="z-index:30">
    <img src="images/char-left.png" alt="" style="display:block; height:22vh; min-height:140px; max-height:220px;" />
  </div>

  <!-- Character Right -->
  <div class="fixed bottom-0 right-0 pointer-events-none" style="z-index:30">
    <img src="images/amba4.png" alt="" style="display:block; height:22vh; min-height:140px; max-height:220px;" />
  </div>

  <div class="relative" style="z-index:2; min-height:100vh; display:flex; align-items:center; justify-content:center; padding: 90px 2rem 2rem;">

  <div class="grid grid-cols-2 gap-4 max-w-5xl mx-auto">

    <!-- ===== REGULAR LANE ===== -->
    <div class="space-y-3">

      <!-- Main Panel -->
      <div class="panel-reg rounded-2xl overflow-hidden p-4 space-y-4">

        <!-- Header -->
        <div class="flex items-center justify-between">
          <span class="text-white/70 text-xs font-bold tracking-[0.18em] uppercase">Regular Lane</span>
          <span class="bg-white/20 text-white text-xs font-bold px-3 py-1 rounded-full tracking-wide">Student/Regular</span>
        </div>

        <!-- Serving + Stats -->
        <div class="flex gap-3 items-stretch">
          <!-- Big Number -->
          <div class="flex-1 flex flex-col justify-center">
            <span class="text-white/60 text-xs font-bold tracking-[0.18em] uppercase mb-1">Serving</span>
            <div id="reg-current" class="text-[5.5rem] font-black text-white leading-none">—</div>
          </div>
          <!-- UP NEXT + IN QUEUE stacked -->
          <div class="flex flex-col gap-3 w-[170px]">
            <div class="box-reg rounded-xl p-3 flex-1 flex flex-col justify-center">
              <span class="text-white/60 text-[0.6rem] font-bold tracking-[0.18em] uppercase mb-1">Up Next</span>
              <div id="reg-next" class="text-4xl font-black text-white text-center">—</div>
            </div>
            <div class="box-reg rounded-xl p-3 flex-1 flex flex-col justify-center">
              <span class="text-white/60 text-[0.6rem] font-bold tracking-[0.18em] uppercase mb-1">In Queue</span>
              <div id="reg-count" class="text-4xl font-black text-white text-center">0</div>
            </div>
          </div>
        </div>

        <!-- Buttons -->
        <div class="grid grid-cols-2 gap-3">
          <button onclick="doAction('next','regular')"
                  class="btn-next-reg rounded-full py-3 font-bold text-sm flex items-center justify-center gap-2 transition-all active:scale-95">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 5l7 7-7 7M5 5l7 7-7 7"/></svg>
            NEXT
          </button>
          <button onclick="doAction('skip','regular')"
                  class="btn-next-reg rounded-full py-3 font-bold text-sm flex items-center justify-center gap-2 transition-all active:scale-95">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
            SKIP
          </button>
        </div>

        <!-- Pending / Served -->
        <div class="space-y-1 text-xs">
          <div>
            <span class="text-white/50 font-bold tracking-[0.18em] uppercase">Pending</span>
            <div id="reg-pending" class="text-white/80 mt-0.5 flex flex-wrap gap-1">
              <span class="text-white/40">Loading...</span>
            </div>
          </div>
          <div>
            <span class="text-white/50 font-bold tracking-[0.18em] uppercase">Served</span>
            <div id="reg-catered" class="text-white/80 mt-0.5 flex flex-wrap gap-1">
              <span class="text-white/40">None yet</span>
            </div>
          </div>
        </div>

      </div>

      <!-- Reset Box -->
      <div class="reset-reg border border-white/10 rounded-2xl p-4 space-y-3">
        <span class="text-white/50 text-xs font-bold tracking-[0.18em] uppercase">Reset Priority Queue</span>
        <div class="flex gap-2 items-center">
          <div class="flex-1">
            <label class="text-white/40 text-[0.65rem] uppercase tracking-widest block mb-1">Start</label>
            <input id="reg-start" type="number" value="1" placeholder="1"
                   class="w-full rounded-xl px-3 py-2 text-sm border border-white/20 focus:outline-none focus:border-white/50"/>
          </div>
          <div class="flex-1">
            <label class="text-white/40 text-[0.65rem] uppercase tracking-widest block mb-1">End</label>
            <input id="reg-end" type="number" value="100" placeholder="100"
                   class="w-full rounded-xl px-3 py-2 text-sm border border-white/20 focus:outline-none focus:border-white/50"/>
          </div>
          <button onclick="doReset('regular')"
                  class="btn-reset rounded-full px-4 py-2 font-bold text-xs flex items-center gap-1.5 transition-all active:scale-95 mt-4">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
            RESET
          </button>
        </div>
      </div>

    </div>

    <!-- ===== PRIORITY LANE ===== -->
    <div class="space-y-3">

      <!-- Main Panel -->
      <div class="panel-pri rounded-2xl overflow-hidden p-4 space-y-4">

        <!-- Header -->
        <div class="flex items-center justify-between">
          <span class="text-white/70 text-xs font-bold tracking-[0.18em] uppercase">Priority Lane</span>
          <span class="bg-white/20 text-white text-xs font-bold px-3 py-1 rounded-full tracking-wide">Senior/PWD/Pregnant</span>
        </div>

        <!-- Serving + Stats -->
        <div class="flex gap-3 items-stretch">
          <div class="flex-1 flex flex-col justify-center">
            <span class="text-white/60 text-xs font-bold tracking-[0.18em] uppercase mb-1">Serving</span>
            <div id="pri-current" class="text-[5.5rem] font-black text-white leading-none">—</div>
          </div>
          <div class="flex flex-col gap-3 w-[170px]">
            <div class="box-pri rounded-xl p-3 flex-1 flex flex-col justify-center">
              <span class="text-white/60 text-[0.6rem] font-bold tracking-[0.18em] uppercase mb-1">Up Next</span>
              <div id="pri-next" class="text-4xl font-black text-white text-center">—</div>
            </div>
            <div class="box-pri rounded-xl p-3 flex-1 flex flex-col justify-center">
              <span class="text-white/60 text-[0.6rem] font-bold tracking-[0.18em] uppercase mb-1">In Queue</span>
              <div id="pri-count" class="text-4xl font-black text-white text-center">0</div>
            </div>
          </div>
        </div>

        <!-- Buttons -->
        <div class="grid grid-cols-2 gap-3">
          <button onclick="doAction('next','priority')"
                  class="btn-next-pri rounded-full py-3 font-bold text-sm flex items-center justify-center gap-2 transition-all active:scale-95">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 5l7 7-7 7M5 5l7 7-7 7"/></svg>
            NEXT
          </button>
          <button onclick="doAction('skip','priority')"
                  class="btn-next-pri rounded-full py-3 font-bold text-sm flex items-center justify-center gap-2 transition-all active:scale-95">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
            SKIP
          </button>
        </div>

        <!-- Pending / Served -->
        <div class="space-y-1 text-xs">
          <div>
            <span class="text-white/50 font-bold tracking-[0.18em] uppercase">Pending</span>
            <div id="pri-pending" class="text-white/80 mt-0.5 flex flex-wrap gap-1">
              <span class="text-white/40">Loading...</span>
            </div>
          </div>
          <div>
            <span class="text-white/50 font-bold tracking-[0.18em] uppercase">Served</span>
            <div id="pri-catered" class="text-white/80 mt-0.5 flex flex-wrap gap-1">
              <span class="text-white/40">None yet</span>
            </div>
          </div>
        </div>

      </div>

      <!-- Reset Box -->
      <div class="reset-pri border border-white/10 rounded-2xl p-4 space-y-3">
        <span class="text-white/50 text-xs font-bold tracking-[0.18em] uppercase">Reset Priority Queue</span>
        <div class="flex gap-2 items-center">
          <div class="flex-1">
            <label class="text-white/40 text-[0.65rem] uppercase tracking-widest block mb-1">Start</label>
            <input id="pri-start" type="number" value="1" placeholder="1"
                   class="w-full rounded-xl px-3 py-2 text-sm border border-white/20 focus:outline-none focus:border-white/50"/>
          </div>
          <div class="flex-1">
            <label class="text-white/40 text-[0.65rem] uppercase tracking-widest block mb-1">End</label>
            <input id="pri-end" type="number" value="100" placeholder="100"
                   class="w-full rounded-xl px-3 py-2 text-sm border border-white/20 focus:outline-none focus:border-white/50"/>
          </div>
          <button onclick="doReset('priority')"
                  class="btn-reset rounded-full px-4 py-2 font-bold text-xs flex items-center gap-1.5 transition-all active:scale-95 mt-4">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
            RESET
          </button>
        </div>
      </div>

    </div>

  </div>

  <!-- Toast -->
  <div id="toast" class="fixed bottom-6 right-6 bg-gray-800 border border-gray-600 rounded-xl px-5 py-3 text-sm font-medium shadow-xl opacity-0 transition-opacity duration-300 pointer-events-none"></div>

  <script>
    const API = 'api.php';
    let lastState = {};

    function showToast(msg, color = 'text-white') {
      const t = document.getElementById('toast');
      t.textContent = msg;
      t.className = `fixed bottom-6 right-6 bg-gray-800 border border-gray-600 rounded-xl px-5 py-3 text-sm font-medium shadow-xl transition-opacity duration-300 ${color}`;
      t.style.opacity = '1';
      setTimeout(() => t.style.opacity = '0', 2500);
    }

    function setIfChanged(id, value) {
      const el = document.getElementById(id);
      if (!el) return;
      const str = value != null ? String(value) : '—';
      if (el.textContent !== str) el.textContent = str;
    }

    function renderQueue(prefix, data) {
      setIfChanged(`${prefix}-current`, data.current);
      setIfChanged(`${prefix}-next`, data.next);
      setIfChanged(`${prefix}-count`, data.pending_count ?? 0);

      const newPending = JSON.stringify(data.pending);
      if (lastState[`${prefix}_p`] !== newPending) {
        lastState[`${prefix}_p`] = newPending;
        const el = document.getElementById(`${prefix}-pending`);
        el.innerHTML = data.pending?.length
          ? data.pending.map(n => `<span class="bg-white/10 rounded px-1.5 py-0.5 text-white/80 font-bold">${n}</span>`).join('')
          : '<span class="text-white/30">Empty</span>';
      }

      const newCatered = JSON.stringify(data.catered);
      if (lastState[`${prefix}_c`] !== newCatered) {
        lastState[`${prefix}_c`] = newCatered;
        const el = document.getElementById(`${prefix}-catered`);
        el.innerHTML = data.catered?.length
          ? [...data.catered].reverse().map(n => `<span class="bg-white/10 rounded px-1.5 py-0.5 text-white/60 font-bold">${n}</span>`).join('')
          : '<span class="text-white/30">None yet</span>';
      }
    }

    async function fetchStatus() {
      try {
        const res = await fetch(`${API}?action=status&_=${Date.now()}`);
        const data = await res.json();
        renderQueue('reg', data.regular);
        renderQueue('pri', data.priority);
      } catch(e) { console.error(e); }
    }

    async function doAction(action, type) {
      try {
        const res = await fetch(`${API}?action=${action}&type=${type}`);
        const data = await res.json();
        if (data.error) { showToast('⚠️ ' + data.error, 'text-red-400'); return; }
        const prefix = type === 'priority' ? 'pri' : 'reg';
        renderQueue(prefix, data);
        const label = type === 'priority' ? '🟡 Priority' : '🔵 Regular';
        showToast(action === 'next' ? `${label} → Now serving ${data.current}` : `${label} → Skipped to ${data.current}`, 'text-green-400');
      } catch(e) { showToast('❌ Request failed', 'text-red-400'); }
    }

    async function doReset(type) {
      const prefix = type === 'priority' ? 'pri' : 'reg';
      const start = parseInt(document.getElementById(`${prefix}-start`).value) || 1;
      const end   = parseInt(document.getElementById(`${prefix}-end`).value) || 100;
      if (!confirm(`Reset ${type} queue (${start}–${end})? This cannot be undone.`)) return;
      try {
        const res = await fetch(`${API}?action=reset&type=${type}`, {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: `start=${start}&end=${end}`
        });
        const data = await res.json();
        renderQueue(prefix, data);
        showToast(`🔄 ${type} queue reset (${start}–${end})`, 'text-blue-400');
      } catch(e) { showToast('❌ Reset failed', 'text-red-400'); }
    }

    fetchStatus();
    setInterval(fetchStatus, 2000);
  </script>

  </div>
</body>
</html>