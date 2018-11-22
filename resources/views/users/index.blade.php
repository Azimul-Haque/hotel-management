@extends('adminlte::page')

@section('title', 'MeghKabbo | Users')

@section('css')
<script src="{{ asset('vendor/adminlte/vendor/jquery/dist/jquery.min.js') }}"></script>
@stop

@section('content_header')
    <h1>Users
        <div class="pull-right">
          <button class="btn btn-success" data-toggle="modal" data-target="#addUserModal" data-backdrop="static"> Create New User</button>
        </div>
    </h1>
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
            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#editMemberModal{{ $user->id }}" data-backdrop="static"><i class="fa fa-pencil" aria-hidden="true"></i></button>
            <!-- Trigger the modal with a button -->
            {{-- edit modal--}}
            <div class="modal fade" id="editMemberModal{{ $user->id }}" role="dialog">
              <div class="modal-dialog modal-md">
                <div class="modal-content">
                  <div class="modal-header modal-header-success">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit <b>{{ $user->name }}</b></h4>
                  </div>
                  <div class="modal-body">
                    {!! Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'PUT', 'class' => 'form-default', 'enctype' => 'multipart/form-data']) !!}
                      <div class="form-group">
                          <strong>Name:</strong>
                          {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control', 'required' => '')) !!}
                      </div>
                      <div class="form-group">
                          <strong>Email:</strong>
                          {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control', 'required' => '')) !!}
                      </div>
                      <div class="form-group">
                          <strong>Password:</strong>
                          {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control', 'required' => '')) !!}
                      </div>
                      <div class="form-group">
                          <strong>Confirm Password:</strong>
                          {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control', 'required' => '')) !!}
                      </div>
                      <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label><strong>Photo (300 X 300 &amp; 200Kb Max):</strong></label>
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <span class="btn btn-default btn-file">
                                            Browse <input type="file" id="editimage{{ $user->id }}" name="image">
                                        </span>
                                    </span>
                                    <input type="text" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                          <center>
                            @if($user->image != null)
                            <img src="{{ asset('images/users/'.$user->image)}}" id='img-update{{ $user->id }}' style="height: 120px; width: auto; padding: 5px;" />
                            @else
                              <img src="{{ asset('images/user.png')}}" id='img-update{{ $user->id }}' style="height: 120px; width: auto; padding: 5px;" />
                            @endif
                          </center>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                        {!! Form::submit('Save', array('class' => 'btn btn-success')) !!}
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                  {!! Form::close() !!}
                </div>
              </div>
            </div>
            <script type="text/javascript">
              $(document).ready( function() {
                $(document).on('change', '.btn-file :file', function() {
                  var input = $(this),
                      label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                  input.trigger('fileselect', [label]);
                });

                $('.btn-file :file').on('fileselect', function(event, label) {
                    var input = $(this).parents('.input-group').find(':text'),
                        log = label;
                    if( input.length ) {
                        input.val(log);
                    } else {
                        if( log ) alert(log);
                    }
                });
                $("#editimage{{ $user->id }}").change(function(){
                    readUpdateURL(this);
                    var filesize = parseInt((this.files[0].size)/1024);
                    if(filesize > 200) {
                      $("#editimage{{ $user->id }}").val('');
                      toastr.warning('File size is: '+filesize+' Kb. try uploading less than 200Kb', 'WARNING').css('width', '400px;');
                        setTimeout(function() {
                          $("#img-update{{ $user->id }}").attr('src', '{{ asset('images/user.png') }}');
                        }, 1000);
                    }
                });
                function readUpdateURL(input) {
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            $('#img-update{{ $user->id }}').attr('src', e.target.result);
                        }
                        reader.readAsDataURL(input.files[0]);
                    }
                }
              });
            </script>
            {{-- edit modal--}}

            {{-- delete modal--}}
            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $user->id }}" data-backdrop="static"><i class="fa fa-trash" aria-hidden="true"></i></button>
            <!-- Trigger the modal with a button -->
            <!-- Modal -->
            <div class="modal fade" id="deleteModal{{ $user->id }}" role="dialog">
              <div class="modal-dialog modal-md">
                <div class="modal-content">
                  <div class="modal-header modal-header-danger">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Delete Confirmation</h4>
                  </div>
                  <div class="modal-body">
                    Delete user <big><b>{{ $user->name }}</b></big>?
                  </div>
                  <div class="modal-footer">
                    {!! Form::model($user, ['route' => ['users.destroy', $user->id], 'method' => 'DELETE']) !!}
                        <button type="submit" class="btn btn-danger">Delete</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    {!! Form::close() !!}
                  </div>
                </div>
              </div>
            </div>
            {{-- delete modal--}}
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  {{-- add user Modal --}}
  <div class="modal fade" id="addUserModal" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header modal-header-success">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">
            Add new user
          </h4>
        </div>
        <div class="modal-body">
          {!! Form::open(array('route' => 'users.store','method'=>'POST', 'enctype' => 'multipart/form-data')) !!}
            <div class="form-group">
                <strong>Name:</strong>
                {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control', 'required' => '')) !!}
            </div>
            <div class="form-group">
                <strong>Email:</strong>
                {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control', 'required' => '')) !!}
            </div>
            <div class="form-group">
                <strong>Password:</strong>
                {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control', 'required' => '')) !!}
            </div>
            <div class="form-group">
                <strong>Confirm Password:</strong>
                {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control', 'required' => '')) !!}
            </div>
            <div class="row">
              <div class="col-md-8">
                  <div class="form-group">
                      <label><strong>Photo (300 X 300 &amp; 200Kb Max):</strong></label>
                      <div class="input-group">
                          <span class="input-group-btn">
                              <span class="btn btn-default btn-file">
                                  Browse <input type="file" id="image" name="image">
                              </span>
                          </span>
                          <input type="text" class="form-control" readonly>
                      </div>
                  </div>
              </div>
              <div class="col-md-4">
                <center>
                  <img src="{{ asset('images/user.png')}}" id='img-upload' style="height: 120px; width: auto; padding: 5px;" />
                </center>
              </div>
            </div>
          </div>
          <div class="modal-footer">
              {!! Form::submit('Save', array('class' => 'btn btn-success')) !!}
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>
  {{-- add user Modal --}}
@stop

@section('js')
  <script type="text/javascript">
      $(document).ready( function() {
        $(document).on('change', '.btn-file :file', function() {
          var input = $(this),
              label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
          input.trigger('fileselect', [label]);
        });

        $('.btn-file :file').on('fileselect', function(event, label) {
            var input = $(this).parents('.input-group').find(':text'),
                log = label;
            if( input.length ) {
                input.val(log);
            } else {
                if( log ) alert(log);
            }
        });
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#img-upload').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#image").change(function(){
            readURL(this);
            var filesize = parseInt((this.files[0].size)/1024);
            if(filesize > 200) {
              $("#image").val('');
              toastr.warning('File size is: '+filesize+' Kb. try uploading less than 200Kb', 'WARNING').css('width', '400px;');
                setTimeout(function() {
                  $("#img-upload").attr('src', '{{ asset('images/user.png') }}');
                }, 1000);
            }
        });

      });
  </script>
@stop