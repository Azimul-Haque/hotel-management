@extends('adminlte::page')

@section('title', 'MeghKabbo | Profile')

@section('content_header')
    <h1>Profile</h1>
@stop

@section('content')
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <table class="table table-shadow">
        <tr>
          <td rowspan="3" style="width: 180px;">
            @if($user->image != null || $user->image != '')
            <img src="{{ asset('images/users/'.$user->image) }}" class="img-responsive" style="max-width: 180px; height: auto;">
            @else
            <img src="{{ asset('images/user.png') }}" class="img-responsive" style="max-width: 180px; height: auto;">
            @endif
          </td>
          <td>{{ $user->name }}</td>
        </tr>
        <tr>
          <td>{{ $user->email }}</td>
        </tr>
        <tr>
          <td>Created: {{ date('F d, Y', strtotime($user->created_at)) }}</td>
        </tr>
      </table>
    </div>
  </div>
@stop