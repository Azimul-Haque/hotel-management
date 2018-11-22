@extends('adminlte::page')

@section('title', 'MeghKabbo | Statement Reports')

@section('css')
  <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
@stop

@section('content_header')
    <h1>Reports</h1>
@stop

@section('content')
  <div class="row">
    <div class="col-md-4">
      <div class="box box-success box-custom">
        <div class="box-header with-border text-green">
          <i class="fa fa-file-pdf-o"></i>
          <h3 class="box-title">Date Range Report</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          {!! Form::open(['route' => 'dashboard.rangestatement', 'method' => 'get', 'target' => '_blank']) !!}
            <div class="form-group">
              {!! Form::text('from', null, array('class' => 'form-control text-green', 'required' => '', 'placeholder' => 'Select from date', 'id' => 'fromDate', 'autocomplete' => 'off')) !!}
            </div>
            <div class="form-group">
              {!! Form::text('to', null, array('class' => 'form-control text-green', 'required' => '', 'placeholder' => 'Select to date', 'id' => 'toDate', 'autocomplete' => 'off')) !!}
            </div>
            <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-file-pdf-o" aria-hidden="true"></i> Get Report</button>
          {!! Form::close() !!}
        </div>
        <!-- /.box-body -->
      </div>
    </div>
    <div class="col-md-4">
      <div class="box box-primary box-custom">
        <div class="box-header with-border text-blue">
          <i class="fa fa-file-pdf-o"></i>
          <h3 class="box-title">Monthly Report</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          {!! Form::open(['route' => 'dashboard.monthstatement', 'method' => 'get', 'target' => '_blank']) !!}
            <div class="form-group">
              <select class="form-control text-blue" name="month" required="">
                <option value="" selected="" disabled="">Select Month</option>
                @foreach($reservation_months as $month)
                  <option value="{{ date('Y-m', strtotime($month->date)) }}">{{ date('F Y', strtotime($month->date)) }}</option>
                @endforeach 
              </select>
            </div>
            <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-file-pdf-o" aria-hidden="true"></i> Get Report</button>
          {!! Form::close() !!}
        </div>
        <!-- /.box-body -->
      </div>
    </div>
    <div class="col-md-4">
      <div class="box box-warning box-custom">
        <div class="box-header with-border text-yellow">
          <i class="fa fa-file-pdf-o"></i>
          <h3 class="box-title">Room wise Monthly Report</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          {!! Form::open(['route' => 'dashboard.roomwisetatement', 'method' => 'get', 'target' => '_blank']) !!}
            <div class="form-group">
              <select class="form-control text-yellow" name="room_name" required="">
                <option value="" selected="" disabled="">Select Room Name</option>
                <option value="G1 (Group)">G1 (Group)</option>
                <option value="G2 (Group)">G2 (Group)</option>
                <option value="101 (Family)">101 (Family)</option>
                <option value="102 (Couple)">102 (Couple)</option>
                <option value="103 (Couple)">103 (Couple)</option>
                <option value="201 (Couple)">201 (Couple)</option>
                <option value="202 (Couple)">202 (Couple)</option>
                <option value="203 (Couple)">203 (Couple)</option>
                <option value="301 (E. Double)">301 (E. Double)</option>
                <option value="302 (Double)">302 (Double)</option>
                <option value="303 (Triple)">303 (Triple)</option>
              </select>
            </div>
            <div class="form-group">
              <select class="form-control text-yellow" name="month" required="">
                <option value="" selected="" disabled="">Select Month</option>
                @foreach($reservation_months as $month)
                  <option value="{{ date('Y-m', strtotime($month->date)) }}">{{ date('F Y', strtotime($month->date)) }}</option>
                @endforeach 
              </select>
            </div>
            <button class="btn btn-warning" type="submit"><i class="fa fa-fw fa-file-pdf-o" aria-hidden="true"></i> Get Report</button>
          {!! Form::close() !!}
        </div>
        <!-- /.box-body -->
      </div>
    </div>
  </div>
@stop

@section('js')
<script type="text/javascript" src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">
  $(function() {
    $("#toDate").datepicker({
      format: 'MM dd, yyyy',
      todayHighlight: true,
      autoclose: true,
      Readonly: true,
      orientation: 'auto bottom',
    }).attr("readonly", "readonly");
    $("#fromDate").datepicker({
      format: 'MM dd, yyyy',
      todayHighlight: true,
      autoclose: true,
      Readonly: true,
      orientation: 'auto bottom',
    }).attr("readonly", "readonly");
  });
</script>
@stop