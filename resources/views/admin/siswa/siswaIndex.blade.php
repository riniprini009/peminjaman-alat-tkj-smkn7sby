@extends('layouts.admin')
@section('title', 'Data Siswa')
@section('link')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/universal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/filter.css') }}">
    <link rel="stylesheet" href="{{ asset('css/content.css') }}">
    <link rel="stylesheet" href="{{ asset('css/table.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/button.css') }}">
@endsection

@section('content')
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <h4>Data Siswa</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><i class="bx bx-home"></i>
                                    <a href="#">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="#">User</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Data Siswa
                                </li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-md-6 col-sm-12 text-right">
                        <a href="{{ route('siswa.add') }}">
                            <button class="btn btn-universal" type="button" title="Tambah">
                                <i class="fa fa-plus"></i>
                                Add New
                            </button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-box">
                <div class="toolbar-wrapper">
                    <div class="search-wrapper mb-2">
                        <i class="fa fa-search search-wrapper-icon"></i>
                        <input type="text" class="form-control search-box-wrapper" placeholder="Search..."
                            id="searchInput">
                        <button class="filter-btn" id="filterBtn" data-toggle="modal" data-target="#filterModal">
                            <i class="fa fa-sliders"></i>
                            <span class="filter-badge" id="filterBadge">0</span>
                        </button>
                    </div>
                    <div class="col-md-6 col-12 d-flex gap-2 flex-wrap justify-content-md-end m-0 p-0">
                        <button onclick="exportPdf()" type="button" class="btn-universal" title="Download">
                            <i class="fa fa-download"></i>
                            Export
                        </button>

                        <button type="button" class="btn-universal ml-3" data-toggle="modal"
                            data-target="#modal-import-data-siswa" title="Upload">
                            <i class="fa fa-upload"></i>
                            Import
                        </button>
                    </div>
                </div>
                <div id="show-entries" class="ml-0 mt-3"></div>
                <div class="pb-20">
                    <div class="table-responsive p-0 m-0">
                        <table class="data-table table hover multiple-select-row py-3 px-4 border-0"
                            style="background: #e9edf9b1 !important; border-radius: 22px;">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Siswa</th>
                                    <th>Nomor Induk Siswa</th>
                                    <th>Kelas</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($siswas as $index => $siswa)
                                    <tr>
                                        <td>
                                            <div class="no-badge">{{ $index + 1 }}.</div>
                                        </td>
                                        <td>{{ ucwords($siswa->nama_siswa) }}</td>
                                        <td>{{ $siswa->nis }}</td>
                                        <td>{{ strtoupper($siswa->kelas) }}</td>
                                        <td>{{ ucwords($siswa->jenis_kelamin) }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <button type="button" class="btn btn-icon btn-edit"
                                                    data-id-siswa="{{ $siswa->id_siswa }}"
                                                    data-nama-siswa="{{ ucwords($siswa->nama_siswa) }}"
                                                    data-nis="{{ $siswa->nis }}" data-kelas="{{ $siswa->kelas }}"
                                                    data-jenis-kelamin="{{ $siswa->jenis_kelamin }}" title="Edit">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </button>
                                                <button type="button" class="btn btn-icon btn-delete"
                                                    data-id-siswa="{{ $siswa->id_siswa }}"
                                                    data-nama-siswa="{{ ucwords($siswa->nama_siswa) }}" title="Delete">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('modal')
    <div class="modal fade" id="filterModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-white">
                        <i class="fa fa-filter mr-2"></i> Filter Data
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="filter-card mb-3">
                        <div class="filter-label-wrapper">
                            <i class="bi bi-mortarboard-fill filter-icon"></i>
                            <div class="filter-label">Kelas</div>
                        </div>
                        <select id="filterKelas" class="form-control filterKelas filter-input">
                            <option value="">All Kelas</option>
                            <option value="x tkj 1">X TKJ 1</option>
                            <option value="x tkj 2">X TKJ 2</option>
                            <option value="x tkj 3">X TKJ 3</option>
                            <option value="x tkj 4">X TKJ 4</option>
                            <option value="x tkj 5">X TKJ 5</option>
                            <option value="x tkj 6">X TKJ 6</option>
                            {{-- @foreach ($siswas->unique('kelas') as $siswa)
                                <option value="{{ $siswa->kelas }}">
                                    {{ $siswa->kelas }}
                                </option>
                            @endforeach --}}
                        </select>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button class="btn btn-light btn-back"><i
                                    class="bi bi-arrow-counterclockwise"></i>Reset</button>
                    <button class="btn btn-primary btn-universal"><i
                                    class="bi bi-check2-circle"></i>Terapkan</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade modal-edit" id="modal-edit-data-siswa" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-white" id="myLargeModalLabel"><i
                            class="fa-solid fa-pen-to-square"></i>Edit Data Siswa</h4>
                    <button type="button" class="close text-white" data-dismiss="modal">×</button>
                </div>
                <form id="edit-data-siswa" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body p-4">
                        <div class="card-modal-edit">
                            <input type="hidden" id="id-siswa" name="id_siswa">
                            <div class="form-group row align-items-center">
                                <label for="nama_siswa" class="col-md-3 col-form-label">Nama Siswa</label>
                                <div class="col-md-9 position-relative">
                                    <input type="text" class="form-control" id="nama-siswa" name="nama_siswa"
                                        placeholder="Masukkan Nama Siswa" required>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="nis" class="col-md-3 col-form-label">NIS</label>
                                <div class="col-md-9 position-relative">
                                    <input type="text" class="form-control" id="nis" name="nis"
                                        placeholder="Masukkan NIS" required>
                                    <small id="error-nis" class="d-none text-danger">
                                    </small>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="kelas" class="col-md-3 col-form-label">Kelas</label>
                                <div class="col-md-9 position-relative">
                                    <select id="kelas" name="kelas" class="form-control" required>
                                        <option value="" disabled>--Pilih--</option>
                                        <option value="x tkj 1">X TKJ 1</option>
                                        <option value="x tkj 2">X TKJ 2</option>
                                        <option value="x tkj 3">X TKJ 3</option>
                                        <option value="x tkj 4">X TKJ 4</option>
                                        <option value="x tkj 5">X TKJ 5</option>
                                        <option value="x tkj 6">X TKJ 6</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="jenis_kelamin" class="col-md-3 col-form-label">Jenis Kelamin</label>
                                <div class="col-md-9 position-relative">
                                    <select id="jenis-kelamin" name="jenis_kelamin" class="form-control" required>
                                        <option value="" disabled>--Pilih--</option>
                                        <option value="laki-laki">Laki-Laki</option>
                                        <option value="perempuan">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer pt-0">
                        <button type="button" class="btn btn-back" data-dismiss="modal">
                            <i class="fa-solid fa-circle-xmark"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-universal" id="btn-edit">
                            <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade modal-import" id="modal-import-data-siswa" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-white"><i class="fa fa-upload"></i>Upload Data Siswa</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form action="{{ route('siswa.import') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <input type="file" class="form-control" accept=".csv,.xlsx,.xls" name="file" required>
                            <small class="form-text">File yang diterima: .csv, .xlsx, .xls</small>
                        </div>
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>Format File:</strong> Nama, Nis, Kelas, Jenis Kelamin<br>
                            <small>Contoh: Ryan, 1234, X TKJ 1, Laki-Laki</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-back" data-dismiss="modal"> <i
                                class="fa-solid fa-circle-xmark"></i>Batal</button>
                        <button type="submit" class="btn btn-universal"><i class="fa-solid fa-check"></i>Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="update-success" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content text-center p-4">
                <div class="modal-body font-18">
                    <h3 class="mb-20">Update Berhasil!</h3>
                    <div class="mb-30">
                        <img src="{{ asset('deskap/vendors/images/success.png') }}" alt="success" />
                    </div>
                    <p id="update-success-text"></p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="store-success" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content text-center p-4">
                <div class="modal-body font-18">
                    <h3 class="mb-20">Berhasil!</h3>
                    <div class="mb-30">
                        <img src="{{ asset('deskap/vendors/images/success.png') }}" alt="success" />
                    </div>
                    <p id="store-success-text"></p>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('deskap/src/plugins/sweetalert2/sweetalert2.all.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{ asset('js/dataTable.js') }}"></script>
    <script src="{{ asset('js/dataSiswa.js') }}"></script>
@endpush
@push('scripts')
    <script>
        $(document).on("click", ".btn-delete", function(e) {
            e.preventDefault();

            let idSiswa = $(this).data("id-siswa");
            let namaSiswa = $(this).data("nama-siswa");

            Swal.fire({
                title: "Yakin?",
                html: "Anda ingin menghapus <strong>" + namaSiswa + "</strong>?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya, hapus!",
                cancelButtonText: "Batal",
                customClass: {
                    confirmButton: "btn btn-success margin-5",
                    cancelButton: "btn btn-danger margin-5",
                },
                buttonsStyling: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Deleted!",
                        html: "Siswa <strong>" +
                            namaSiswa +
                            "</strong> berhasil dihapus.",
                        icon: "success",
                        timer: 3000,
                        showConfirmButton: false,
                    });

                    let form = $("<form>", {
                        method: "POST",
                        action: "/delete-siswa/" + idSiswa,
                    });

                    let token = $("<input>", {
                        type: "hidden",
                        name: "_token",
                        value: "{{ csrf_token() }}",
                    });

                    let method = $("<input>", {
                        type: "hidden",
                        name: "_method",
                        value: "DELETE",
                    });

                    form.append(token, method).appendTo("body").submit();
                }
            });
        });
        @if (session('update_success'))
            $('#update-success-text').html(
                'Data siswa dengan nama <strong>{{ session('update_success') }}</strong> berhasil di update'
            );

            $('#update-success').modal('show');

            setTimeout(function() {
                $('#update-success').modal('hide');
            }, 3000);
        @endif

        @if (session('store_success'))
            $('#store-success-text').html(
                'Data siswa dengan nama <strong>{{ session('store_success') }}</strong> berhasil disimpan'
            );

            $('#store-success').modal('show');

            setTimeout(function() {
                $('#store-success').modal('hide');
            }, 3000);
        @endif

        @if (session('upload_success'))
            toastr.success("{{ session('upload_success') }}", "Upload Berhasil", {
                timeOut: 3000,
                progressBar: true,
                closeButton: true
            });
        @endif

        @if ($errors->has('nis'))
            toastr.error(
                'NIS sudah digunakan oleh siswa lain',
                'Gagal Update'
            );
        @endif
    </script>
