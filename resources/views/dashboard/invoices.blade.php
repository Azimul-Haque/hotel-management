@extends('adminlte::page')

@section('title', 'MeghKabbo | Invoice Generation')

@section('css')
  <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('vendor/adminlte/plugins/iCheck/square/blue.css') }}">
@stop

@section('content_header')
    <h1>Invoice Generation</h1>
@stop

@php $flagModal = 1; @endphp
@section('content')
  <div class="row">
    <div class="col-md-7">
      <div class="table-responsive">
        <table class="table" id="datatable-reservations">
          <thead>
            <tr>
              <th></th>
              <th>Room Name</th>
              <th>Date Enjoyed</th>
              <th>Guest Name</th>
              <th>PNR</th>
            </tr>
          </thead>
          <tbody>
            @foreach($reservations as $reservation)
            <tr>
              <td><input type="checkbox" class="icheck" id="checkreservation{{ $reservation->id }}"></td>
              <td>{{ $reservation->room_name }}</td>
              <td>{{ date('D, M d, Y', strtotime($reservation->date)) }}</td>
              <td>{{ $reservation->name }}</td>
              <td><b>{{ $reservation->pnr }}</b></td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    <div class="col-md-5">
      <div class="box box-success box-custom">
        <div class="box-header with-border text-green">
          <i class="fa fa-file-pdf-o"></i>
          <h3 class="box-title">Generate Invoice</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          {!! Form::open(['route' => 'dashboard.generateinvoice', 'method' => 'get', 'target' => '_blank']) !!}
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <strong>Guest Name:</strong>
                  {!! Form::text('name', null, array('class' => 'form-control text-green', 'required' => '', 'placeholder' => 'Guest Name', 'id' => 'name', 'autocomplete' => 'off')) !!}
                  {!! Form::hidden('pnr', null, ['id' => 'pnr']) !!}
                  {!! Form::hidden('email', null, ['id' => 'email']) !!}
                  {!! Form::hidden('phone', null, ['id' => 'phone']) !!}
                  {!! Form::hidden('room_type', null, ['id' => 'room_type']) !!}
                  {!! Form::hidden('checkin', null, ['id' => 'checkin']) !!}
                  {!! Form::hidden('checkout', null, ['id' => 'checkout']) !!}
                  {!! Form::hidden('discount_tk_or_percentage', null, ['id' => 'discount_tk_or_percentage_hidden']) !!}

                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <strong>Booked by:</strong>
                  {!! Form::text('booked_by', null, array('class' => 'form-control text-green', 'required' => '', 'placeholder' => 'Booked by', 'id' => 'booked_by', 'autocomplete' => 'off')) !!}
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <strong>Room Price:</strong>
                  {!! Form::text('price', null, array('class' => 'form-control text-green', 'required' => '', 'placeholder' => 'Room Price', 'id' => 'price', 'autocomplete' => 'off')) !!}
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <strong>Discount:</strong>
                  <div class="input-group">
                    {!! Form::text('discount', null, array('class' => 'form-control text-green', 'required' => '', 'placeholder' => 'Discount', 'id' => 'discount', 'autocomplete' => 'off')) !!}
                    <span class="input-group-addon" id="discount_tk_or_percentage"></span>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <strong>Advanced/ Paid:</strong>
                  {!! Form::text('advance', null, array('class' => 'form-control text-green', 'required' => '', 'placeholder' => 'Advanced/ Paid', 'id' => 'advance', 'autocomplete' => 'off')) !!}
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <strong>Due:</strong>
                  {!! Form::text('due', null, array('class' => 'form-control text-green', 'required' => '', 'placeholder' => 'Due', 'id' => 'due', 'autocomplete' => 'off')) !!}
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <strong>Payment Method:</strong>
                  <select name="payment_method" class="form-control" required="">
                    <option value="" selected="" disabled="">Select Payment Method</option>
                    <option value="bKash-Dhaka">bKash-Dhaka</option>
                    <option value="bKash-Sajek">bKash-Sajek</option>
                    <option value="Bank Acc.">Bank Acc.</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <strong>Note/ Promo offer:</strong>
                {!! Form::textarea('note', null, array('class' => 'form-control text-green', 'placeholder' => 'Note/ Promo offer', 'id' => 'note', 'style' => 'resize:none; height:100px;')) !!}
              </div>
            </div>
            <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-file-pdf-o" aria-hidden="true"></i> Get Report</button>
          {!! Form::close() !!}
        </div>
        <!-- /.box-body -->
      </div>
    </div>
  </div>
@stop

