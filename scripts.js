// scripts.js
function startClock() {
  const el = document.getElementById('clock');
  function update() {
    const now = new Date();
    // show local time
    el.textContent = now.toLocaleTimeString();
  }
  update();
  setInterval(update, 1000);
}
document.addEventListener('DOMContentLoaded', startClock);