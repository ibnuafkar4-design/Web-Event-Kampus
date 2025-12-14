let allEvents = [];

document.addEventListener("DOMContentLoaded", () => {

  fetch("gets_events.php")
    .then(res => res.json())
    .then(data => {
      allEvents = data;
      renderEvents(allEvents);
    });

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

function renderEvents(events) {
  const eventScroll = document.getElementById("eventScroll");
  eventScroll.innerHTML = "";

  if (events.length === 0) {
    eventScroll.innerHTML = "<p class='text-light'>Event tidak ditemukan</p>";
    return;
  }

  events.forEach(event => {
    const card = document.createElement("div");
    card.className = "event-card";
    card.setAttribute("data-bs-toggle", "modal");
    card.setAttribute("data-bs-target", "#detailModal");

    card.innerHTML = `
      <img src="uploads/${event.gambar}">
      <div class="event-info">
        <h5>${event.judul}</h5>
        <p>${event.tanggal}</p>
      </div>
    `;

    card.onclick = () => {
      document.getElementById("detailTitle").innerText = event.judul;
      document.getElementById("detailImg").src = "uploads/" + event.gambar;
      document.getElementById("detailDate").innerText = event.tanggal;
      document.getElementById("detailTime").innerText = event.waktu;
      document.getElementById("detailPlace").innerText = event.tempat;
      document.getElementById("detailDesc").innerText = event.deskripsi;
    };

    eventScroll.appendChild(card);
  });
}
