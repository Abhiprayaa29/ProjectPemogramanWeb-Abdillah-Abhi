<audio id="bgMusic" loop>
        <source src="assets/audio/Discover Indonesia_ Yogyakarta in Cinematic 4K  Culture, Temples & Nature.mp3" type="audio/mp3">
    </audio>

    <button id="musicBtn" onclick="toggleMusic()" class="btn btn-primary rounded-circle p-3 shadow-lg position-fixed bottom-0 end-0 m-4 z-3 d-flex align-items-center justify-content-center border-2 border-white" style="width: 60px; height: 60px;">
        <i id="musicIcon" class="bi bi-music-note-beamed fs-4"></i>
    </button>

    <footer class="bg-dark text-white pt-5 mt-5 border-top border-secondary">
        <div class="container text-center pb-4">
            <p class="text-white-50 small mb-0">&copy; <?php echo date("Y"); ?> <strong>JogjaLensa</strong>. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // --- 1. PAGE TRANSITION LOGIC (PENTING UNTUK SMOOTH) ---
        
        // Saat halaman selesai dimuat (Fade In)
        window.addEventListener("load", function() {
            // Hilangkan Loader
            const loader = document.getElementById('page-loader');
            if(loader) {
                loader.style.opacity = '0';
                setTimeout(() => { loader.style.display = 'none'; }, 500);
            }
            // Munculkan Body
            document.body.classList.add('loaded');
        });

        // Saat Link diklik (Fade Out dulu, baru pindah)
        document.querySelectorAll('a').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                // Cek apakah link internal (pindah halaman dalam website)
                // Abaikan jika target="_blank" atau link hash (#)
                if (this.hostname === window.location.hostname && this.getAttribute('target') !== '_blank' && this.getAttribute('href').indexOf('#') === -1) {
                    e.preventDefault(); // Tahan perpindahan halaman
                    
                    const targetUrl = this.href;

                    // Jalankan animasi Fade Out
                    document.body.classList.remove('loaded'); // Body jadi opacity 0 lagi

                    // Tunggu 500ms (sesuai durasi CSS transition), baru pindah
                    setTimeout(() => {
                        window.location.href = targetUrl;
                    }, 500);
                }
            });
        });


        // --- 2. LOGIC MUSIK PINTAR (RESUME PLAYBACK) ---
        var audio = document.getElementById("bgMusic");
        var btn = document.getElementById("musicBtn");
        var icon = document.getElementById("musicIcon");

        function saveMusicState() {
            localStorage.setItem("musicTime", audio.currentTime);
            localStorage.setItem("musicStatus", audio.paused ? "paused" : "playing");
        }

        window.addEventListener("load", function() {
            var savedTime = localStorage.getItem("musicTime");
            var savedStatus = localStorage.getItem("musicStatus");

            if (savedTime) audio.currentTime = parseFloat(savedTime);

            if (savedStatus === "playing") {
                audio.volume = 0.5; 
                var playPromise = audio.play();
                if (playPromise !== undefined) {
                    playPromise.then(_ => { updateIconToPause(); }).catch(error => { updateIconToPlay(); });
                }
            } else {
                updateIconToPlay();
            }
        });

        audio.addEventListener("timeupdate", saveMusicState);
        audio.addEventListener("play", saveMusicState);
        audio.addEventListener("pause", saveMusicState);

        function toggleMusic() {
            if (audio.paused) {
                audio.play();
                updateIconToPause();
            } else {
                audio.pause();
                updateIconToPlay();
            }
        }

        function updateIconToPause() {
            icon.classList.remove("bi-music-note-beamed");
            icon.classList.add("bi-pause-fill");
            btn.classList.remove("btn-primary");
            btn.classList.add("btn-danger");
            btn.classList.add("pulse-animation"); // Efek berdenyut
        }

        function updateIconToPlay() {
            icon.classList.remove("bi-pause-fill");
            icon.classList.add("bi-music-note-beamed");
            btn.classList.remove("btn-danger");
            btn.classList.add("btn-primary");
            btn.classList.remove("pulse-animation");
        }

        // Script Modal Booking
        function openBooking(packageName, price) {
            var modalTitle = document.getElementById('modalPackageName');
            var modalPrice = document.getElementById('modalPrice');
            var modalEl = document.getElementById('bookingModal');
            if (modalTitle && modalPrice && modalEl) {
                modalTitle.innerText = packageName;
                modalPrice.innerText = "Rp " + new Intl.NumberFormat('id-ID').format(price);
                var myModal = new bootstrap.Modal(modalEl);
                myModal.show();
            }
        }
    </script>

    <style>
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7); }
            70% { box-shadow: 0 0 0 15px rgba(220, 53, 69, 0); }
            100% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0); }
        }
        .pulse-animation {
            animation: pulse 2s infinite;
        }
    </style>
</body>
</html>