@extends('layouts.main')

@section('title')
  Buat Booking - ROOMING
@endsection 

@section('header-title')
  Buat Booking
@endsection 
    
@section('breadcrumbs')
  <div class="breadcrumb-item"><a href="#">Transaksi</a></div>
  <div class="breadcrumb-item"><a href="{{ route('my-booking-list.index') }}">My Booking</a></div>
  <div class="breadcrumb-item active">
    Buat Booking
  </div>
@endsection

@section('section-title')
  Buat Booking
@endsection 
    
@section('section-lead')
  Silakan isi form di bawah ini untuk membuat booking.
@endsection

@section('content')

  @component('components.form')
    @slot('row_class', 'justify-content-center')
    @slot('col_class', 'col-12 col-md-6')
    
    @slot('form_method', 'POST')
    @slot('form_action', 'my-booking-list.store')

    @slot('input_form')

      {{-- Nama Ruangan --}}
      @component('components.input-field')
          @slot('input_label', 'Nama Ruangan')
          @slot('input_type', 'select')
          @slot('select_content')
            <option value="">Pilih Ruangan</option>
            @foreach ($rooms as $room)
            <option value="{{ $room->id }}"
                {{ old('room_id') == $room->id ? 'selected' : '' }}>
                {{ $room->name }}</option>
            @endforeach
          @endslot
          @slot('input_name', 'room_id')
          @slot('form_group_class', 'required')
          @slot('other_attributes', 'required autofocus')
      @endcomponent

      {{-- UNIT --}}
@component('components.input-field')
    @slot('input_label', 'Unit')
    @slot('input_type', 'select')
    @slot('select_content')
        <option value="">Pilih Unit</option>
        <option value="General Manager">General Manager</option>
        <option value="Airport Operation Center Head">Airport Operation Center Head</option>
        <option value="Airport Quality & Safety Management System Departement Head">Airport Quality & Safety Management System Departement Head</option>
        <option value="Branch Communication & CSR Departement Head">Branch Communication & CSR Departement Head</option>
        <option value="Legal & Compliance Departement Head">Legal & Compliance Departement Head</option>
        <option value="Asset Management & General Services Departement Head">Asset Management & General Services Departement Head</option>
        <option value="Airport Operation, Service, & Security Division Head">Airport Operation, Service, & Security Division Head</option>
        <option value="Airport Operation Airside Departement Head">Airport Operation Airside Departement Head</option>
        <option value="Airport Operation Landside & Terminal Services Departement Head">Airport Operation Landside & Terminal Services Departement Head</option>
        <option value="Airport Rescue & Fire Fighting Departement Head">Airport Rescue & Fire Fighting Departement Head</option>
        <option value="Airport Security Departement Head">Airport Security Departement Head</option>
        <option value="Airport Technical Division Head">Airport Technical Division Head</option>
        <option value="Airport Facilities Departement Head">Airport Facilities Departement Head</option>
        <option value="Airport Equipment Departement Head">Airport Equipment Departement Head</option>
        <option value="Airport Technology Departement Head">Airport Technology Departement Head</option>
        <option value="Airport Commercial Division Head">Airport Commercial Division Head</option>
        <option value="Aero Commercial Departement Head">Aero Commercial Departement Head</option>
        <option value="Non Aero Commercial Departement Head">Non Aero Commercial Departement Head</option>
    @endslot
    @slot('input_name', 'unit')
    @slot('form_group_class', 'required')
    @slot('other_attributes', 'required')
@endcomponent



      {{-- Tanggal Booking --}}
      @component('components.input-field')
          @slot('input_label', 'Tanggal Booking')
          @slot('input_type', 'text')
          @slot('input_name', 'date')
          @slot('input_classes', 'datepicker')
          @slot('form_group_class', 'required')
          @slot('other_attributes', 'required')
      @endcomponent

      {{-- Waktu Mulai --}}
      @component('components.input-field')
          @slot('form_row', 'open')
          @slot('col', 'col-md-6')
          @slot('input_label', 'Waktu Mulai')
          @slot('input_type', 'text')
          @slot('input_id', 'start_time')
          @slot('input_name', 'start_time')
          @slot('placeholder', 'HH:mm')
          @slot('input_classes', 'timepicker')
          @slot('form_group_class', 'col required')
          @slot('other_attributes', 'required')
      @endcomponent

      {{-- Waktu Selesai --}}
      @component('components.input-field')
          @slot('form_row', 'close')
          @slot('col', 'col-md-6')
          @slot('input_label', 'Waktu Selesai')
          @slot('input_type', 'text')
          @slot('input_id', 'end_time')
          @slot('input_name', 'end_time')
          @slot('placeholder', 'HH:mm')
          @slot('input_classes', 'timepicker')
          @slot('form_group_class', 'col required')
          @slot('other_attributes', 'required')
      @endcomponent

      {{-- Keperluan --}}
      @component('components.input-field')
          @slot('input_label', 'Keperluan')
          @slot('input_type', 'text')
          @slot('input_name', 'purpose')
          @slot('form_group_class', 'required')
          @slot('other_attributes', 'required')
      @endcomponent

      {{-- Konsumsi --}}
      @component('components.input-field')
          @slot('input_label', 'Konsumsi')
          @slot('input_type', 'select')
          @slot('select_content')
            <option value="">Pilih Konsumsi</option>
            <option value="snack_box" {{ old('konsumsi')=='snack_box' ? 'selected' : '' }}>Snack Box</option>
            <option value="makan_siang" {{ old('konsumsi')=='makan_siang' ? 'selected' : '' }}>Makan Siang</option>
            <option value="snack_box_makan_siang" {{ old('konsumsi')=='snack_box_makan_siang' ? 'selected' : '' }}>
              Snack Box dan Makan Siang
            </option>
          @endslot
          @slot('input_name', 'konsumsi')
          @slot('form_group_class', 'required')
          @slot('other_attributes', 'required')
      @endcomponent

    @endslot

    @slot('card_footer', 'true')
    @slot('card_footer_class', 'text-right')
    @slot('card_footer_content')
      @include('includes.save-cancel-btn')
    @endslot 

  @endcomponent

@endsection

@push('after-style')
  {{-- datepicker  --}}
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endpush

@push('after-script')
  {{-- datepicker  --}}
  <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
@endpush

@include('includes.notification')
