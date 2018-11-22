@extends('adminlte::page')

@section('title', 'MeghKabbo | PNR Search')

@section('content_header')
    <h1>Search Result: {{ $reservations->count() }} reseul(s) found</h1>
@stop

@section('content')
  <div class="row">
    <div class="col-md-8">
      @foreach($reservations as $reservation)
      <div class="box box-success box-custom">
        <div class="box-header with-border text-green">
          <i class="fa fa-tag"></i>
          <h3 class="box-title">PNR: {{ $reservation->pnr }}</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          Guest Info: <b>{{ $reservation->name }}</b>, <i class="fa fa-phone"></i> {{ $reservation->phone }}, <i class="fa fa-envelope-o"></i> {{ $reservation->email }}<br/>
          Room: {{ $reservation->room_name }}<br/>
          Date Reserved: <b><u>{{ date('l, F d, Y', strtotime($reservation->date)) }}</u></b>
        </div>
        <!-- /.box-body -->
      </div>
      @endforeach
    </div>
    <div class="col-md-4">
      
    </div>
  </div>
@stop