
document.addEventListener("DOMContentLoaded", function(){
  function norm(s){return s.trim().toLowerCase().replace(/[^a-z0-9]+/g,'-')}
  // collect section ids
  const sections = Array.from(document.querySelectorAll("section[id]")).map(s => ({id:s.id, el:s}));
  // find anchors that don't go anywhere or point to "#"
  const anchors = Array.from(document.querySelectorAll("a[href='#'], a[href=''], a[data-target]"));
  anchors.forEach(a=>{
    let target = a.getAttribute("data-target") || a.textContent || a.getAttribute("aria-label") || "";
    target = target.trim();
    if(!target) return;
    // try by id exact match
    if(document.getElementById(target)) { a.setAttribute("href","#"+target); return; }
    // try normalized match
    const n = norm(target);
    for(const s of sections){
      if(s.id.toLowerCase()===n || norm(s.id)===n || norm(s.el.textContent).includes(n) || norm(s.el.getAttribute("data-title")||"").includes(n)){
        a.setAttribute("href","#"+s.id);
        return;
      }
    }
    // fallback: if anchor has class 'inicio' -> link to top
    if(a.classList.contains("inicio") || /inicio|home/i.test(target)){
      a.setAttribute("href", location.pathname + "#" + (sections[0] ? sections[0].id : ""));
    }
  });

  // smooth scroll
  document.querySelectorAll('a[href^="#"]').forEach(a=>{
    a.addEventListener("click", function(e){
      const id = this.getAttribute("href").slice(1);
      if(!id) return;
      const dest = document.getElementById(id);
      if(dest){ e.preventDefault(); dest.scrollIntoView({behavior:"smooth",block:"start"}); history.replaceState(null,"", "#"+id); }
    });
  });
});
