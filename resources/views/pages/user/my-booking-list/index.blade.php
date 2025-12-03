@extends('layouts.main')

@section('title', 'PT Angkasa Pura Indonesia')
@section('header-title', 'My Booking List')
    
@section('breadcrumbs')
  <div class="breadcrumb-item"><a href="#">Transaksi</a></div>
  <div class="breadcrumb-item active">My Booking List</div>
@endsection

@section('section-title', 'My Booking List')
@section('section-lead')
  Berikut ini adalah daftar seluruh booking yang pernah kamu buat.
@endsection

@section('content')

  @component('components.datatables')
    @slot('buttons')
      <a href="{{ route('my-booking-list.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i>&nbsp;Booking
      </a>
    @endslot
    
    @slot('table_id', 'my-booking-list-table')
    @slot('table_header')
      <tr>
        <th>No</th>
        <th>Foto</th>
        <th>Ruangan</th>
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

    $('#my-booking-list-table').DataTable({
      processing: true,
      serverSide: true,
      ajax: '{{ route('my-booking-list.json') }}',
      columnDefs: [ 
        { targets: [3], orderable: false }, 
        { targets: [4], orderable: true },
        { targets: 6, render: $.fn.dataTable.render.ellipsis(20, true) }, 
      ],
      order: [[4, 'desc']],
      columns: [
        { name: 'DT_RowIndex', data: 'DT_RowIndex', orderable: false, searchable: false },

        { 
          name: 'room.photo',
          data: 'room.photo',
          orderable: false, 
          searchable: false,
          render: function (data) {
            if(data) {
              return `<div class="gallery gallery-fw">
                        <a href="/storage/${data}" data-toggle="lightbox">
                          <img src="/storage/${data}" class="img-fluid" style="min-width: 80px; height: auto;">
                        </a>
                      </div>`;
            } else return '-';
          }
        },

        {
          name: 'room.name',
          data: 'room.name',
          render: function (data, type, row) {
            var result = data + '<div class="table-links">';
            if(row.status === 'PENDING' || row.status === 'DISETUJUI') {
              result += ' <a href="javascript:;" data-id="'+row.id+'" data-title="Batalkan" data-body="Yakin batalkan booking ini?" class="text-danger" id="cancel-btn">Batalkan</a>';
            }
            result += '</div>';
            return result;
          }
        },

        // UNIT — FIXED 
        { 
          name: 'unit', 
          data: 'unit',
          orderable: false,
          searchable: false,
          defaultContent: '-'
        },

        { name: 'date', data: 'date' },
        { name: 'start_time', data: 'start_time' },
        { name: 'end_time', data: 'end_time' },
        { name: 'purpose', data: 'purpose' },

        // KONSUMSI — FIX
        { 
          name: 'konsumsi', 
          data: 'konsumsi',
          render: function(data){
            switch(data){
                case 'snack_box': return 'Snack Box';
                case 'makan_siang': return 'Makan Siang';
                case 'snack_box_makan_siang': return 'Snack Box dan Makan Siang';
                default: return '-';
            }
          }
        },

        // STATUS
        { 
          name: 'status',
          data: 'status',
          render: function (data) {
            let badgeClass = {
              'PENDING': 'info',
              'DISETUJUI': 'primary',
              'DITOLAK': 'danger',
              'EXPIRED': 'warning',
              'BATAL': 'warning',
              'SELESAI': 'success'
            }[data] || 'secondary';

            return `<span class="badge badge-` + badgeClass + `">` + data + `</span>`;
          } 
        },
      ],
    });

    // Modal batal booking
    $(document).on('click', '#cancel-btn', function() {
      var id    = $(this).data('id'); 
      var title = $(this).data('title');
      var body  = $(this).data('body');
      $('.modal-title').html(title);
      $('.modal-body').html(body);
      $('#confirm-form').attr('action', '/my-booking-list/'+id+'/cancel');
      $('#confirm-form').attr('method', 'POST');
      $('#submit-btn').attr('class', 'btn btn-danger');
      $('#lara-method').attr('value', 'put');
      $('#confirm-modal').modal('show');
    });

    // Lightbox foto ruangan
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