@endpush
{{-- <script>
    // $(document).ready(function() {
    //     // ===================== FILTER =====================
    //     let filterState = {
    //         kelas: '',
    //     };

    //     function countActiveFilters() {
    //         let count = 0;

    //         if (filterState.kelas) count++;
    //         return count;
    //     }

    //     $('.btn-universal').on('click', function() {

    //         table.column(3).search(filterState.kelas).draw();
    //         let total = countActiveFilters();

    //         $('#filterBadge').text(total).toggle(total > 0);
    //         $('#filterModal').modal('hide');
    //     });


    //     $('.btn-back').on('click', function() {

    //         filterState = {
    //             kelas: '',
    //         };

    //         $('select.filter-input').prop('selectedIndex', 0);
    //         table.search('').columns().search('').draw();

    //         $('#filterBadge').hide().text('0');
    //     });

    //     // ===================== SEARCH =====================
    //     let timeout;

    //     $('#searchInput').on('input', function() {
    //         clearTimeout(timeout);
    //         timeout = setTimeout(() => {
    //             table.search(this.value).draw();
    //         }, 300);
    //     });

    //     // ===================== DROPDOWN FILTER =====================
    //     $('#filterKelas').on('change', function() {
    //         filterState.kelas = $(this).val();
    //     });

    //     // ========================= EXPORT =========================
    //     window.exportPdf = function() {
    //         let url = "/export-siswa";

    //         if (filterState.kelas) {
    //             url += "?kelas=" + encodeURIComponent(filterState.kelas);
    //         }

    //         window.open(url, "_blank");
    //     };


    //     // ========================= EDIT =========================
    //     $(document).on('click', '.btn-edit', function(e) {
    //         e.preventDefault();

    //         let idSiswa = $(this).data('id-siswa');
    //         let namaSiswa = $(this).data('nama-siswa');
    //         let nis = $(this).data('nis');
    //         let kelas = $(this).data('kelas');
    //         let jenis = $(this).data('jenis-kelamin');

    //         $('#id-siswa').val(idSiswa);
    //         $('#nama-siswa').val(namaSiswa);
    //         $('#nis').val(nis);
    //         $('#kelas').val(kelas);
    //         $('#jenis-kelamin').val(jenis);

    //         $('#edit-data-siswa').attr('action', '/update-siswa/' + idSiswa);

    //         $('#modal-edit-data-siswa').modal('show');
    //     });

    //     // ========================= DELETE =========================
    //     $(document).on('click', '.btn-delete', function(e) {
    //         e.preventDefault();

    //         let idSiswa = $(this).data('id-siswa');
    //         let namaSiswa = $(this).data('nama-siswa');

    //         Swal.fire({
    //             title: 'Yakin?',
    //             html: "Anda ingin menghapus <strong>" + namaSiswa + "</strong>?",
    //             icon: 'warning',
    //             showCancelButton: true,
    //             confirmButtonText: 'Ya, hapus!',
    //             cancelButtonText: 'Batal',
    //             customClass: {
    //                 confirmButton: 'btn btn-success margin-5',
    //                 cancelButton: 'btn btn-danger margin-5'
    //             },
    //             buttonsStyling: false
    //         }).then((result) => {
    //             if (result.isConfirmed) {

    //                 Swal.fire({
    //                     title: 'Deleted!',
    //                     html: "Siswa <strong>" + namaSiswa +
    //                         "</strong> berhasil dihapus.",
    //                     icon: 'success',
    //                     timer: 3000,
    //                     showConfirmButton: false
    //                 });

    //                 let form = $('<form>', {
    //                     method: 'POST',
    //                     action: '/delete-siswa/' + idSiswa
    //                 });

    //                 let token = $('<input>', {
    //                     type: 'hidden',
    //                     name: '_token',
    //                     value: '{{ csrf_token() }}'
    //                 });

    //                 let method = $('<input>', {
    //                     type: 'hidden',
    //                     name: '_method',
    //                     value: 'DELETE'
    //                 });

    //                 form.append(token, method).appendTo('body').submit();
    //             }
    //         });
    //     });

    //     // ========================= DATATABLE INIT =========================
    //     let table;

    //     if (!$.fn.DataTable.isDataTable('.data-table')) {
    //         table = $('.data-table').DataTable({
    //             responsive: false,
    //             autoWidth: false,
    //             pageLength: 10,
    //             lengthChange: true,
    //             ordering: false,
    //             dom: 'lrtip',

    //             language: {
    //                 search: "",
    //                 zeroRecords: "Data tidak ditemukan",
    //                 info: "Showing _START_ to _END_ of _TOTAL_ entries",
    //                 lengthMenu: "_MENU_",
    //                 paginate: {
    //                     next: ">>",
    //                     previous: "<<"
    //                 }
    //             }
    //         });

    //         // $('#search-wrapper').html($('.dataTables_filter').detach());

    //         $('#show-entries')
    //             .html($('.dataTables_length').addClass('m-0 p-0').detach())
    //             .prepend('<span class="my-1">Show :</span>');
    //     }

    //     // ========================= TOOLTIP =========================
    //     $(function() {
    //         $('[title]').tooltip({
    //             placement: 'top',
    //             offset: '0,3'
    //         });
    //     });
    // });
</script> --}}
