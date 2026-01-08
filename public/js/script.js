

document.addEventListener("DOMContentLoaded", function () {

    // ================== SIDEBAR ==================
    const menuBtn = document.getElementById('menuBtn');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');

    if (menuBtn && sidebar && overlay) {
        menuBtn.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });
    }


    // ================== FORM BOOKING ==================
    const jamMulai = document.getElementById('jam_mulai');
    const jamSelesai = document.getElementById('jam_selesai');
    const durasiInput = document.getElementById('durasi');
    const tarifAwalInput = document.getElementById('tarif_awal'); // FIXED
    const kodeDiskonInput = document.getElementById('kode_diskon');
    const couponNotif = document.getElementById('couponNotif');
    const tarifAkhirInput = document.getElementById('tarif_akhir'); // FIXED (tarif akhir)
    const formBooking = document.getElementById("formBooking");
    const btnSubmit = document.getElementById("btnSubmit");
    const confirmModal = document.getElementById("confirmModal");
    const confirmBox = document.getElementById("confirmBox");
    const btnCancelModal = document.getElementById("btnCancelModal");
    const btnConfirmModal = document.getElementById("btnConfirmModal");
    const btnBatal = document.getElementById("btnBatal");
    const btnBatalAdmin = document.getElementById("btnBatalAdmin");
    const lapanganSelect = document.getElementById('lapangan');

    let tarifPerJam = 0;

    // Buat pilihan jam selesai otomatis setelah pilih jam mulai
    function updateJamSelesai() {
        if (!jamSelesai) return;
        jamSelesai.innerHTML = '<option value="">-- Pilih Jam Selesai --</option>';
        if (jamMulai && jamMulai.value) {
            const startHour = parseInt(jamMulai.value.split(':')[0]);
            for (let h = startHour + 1; h <= 23; h++) {
                const jam = (h < 10 ? '0' : '') + h + ':00';
                let opt = document.createElement('option');
                opt.value = jam;
                opt.textContent = jam;
                jamSelesai.appendChild(opt);
            }
        }
        hitungDurasi();
    }

    // Kalkulasi durasi & tarif
    function hitungDurasi() {
        if (jamMulai && jamSelesai && jamMulai.value && jamSelesai.value && tarifPerJam > 0) {
            const mulai = parseInt(jamMulai.value.split(':')[0]);
            const selesai = parseInt(jamSelesai.value.split(':')[0]);
            const durasi = selesai - mulai;
            if (durasi > 0) {
                const total = durasi * tarifPerJam;
                durasiInput.value = durasi + ' jam';

                // Simpan Tarif Awal
                tarifAwalInput.value = 'Rp ' + total.toLocaleString('id-ID'); // FIXED

                // Default Tarif Akhir = Tarif Awal
                tarifAkhirInput.value = 'Rp ' + total.toLocaleString('id-ID'); // FIXED
            } else {
                durasiInput.value = '';
                tarifAwalInput.value = '';
                tarifAkhirInput.value = '';
            }
        }
    }

    // Event listener kode diskon
    if (kodeDiskonInput) {
        kodeDiskonInput.addEventListener("input", () => {
            const kode = kodeDiskonInput.value.trim().toUpperCase();

            // reset notif
            couponNotif.classList.add("hidden");
            couponNotif.classList.remove("text-green-600", "text-red-600");

            if (!tarifAwalInput.value) return;

            const tarifAwal = parseInt(tarifAwalInput.value.replace(/[^0-9]/g, '')) || 0;
            let tarifAkhir = tarifAwal;

            // cari diskon sesuai kode
            const diskon = diskons.find(d => d.kode.toUpperCase() === kode);

            if (diskon) {
                if (diskon.tipe === "persentase") {
                    tarifAkhir = tarifAwal - (tarifAwal * diskon.nilai / 100);
                    couponNotif.textContent = `✅ Diskon ${diskon.nilai}% berhasil diterapkan!`;
                } else {
                    tarifAkhir = tarifAwal - diskon.nilai;
                    couponNotif.textContent = `✅ Diskon Rp ${diskon.nilai.toLocaleString('id-ID')} berhasil diterapkan!`;
                }
                couponNotif.classList.add("text-green-600");
                couponNotif.classList.remove("hidden");
            } else if (kode.length >= 3) {
                couponNotif.textContent = "❌ Kode diskon tidak valid.";
                couponNotif.classList.add("text-red-600");
                couponNotif.classList.remove("hidden");
            }

            tarifAkhirInput.value = 'Rp ' + tarifAkhir.toLocaleString('id-ID');
        });
    }




    // Event: pilih lapangan → ambil tarif/jam
    if (lapanganSelect) {
        lapanganSelect.addEventListener('change', () => {
            const selected = lapanganSelect.options[lapanganSelect.selectedIndex];
            tarifPerJam = parseInt(selected.dataset.tarif) || 0;
            hitungDurasi();
        });
    }

    if (jamMulai) jamMulai.addEventListener('change', updateJamSelesai);
    if (jamSelesai) jamSelesai.addEventListener('change', hitungDurasi);

    // ================== CONFIRM MODAL ==================
    if (btnSubmit && confirmModal && confirmBox) {
        btnSubmit.addEventListener("click", (e) => {
            e.preventDefault();
            confirmModal.classList.remove("hidden");
            setTimeout(() => {
                confirmBox.classList.remove("scale-95", "opacity-0");
                confirmBox.classList.add("scale-100", "opacity-100");
            }, 50);
        });
    }

    if (btnConfirmModal && formBooking) {
        btnConfirmModal.addEventListener("click", function () {
            formBooking.submit();
        });
    }

    if (btnCancelModal && confirmModal && confirmBox) {
        btnCancelModal.addEventListener("click", () => {
            confirmBox.classList.add("scale-95", "opacity-0");
            confirmBox.classList.remove("scale-100", "opacity-100");
            setTimeout(() => confirmModal.classList.add("hidden"), 300);
        });
    }

    if (btnBatal) {
        btnBatal.addEventListener("click", () => window.location.href = "/member");
    }

    if (btnBatalAdmin) {
        btnBatal.addEventListener("click", () => window.location.href = "/admin");
    }

    // ================== SHOW/HIDE PASSWORD ==================
    function setupTogglePassword(inputId, buttonId) {
        const input = document.getElementById(inputId);
        const button = document.getElementById(buttonId);

        if (input && button) {
            button.addEventListener("click", () => {
                const isPassword = input.getAttribute("type") === "password";
                input.setAttribute("type", isPassword ? "text" : "password");
                button.textContent = isPassword ? "Hide" : "Show";
            });
        }
    }

    setupTogglePassword("password", "togglePassword");
    setupTogglePassword("password_confirmation", "togglePasswordConfirmation");
});
