// Ambil event dari localStorage
let events = JSON.parse(localStorage.getItem("events")) || [];

//event yang selalu ada walau kosong di admin
if (events.length === 0) {
  events = [
    {
      title: "Konser Musik Mahasiswa",
      date: "25 Nov 2025",
      time: "19.00 WIB",
      place: "Lapangan Polibatam",
      desc: "Nikmati malam penuh hiburan musik dari band-band kampus terbaik!",
      img: "https://th.bing.com/th/id/OIP.PucBNbA6tKXcc2rbEonrrQHaKf?w=208&h=295&c=7&r=0&o=7&dpr=1.3&pid=1.7&rm=3",
      daftar: true,
    },
  ];
  localStorage.setItem("events", JSON.stringify(events));
}

// user ecek ecek
const currentUser = localStorage.getItem("currentUser");

function save() {
  localStorage.setItem("events", JSON.stringify(events));
}

// Buat nampilin event ke halaman
function render(list = events) {
  carouselInner.innerHTML = "";
  eventScroll.innerHTML = "";
  //Looping card dan carousel
  list.forEach((event, i) => {
    // Carousel nya
    carouselInner.innerHTML += `
      <div class="carousel-item${i === 0 ? " active" : ""}">
        <img src="${event.img}" class="d-block w-100" alt="${event.title}">
        <div class="carousel-caption">
          <h3>${event.title}</h3>
          <p>${event.date} • ${event.place}</p>
          <button class="btn btn-warning btn-sm" onclick="showDetail(${i})">
            <i class='fa fa-info-circle'></i> Detail
          </button>
        </div>
      </div>`;
    // Card event di halaman
    eventScroll.innerHTML += `
      <div class="event-card" onclick="showDetail(${i})">
        <img src="${event.img}" alt="${event.title}">
        <div class="event-info">
          <strong>${event.title}</strong><br>
          <small>${event.date}</small>
        </div>
      </div>`;
  });
}

// Detail Event Modal
function showDetail(i) {
  const event = events[i];
  const modal = new bootstrap.Modal(document.getElementById("detailModal"));
  const btn = document.getElementById("btnDaftar");

  // Isi konten modal
  document.getElementById("detailImg").src = event.img;
  document.getElementById("detailTitle").innerText = event.title;
  document.getElementById("detailDate").innerText = event.date;
  document.getElementById("detailTime").innerText = event.time;
  document.getElementById("detailPlace").innerText = event.place;
  document.getElementById("detailDesc").innerText = event.desc;

  // Tombol daftar bakal tampil kalau event di set bisa daftar
  btn.style.display = event.daftar ? "inline-block" : "none";
  if (!event.daftar) return modal.show();

  const sudahDaftar = event.peserta.includes(currentUser);
  btn.innerHTML = sudahDaftar ? "Batal Daftar" : "Daftar Event";
  btn.className = sudahDaftar
    ? "btn btn-secondary mt-2"
    : "btn btn-custom mt-2";

  btn.onclick = () => {
    event.peserta = sudahDaftar
      ? event.peserta.filter((u) => u !== currentUser)
      : [...event.peserta, currentUser];
    save();
    render();
    modal.hide();
  };

  modal.show();
}

//Buat search event
document.addEventListener("DOMContentLoaded", () => {
  const bar = document.getElementById("searchBar");
  const btn = document.querySelector("button[type='submit']");
  btn.addEventListener("click", (e) => {
    e.preventDefault();
    const key = bar.value.trim().toLowerCase();
    const hasil = events.filter((ev) => ev.title.toLowerCase().includes(key));
    render(hasil.length ? hasil : events);
  });

  render();
});
