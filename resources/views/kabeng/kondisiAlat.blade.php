@extends('layouts.kabeng')
@section('title', 'Laporan Kondisi Alat')
@section('link')
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/content.css') }}">
    <link rel="stylesheet" href="{{ asset('css/universal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/filter.css') }}">
    <link rel="stylesheet" href="{{ asset('css/table.css') }}">
    <link rel="stylesheet" href="{{ asset('css/button.css') }}">
@endsection

@section('content')
    @php
        function badgeClass($kondisi)
        {
            if ($kondisi == 'rusak') {
                return 'badge-soft-danger';
            } elseif ($kondisi == 'perlu perbaikan') {
                return 'badge-soft-warning';
            } else {
                return 'badge-soft-dark';
            }
        }

    @endphp
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <h4>Laporan Kondisi Alat</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><i class="bx bx-home"></i>
                                    <a href="{{ route('dashboardKabeng.index') }}">Dashboard Kabeng</a>
                                </li>
                                <li class="breadcrumb-item"><i class="bx bx-home"></i>
                                    <a href="#">Laporan</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Kondisi Alat
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="card-box">
                <div class="toolbar-wrapper">
                    <div class="search-wrapper mb-2">
                        <i class="fa fa-search search-wrapper-icon"></i>
                        <input type="text" class="form-control search-box-wrapper" placeholder="Search..."
                            id="searchInput">

                    </div>
                    <button onclick="exportPdf()" type="button" class="btn-universal" title="Download">
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
                                    <th>Tipe Alat</th>
                                    <th>Kondisi Alat</th>

                                </tr>
                            </thead>

                            <tbody>

                                @foreach ($kondisi as $item)
                                    <tr>

                                        <td>
                                            <div class="no-badge">
                                                {{ $loop->iteration }}.
                                            </div>
                                        </td>

                                        <td>
                                            {{ ucwords($item->nama_tipe) }}
                                        </td>

                                        <td>
                                            <div class="kondisi d-flex gap-1 flex-wrap">
                                                @if ($item->total_rusak > 0)
                                                    <span
                                                        class="badge {{ badgeClass('rusak') }} px-3 py-2 rounded-pill mr-2">
                                                        Rusak: {{ $item->total_rusak }}
                                                    </span>
                                                @endif

                                                @if ($item->total_perbaikan > 0)
                                                    <span
                                                        class="badge {{ badgeClass('perlu perbaikan') }} px-3 py-2 rounded-pill mr-2">
                                                        Perbaikan: {{ $item->total_perbaikan }}
                                                    </span>
                                                @endif

                                                @if ($item->total_hilang > 0)
                                                    <span class="badge {{ badgeClass('hilang') }} px-3 py-2 rounded-pill mr-2">
                                                        Hilang: {{ $item->total_hilang }}
                                                    </span>
                                                @endif
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
@push('scripts')
    <script>
        $(document).ready(function() {

            // // ===================== SEARCH =====================
            // let timeout;

            // $('#searchInput').on('input', function() {
            //     clearTimeout(timeout);
            //     timeout = setTimeout(() => {
            //         table.search(this.value).draw();
            //     }, 300);
            // });



            // // ========================= DATATABLE INIT =========================
            // let table;

            // if (!$.fn.DataTable.isDataTable('.data-table')) {

            //     table = $('.data-table').DataTable({
            //         responsive: false,
            //         autoWidth: false,
            //         pageLength: 10,
            //         lengthChange: true,
            //         ordering: false,
            //         dom: 'lrtip',

            //         language: {
            //             search: "",
            //             zeroRecords: "Data tidak ditemukan",
            //             info: "Showing _START_ to _END_ of _TOTAL_ entries",
            //             lengthMenu: "_MENU_",
            //             paginate: {
            //                 next: ">>",
            //                 previous: "<<"
            //             }
            //         }
            //     });

            //     // ========================= SELECT2 FILTER =========================
            //     // move datatable UI
            //     // $('#search-wrapper').html($('.dataTables_filter').detach());

            //     $('#show-entries')
            //         .html($('.dataTables_length').addClass('m-0 p-0').detach())
            //         .prepend('<span class="my-1">Show :</span>');
            // }



            // // ========================= TOOLTIP =========================
            // $(function() {
            //     $('[title]').tooltip({
            //         placement: 'top',
            //         offset: '0,3'
            //     });
            // });



            window.exportPdf = function() {
                let url = "/export-kondisi";

                window.open(url, "_blank");
            };
        });
    </script>
@endpush
