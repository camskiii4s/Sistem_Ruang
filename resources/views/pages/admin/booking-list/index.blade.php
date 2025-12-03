@extends('layouts.main')

@section('title', 'PT Angkasa Pura Indonesia')

@section('header-title', 'Booking List')

@section('breadcrumbs')
<div class="breadcrumb-item"><a href="#">Transaksi</a></div>
<div class="breadcrumb-item active">Booking List</div>
@endsection

@section('section-title', 'Booking List')

@section('section-lead')
Berikut ini adalah daftar seluruh booking dari setiap user.
@endsection

@section('content')

{{-- ===========================
    FORM LAPORAN (PDF + PREVIEW)
=========================== --}}
<div class="card mb-4">
    <div class="card-body">
        <h5 class="mb-3">Laporan Booking</h5>

        <form action="{{ route('booking-list.report') }}" method="GET" target="_blank" class="row g-3">

            <div class="col-md-4">
                <label class="form-label">Tanggal Mulai</label>
                <input type="date" name="start_date" class="form-control" required>
            </div>

            <div class="col-md-4">
                <label class="form-label">Tanggal Selesai</label>
                <input type="date" name="end_date" class="form-control" required>
            </div>

            <div class="col-md-4 d-flex align-items-end gap-2">

                {{-- TOMBOL PREVIEW --}}
                <a href="#"
                   class="btn btn-primary w-50"
                   onclick="
                       this.href='{{ route('booking-list.preview') }}?start_date='+
                       document.querySelector('[name=start_date]').value+
                       '&end_date='+
                       document.querySelector('[name=end_date]').value
                   "
                   target="_blank">
                    <i class="fas fa-eye"></i> Preview
                </a>

                {{-- EXPORT PDF --}}
                <button type="submit" class="btn btn-danger w-50">
                    <i class="fas fa-file-pdf"></i> Export PDF
                </button>
            </div>

        </form>

    </div>
</div>

{{-- ===========================
    DATATABLES
=========================== --}}
@component('components.datatables')
    @slot('table_id', 'booking-list-table')

    @slot('table_header')
        <tr>
            <th>No</th>
            <th>Foto</th>
            <th>Ruangan</th>
            <th>User</th>
            <th>Unit</th>
            <th>Tanggal</th>
            <th>Waktu Mulai</th>
            <th>Waktu Selesai</th>
            <th>Keperluan</th>
            <th>Konsumsi</th>
            <th>Status</th>
        </tr>
    @endslot
@endcomponent

@endsection

@push('after-script')
<script src="//cdn.datatables.net/plug-ins/1.10.22/dataRender/ellipsis.js"></script>

<script>
$(document).ready(function() {

    $('#booking-list-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('booking-list.json') }}',
        order: [[4, 'desc'], [5, 'desc']],

        columns: [

            { data: 'DT_RowIndex', orderable: false, searchable: false },

            {
                data: 'room.photo',
                orderable: false,
                searchable: false,
                render: function(data) {
                    if (data) {
                        return `
                            <div class="gallery gallery-fw">
                                <a href="{{ asset('storage/${data}') }}" data-toggle="lightbox">
                                    <img src="{{ asset('storage/${data}') }}" class="img-fluid" style="min-width: 80px;">
                                </a>
                            </div>
                        `;
                    }
                    return '-';
                }
            },

            {
                data: 'room_name',
                name: 'room_name',
                orderable: false,
                render: function(data, type, row) {

                    let result = data;
                    let now = new Date();
                    let bookingDate = new Date(row.date + ' ' + row.start_time);
                    let links = ('ontouchstart' in window) ? '<div>' : '<div class="table-links">';

                    if (bookingDate > now && (row.status === 'PENDING' || row.status === 'DITOLAK')) {
                        links += `
                            <a href="javascript:;" 
                               data-id="${row.id}" 
                               data-title="Setujui"
                               data-body="Yakin setujui booking ini?"
                               data-value="1"
                               class="text-primary"
                               id="acc-btn">Setujui</a>
                        `;
                    }

                    if (row.status === 'PENDING') {
                        links += '<div class="bullet"></div>';
                    }

                    if (row.status === 'PENDING' || row.status === 'DISETUJUI') {
                        links += `
                            <a href="javascript:;" 
                               data-id="${row.id}" 
                               data-title="Tolak"
                               data-body="Yakin tolak booking ini?"
                               data-value="0"
                               class="text-danger"
                               id="deny-btn">Tolak</a>
                        `;
                    }

                    links += '</div>';
                    result += links;

                    return result;
                }
            },

            { data: 'user_name', orderable: false },

            {
                data: 'unit',
                name: 'unit',
                orderable: false,
                render: function(data) {
                    return data ? data : '-';
                }
            },

            { data: 'date' },

            { data: 'start_time' },

            { data: 'end_time' },

            { data: 'purpose' },

            {
                data: 'konsumsi',
                name: 'konsumsi',
                orderable: false,
                render: function(data) {
                    return data ? data : '-';
                }
            },

            {
                data: 'status',
                render: function(data) {
                    let color = 'secondary';

                    if (data === 'PENDING') color = 'info';
                    if (data === 'DISETUJUI') color = 'primary';
                    if (data === 'DIGUNAKAN') color = 'primary';
                    if (data === 'DITOLAK') color = 'danger';
                    if (data === 'EXPIRED') color = 'warning';
                    if (data === 'BATAL') color = 'warning';
                    if (data === 'SELESAI') color = 'success';

                    return `<span class="badge badge-${color}">${data}</span>`;
                }
            }

        ]
    });

    // Approve / Deny
    $(document).on('click', '#acc-btn, #deny-btn', function() {
        let id    = $(this).data('id');
        let title = $(this).data('title');
        let body  = $(this).data('body');
        let value = $(this).data('value');

        $('#confirm-modal .modal-title').html(title);
        $('#confirm-modal .modal-body').html(body);

        $('#confirm-form').attr('action', '/admin/booking-list/' + id + '/update/' + value);
        $('#confirm-form').attr('method', 'POST');

        $('#submit-btn').attr('class', value == 1 ? 'btn btn-primary' : 'btn btn-danger');

        $('#lara-method').val('put');

        $('#confirm-modal').modal('show');
    });

    // Lightbox
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    });

});
</script>

@include('includes.lightbox')
@include('includes.notification')
@include('includes.confirm-modal')

@endpush
