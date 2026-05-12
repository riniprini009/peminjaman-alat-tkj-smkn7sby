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

                                <!-- 🔵 KIRI -->
                                <div>
                                    <div>
                                        <i class="bi bi-box-seam me-2"></i>
                                        <strong>Alat Dipesan</strong>
                                    </div>

                                    <div class="small mt-1">
                                        Batas Pengembalian:
                                        <strong>
                                            {{ \Carbon\Carbon::parse($peminjaman->tanggal_selesai . ' ' . $peminjaman->jam_selesai)->translatedFormat('d F Y H:i') }}
                                        </strong>
                                    </div>
                                </div>

                                <!-- 🟢 KANAN (CENTER VERTIKAL OTOMATIS) -->
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
                                                <small
                                                    class="text-muted">{{ ucwords($detail->jenisAlat->nama_jenis) }}</small>
                                            </div>
                                            <span class="qty-badge">x{{ $detail->pivot->quantity }}</span>
                                        </div>

                                        <!-- KODE ALAT (DARI DB / RELASI DETAIL ALAT) -->
                                        <div class="code-box mt-2">
                                            <span class="label">Kode Alat</span>
                                            <div class="codes">
                                            </div>
                                        </div>

                                        <!-- STATUS -->
                                        <div class="status-bar mt-3 alat-checkpoint" data-tipe="{{ $detail->nama_tipe }}">
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
    <form id="form-pinjam" method="POST" action="{{ route('peminjamanDetail.store', $peminjaman->id_pinjam) }}">
        @csrf
        {{-- <input type="hidden" name="id_pinjam" value="{{ $peminjaman->id_pinjam }}"> --}}
        <input type="hidden" name="alat" id="alat">

        <button type="button" class="btn btn-success fixed-confirm-btn" id="btn-konfirmasi">
            <i class="bi bi-check-lg"></i> Konfirmasi
        </button>
    </form>
@endsection

