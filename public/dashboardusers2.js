document.addEventListener("DOMContentLoaded", function () {

  fetch("gets_events.php")
    .then(response => response.json())
    .then(events => {
      const eventScroll = document.getElementById("eventScroll");

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
    });

});
