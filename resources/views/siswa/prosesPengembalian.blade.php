@extends('layouts.siswa')
@section('title', 'Scan & Input Alat')
@section('link')
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" /> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/universal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/add.css') }}">
    <link rel="stylesheet" href="{{ asset('css/button.css') }}">
@endsection
@section('content')
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><i class="fa-solid fa-house"></i>
                                    <a href="index.html">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="index.html">Peminjaman</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="index.html">Proses Pengembalian</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Scan QR Code
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="row g-4 justify-content-center" style="margin-top: 20px;">
                <div class="col-lg-5">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-primary text-white">
                            <i class="bi bi-qr-code-scan me-2"></i> Scan QR / Input Kode
                        </div>
                        <div class="card-body p-3">

                            <div id="reader" class="mb-2 scanner-box"></div>

                            <div class="scan-control mb-2">
                                <button type="button" id="btnScan" onclick="toggleScanner()" class="btn-scan-toggle">

                                    Stop Scan
                                </button>
                            </div>

                            <div class="input-group manual-group mt-3 mb-2">
                                <input type="text" id="input-manual" class="form-control"
                                    placeholder="Masukkan kode alat">

                                <button class="btn btn-universal" id="add-manual">
                                    <i class="bi bi-plus-lg"></i>
                                    Tambah
                                </button>
                            </div>

                            <small class="scan-note">
                                Scan QR atau input manual
                            </small>

                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="card inventory-card shadow-sm border-0">
                        <div class="card-header inventory-header text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="bi bi-tools me-2"></i>
                                    <strong>Alat Dipinjam</strong>
                                </div>
                                <span class="badge bg-light" id="progressScan">
                                    0 / 0
                                </span>
                            </div>
                        </div>

                        <div class="card-body inventory-scroll p-3">

                            <div id="peminjaman-checkpoint">

                                @foreach ($peminjaman->tipeAlat as $detail)
                                    <div class="inventory-item">

                                        <!-- TOP -->
                                        <div class="item-top">
                                            <div>
                                                <h6 class="mb-0">{{ ucwords($detail->nama_tipe) }}</h6>
                                                <small class="text-muted">
                                                    {{ ucwords($detail->jenisAlat->nama_jenis) }}
                                                </small>
                                            </div>

                                            <span class="qty-badge">
                                                x{{ $detail->pivot->quantity }}
                                            </span>
                                        </div>

                                        <!-- KODE ALAT (FIXED) -->
                                        <div class="code-box mt-2">
                                            <span class="label">Kode Alat</span>

                                            <div class="codes">
                                                @foreach ($peminjaman->detailAlat->where('id_tipe', $detail->id_tipe) as $alat)
                                                    <span class="code py-1 px-2">
                                                        {{ $alat->kode_alat }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="status-bar mt-3 alat-checkpoint" data-id-tipe="{{ $detail->id_tipe }}">
                                            @for ($i = 0; $i < $detail->pivot->quantity; $i++)
                                                <i class="bi bi-check-circle-fill scan-check text-secondary"></i>
                                            @endfor
                                            {{-- <small class="status-text">Progress scan</small> --}}
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form id="form-pinjam" method="POST" action="{{ route('prosesPengembalian.scan', $peminjaman->id_pinjam) }}">
        @csrf
        @method('PUT')
        {{-- <input type="hidden" name="id_pinjam" value="{{ $peminjaman->id_pinjam }}"> --}}
        <input type="hidden" name="alat" id="alat">

        <button type="button" class="btn btn-success fixed-confirm-btn" id="btn-konfirmasi" onclick="submitPinjam()">
           <i class="fa fa-thumbs-up mr-1"></i> Konfirmasi
        </button>
    </form>
@endsection

@push('scripts')
    <script src="{{ asset('js/html5-qrcode.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let daftarKodePeminjaman = @json($peminjaman->detailAlat->pluck('kode_alat'));
        let daftarPeminjaman = @json($peminjaman->tipeAlat);
    </script>
    <script>
        let scanner;
        let scanAktif = false;
        let scanLock = false;
        let dataScan = {};
        let successSound = new Audio("{{ asset('sounds/success.mp3') }}");
        successSound.load();
        $(document).ready(function() {
            updateProgress();
            scanner = new Html5Qrcode("reader");
            startScanner();
        });

        function onScanSuccess(decodedText) {

            if (scanLock) return;
            scanLock = true;

            let kodeAlat = decodedText.split('/').pop();

            successSound.currentTime = 0;
            successSound.play().catch(() => {});

            if (!daftarKodePeminjaman.includes(kodeAlat)) {

                Swal.fire({
                    icon: 'error',
                    title: 'Kode Tidak Valid',
                    text: 'Kode alat ini tidak ada di peminjaman'
                });

                setTimeout(function() {
                    scanLock = false;
                }, 1200);

                return;
            }

            highlightKode(kodeAlat);

            let idTipe = null;

            // 🔥 ganti querySelectorAll → jQuery
            $('.code').each(function() {

                if ($(this).text().trim() === kodeAlat) {

                    idTipe = $(this)
                        .closest('.inventory-item')
                        .find('.alat-checkpoint')
                        .data('idTipe');
                }
            });

            if (idTipe) {

                if (!dataScan[idTipe]) {
                    dataScan[idTipe] = [];
                }

                if (!dataScan[idTipe].includes(kodeAlat)) {
                    dataScan[idTipe].push(kodeAlat);
                }

                renderChecklist(idTipe);
                updateProgress();
            }

            setTimeout(function() {
                scanLock = false;
            }, 1500);
        }
        // function onScanSuccess(decodedText) {

        //     if (scanLock) return;
        //     scanLock = true;

        //     let kodeAlat = decodedText.split('/').pop();
        //     successSound.currentTime = 0;
        //     successSound.play().catch(() => {});

        //     if (!daftarKodePeminjaman.includes(kodeAlat)) {

        //         Swal.fire({
        //             icon: 'error',
        //             title: 'Kode Tidak Valid',
        //             text: 'Kode alat ini tidak ada di peminjaman'
        //         });

        //         setTimeout(() => {
        //             scanLock = false;
        //         }, 1200);

        //         return;
        //     }

        //     highlightKode(kodeAlat);

        //     let idTipe = null;

        //     document.querySelectorAll('.code').forEach(el => {
        //         if (el.innerText.trim() === kodeAlat) {
        //             idTipe = el.closest('.inventory-item')
        //                 .querySelector('.alat-checkpoint')
        //                 .dataset.idTipe;
        //         }
        //     });

        //     if (idTipe) {



        //         if (!dataScan[idTipe]) {
        //             dataScan[idTipe] = [];
        //         }

        //         if (!dataScan[idTipe].includes(kodeAlat)) {
        //             dataScan[idTipe].push(kodeAlat);
        //         }

        //         renderChecklist(idTipe);
        //         updateProgress();
        //     }

        //     setTimeout(() => {
        //         scanLock = false;
        //     }, 1500);
        // }

        // function highlightKode(kode) {

        //     document.querySelectorAll('.code').forEach(el => {

        //         if (el.innerText.trim() === kode) {

        //             el.style.background = "#d1fae5"; // hijau pastel
        //             el.style.border = "1px solid #10b981";
        //             el.style.transition = "0.3s ease";

        //         }
        //     });
        // }

        function highlightKode(kode) {

            $('.code').each(function() {

                if ($(this).text().trim() === kode) {

                    $(this).css({
                        "background": "#d1fae5",
                        "border": "1px solid #10b981",
                        "transition": "0.3s ease"
                    });

                }
            });
        }

        function startScanner() {
            scanner.start({
                    facingMode: "environment"
                }, {
                    fps: 15,
                    qrbox: function(w, h) {
                        let size = Math.min(w, h) * 0.80;
                        return {
                            width: size,
                            height: size
                        };
                    }
                },
                onScanSuccess
            ).catch(function(err) {
                console.error(err);
            });

            scanAktif = true;

            document.getElementById("btnScan").innerHTML = '<i class="bi bi-camera-video-fill"></i> Stop Scan';
            document.getElementById("btnScan").classList.remove("btn-success");
            document.getElementById("btnScan").classList.add("btn-danger");
        }


        function toggleScanner() {
            if (scanAktif) {
                scanner.stop().then(function() {
                    scanAktif = false;
                    document.getElementById("btnScan").innerHTML =
                        '<i class="bi bi-camera-video-off-fill"></i> Mulai Scan';
                    document.getElementById("btnScan").classList.remove("btn-danger");
                    document.getElementById("btnScan").classList.add("btn-success");
                });
            } else {
                startScanner();
            }
        }

        function renderChecklist(idTipe) {

            let container = $('.alat-checkpoint[data-id-tipe="' + idTipe + '"]');

            let dots = container.find('.scan-check');

            let count = dataScan[idTipe] ? dataScan[idTipe].length : 0;

            dots.removeClass('text-success').addClass('text-secondary');

            dots.each(function(index) {
                if (index < count) {
                    $(this).addClass('text-success');
                }
            });
        }

        function updateProgress() {

            let total = 0;
            let sudah = 0;

            daftarPeminjaman.forEach(item => {

                total += item.pivot.quantity;

                let idTipe = item.id_tipe; // 👈 PAKAI ID, bukan nama

                if (dataScan[idTipe]) {
                    sudah += dataScan[idTipe].length;
                }
            });

            let el = document.getElementById("progressScan");
            el.style.fontWeight = "bold";

            if (sudah >= total) {
                el.innerText = sudah + " / " + total + " [Lengkap]";
                el.classList.remove("text-danger");
                el.classList.add("text-success");
            } else {
                el.innerText = sudah + " / " + total + " [Tidak lengkap]";
                el.classList.remove("text-success");
                el.classList.add("text-danger");
            }
        }

        document.getElementById('add-manual').addEventListener('click', function() {

            let kodeAlat = document.getElementById('input-manual').value.trim();

            if (kodeAlat === '') {
                toastr.warning('Masukkan kode alat');
                return;
            }

            if (!daftarKodePeminjaman.includes(kodeAlat)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Kode Tidak Valid',
                    text: 'Kode alat ini tidak ada di peminjaman'
                });
                return;
            }

            highlightKode(kodeAlat);

            let idTipe = null;

            document.querySelectorAll('.code').forEach(el => {
                if (el.innerText.trim() === kodeAlat) {
                    idTipe = el.closest('.inventory-item')
                        .querySelector('.alat-checkpoint')
                        .dataset.idTipe;
                }
            });

            if (idTipe) {

                if (!dataScan[idTipe]) {
                    dataScan[idTipe] = [];
                }

                if (!dataScan[idTipe].includes(kodeAlat)) {
                    dataScan[idTipe].push(kodeAlat);
                }

                renderChecklist(idTipe);
                updateProgress();
            }

            document.getElementById('input-manual').value = '';
        });

        document.getElementById('input-manual').addEventListener('keypress', function(e) {

            if (e.key === 'Enter') {
                e.preventDefault();
                document.getElementById('add-manual').click();
            }

        });

        // function submitPinjam() {

        //     let total = 0;
        //     let sudah = 0;

        //     daftarPeminjaman.forEach(item => {
        //         total += item.pivot.quantity;

        //         let idTipe = item.id_tipe;

        //         if (dataScan[idTipe]) {
        //             sudah += dataScan[idTipe].length;
        //         }
        //     });

        //     // ❌ belum lengkap → stop
        //     if (sudah < total) {
        //         Swal.fire({
        //             icon: 'warning',
        //             title: 'Belum Lengkap',
        //             text: `Masih ${total - sudah} alat belum discan`
        //         });
        //         return;
        //     }

        //     // ✅ sudah lengkap → langsung kirim
        //     document.getElementById('alat').value = JSON.stringify(dataScan);
        //     document.getElementById('form-pinjam').submit();
        // }

        function submitPinjam() {

            let total = 0;
            let sudah = 0;

            daftarPeminjaman.forEach(item => {
                total += item.pivot.quantity;

                let idTipe = item.id_tipe;

                if (dataScan[idTipe]) {
                    sudah += dataScan[idTipe].length;
                }
            });

            // ❗ kalau belum lengkap, TAMPILKAN KONFIRMASI
            if (sudah < total) {

                Swal.fire({
                    icon: 'warning',
                    title: 'Belum Lengkap',
                    html: `Kurang <b>${total - sudah}</b> alat belum discan.<br><br>
                   Apakah tetap ingin melanjutkan?`,
                    showCancelButton: true,
                    confirmButtonText: 'Tetap Kirim',
                    cancelButtonText: 'Batal'
                }).then((result) => {

                    if (result.isConfirmed) {
                        kirimData();
                    }

                });

                return;
            }

            // kalau sudah lengkap langsung submit
            kirimData();
        }

        function kirimData() {
            document.getElementById('alat').value = JSON.stringify(dataScan);
            document.getElementById('form-pinjam').submit();
        }
    </script>
@endpush
