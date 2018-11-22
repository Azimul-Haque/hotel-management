@extends('adminlte::page')

@section('title', 'MeghKabbo | Vacant Room')

@section('content_header')
    <h1>Vacant Confirmation</h1>
@stop

@section('content')
  <div class="row">
    <div class="col-md-6 col-md-offset-3">
      <div class="panel panel-danger">
        <div class="panel-heading">
          Are you sure to vacant the room <u>{{ $reservation->room_name }}</u>?
        </div>
        <div class="panel-body">
          Date: <b>{{ date('F d, Y', strtotime($reservation->date)) }}</b><br/>
          Guest Name: <b>{{ $reservation->name }}</b><br/>
          Email: <b>{{ $reservation->email }}</b><br/>
          Phone: <b>{{ $reservation->phone }}</b><br/>
        </div>
        <div class="panel-footer">
          {!! Form::model($reservation, ['route' => ['reservation.destroy', $reservation->id], 'method' => 'DELETE']) !!}
              <button type="submit" class="btn btn-danger">Yes, Vacate the Room</button>
              <a href="{{ route('dashboard.index') }}" class="btn btn-default float-right" data-dismiss="modal">Cancel</a>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>
@stop