@push('scripts')
    <script src="{{ asset('js/html5-qrcode.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let alatData = @json($allAlat->keyBy('kode_alat'));
        let daftarPeminjaman = @json($peminjaman->tipeAlat);
        let successSoundPath = "{{ asset('sounds/success.mp3') }}";
    </script>
    <script src="{{ asset('js/scanPinjam.js') }}"></script>
    <script>
        
        // let scanner;
        // let scanAktif = false;
        // let lastScan = null;
        // let scanLock = false;

        // let successSound = new Audio("{{ asset('sounds/success.mp3') }}");
        // successSound.load();

        // // ambil kode dari URL /scan/T1-006
        // // let kodeAlat = window.location.pathname.split('/').pop();
        // let kodeAlat = new URLSearchParams(window.location.search).get('kode');
        // if (kodeAlat) {
        //     setTimeout(() => {

        //         successSound.currentTime = 0;
        //         successSound.play().catch(() => {});

        //         setTimeout(() => {
        //             addAlat(kodeAlat);
        //         }, 10);

        //     }, 500);
        // }

        // $(document).ready(function() {

        //     updateProgress();

        //     scanner = new Html5Qrcode("reader");

        //     startScanner();

        // });

        // function onScanSuccess(decodedText) {

        //     if (scanLock) return;

        //     // if (lastScan === decodedText) return;

        //     scanLock = true;

        //     // lastScan = decodedText;

        //     let kodeAlat = decodedText.split('/').pop();

        //     successSound.currentTime = 0;

        //     successSound.play().catch(() => {});

        //     addAlat(kodeAlat);

        //     setTimeout(function() {

        //         scanLock = false;

        //         // lastScan = null;

        //     }, 1500);
        // }

        // function startScanner() {

        //     scanner.start({
        //             facingMode: "environment"
        //         }, {
        //             fps: 15,
        //             qrbox: function(w, h) {

        //                 let size = Math.min(w, h) * 0.80;

        //                 return {
        //                     width: size,
        //                     height: size
        //                 };
        //             }
        //         },
        //         onScanSuccess
        //     ).then(function() {

        //         scanAktif = true;

        //         $("#btnScan")
        //             .html('<i class="bi bi-camera-video-fill"></i> Stop Scan')
        //             .removeClass("btn-success")
        //             .addClass("btn-danger");

        //     }).catch(function(err) {

        //         console.error(err);

        //     });
        // }

        // function toggleScanner() {

        //     if (scanAktif) {

        //         scanner.stop().then(function() {

        //             scanAktif = false;

        //             $("#btnScan")
        //                 .html('<i class="bi bi-camera-video-off-fill"></i> Mulai Scan')
        //                 .removeClass("btn-danger")
        //                 .addClass("btn-success");

        //         });

        //     } else {

        //         startScanner();

        //     }
        // }

        // function renderKode(tipe, kodeAlat) {

        //     let container = $('.alat-checkpoint[data-tipe="' + tipe + '"]')
        //         .closest('.inventory-item')
        //         .find('.codes');

        //     container.append(`
        //         <span class="code">
        //             ${kodeAlat}
        //             <i class="bi bi-trash-fill code-trash"></i>
        //         </span>
        //     `);
        // }

        // let dataScan = {};

        // let batasTipe = {};

        // daftarPeminjaman.forEach(function(item) {

        //     let tipe = item.nama_tipe.toLowerCase().trim();

        //     batasTipe[tipe] = item.pivot.quantity;

        // });

        // function addAlat(kodeAlat) {

        //     let dataAlat = alatData[kodeAlat];

        //     if (!dataAlat) {

        //         toastr.error("Alat tidak ditemukan");

        //         return;
        //     }

        //     let tipeAlatScan = dataAlat.tipe_alat.nama_tipe.toLowerCase().trim();

        //     let tipeSesuai = false;

        //     daftarPeminjaman.forEach(function(item) {

        //         let tipePeminjaman = item.nama_tipe.toLowerCase().trim();

        //         if (tipePeminjaman === tipeAlatScan) {

        //             tipeSesuai = true;
        //         }
        //     });

        //     if (!tipeSesuai) {

        //         Swal.fire({
        //             icon: 'warning',
        //             title: 'Peringatan',
        //             text: 'Tidak sesuai tipe yang dipinjam'
        //         });

        //         return;
        //     }

        //     if (dataAlat.status_alat === "tidak tersedia") {

        //         Swal.fire({
        //             icon: 'warning',
        //             title: 'Peringatan',
        //             text: 'Alat sedang tidak tersedia'
        //         });

        //         return;
        //     }

        //     if (dataAlat.kondisi_alat !== "baik") {

        //         Swal.fire({
        //             icon: 'warning',
        //             title: 'Peringatan',
        //             text: 'Alat rusak / tidak dalam kondisi baik'
        //         });

        //         return;
        //     }

        //     let jumlah = dataScan[tipeAlatScan] ?
        //         dataScan[tipeAlatScan].length :
        //         0;

        //     let max = batasTipe[tipeAlatScan] || 0;

        //     if (jumlah >= max) {
        //         Swal.fire({
        //             icon: 'warning',
        //             title: 'Peringatan',
        //             text: 'Jumlah alat untuk tipe ini sudah penuh'
        //         });
        //         // toastr.warning('Jumlah alat untuk tipe ini sudah penuh');

        //         return;
        //     }

        //     if (!dataScan[tipeAlatScan]) {

        //         dataScan[tipeAlatScan] = [];
        //     }

        //     if (dataScan[tipeAlatScan].includes(kodeAlat)) return;

        //     dataScan[tipeAlatScan].push(kodeAlat);

        //     renderKode(tipeAlatScan, kodeAlat);

        //     renderChecklist(tipeAlatScan);

        //     updateProgress();
        // }

        // $('#add-manual').on('click', function() {

        //     let kodeAlat = $('#input-manual').val().trim();

        //     if (kodeAlat === '') {

        //         toastr.warning('Masukkan kode alat');

        //         return;
        //     }

        //     addAlat(kodeAlat);

        //     $('#input-manual').val('');
        // });

        // $('#input-manual').on('keypress', function(e) {

        //     if (e.key === 'Enter') {

        //         e.preventDefault();

        //         $('#add-manual').click();
        //     }
        // });

        // $(document).on('click', '.code-trash', function() {

        //     let codeElement = $(this).closest('.code');

        //     let kodeAlat = codeElement
        //         .clone()
        //         .children()
        //         .remove()
        //         .end()
        //         .text()
        //         .trim();

        //     let tipe = codeElement
        //         .closest('.inventory-item')
        //         .find('.alat-checkpoint')
        //         .data('tipe')
        //         .toLowerCase()
        //         .trim();

        //     codeElement.remove();

        //     if (dataScan[tipe]) {

        //         dataScan[tipe] = dataScan[tipe].filter(function(k) {

        //             return k !== kodeAlat;

        //         });
        //     }

        //     renderChecklist(tipe);

        //     updateProgress();
        // });

        // function renderChecklist(tipe) {

        //     let container = $('.alat-checkpoint[data-tipe="' + tipe + '"]');

        //     let dots = container.find('.scan-check');

        //     let count = (dataScan[tipe] || []).length;

        //     dots
        //         .removeClass('text-success')
        //         .addClass('text-secondary');

        //     dots.each(function(index) {

        //         if (index < count) {

        //             $(this)
        //                 .removeClass('text-secondary')
        //                 .addClass('text-success');
        //         }
        //     });
        // }

        // function updateProgress() {

        //     let total = 0;

        //     let sudah = 0;

        //     daftarPeminjaman.forEach(function(item) {

        //         total += item.pivot.quantity;

        //         let tipe = item.nama_tipe.toLowerCase().trim();

        //         if (dataScan[tipe]) {

        //             sudah += dataScan[tipe].length;
        //         }
        //     });

        //     let el = $("#progressScan");

        //     el.css("fontWeight", "bold");

        //     if (sudah >= total) {

        //         el
        //             .text(sudah + " / " + total + " [Lengkap]")
        //             .removeClass("text-danger")
        //             .addClass("text-success");

        //     } else {

        //         el
        //             .text(sudah + " / " + total + " [Tidak lengkap]")
        //             .removeClass("text-success")
        //             .addClass("text-danger");
        //     }
        // }

        // function submitPinjam() {

        //     let semuaAlat = [];

        //     for (let tipe in dataScan) {

        //         semuaAlat = semuaAlat.concat(dataScan[tipe]);
        //     }

        //     semuaAlat = [...new Set(semuaAlat)];

        //     let totalPinjam = 0;

        //     daftarPeminjaman.forEach(function(item) {

        //         totalPinjam += item.pivot.quantity;

        //     });

        //     if (semuaAlat.length < totalPinjam) {

        //         Swal.fire({
        //             icon: 'warning',
        //             title: 'Belum lengkap',
        //             text: 'Scan semua alat terlebih dahulu'
        //         });

        //         return;
        //     }

        //     $('#alat').val(semuaAlat.join(','));

        //     $('#form-pinjam').submit();
        // }

        // $('#btn-konfirmasi').on('click', function() {
        //     submitPinjam();
        // });
    </script>
    {{-- <script>
        let scanner;
        let scanAktif = false;
        let lastScan = null;
        let scanLock = false;
        let successSound = new Audio("{{ asset('sounds/success.mp3') }}");
        successSound.load();
        let kodeAlat = window.location.pathname.split('/').pop();

        if (kodeAlat) {
            setTimeout(() => {
                successSound.currentTime = 0;
                successSound.play().catch(() => {});

                setTimeout(() => {
                    addAlat(kodeAlat);
                }, 10);

            }, 500);
        }
        // let kodeAlat = new URLSearchParams(window.location.search).get('kode');

        // if (kodeAlat) {
        //     setTimeout(() => {
        //         successSound.currentTime = 0;
        //         successSound.play().catch(() => {});
        //         setTimeout(() => {
        //             addAlat(kodeAlat);
        //         }, 10); // 🔥 kasih jeda kecil biar audio mulai dulu

        //     }, 500);
        // }


        // document.addEventListener("DOMContentLoaded", function() {
        //     updateProgress();
        //     scanner = new Html5Qrcode("reader");
        //     startScanner();
        // });
        $(document).ready(function() {
            updateProgress();
            scanner = new Html5Qrcode("reader");
            startScanner();
        });

        function onScanSuccess(decodedText) {

            if (scanLock) return;

            if (lastScan === decodedText) return;

            scanLock = true;
            lastScan = decodedText;

            let kodeAlat = decodedText.split('/').pop();
            successSound.currentTime = 0;
            successSound.play().catch(() => {});
            addAlat(kodeAlat);

            setTimeout(() => {
                scanLock = false;
                lastScan = null;
            }, 1500);

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

        function renderKode(tipe, kodeAlat) {

            let container = $('.alat-checkpoint[data-tipe="' + tipe + '"]')
                .closest('.inventory-item')
                .find('.codes');

            container.append(`
        <span class="code">
            ${kodeAlat}
            <i class="bi bi-trash-fill code-trash"></i>
        </span>
    `);
        }
        let dataScan = {};
        let batasTipe = {};
        daftarPeminjaman.forEach(item => {
            let tipe = item.nama_tipe.toLowerCase().trim();
            batasTipe[tipe] = item.pivot.quantity;
        });

        function addAlat(kodeAlat) {

            let dataAlat = alatData[kodeAlat];

            if (!dataAlat) {
                toastr.error("Alat tidak ditemukan");
                return;
            }

            let tipeAlatScan = dataAlat.tipe_alat.nama_tipe.toLowerCase().trim();

            let tipeSesuai = false;

            daftarPeminjaman.forEach(item => {
                let tipePeminjaman = item.nama_tipe.toLowerCase().trim();

                if (tipePeminjaman === tipeAlatScan) {
                    tipeSesuai = true;
                }
            });

            if (!tipeSesuai) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Tidak sesuai tipe yang dipinjam'
                });
                return;
            }

            if (dataAlat.status_alat === "tidak tersedia") {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Alat sedang tidak tersedia'
                });
                return;
            }

            if (dataAlat.kondisi_alat !== "baik") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Alat rusak / tidak dalam kondisi baik'
                });
                return;
            }
            // 🔥 TAMBAHAN LIMIT (INI SAJA YANG BARU)
            let jumlah = dataScan[tipeAlatScan] ? dataScan[tipeAlatScan].length : 0;
            let max = batasTipe[tipeAlatScan] || 0;

            if (jumlah >= max) {

                toastr.warning('Jumlah alat untuk tipe ini sudah penuh');
                return;
            }

            // simpan data scan
            if (!dataScan[tipeAlatScan]) {
                dataScan[tipeAlatScan] = [];
            }

            if (dataScan[tipeAlatScan].includes(kodeAlat)) return;

            dataScan[tipeAlatScan].push(kodeAlat);

            renderKode(tipeAlatScan, kodeAlat);
            renderChecklist(tipeAlatScan);
            updateProgress();
        }

        document.getElementById('add-manual').addEventListener('click', function() {

            let kodeAlat = document.getElementById('input-manual').value
                .trim();

            if (kodeAlat === '') {
                toastr.warning('Masukkan kode alat');
                return;
            }

            addAlat(kodeAlat); // pakai logic scan yang sama

            document.getElementById('input-manual').value = '';
        });

        document.getElementById('input-manual').addEventListener('keypress', function(e) {

            if (e.key === 'Enter') {
                e.preventDefault();
                document.getElementById('add-manual').click();
            }

        });

        // function updateChecklist(tipe) {

        //     let container = $('.alat-checkpoint[data-tipe="' + tipe + '"]');

        //     // ambil 1 dot pertama yang masih abu-abu
        //     let nextDot = container.find('.scan-check.text-secondary').first();

        //     if (nextDot.length === 0) return; // semua sudah hijau

        //     nextDot
        //         .removeClass('text-secondary')
        //         .addClass('text-success');
        // }


        $(document).on('click', '.code-trash', function() {

            let codeElement = $(this).closest('.code');
            let kodeAlat = codeElement.clone().children().remove().end().text().trim();

            let tipe = codeElement.closest('.inventory-item')
                .find('.alat-checkpoint')
                .data('tipe')
                .toLowerCase()
                .trim();

            // hapus UI
            codeElement.remove();

            // hapus dari state
            if (dataScan[tipe]) {
                dataScan[tipe] = dataScan[tipe].filter(k => k !== kodeAlat);
            }

            // refresh checklist
            renderChecklist(tipe);
            updateProgress();
        });

        function renderChecklist(tipe) {

            let container = $('.alat-checkpoint[data-tipe="' + tipe + '"]');

            let dots = container.find('.scan-check');
            let count = (dataScan[tipe] || []).length;

            // reset dulu semua
            dots.removeClass('text-success').addClass('text-secondary');

            // isi ulang sesuai data
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

                let tipe = item.nama_tipe.toLowerCase().trim();

                if (dataScan[tipe]) {
                    sudah += dataScan[tipe].length;
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

        function submitPinjam() {

            let semuaAlat = [];

            for (let tipe in dataScan) {
                semuaAlat = semuaAlat.concat(dataScan[tipe]);
            }

            semuaAlat = [...new Set(semuaAlat)];
            let totalPinjam = 0;

            daftarPeminjaman.forEach(item => {
                totalPinjam += item.pivot.quantity;
            });

            if (semuaAlat.length < totalPinjam) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Belum lengkap',
                    text: 'Scan semua alat terlebih dahulu'
                });
                return;
            }

            // tanpa JSON.stringify
            document.getElementById('alat').value = semuaAlat.join(',');

            document.getElementById('form-pinjam').submit();
        }
    </script> --}}
@endpush
