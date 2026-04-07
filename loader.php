<?php /* loader.php — PSA Intro Loader. Include at the top of <body> in any page. */ ?>

<!-- ===== INTRO LOADER ===== -->
<div id="psa-loader" style="
  position:fixed; inset:0; z-index:9999;
  background:linear-gradient(160deg,#060f22 0%,#0c0c0c 60%,#130505 100%);
  display:flex; flex-direction:column;
  align-items:center; justify-content:center;
  overflow:hidden; font-family:'Barlow','Segoe UI',sans-serif;
  transition:opacity 0.6s ease, visibility 0.6s ease;
">

  <!-- Subtle grid -->
  <div style="position:absolute;inset:0;opacity:0.04;
    background-image:linear-gradient(rgba(255,255,255,.6) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.6) 1px,transparent 1px);
    background-size:40px 40px;pointer-events:none;"></div>

  <!-- Glow -->
  <div id="ldr-glow" style="position:absolute;width:380px;height:380px;border-radius:50%;
    background:radial-gradient(circle,rgba(20,60,180,0.22) 0%,transparent 68%);
    animation:ldrPulse 2.8s ease-in-out infinite;pointer-events:none;"></div>

  <!-- Orbit rings -->
  <div style="position:absolute;width:240px;height:240px;border-radius:50%;
    border:1px solid transparent;border-top-color:rgba(30,80,210,.55);
    border-right-color:rgba(30,80,210,.12);animation:ldrSpin 4s linear infinite;pointer-events:none;"></div>
  <div style="position:absolute;width:320px;height:320px;border-radius:50%;
    border:1px solid transparent;border-bottom-color:rgba(200,30,30,.45);
    border-left-color:rgba(200,30,30,.1);animation:ldrSpin 7s linear infinite reverse;pointer-events:none;"></div>
  <div style="position:absolute;width:410px;height:410px;border-radius:50%;
    border:1px solid transparent;border-top-color:rgba(245,200,20,.2);
    border-right-color:rgba(245,200,20,.05);animation:ldrSpin 12s linear infinite;pointer-events:none;"></div>

  <!-- Particles -->
  <div id="ldr-particles" style="position:absolute;inset:0;pointer-events:none;"></div>

  <!-- PSA Logo -->
  <div style="position:relative;z-index:10;animation:ldrFloat 3.2s ease-in-out infinite;">
    <div style="
      width:150px;height:150px;border-radius:50%;background:#fff;overflow:hidden;
      display:flex;align-items:center;justify-content:center;
      box-shadow:0 0 0 4px rgba(255,255,255,0.15),0 0 48px rgba(30,80,210,0.5);
      animation:ldrPop .75s cubic-bezier(.34,1.56,.64,1) both;
      animation-delay:.15s;opacity:0;
    ">
      <img src="images/logo_(2).png" alt="PSA Logo"
           style="width:142px;height:142px;object-fit:contain;border-radius:50%;" />
    </div>
  </div>

  <!-- Text -->
  <div style="position:relative;z-index:10;display:flex;flex-direction:column;align-items:center;gap:5px;margin-top:22px;">
    <div style="width:60px;height:2px;background:linear-gradient(90deg,#1e50d2,#facc15,#cc2222);
      border-radius:99px;animation:ldrFadeIn .4s ease both;animation-delay:.85s;opacity:0;"></div>
    <div style="font-family:'Oswald','Impact',sans-serif;color:#fff;font-size:1.4rem;font-weight:700;
      letter-spacing:.2em;text-transform:uppercase;
      animation:ldrFadeUp .55s ease both;animation-delay:.75s;opacity:0;">PSA Davao Del Sur</div>
    <div style="color:rgba(255,255,255,.45);font-size:.68rem;font-weight:600;
      letter-spacing:.28em;text-transform:uppercase;
      animation:ldrFadeUp .55s ease both;animation-delay:.92s;opacity:0;">Queue Management System</div>
  </div>

  <!-- Progress bar -->
  <div style="position:absolute;bottom:50px;width:220px;height:3px;
    background:rgba(255,255,255,.09);border-radius:99px;overflow:hidden;
    animation:ldrFadeIn .4s ease both;animation-delay:1.1s;opacity:0;">
    <div style="height:100%;width:0%;border-radius:99px;
      background:linear-gradient(90deg,#1e50d2,#facc15,#cc2222);
      animation:ldrFill 2.5s ease-in-out both;animation-delay:1.1s;"></div>
  </div>
  <div style="position:absolute;bottom:30px;color:rgba(255,255,255,.28);font-size:.58rem;
    letter-spacing:.25em;text-transform:uppercase;
    animation:ldrFadeIn .4s ease both;animation-delay:1.1s;opacity:0;">Loading, please wait…</div>

</div>

<style>
  @keyframes ldrPulse  { 0%,100%{transform:scale(.9);opacity:.55} 50%{transform:scale(1.1);opacity:1} }
  @keyframes ldrSpin   { to{transform:rotate(360deg)} }
  @keyframes ldrFloat  { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-10px)} }
  @keyframes ldrPop    { from{transform:scale(.3);opacity:0} to{transform:scale(1);opacity:1} }
  @keyframes ldrFadeUp { from{transform:translateY(12px);opacity:0} to{transform:translateY(0);opacity:1} }
  @keyframes ldrFadeIn { to{opacity:1} }
  @keyframes ldrFill   { from{width:0%} to{width:100%} }
  @keyframes ldrDotRise {
    0%  {transform:translateY(0) scale(1);opacity:0}
    10% {opacity:1} 90%{opacity:.4}
    100%{transform:translateY(-100vh) scale(.2);opacity:0}
  }
</style>

<script>
  (function() {
    // Spawn floating particles
    var colors = ['#1e50d2','#cc2222','#facc15','#ffffff'];
    var container = document.getElementById('ldr-particles');
    colors.forEach(function(col) {
      for (var i = 0; i < 6; i++) {
        var d = document.createElement('div');
        var s = Math.random() * 4 + 2;
        d.style.cssText = 'position:absolute;border-radius:50%;'
          + 'width:' + s + 'px;height:' + s + 'px;'
          + 'background:' + col + ';'
          + 'left:' + (Math.random() * 100) + '%;'
          + 'bottom:' + (Math.random() * 18) + '%;'
          + 'animation:ldrDotRise ' + (3 + Math.random() * 4) + 's linear ' + (Math.random() * 3) + 's infinite;'
          + 'opacity:0;';
        container.appendChild(d);
      }
    });

    // Hide loader after 3.2s (progress bar finishes at ~3.6s, fade out early)
    window.addEventListener('load', function() {
      setTimeout(function() {
        var loader = document.getElementById('psa-loader');
        loader.style.opacity = '0';
        loader.style.visibility = 'hidden';
        setTimeout(function() { loader.remove(); }, 650);
      }, 3200);
    });
  })();
</script>
<!-- ===== END INTRO LOADER ===== -->