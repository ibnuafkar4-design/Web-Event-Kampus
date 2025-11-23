let events = JSON.parse(localStorage.getItem("events"));
const table = document.getElementById("eventTable");
const form = document.getElementById("eventForm");
const eventModal = new bootstrap.Modal(document.getElementById("eventModal"));
const pesertaModal = new bootstrap.Modal(document.getElementById("pesertaModal"));
const listPeserta = document.getElementById("listPeserta");

// Render event ke tabel
function render() {
  table.innerHTML = "";
  //di dalam tabelnya
  events.forEach((event, i) => {
    table.innerHTML +=`
      <tr>
        <td>${event.title}</td>
        <td>${event.date}</td>
        <td>${event.time}</td>
        <td>${event.place}</td>
        <td>${event.daftar ? "Bisa" : "Tidak"}</td>
        <td>
          <img src="${
            event.img
          }" alt="img" width="80" height="60" style="object-fit:cover;border-radius:5px">
        </td>
        <td>
          <button class="btn btn-info btn-sm" onclick="lihatPeserta(${i})">Lihat (${event.peserta?.length || 0})</button>
        </td>
        <td>
          <button class="btn btn-warning btn-sm me-1" onclick="editEvent(${i})"><i class="fa fa-edit"></i>Edit</button>
          <button class="btn btn-danger btn-sm" onclick="hapusEvent(${i})"><i class="fa fa-trash"></i>Hapus</button>
        </td>
      </tr>`;
  });

  localStorage.setItem("events", JSON.stringify(events));
}

// Tambah/Edit event
form.addEventListener("submit", (tambah) => {
  tambah.preventDefault();
  const idx = document.getElementById("index").value;
  const fileInput = document.getElementById("imgFile");
  let imagePath = events[idx]?.img

  //input files
  if (fileInput.files && fileInput.files[0])
  {
    imagePath = URL.createObjectURL(fileInput.files[0]);
  }
  //untuk tambah event
  const newEvent = {
    title: document.getElementById("title").value,
    date: document.getElementById("date").value,
    time: document.getElementById("time").value,
    place: document.getElementById("place").value,
    desc: document.getElementById("desc").value,
    img: imagePath,
    daftar: document.getElementById("daftar"),
    peserta: events[idx]?.peserta || [],
  };

  if (idx === "") events.push(newEvent);
  else events[idx] = newEvent;

  localStorage.setItem("events", JSON.stringify(events));
  form.reset();
  document.getElementById("index").value = "";
  eventModal.hide();
  render();
});

// Edit event
function editEvent(i) {
  const e = events[i];
  document.getElementById("index").value = i;
  document.getElementById("title").value = e.title;
  document.getElementById("date").value = e.date;
  document.getElementById("time").value = e.time;
  document.getElementById("place").value = e.place;
  document.getElementById("desc").value = e.desc;
  document.getElementById("daftar").value = e.daftar ? "true" : "false";
  eventModal.show();
}

// Hapus event
function hapusEvent(i) {
  if (confirm("Yakin mau hapus event ini?")) {
    events.splice(i, 1);
    localStorage.setItem("events", JSON.stringify(events));
    render();
  }
}

// Lihat peserta
function lihatPeserta(i) {
  const ev = events[i];
  listPeserta.innerHTML = "";
  if (!ev.peserta || ev.peserta.length === 0) {
    listPeserta.innerHTML = `<li class="list-group-item bg-dark text-muted text-center">Belum ada peserta</li>`;
  } else {
    ev.peserta.forEach((p, idx) => {
      listPeserta.innerHTML += `
        <li class="list-group-item bg-dark text-light d-flex justify-content-between align-items-center">
          ${idx + 1}. ${p}
          <button class="btn btn-outline-danger" onclick="hapusPeserta(${i}, ${idx})">Hapus<i class="fa fa-times"></i></button>
        </li>`;
    });
  }
  pesertaModal.show();
}

// Hapus peserta
function hapusPeserta(eventIdx, pesertaIdx) {
  events[eventIdx].peserta.splice(pesertaIdx, 1);
  localStorage.setItem("events", JSON.stringify(events));
  lihatPeserta(eventIdx);
}

// Tombol tambah event
document.getElementById("btnAdd").addEventListener("click", () => {
  form.reset();
  document.getElementById("index").value = "";
  eventModal.show();
});

// Render Event nya
render();
