@extends('adminlte::page')

@section('title', 'MeghKabbo | Blackout Days')

@section('css')
  <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
@stop

@section('content_header')
    <h1>Blackout Days</h1>
@stop

@php $flagModal = 1; @endphp
@section('content')
  <div class="row">
    <div class="col-md-4">
      <div class="box box-warning box-custom">
        <div class="box-header with-border text-yellow">
          <i class="fa fa-calendar-times-o"></i>
          <h3 class="box-title">Add a new Blackout Day</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          {!! Form::open(['route' => 'dashboard.blackout.store', 'method' => 'post']) !!}
            <div class="form-group">
              {!! Form::text('occasion', null, array('class' => 'form-control text-yellow', 'required' => '', 'placeholder' => 'Write Occasion', 'autocomplete' => 'off')) !!}
            </div>
            <div class="form-group">
              {!! Form::text('date', null, array('class' => 'form-control text-yellow', 'required' => '', 'placeholder' => 'Select Date', 'id' => 'blackoutDay', 'autocomplete' => 'off')) !!}
            </div>
            <button class="btn btn-warning" type="submit"><i class="fa fa-fw fa-plus" aria-hidden="true"></i> Save</button>
          {!! Form::close() !!}
        </div>
        <!-- /.box-body -->
      </div>
    </div>
    <div class="col-md-8">
      <div class="table-responsive">
        <table class="table" id="datatable-blackouts">
          <thead>
            <tr>
              <th>Occation</th>
              <th>Date</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($blackouts as $blackout)
            <tr>
              <td>
                {{ $blackout->occasion }}
              </td>
              <td>
                {{ date('F d, Y', strtotime($blackout->date)) }}
              </td>
              <td>
                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal{{ $blackout->id }}" data-backdrop="static"><i class="fa fa-edit"></i></button>
                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $blackout->id }}" data-backdrop="static"><i class="fa fa-trash"></i></button>
              </td>
              {{-- edit Modal --}}
              <div class="modal fade" id="editModal{{ $blackout->id }}" role="dialog">
                <div class="modal-dialog modal-md">
                  <div class="modal-content">
                    <div class="modal-header modal-header-warning">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">
                        <i class="fa fa-calendar-times-o" aria-hidden="true"></i>
                        Edit Blackout Day
                      </h4>
                    </div>
                    <div class="modal-body">
                    {!! Form::model($blackout, ['route' => ['dashboard.blackout.update', $blackout->id], 'method' => 'PUT']) !!}
                      <div class="form-group">
                        {!! Form::text('occasion', null, array('class' => 'form-control text-yellow', 'required' => '', 'placeholder' => 'Write Occasion', 'id' => 'fromusageDate', 'autocomplete' => 'off')) !!}
                      </div>
                      <div class="form-group">
                        {!! Form::text('date', date('F d, Y', strtotime($blackout->date)), array('class' => 'form-control text-yellow', 'required' => '', 'placeholder' => 'Select Date', 'id' => 'blackoutDay'.$blackout->id, 'autocomplete' => 'off')) !!}
                      </div>
                    </div>
                    <div class="modal-footer">
                        {!! Form::submit('Save', array('class' => 'btn btn-warning')) !!}
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                    {!! Form::close() !!} 
                  </div>
                </div>
              </div>
              {{-- edit Modal --}}

              {{-- delete Modal --}}
              <div class="modal fade" id="deleteModal{{ $blackout->id }}" role="dialog">
                <div class="modal-dialog modal-md">
                  <div class="modal-content">
                    <div class="modal-header modal-header-danger">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">
                        <i class="fa fa-calendar-times-o" aria-hidden="true"></i>
                        Confirm to delete blackout day?
                      </h4>
                    </div>
                    <div class="modal-body">
                      Occation: <b>{{ $blackout->occasion }}</b><br/>
                      Date: <b>{{ date('F d, Y', strtotime($blackout->date)) }}</b>
                    </div>
                    <div class="modal-footer">
                        {!! Form::model($blackout, ['route' => ['dashboard.blackout.delete', $blackout->id], 'method' => 'DELETE']) !!}
                            <button type="submit" class="btn btn-danger">Delete</button>
                        {!! Form::close() !!}
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                    {!! Form::close() !!} 
                  </div>
                </div>
              </div>
              {{-- delete Modal --}}
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@stop

@section('js')
<script type="text/javascript" src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">
  $(function() {
    $("#blackoutDay").datepicker({
      format: 'MM dd, yyyy',
      todayHighlight: true,
      autoclose: true,
      Readonly: true,
      orientation: 'auto bottom',
    }).attr("readonly", "readonly");
  });
</script>
@foreach($blackouts as $blackout)
  <script type="text/javascript">
    $(function() {
      $("#blackoutDay{{ $blackout->id }}").datepicker({
        format: 'MM dd, yyyy',
        todayHighlight: true,
        autoclose: true,
        Readonly: true,
        orientation: 'auto bottom',
      }).attr("readonly", "readonly");
    });
  </script>

  @if ((count($errors) > 0) && ($flagModal == 1))
    <script>
        $( document ).ready(function() {
            $('#editModal{{ $blackout->id }}').modal('show');
        });
    </script>
    @php $flagModal = 0; @endphp
  @endif
@endforeach
<script type="text/javascript">
  $(function () {
    //$.fn.dataTable.moment('DD MMMM, YYYY hh:mm:ss tt');
    $('#datatable-blackouts').DataTable({
      'paging'      : true,
      'pageLength'  : 8,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true,
      'order': [[ 1, "desc" ]],
       columnDefs: [
              { targets: [2], visible: true, searchable: false},
              { targets: '_all', visible: true, searchable: true },
              { targets: [1], type: 'date'}
       ]
    });
    $('#datatable-commodities_wrapper').removeClass( 'form-inline' );
  })
</script>

@stop