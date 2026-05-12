@extends('layouts.admin')
@section('title', 'Data Detail Alat')
@section('link')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/content.css') }}">
    <link rel="stylesheet" href="{{ asset('css/universal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/filter.css') }}">
    <link rel="stylesheet" href="{{ asset('css/table.css') }}">

    <link rel="stylesheet" href="{{ asset('css/button.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
@endsection

@section('content')
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <h4>Data Detail Alat</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><i class="bx bx-home"></i>
                                    <a href="#">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="#">Alat</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="#">Data Tipe Alat</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Data Detail Alat
                                </li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-md-6 col-sm-12 text-right">

                        <button class="btn btn-universal btn-add" type="button">
                            <i class="fa fa-plus"></i>
                            Add New
                        </button>

                    </div>
                </div>
            </div>
            <div class="card-box mb-30">
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
                    <button onclick="exportPdf({{ $idTipe }})" type="button" class="btn-universal" title="Download">
                        <i class="fa fa-download"></i>
                        Export
                    </button>
                </div>
                <div id="show-entries" class="ml-0 mt-3"></div>
                <div class="pb-20">
                    <div class="table-responsive p-0 m-0">
                        <table class="data-table table hover multiple-select-row py-3 px-4 border-0"
                            style="background: #e9edf9b1 !important; border-radius: 22px;">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Kode Alat</th>
                                    <th>Kondisi Alat</th>
                                    <th>Status Alat</th>
                                    <th>QR Code</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($details as $index => $detail)
                                    <tr>
                                        <td>
                                            <div class="no-badge">{{ $index + 1 }}.</div>
                                        </td>
                                        <td>{{ $detail->kode_alat }}</td>
                                        <td>{{ ucwords($detail->kondisi_alat) }}</td>
                                        <td>{{ ucwords($detail->status_alat) }}</td>
                                        <td>
                                            <div class="qr-box">
                                                <img class="qr-img" src="{{ asset($detail->qr_code) }}">
                                                <div class="garis"></div>
                                                <div class="kode-wrapper">
                                                    <img class="logo-kecil"
                                                        src="https://smkkotadijawatimur.wordpress.com/wp-content/uploads/2017/04/logo-smkn7-resmi.jpg?w=255">
                                                    <span class="kode">{{ $detail->kode_alat }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <button type="button" class="btn btn-icon btn-edit"
                                                    data-id-detail="{{ $detail->id_detail_alat }}"
                                                    data-kondisi-alat="{{ $detail->kondisi_alat }}" title="Edit">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </button>
                                                <button type="button" class="btn btn-icon btn-delete"
                                                    data-id-detail="{{ $detail->id_detail_alat }}"
                                                    data-kode-alat="{{ $detail->kode_alat }}" title="Delete">
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
                {{-- <div class="pb-20">
                    <table class="data-table table hover multiple-select-row nowrap">
                        <thead>
                            <tr>
                                <th>NO.</th>
                                @if ($isQr && $isKode)
                                    <th>KODE ALAT</th>
                                @endif
                                <th>KONDISI</th>
                                <th>STATUS</th>
                                @if ($isQr && $isKode)
                                    <th>QR CODE</th>
                                @endif
                                <th>AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($details as $index => $detail)
                                <tr>
                                    <td>{{ $index + 1 }}.</td>
                                    @if ($isQr && $isKode)
                                        <td>{{ $detail->kode_alat }}</td>
                                    @endif
                                    <td>{{ ucwords($detail->kondisi_alat) }}</td>
                                    <td>{{ ucwords($detail->status_alat) }}</td>
                                    @if ($isQr && $isKode)
                                        <td>
                                            <div class="qr-box">
                                                <img class="qr-img" src="{{ asset($detail->qr_code) }}">
                                                <div class="garis"></div>
                                                <div class="kode-wrapper">
                                                    <img class="logo-kecil"
                                                        src="https://smkkotadijawatimur.wordpress.com/wp-content/uploads/2017/04/logo-smkn7-resmi.jpg?w=255">
                                                    <span class="kode">{{ $detail->kode_alat }}</span>
                                                </div>

                                            </div>
                                        </td>
                                    @endif
                                    <td>
                                        <div class="d-flex align-items-center gap-2">

                                       
                                            <button type="button" class="btn btn-icon btn-edit"
                                                data-id="{{ $detail->id_detail_alat }}"
                                                data-kondisi-alat="{{ $detail->kondisi_alat }}" title="Edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>

                                        
                                            <button type="button" class="btn btn-icon btn-delete"
                                                data-id="{{ $detail->id_detail_alat }}"
                                                data-kode-alat="{{ $detail->kode_alat }}" title="Delete">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>

                                        </div>
                                      
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div> --}}
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
                            <i class="bi bi-exclamation-triangle filter-icon"></i>
                            <div class="filter-label">Kondisi Alat</div>
                        </div>
                        <select id="filterKondisi" class="form-control filterKondisi filter-input">
                            <option value="">All Kondisi</option>
                            <option value="baik">Baik</option>
                            <option value="perlu perbaikan">Perlu Perbaikan</option>
                            <option value="rusak">Rusak</option>
                            <option value="hilang">Hilang</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button class="btn btn-light btn-back"><i class="fa-solid fa-rotate-left"></i>Reset</button>
                    <button class="btn btn-primary btn-universal" id="btn-apply-filter"><i
                            class="fa-solid fa-floppy-disk"></i>Terapkan</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade modal-add-data-detail" id="modal-add-data-detail" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-white" id="myLargeModalLabel">
                        <i class="fa-solid fa-file-circle-plus"></i> Tambah Alat
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        ×
                    </button>
                </div>
                <form action="{{ route('detail.store', $idTipe) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="jumlah">Jumlah</label>
                            <input type="number" class="form-control" id="jumlah" name="jumlah"
                                placeholder="Masukkan jumlah" min="1">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-back" data-dismiss="modal">
                            <i class="fa fa-circle-xmark"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-universal">
                            <i class="fa-solid fa-qrcode"></i>
                            Generate
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade modal-edit-data-detail" id="modal-edit-data-detail" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h4 class="modal-title text-white" id="myLargeModalLabel"><i
                            class="fa-solid fa-pen-to-square mr-3"></i>Edit Data Detail Alat</h4>
                    <button type="button" class="close text-white" data-dismiss="modal">×</button>
                </div>
                <form id="edit-detail-form" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" id="id-detail-alat" name="id_detail_alat">
                        <div class="form-group row align-items-center">
                            <label for="kondisi-alat" class="col-md-3 col-form-label">Kondisi Alat</label>
                            <div class="col-md-9 position-relative">
                                <select name="kondisi_alat" id="kondisi-alat" required class="form-control">
                                    <option value=""disabled>--Pilih--</option>
                                    <option value="baik">Baik</option>
                                    <option value="perlu perbaikan">Perlu Perbaikan</option>
                                    <option value="rusak">Rusak</option>
                                    <option value="hilang">Hilang</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-back" data-dismiss="modal"> <i
                                class="fa fa-circle-xmark"></i>Batal</button>
                        <button type="submit" class="btn btn-universal"><i class="fa-solid fa-floppy-disk"></i>Simpan
                            Perubahan</button>
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
    <script src="{{ asset('js/dataDetail.js') }}"></script>
    <script>
        // $(document).ready(function() {
        //     // ===================== STATE =====================
        //     let filterState = {
        //         kondisi_alat: '',
        //         status_alat: ''
        //     };

        //     // ===================== HELPER =====================
        //     function countActiveFilters() {
        //         let count = 0;

        //         if (filterState.kondisi_alat) count++;
        //         if (filterState.status_alat) count++;
        //         return count;
        //     }

        //     // ===================== DROPDOWN FILTER =====================
        //     $('#filterKondisi').on('change', function() {
        //         filterState.kondisi_alat = $(this).val();
        //     });

        //     $('#filterStatus').on('change', function() {
        //         filterState.status_alat = $(this).val();
        //     });

        //     // ===================== FILTER APPLY =====================
        //     $('.btn-universal').on('click', function() {
        //         table.column(2).search(filterState.kondisi_alat ? '^' + filterState.kondisi_alat + '$' : '',
        //             true, false).draw();

        //         table.column(3).search(filterState.status_alat).draw();

        //         let total = countActiveFilters();
        //         $('#filterBadge').text(total).toggle(total > 0);
        //         $('#filterModal').modal('hide');
        //     });

        //     // ===================== RESET =====================
        //     $('.btn-back').on('click', function() {

        //         filterState = {
        //             kondisi_alat: '',
        //             status_alat: ''
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

        //     window.exportPdf = function(idTipe) {
        //         let url = "/export-detail/" + idTipe;
        //         let params = [];

        //         if (filterState.kondisi_alat) {
        //             params.push("kondisi_alat=" + encodeURIComponent(filterState.kondisi_alat));
        //         }

        //         if (filterState.status_alat) {
        //             params.push("status_alat=" + encodeURIComponent(filterState.status_alat));
        //         }

        //         if (params.length > 0) {
        //             url += "?" + params.join("&");
        //         }

        //         window.open(url, "_blank");
        //     };

        //     $(document).on('click', '.btn-add', function(e) {
        //         e.preventDefault();
        //         $('#modal-add-data-detail').modal('show');
        //     });

        //     $('#modal-add-data-detail').on('hidden.bs.modal', function() {
        //         $(this).find('form')[0].reset();
        //     });

        //     $(document).on('click', '.btn-edit', function(e) {
        //         e.preventDefault();
        //         let idDetail = $(this).data('id-detail');
        //         let kondisiAlat = $(this).data('kondisi-alat');

        //         $('#kondisi-alat').val(kondisiAlat);
        //         $('#edit-detail-form').attr('action', '/update-detail/' + idDetail);
        //         $('#modal-edit-data-detail').modal('show');
        //     });

        //     $(document).on('click', '.btn-delete', function(e) {
        //         e.preventDefault();

        //         let idDetail = $(this).data('id-detail');
        //         let kodeAlat = $(this).data('kode-alat');

        //         Swal.fire({
        //             title: 'Yakin?',
        //             html: "Anda ingin menghapus <strong>" + kodeAlat + "</strong>?",
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
        //                     html: "Detail <strong>" + kodeAlat +
        //                         "</strong> berhasil dihapus.",
        //                     icon: 'success',
        //                     timer: 3000,
        //                     showConfirmButton: false
        //                 });

        //                 // Submit form DELETE
        //                 var form = $('<form>', {
        //                     'method': 'POST',
        //                     'action': '/delete-detail/' + idDetail
        //                 });

        //                 var token = $('<input>', {
        //                     'type': 'hidden',
        //                     'name': '_token',
        //                     'value': '{{ csrf_token() }}'
        //                 });

        //                 var method = $('<input>', {
        //                     'type': 'hidden',
        //                     'name': '_method',
        //                     'value': 'DELETE'
        //                 });

        //                 form.append(token, method).appendTo('body').submit();
        //             }
        //         });
        //     });

        //     if (!$.fn.DataTable.isDataTable('.data-table')) {

        //         var table = $('.data-table').DataTable({
        //             responsive: true,
        //             autoWidth: false,
        //             pageLength: 10,
        //             lengthChange: true,
        //             dom: 'lrtip',
        //             ordering: false,
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

        //         $('#show-entries').html($('.dataTables_length').detach());
        //         $('#show-entries').prepend('<span class="me-1">Show :</span>');
        //     }

        //     $(function() {
        //         $('[title]').tooltip({
        //             placement: 'top',
        //             offset: '0,3'
        //         })
        //     })
        // });
    </script>
@endpush
@push('scripts')
    <script>
        $(document).on("click", ".btn-delete", function(e) {
            e.preventDefault();

            let idDetail = $(this).data("id-detail");
            let kodeAlat = $(this).data("kode-alat");

            Swal.fire({
                title: "Yakin?",
                html: "Anda ingin menghapus <strong>" + kodeAlat + "</strong>?",
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
                        html: "Detail <strong>" +
                            kodeAlat +
                            "</strong> berhasil dihapus.",
                        icon: "success",
                        timer: 3000,
                        showConfirmButton: false,
                    });

                    // Submit form DELETE
                    var form = $("<form>", {
                        method: "POST",
                        action: "/delete-detail/" + idDetail,
                    });

                    var token = $("<input>", {
                        type: "hidden",
                        name: "_token",
                        value: "{{ csrf_token() }}",
                    });

                    var method = $("<input>", {
                        type: "hidden",
                        name: "_method",
                        value: "DELETE",
                    });

                    form.append(token, method).appendTo("body").submit();
                }
            });
        });

        @if (session('update_success'))
            // Tampilkan modal
            $('#update-success-text').html(
                'Data detail alat dengan kode alat <strong>{{ session('update_success') }}</strong> berhasil di update'
            );

            $('#update-success').modal('show');
            setTimeout(function() {
                $('#update-success').modal('hide');
            }, 3000);
        @endif

        @if (session('store_success'))

            $('#store-success-text').html(
                '<strong>{{ session('store_success') }}</strong>'
            );

            $('#store-success').modal('show');
            setTimeout(function() {
                $('#store-success').modal('hide');
            }, 3000);
        @endif
    </script>
@endpush
