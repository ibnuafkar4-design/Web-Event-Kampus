let allEvents = [];

document.addEventListener("DOMContentLoaded", () => {

  fetch("gets_events.php")
    .then(res => res.json())
    .then(data => {
      console.log("DATA EVENT:", data);

      allEvents = data;

      renderEvents(allEvents);
      renderCarousel(allEvents);
    })
    .catch(err => console.error(err));

  const bar = document.getElementById("searchBar");
  const btn = document.getElementById("btnSearch");

  btn.addEventListener("click", (e) => {
    e.preventDefault();

    const key = bar.value.toLowerCase().trim();
    const filtered = allEvents.filter(ev =>
      ev.judul.toLowerCase().includes(key)
    );

    renderEvents(filtered);
  });
});


// ================= CARD =================
function renderEvents(events) {
  const eventScroll = document.getElementById("eventScroll");
  eventScroll.innerHTML = "";

  events.forEach(event => {
    const card = document.createElement("div");
    card.className = "event-card";
    card.setAttribute("data-bs-toggle", "modal");
    card.setAttribute("data-bs-target", "#detailModal");

    card.innerHTML = `
      <img src="upload/${event.gambar}">
      <div class="event-info">
        <h5>${event.judul}</h5>
        <p>${event.tanggal}</p>
      </div>
    `;

    card.onclick = () => fillModal(event);
    eventScroll.appendChild(card);
  });
}


// ================= CAROUSEL =================
function renderCarousel(events) {
  const carouselInner = document.getElementById("carouselInner");

  if (!carouselInner) {
    console.error("carouselInner tidak ditemukan");
    return;
  }

  carouselInner.innerHTML = "";

  events.slice(0, 3).forEach((event, index) => {
    const item = document.createElement("div");
    item.className = "carousel-item" + (index === 0 ? " active" : "");

    item.innerHTML = `
      <img src="upload/${event.gambar}" class="d-block w-100"
           style="height:450px;object-fit:cover;cursor:pointer">
      <div class="carousel-caption bg-dark bg-opacity-50 rounded">
        <h5>${event.judul}</h5>
        <p>${event.tanggal} • ${event.tempat}</p>
      </div>
    `;

    item.onclick = () => fillModal(event);
    carouselInner.appendChild(item);
  });
}


// ================= MODAL =================
function fillModal(event) {
  document.getElementById("detailTitle").innerText = event.judul;
  document.getElementById("detailImg").src = "upload/" + event.gambar;
  document.getElementById("detailDate").innerText = event.tanggal;
  document.getElementById("detailTime").innerText = event.waktu;
  document.getElementById("detailPlace").innerText = event.tempat;
  document.getElementById("detailDesc").innerText = event.deskripsi;
}
