@extends('layouts.admin')
@section('title', 'Data Akun User')
@section('link')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/content.css') }}">
    <link rel="stylesheet" href="{{ asset('css/universal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/akun.css') }}">
    <link rel="stylesheet" href="{{ asset('css/filter.css') }}">
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
                            <h4>Data Akun User</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><i class="bx bx-home"></i>
                                    <a href="{{ route('dashboardAdmin.index') }}">Dashboard Admin</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="#">User</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Data Akun User
                                </li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-md-6 col-sm-12 text-right">
                        <a href="{{ route('akun.add') }}">
                            <button class="btn btn-universal" type="button"><i class="fa fa-plus"></i>Add
                                New
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
                    <button onclick="exportPdf()" type="button" class="btn-universal" title="Download">
                        <i class="fa fa-download"></i>
                        Export
                    </button>
                </div>
                <div id="show-entries" class="ml-0 mt-3"></div>
                {{-- <div class="row align-items-center m-0">
                    <div class="col-md-6 col-12 mb-md-0 p-0 m-0">
                        <div class="input-group mb-0">
                            <div id="search-wrapper" class="pr-2"></div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12 d-flex gap-2 flex-wrap justify-content-md-end m-0 p-0">
                        <button type="button" class="btn-universal" title="Download">
                            <i class="fa fa-download"></i>
                            Export
                        </button>
                    </div>
                </div>

                <div class="row mb-3 align-items-center">
                    <div class="col-12 d-flex justify-content-between align-items-center px-3 py-2">
                        <div id="show-entries"></div>
                    </div>
                </div> --}}

                <div class="pb-20">
                    <div class="table-responsive p-0 m-0">
                        <table class="data-table table hover multiple-select-row py-3 px-4 border-0"
                            style="background: #e9edf9b1 !important; border-radius: 22px;">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama user</th>
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($akuns as $index => $akun)
                                    <tr>
                                        <td>
                                            <div class="no-badge">{{ $index + 1 }}.</div>
                                        </td>
                                        <td>{{ ucwords($akun->siswa?->nama_siswa ?? $akun->username) }}</td>
                                        <td>{{ $akun->username }}</td>
                                        <td>{{ ucwords($akun->role) }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <button type="button" class="btn btn-icon btn-edit"
                                                    data-id-akun="{{ $akun->id_akun_user }}"
                                                    data-nama-user="{{ ucwords($akun->siswa?->nama_siswa ?? $akun->username) }}"
                                                    data-username="{{ $akun->username }}" data-role="{{ $akun->role }}"
                                                    title="Edit">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </button>

                                                <!-- DELETE -->
                                                <button type="button" class="btn btn-icon btn-delete"
                                                    data-id-akun="{{ $akun->id_akun_user }}"
                                                    data-nama-user="{{ ucwords($akun->siswa?->nama_siswa ?? $akun->username) }}"
                                                    title="Delete">
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
                            <i class="bi bi-people-fill filter-icon"></i>
                            <div class="filter-label">Role</div>
                        </div>
                        <select id="filterRole" class="form-control filterRole filter-input">
                            <option value="">All Role</option>
                            <option value="admin">Admin</option>
                            <option value="siswa">Siswa</option>
                            <option value="kabeng">Kabeng</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button class="btn btn-light btn-back" id="btnResetFilter"><i class="bi bi-arrow-counterclockwise" ></i>Reset</button>
                    <button class="btn btn-primary btn-universal" id="btnApplyFilter"><i class="bi bi-check2-circle" ></i>Terapkan</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal modal-edit-akun fade" id="modal-edit-akun" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h4 class="modal-title text-white" id="myLargeModalLabel"><i
                            class="fa-solid fa-pen-to-square mr-3"></i>Edit Data Akun User</h4>
                    <button type="button" class="close text-white" data-dismiss="modal">×</button>
                </div>
                <div class="col-12 mb-30 mt-30">
                    <div class="pd-20 card-box">
                        <div class="tab">
                            <div class="row clearfix">
                                <div class="col-md-3 col-sm-12 pr-0">
                                    <ul class="nav flex-column nav-pills vtabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#edit-data"
                                                role="tab" aria-selected="true"><i
                                                    class="fa-solid fa-user-pen"></i>Edit Data</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#ganti-password" role="tab"
                                                aria-selected="false"><i class="fa-solid fa-key"></i>Ganti
                                                Password</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-9 col-sm-12">
                                    <form id="form-edit-akun" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" id="id-akun-user" name="id_akun_user">
                                        <div class="tab-content">

                                            <div class="tab-pane fade show active" id="edit-data" role="tabpanel">
                                                <div class="pd-20">
                                                    {{-- <form id="edit-data-form" method="POST">
                                                        @csrf
                                                        @method('PUT') --}}
                                                    <div class="modal-body-akun" style="border-radius: 20px;">
                                                        <input type="hidden" id="id-akun-user" name="id_akun_user">
                                                        <div class="form-group row align-items-center">
                                                            <label for="nama" class="col-md-3 col-form-label">Nama
                                                                User</label>
                                                            <div class="col-md-9 position-relative">
                                                                <input type="text" class="form-control" id="nama-user"
                                                                    name="nama" placeholder="Masukkan Nama" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row align-items-center">
                                                            <label for="username"
                                                                class="col-md-3 col-form-label">Username</label>
                                                            <div class="col-md-9 position-relative">
                                                                <input type="text" class="form-control" id="username"
                                                                    name="username" placeholder="Masukkan Username"
                                                                    required>
                                                                <small id="edit-username-error"
                                                                    class="text-danger d-none ml-1"></small>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row align-items-center">
                                                            <label for="role"
                                                                class="col-md-3 col-form-label">Role</label>
                                                            <div class="col-md-9 position-relative">
                                                                <select id="role" name="role"
                                                                    class="form-control" required>
                                                                    <option value="" disabled>--Pilih--</option>
                                                                    <option value="admin">Admin</option>
                                                                    <option value="siswa">Siswa</option>
                                                                    </option>
                                                                    <option value="kabeng">Kabeng</option>
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        {{-- <div class="modal-footer border-0 p-0">
                                                                <button type="button" class="btn btn-back"
                                                                    data-dismiss="modal"><i
                                                                        class="fa-solid fa-circle-xmark"></i>Batal</button>
                                                                <button type="submit" class="btn btn-universal"><i
                                                                        class="fa-solid fa-floppy-disk"></i>Simpan
                                                                    Perubahan</button>
                                                            </div> --}}
                                                    </div>
                                                    {{-- </form> --}}
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="ganti-password" role="tabpanel">
                                                <div class="pd-20">
                                                    {{-- <form id="edit-ganti-password-form" method="POST">
                                                        @csrf
                                                        @method('PUT') --}}
                                                    <div class="modal-body-akun" style="border-radius: 20px;">
                                                        <input type="hidden" id="id-akun-user" name="id_akun_user">
                                                        <div class="form-group row align-items-center mb-3">
                                                            <label for="password-baru"
                                                                class="col-md-3 col-form-label">Password Baru
                                                            </label>
                                                            <div class="col-md-9 position-relative">
                                                                <input type="password" class="form-control"
                                                                    id="password-baru" name="password_baru"
                                                                    placeholder="Masukkan password baru">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row align-items-center">
                                                            <label for="conf-pwd"
                                                                class="col-md-3 col-form-label">Konfirmasi
                                                                Password</label>
                                                            <div class="col-md-9 position-relative">
                                                                <input type="password" class="form-control"
                                                                    id="conf-pwd" name="conf_pwd"
                                                                    placeholder="Masukkan konfirmasi password">
                                                                    <small id="edit-pwd-error" class="text-danger d-none"></small>
                                                            </div>
                                                        </div>
                                                        {{-- <div class="modal-footer border-0 p-0">
                                                                <button type="button" class="btn btn-back"
                                                                    data-dismiss="modal"><i
                                                                        class="fa-solid fa-circle-xmark"></i>Batal</button>
                                                                <button type="submit" class="btn btn-universal"><i
                                                                        class="fa-solid fa-floppy-disk"></i>Simpan
                                                                    Perubahan</button>
                                                            </div> --}}
                                                    </div>
                                                    {{-- </form> --}}
                                                </div>
                                            </div>
                                            <div class="wrapper-btn">
                                                <button type="button" class="btn btn-back" data-dismiss="modal"><i
                                                        class="fa-solid fa-circle-xmark"></i>Batal</button>
                                                <button type="submit" class="btn btn-universal"><i
                                                        class="fa-solid fa-floppy-disk"></i>Simpan
                                                    Perubahan</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
    <script src="{{ asset('js/dataAkun.js') }}"></script>
    <script>
        // $(document).ready(function() {
        //     // ===================== FILTER =====================
        //     let filterState = {
        //         role: '',
        //     };

        //     function countActiveFilters() {
        //         let count = 0;

        //         if (filterState.role) count++;
        //         return count;
        //     }

        //     $('.btn-universal').on('click', function() {

        //         table.column(3).search(filterState.role).draw();
        //         let total = countActiveFilters();

        //         $('#filterBadge').text(total).toggle(total > 0);
        //         $('#filterModal').modal('hide');
        //     });


        //     $('.btn-back').on('click', function() {

        //         filterState = {
        //             role: '',
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
        //     $('#filterRole').on('change', function() {
        //         filterState.role = $(this).val();
        //     });

        //     // ========================= EXPORT =========================
        //     window.exportPdf = function() {
        //         let url = "/export-akun-user";
        //         if (filterState.role) {
        //             url += "?role=" + encodeURIComponent(filterState.role);
        //         }
        //         window.open(url, "_blank");
        //     };

        //     // ========================= EDIT AKUN =========================
        //     $(document).on('click', '.btn-edit', function(e) {
        //         e.preventDefault();

        //         let idAkun = $(this).data('id-akun');
        //         let namaUser = $(this).data('nama-user');
        //         let username = $(this).data('username');
        //         let role = $(this).data('role');

        //         $('#id-akun-user').val(idAkun);
        //         $('#nama-user').val(namaUser);
        //         $('#username').val(username);
        //         $('#role').val(role);

        //         $('#form-edit-akun').attr('action', '/update-akun/' + idAkun);

        //         // $('#edit-data-form').attr('action', '/update-data/' + id);
        //         // $('#edit-ganti-password-form').attr('action', '/update-password/' + id);

        //         $('#modal-edit-akun').modal('show');
        //     });

        //     // ========================= DELETE AKUN =========================
        //     $(document).on('click', '.btn-delete', function(e) {
        //         e.preventDefault();

        //         let idAkun = $(this).data('id-akun');
        //         let namaUser = $(this).data('nama-user');

        //         Swal.fire({
        //             title: 'Yakin?',
        //             html: "Anda ingin menghapus <strong>" + namaUser + "</strong>?",
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
        //                     html: "Akun <strong>" + namaUser +
        //                         "</strong> berhasil dihapus.",
        //                     icon: 'success',
        //                     timer: 3000,
        //                     showConfirmButton: false
        //                 });

        //                 let form = $('<form>', {
        //                     method: 'POST',
        //                     action: '/delete-akun/' + idAkun
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

        //     // ========================= DATATABLE =========================
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

        //         // move show entries
        //         $('#show-entries')
        //             .html($('.dataTables_length').detach())
        //             .prepend('<span class="my-1 show">Show :</span>');
        //     }



        //     // ========================= FLASH MESSAGE =========================

        //     @if (session('update_success'))
        //         $('#update-success-text').html(
        //             'Data akun user dengan username <strong>{{ session('update_success') }}</strong> berhasil di update'
        //         );

        //         $('#update-success').modal('show');

        //         setTimeout(function() {
        //             $('#update-success').modal('hide');
        //         }, 3000);
        //     @endif

        //     @if (session('store_success'))
        //         $('#store-success-text').html(
        //             'Data akun dengan username <strong>{{ session('store_success') }}</strong> berhasil disimpan'
        //         );

        //         $('#store-success').modal('show');

        //         setTimeout(function() {
        //             $('#store-success').modal('hide');
        //         }, 3000);
        //     @endif



        //     // ========================= TOOLTIP =========================
        //     $(function() {
        //         $('[title]').tooltip({
        //             placement: 'top',
        //             offset: '0,3'
        //         });
        //     });

        //     // ========================= TAB SWITCH TITLE =========================
        //     $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        //         let target = $(e.target).attr("href");

        //         if (target == "#home7") {
        //             $("#myLargeModalLabel").text("Edit Data Akun User");
        //         } else if (target == "#profile7") {
        //             $("#myLargeModalLabel").text("Ganti Password");
        //         }
        //     });



        //     @if ($errors->has('username'))
        //         toastr.error(
        //             'Username sudah digunakan oleh siswa lain',
        //             'Gagal Update'
        //         );
        //     @endif

        //     $(function() {
        //         $('[title]').tooltip({
        //             placement: 'top',
        //             offset: '0,3'
        //         });
        //     });
        // });
    </script>
@endpush
@push('scripts')
    <script>
        $(document).on("click", ".btn-delete", function(e) {
            e.preventDefault();

            let idAkun = $(this).data("id-akun");
            let namaUser = $(this).data("nama-user");

            Swal.fire({
                title: "Yakin?",
                html: "Anda ingin menghapus <strong>" + namaUser + "</strong>?",
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
                        html: "Akun <strong>" +
                            namaUser +
                            "</strong> berhasil dihapus.",
                        icon: "success",
                        timer: 3000,
                        showConfirmButton: false,
                    });

                    let form = $("<form>", {
                        method: "POST",
                        action: "/delete-akun/" + idAkun,
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
                'Data akun user dengan username <strong>{{ session('update_success') }}</strong> berhasil di update'
            );

            $('#update-success').modal('show');

            setTimeout(function() {
                $('#update-success').modal('hide');
            }, 3000);
        @endif

        @if (session('store_success'))
            $('#store-success-text').html(
                'Data akun dengan username <strong>{{ session('store_success') }}</strong> berhasil disimpan'
            );

            $('#store-success').modal('show');

            setTimeout(function() {
                $('#store-success').modal('hide');
            }, 3000);
        @endif


        @if ($errors->has('username'))
            toastr.error(
                'Username sudah digunakan oleh siswa lain',
                'Gagal Update'
            );
        @endif
    </script>
@endpush
