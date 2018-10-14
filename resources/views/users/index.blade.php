@extends('adminlte::page')

@section('title', 'GaanChil | Users')

@section('content_header')
    <h1>Users</h1>
@stop

@section('content')
  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($users as $user)
        <tr>
          <td>{{ $user->name }}</td>
          <td>{{ $user->email }}</td>
          <td>
            asd
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@stop