@section('js')
<script type="text/javascript" src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/dateformat.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/adminlte/plugins/iCheck/icheck.js') }}"></script>
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
<script>
  $(document).ready(function(){
    $('.icheck').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      increaseArea: '20%' // optional
    });
    $('.icheck').on('ifChanged', function (event) { $(event.target).trigger('change'); });

    var room_type = [];
    var checkin_out = [];
    @foreach($reservations as $reservation)
      $(document).on('change', 'input[Id="checkreservation{{ $reservation->id }}"]', function (e) {
         if(this.checked) {
          console.log('{{ $reservation->name }}');
          if($('#name').val() == '') {
            $('#name').val('{{ $reservation->name }}');
            $('#pnr').val('{{ $reservation->pnr }}');
            $('#email').val('{{ $reservation->email }}');
            $('#phone').val('{{ $reservation->phone }}');
            $('#booked_by').val('{{ $reservation->booked_by }}');
            $('#discount_tk_or_percentage').text('{{ $reservation->discount_tk_or_percentage }}');
            $('#discount_tk_or_percentage_hidden').val('{{ $reservation->discount_tk_or_percentage }}');
          } // checkin checkout room_type

          room_type.push('{{ $reservation->room_name }}');
          var unique_room_type = [];
          unique_room_type = room_type.filter(function(item, pos) {
              return room_type.indexOf(item) == pos;
          })
          $('#room_type').val(unique_room_type);

          checkin_out.push('{{ $reservation->date }}');
          var unique_checkin_out = [];
          unique_checkin_out = checkin_out.filter(function(item, pos) {
              return checkin_out.indexOf(item) == pos;
          })
          unique_checkin_out.sort();
          $('#checkin').val(unique_checkin_out[0]);
          var checkout_add_one = new Date(unique_checkin_out[unique_checkin_out.length-1]);
          checkout_add_one.setDate(checkout_add_one.getDate() + 1); 
          $('#checkout').val(dateFormat(checkout_add_one, 'yyyy-mm-dd HH:MM:ss'));
          console.log(unique_checkin_out[unique_checkin_out.length-1]);


          $('#price').val(addOne($('#price').val(), {{ $reservation->price }}));
          $('#discount').val(addOne($('#discount').val(), {{ $reservation->discount }}));
          $('#advance').val(addOne($('#advance').val(), {{ $reservation->advance }}));
          $('#due').val(addOne($('#due').val(), {{ $reservation->due }}));

        } else {
          console.log('unchecked: {{ $reservation->name }}');
          $('#price').val(subOne($('#price').val(), {{ $reservation->price }}));
          $('#discount').val(subOne($('#discount').val(), {{ $reservation->discount }}));
          $('#advance').val(subOne($('#advance').val(), {{ $reservation->advance }}));
          $('#due').val(subOne($('#due').val(), {{ $reservation->due }}));

          var index_room_type = room_type.indexOf('{{ $reservation->room_name }}');
          if (index_room_type !== -1) room_type.splice(index_room_type, 1);
          $('#room_type').val(room_type);

          var index_checkin_out = checkin_out.indexOf('{{ $reservation->date }}');
          if (index_checkin_out !== -1) checkin_out.splice(index_checkin_out, 1);
          var unique_checkin_out = [];
          unique_checkin_out = checkin_out.filter(function(item, pos) {
              return checkin_out.indexOf(item) == pos;
          })
          unique_checkin_out.sort();

          if (unique_checkin_out === undefined || unique_checkin_out.length == 0) {
            $('#checkin').val('');
            $('#checkout').val('');
          } else {
            $('#checkin').val(unique_checkin_out[0]);
            var checkout_add_one = new Date(unique_checkin_out[unique_checkin_out.length-1]);
            checkout_add_one.setDate(checkout_add_one.getDate() + 1); 
            $('#checkout').val(dateFormat(checkout_add_one, 'yyyy-mm-dd HH:MM:ss'));
          }
          console.log(unique_checkin_out[0]);
          console.log(unique_checkin_out[unique_checkin_out.length-1]);
        }
      });
    @endforeach


    function addOne(totalval, newval) {
      totalval = (parseInt(totalval) || 0) + parseInt(newval);
      return totalval;
    }
    function subOne(totalval, newval) {
      totalval = (parseInt(totalval) || 0) - parseInt(newval);
      return totalval;
    }
  });
</script>
<script type="text/javascript">
  $(function () {
    //$.fn.dataTable.moment('DD MMMM, YYYY hh:mm:ss tt');
    $('#datatable-reservations').DataTable({
      'paging'      : true,
      'pageLength'  : 10,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true,
      'order': [[ 2, "desc" ]],
       columnDefs: [
              { targets: [2], type: 'date'}
       ]
    });
    $('#datatable-commodities_wrapper').removeClass( 'form-inline' );
  })
</script>
@stop