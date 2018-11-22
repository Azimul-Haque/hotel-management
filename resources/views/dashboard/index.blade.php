@extends('adminlte::page')

@section('title', 'MeghKabbo | Dashboard')

@section('css')
  <link rel="stylesheet" type="text/css" href="{{ asset('css/dashboard.css') }}">
  <script src="{{ asset('vendor/adminlte/vendor/jquery/dist/jquery.min.js') }}"></script>
  {!!Html::style('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css')!!}
@stop

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
<div class="table-fixed-left">
  <table class="table-fixed-left-side">
    <tr>
      <th>Date</th>
    </tr>
    <tr>
      <th style="background: #d1c4e9;" data-placement="right" title="101 Super Twin Double Bed">101 Super Twin D. Bed</th>
    </tr>
    <tr>
      <th style="background: #d1c4e9;" data-placement="right" title="102 Seper Group Bed">102 Super Group Bed</th>
    </tr>
    <tr>
      <th style="background: #f0f4c3;" data-placement="right" title="201 Deluxe Family Bed">201 Deluxe Family Bed</th>
    </tr>
    <tr>
      <th style="background: #00e676;" data-placement="right" title="202 Deluxe Couple Bed">202 Deluxe Couple Bed</th>
    </tr>
    <tr>
      <th style="background: #00e676;" data-placement="right" title="203 Deluxe Couple Bed">203 Deluxe Couple Bed</th>
    </tr>
    <tr>
      <th style="background: #00e676;" data-placement="right" title="301 Deluxe Couple Bed">301 Deluxe Couple Bed</th>
    </tr>
    <tr>
      <th style="background: #00e676;" data-placement="right" title="302 Deluxe Couple Bed">302 Deluxe Couple Bed</th>
    </tr>
    <tr>
      <th style="background: #00e676;" data-placement="right" title="303 Deluxe Couple Bed">303 Deluxe Couple Bed</th>
    </tr>
    <tr>
      <th style="background: #ccff90;" data-placement="right" title="401 Executive Twin Double Bed">401 E. Twin Double Bed</th>
    </tr>
    <tr>
      <th style="background: #795548; color: #fff;" data-placement="right" title="402 Deluxe Twin Double Bed">402 Deluxe Twin D. Bed</th>
    </tr>
    <tr>
      <th style="background: #795548; color: #fff;" data-placement="right" title="403 Deluxe Triple Bed">403 Deluxe T. Bed</th>
    </tr>
  </table>
</div>
<div class="table-fixed-right" id="MyDiv">
  <table class="table-fixed-right-side">
    <tr>
      @for($j=-15; $j<16;$j++)
      <td>
        @if(date('F d, Y', strtotime(Carbon::today()->addDays($j))) == date('F d, Y'))
            <center><b style="letter-spacing: 2px; margin: 0px 25px 0px 25px;">Today</b></center>
          @else
            {{ date('D, M d, Y', strtotime(Carbon::today()->addDays($j))) }}
          @endif
      </td>
      @endfor
    </tr>
    @for($i=0; $i<11;$i++)
    <tr>
      @for($j=-15; $j<16;$j++)
        @php 
          $availability = 'Available';
          if((date('l', strtotime(Carbon::today()->addDays($j))) == 'Friday') || date('l', strtotime(Carbon::today()->addDays($j))) == 'Saturday') {
            $css = 'background: #e6e6e6;';
          } else {
            $css = '';
          }
          if(Carbon::today()->addDays($j) < Carbon::today()) {
            $availability = 'N/A';
          }
          $reservation_data = null;

          $blackout_day_occation = '';
          $room_name = '';
          $unique_key = '';

          if($i == 0) {
              $room_name = '101 Super Twin Double Bed';
              $unique_key = $i.'_g1_'.date('d_m_Y', strtotime(Carbon::today()->addDays($j)));
          } elseif($i == 1) {
              $room_name = '102 Super Group Bed';
              $unique_key = $i.'_g2_'.date('d_m_Y', strtotime(Carbon::today()->addDays($j)));
          } elseif($i == 2) {
              $room_name = '201 Deluxe Family Bed';
              $unique_key = $i.'_101_'.date('d_m_Y', strtotime(Carbon::today()->addDays($j)));
          } elseif($i == 3) {
              $room_name = '202 Deluxe Couple Bed';
              $unique_key = $i.'_102_'.date('d_m_Y', strtotime(Carbon::today()->addDays($j)));
          } elseif($i == 4) {
              $room_name = '203 Deluxe Couple Bed';
              $unique_key = $i.'_103_'.date('d_m_Y', strtotime(Carbon::today()->addDays($j)));
          } elseif($i == 5) {
              $room_name = '301 Deluxe Couple Bed';
              $unique_key = $i.'_201_'.date('d_m_Y', strtotime(Carbon::today()->addDays($j)));
          } elseif($i == 6) {
              $room_name = '302 Deluxe Couple Bed';
              $unique_key = $i.'_202_'.date('d_m_Y', strtotime(Carbon::today()->addDays($j)));
          } elseif($i == 7) {
              $room_name = '303 Deluxe Couple Bed';
              $unique_key = $i.'_203_'.date('d_m_Y', strtotime(Carbon::today()->addDays($j)));
          } elseif($i == 8) {
              $room_name = '401 Executive Twin Double Bed';
              $unique_key = $i.'_301_'.date('d_m_Y', strtotime(Carbon::today()->addDays($j)));
          } elseif($i == 9) {
              $room_name = '402 Deluxe Twin Double Bed';
              $unique_key = $i.'_302_'.date('d_m_Y', strtotime(Carbon::today()->addDays($j)));
          } elseif($i == 10) {
              $room_name = '403 Deluxe Triple Bed';
              $unique_key = $i.'_303_'.date('d_m_Y', strtotime(Carbon::today()->addDays($j)));
          }
        @endphp
        @foreach($blackouts as $blackout)
          @php 
          if($blackout->date == Carbon::today()->addDays($j)) {
            $css = 'background: #FFC2C8; color: #004d40;';
            $blackout_day_occation = '* Blackout Day Occation: '.$blackout->occasion;
          }
          @endphp
        @endforeach

        @foreach($reservations as $reservation)
        @if($reservation->unique_key == $unique_key)
          @php 
            if($reservation->reservation_status == 'Booked') {
              $css = 'background: #ffeb3b; color: #000;';
              $availability = '<i class="fa fa-fw fa-calendar-check-o" aria-hidden="true"></i> Booked';
            } elseif ($reservation->reservation_status == 'Paid') {
              if($reservation->date < Carbon::today()) {
                $css = 'background: #2196f3; color: #fff;';
                $availability = '<i class="fa fa-fw fa-check-square-o" aria-hidden="true"></i> Enjoyed';
              } else {
                $css = 'background: #4caf50; color: #fff;';
                $availability = '<i class="fa fa-fw fa-thumbs-o-up" aria-hidden="true"></i> Paid';
              }
            }
            
            $reservation_data = $reservation;
          @endphp
        @endif
        @endforeach
        <td style="{{ $css }}" @if($availability != 'N/A') onclick="showaddFormModal('{{ $unique_key }}', '{{ $room_name }}', '{{ date('F d, Y', strtotime(Carbon::today()->addDays($j))) }}', '{{ $blackout_day_occation }}', '{{ $reservation_data }}', '{{ Carbon::today()->addDays($j) }}', '{{ $availability }}')" @endif>
          {!! $availability !!}
        </td>
      @endfor
    </tr>
    @endfor
  </table>
</div>

{{-- add Modal --}}
<div class="modal fade" id="addFormModal" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header modal-header-success">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">
          <i class="fa fa-bed" aria-hidden="true"></i>
          <span id="add_modal_room_name"></span>, 
          <i class="fa fa-calendar" aria-hidden="true"></i> <span id="add_modal_today_date_with_format"></span>
        </h4>
      </div>
      <div class="modal-body">
        <center><small style=""><u><b><span id="add_modal_blackout_day_occation"></span></b></u></small></center>
          {!! Form::open(['route' => 'reservation.store', 'method' => 'POST']) !!}
          {!! Form::hidden('post_type', 'new') !!}
          {!! Form::hidden('unique_key', null, ['id' => 'add_modal_hidden_unique_key']) !!}
          {!! Form::hidden('date', null, ['id' => 'add_modal_hidden_date']) !!}
          {!! Form::hidden('room_name', null, ['id' => 'add_modal_hidden_room_name']) !!}

          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                {!! Form::label('reservation_status', 'Reservation Status:') !!}
                <select name="reservation_status" class="form-control" id="add_reservation_status_selected" required="">
                  <option value="" selected="" disabled="">Select Reservation Status</option>
                  <option value="Booked">Booked</option>
                  <option value="Paid">Paid</option>
                </select> 
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group" id="hideaddtimelimit">
                {!! Form::label('timelimit  ', 'Timelimit :') !!}
                {!! Form::text('timelimit ', null, array('class' => 'form-control', 'placeholder' => 'Timelimit', 'id' => 'add_timelimit', 'min' => '0', 'step' => 'any', 'autocomplete' => 'off')) !!}
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                {!! Form::label('booked_by', 'Booked by:') !!}
                {!! Form::text('booked_by', null, array('class' => 'form-control', 'placeholder' => 'Booked by', 'required' => '', 'id' => 'add_booked_by', 'min' => '0', 'step' => 'any')) !!}
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                {!! Form::label('name', 'Guest Name:') !!}
                {{-- if available and previous data exists --}}
                <select id="copy_data_yesterday">
                  <option value="" selected="" disabled="">Loading...</option>
                </select>
                {{-- if available and previous data exists --}}
                {!! Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Guest Name', 'required' => '', 'id' => 'add_name')) !!}
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                {!! Form::label('email', 'Email Address:') !!}
                {!! Form::text('email', null, array('class' => 'form-control', 'placeholder' => 'Email Address', 'required' => '', 'id' => 'add_email')) !!}
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                {!! Form::label('phone', 'Contact Number:') !!}
                {!! Form::text('phone', null, array('class' => 'form-control', 'placeholder' => 'Contact Number', 'required' => '', 'id' => 'add_phone')) !!}
              </div>
            </div>
          </div>
          <h4><i class="fa fa-handshake-o" aria-hidden="true"></i> <u>Financial Data</u></h4>
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                {!! Form::label('price', 'Room Price:') !!}
                {!! Form::number('price', null, array('class' => 'form-control', 'placeholder' => 'Room Price', 'required' => '', 'id' => 'add_price', 'min' => '0', 'step' => 'any', 'autocomplete' => 'off')) !!}
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                {!! Form::label('discount', 'Discount:') !!}
                {!! Form::number('discount', null, array('class' => 'form-control', 'placeholder' => 'Discount', 'required' => '', 'id' => 'add_discount', 'min' => '0', 'step' => 'any', 'autocomplete' => 'off')) !!}
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                {!! Form::label('advance', 'Advance/ Paid:') !!}
                {!! Form::number('advance', null, array('class' => 'form-control', 'placeholder' => 'Advance', 'required' => '', 'id' => 'add_advance', 'min' => '0', 'step' => 'any', 'autocomplete' => 'off')) !!}
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                {!! Form::label('due', 'Due:') !!}
                {!! Form::number('due', null, array('class' => 'form-control', 'placeholder' => 'Due', 'required' => '', 'id' => 'add_due', 'min' => '0', 'step' => 'any', 'autocomplete' => 'off')) !!}
              </div>
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
{{-- add Modal --}}

{{-- edit Modal --}}
<div class="modal fade" id="editFormModal" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header modal-header-success">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">
          <i class="fa fa-bed" aria-hidden="true"></i> <span id="edit_modal_room_name"></span>, 
          <i class="fa fa-calendar" aria-hidden="true"></i> <span id="edit_modal_today_date_with_format"></span>, 
          <i class="fa fa-tag" aria-hidden="true"></i> <span id="edit_modal_pnr"></span>
        </h4>
      </div>
      <div class="modal-body">
        <center><small style=""><u><b><span id="edit_modal_blackout_day_occation"></span></b></u></small></center>
      {!! Form::open(['route' => 'reservation.update', 'method' => 'POST']) !!}
        {!! Form::hidden('post_type', 'edit') !!}
        {!! Form::hidden('unique_key', null, ['id' => 'edit_modal_hidden_unique_key']) !!}
        {!! Form::hidden('date', null, ['id' => 'edit_modal_hidden_date']) !!}
        {!! Form::hidden('room_name', null, ['id' => 'edit_modal_hidden_room_name']) !!}
        
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              {!! Form::label('reservation_status', 'Reservation Status:') !!}
              <select name="reservation_status" class="form-control" id="edit_reservation_status_selected" required="">
                <option value="" selected="" disabled="">Select Reservation Status</option>
                <option value="Booked">Booked</option>
                <option value="Paid">Paid</option>
                <option value="Vacant" style="display: none;" id="edit_modal_hidden_vacant">Vacant</option>
              </select> 
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group" id="hideedittimelimit">
              {!! Form::label('timelimit  ', 'Timelimit :') !!}
              {!! Form::text('timelimit ', null, array('class' => 'form-control', 'placeholder' => 'Timelimit', 'id' => 'edit_timelimit', 'min' => '0', 'step' => 'any', 'autocomplete' => 'off')) !!}
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              {!! Form::label('booked_by', 'Booked by:') !!}
              {!! Form::text('booked_by', null, array('class' => 'form-control', 'placeholder' => 'Booked by', 'required' => '', 'id' => 'edit_booked_by', 'min' => '0', 'step' => 'any')) !!}
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              {!! Form::label('name', 'Guest Name:') !!} 
              {!! Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Guest Name', 'required' => '', 'id' => 'edit_name')) !!}
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              {!! Form::label('email', 'Email Address:') !!}
              {!! Form::text('email', null, array('class' => 'form-control', 'placeholder' => 'Email Address', 'required' => '', 'id' => 'edit_email')) !!}
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              {!! Form::label('phone', 'Contact Number:') !!}
              {!! Form::text('phone', null, array('class' => 'form-control', 'placeholder' => 'Contact Number', 'required' => '', 'id' => 'edit_phone')) !!}
            </div>
          </div>
        </div>
        <h4><i class="fa fa-handshake-o" aria-hidden="true"></i> <u>Financial Data</u></h4>
        <div class="row">
          <div class="col-md-3">
            <div class="form-group">
              {!! Form::label('price', 'Room Price:') !!}
              {!! Form::number('price', null, array('class' => 'form-control', 'placeholder' => 'Room Price', 'required' => '', 'id' => 'edit_price', 'min' => '0', 'step' => 'any', 'autocomplete' => 'off')) !!}
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              {!! Form::label('discount', 'Discount:') !!}
              {!! Form::number('discount', null, array('class' => 'form-control', 'placeholder' => 'Discount', 'required' => '', 'id' => 'edit_discount', 'min' => '0', 'step' => 'any', 'autocomplete' => 'off')) !!}
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              {!! Form::label('advance', 'Advance/ Paid:') !!}
              {!! Form::number('advance', null, array('class' => 'form-control', 'placeholder' => 'Advance', 'required' => '', 'id' => 'edit_advance', 'min' => '0', 'step' => 'any', 'autocomplete' => 'off')) !!}
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              {!! Form::label('due', 'Due:') !!}
              {!! Form::text('due', null, array('class' => 'form-control', 'placeholder' => 'Due', 'required' => '', 'id' => 'edit_due', 'min' => '0', 'step' => 'any', 'autocomplete' => 'off')) !!}
            </div>
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
{{-- edit Modal --}}

@stop

@section('js')
  <script type="text/javascript" src="{{ asset('js/moment.js') }}"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
  <script type="text/javascript">
    $(function(){
     $('a[title]').tooltip();
     $('button[title]').tooltip();
     $('th[title]').tooltip();
     $('td[title]').tooltip();
    });
  </script>
  <script type="text/javascript">
    function showaddFormModal(unique_key, room_name, date, blackout_day_occation, reservation_data, hidden_date, availability) {
      $(':input').not(':input[type="hidden"], :checkbox, :submit').val('');
      $('#copy_data_yesterday')
            .find('option')
            .remove()
            .end()
            .prop('disabled', false)
            .append('<option value="" selected disabled>Guest from yeaterday</option>');
      $('#copy_data_yesterday').css('display', 'none');
      $('#hideaddtimelimit').css('display', 'none');
      $('#hideedittimelimit').css('display', 'none');
      if(reservation_data == '') {
        $('#add_modal_room_name').text(room_name);
        $('#add_modal_today_date_with_format').text(date);
        $('#add_modal_blackout_day_occation').text(blackout_day_occation);

        $('#add_modal_hidden_unique_key').val(unique_key);
        $('#add_modal_hidden_date').val(hidden_date);
        $('#add_modal_hidden_room_name').val(room_name);
        if(availability == 'Available') {
          $.get(window.location.protocol + "//" + window.location.host + "/reservation/yesterday/getdata/" + unique_key + "/" + hidden_date, function(data, status){
              if(data != 'N/A' && data != '' && data != '[]') {
                $('#copy_data_yesterday').css('display', '');
                for(var sizeofguest = 0; sizeofguest < data.length; sizeofguest++) {
                  $('#copy_data_yesterday').append('<option value="'+data[sizeofguest].unique_key+'">'+data[sizeofguest].name+'</option>');
                  $('#copy_data_yesterday').attr('onchange', 'fillDataYesterday()');
                }
              } else {
                $('#copy_data_yesterday').css('display', 'none');
              }
          });
        }
        $('#addFormModal').modal({backdrop: "static"});

      } else {
        $('#edit_modal_room_name').text(room_name);
        $('#edit_modal_today_date_with_format').text(date);
        $('#edit_modal_blackout_day_occation').text(blackout_day_occation);

        reservation_data = JSON.parse(reservation_data);

        $('#edit_modal_hidden_unique_key').val(unique_key);
        $('#edit_modal_hidden_date').val(hidden_date);
        $('#edit_modal_hidden_room_name').val(room_name);
        $('#edit_reservation_status_selected').val(reservation_data.reservation_status);
        $('#edit_modal_pnr').text(reservation_data.pnr);
        if($('#edit_reservation_status_selected').val() == 'Booked') {
          $('#edit_modal_hidden_vacant').css('display', 'block');
          $('#edit_modal_hidden_vacant').css('background', '#ef9a9a');
          $('#edit_modal_hidden_vacant').css('color', '#000');
          $('#hideedittimelimit').css('display', '');
          $('#edit_timelimit').datetimepicker({
            format: 'MMMM DD, YYYY hh:mm A',
            date: reservation_data.timelimit
          });
        }
        $('#edit_name').val(reservation_data.name);
        $('#edit_email').val(reservation_data.email);
        $('#edit_phone').val(reservation_data.phone);
        $('#edit_price').val(reservation_data.price);
        $('#edit_discount').val(reservation_data.discount);
        $('#edit_advance').val(reservation_data.advance);
        $('#edit_due').val(reservation_data.due);
        
        $('#editFormModal').modal({backdrop: "static"});
        // console.log(reservation_data);
      }
    }

    function fillDataYesterday() {
      //console.log($('#copy_data_yesterday').val());
      unique_key_to_fill = $('#copy_data_yesterday').val();
      $.get(window.location.protocol + "//" + window.location.host + "/reservation/yesterday/filldata/" + unique_key_to_fill, function(data, status){
          if(data != 'N/A') {
            $('#add_name').val(data.name);
            $('#add_email').val(data.email);
            $('#add_phone').val(data.phone);
          }
      });
    }


    $('.table-fixed-right-side td:nth-child(16)').addClass('today');
    $(document).ready(function(){
      let offset = $('.today').position().left;
      if(screen.width >= 768) {
        offset = offset - 450;
      } else {
        offset = offset - 200;
      }
      $('.table-fixed-right').animate({
          scrollLeft: offset
      }, 300);
    })
  </script>
  <script type="text/javascript">
    $(document).ready(function(){
      $("#add_reservation_status_selected").change(function(){
        if($(this).val() == 'Booked') {
          $('#add_price').val(0);
          $('#add_discount').val(0);
          $('#add_advance').val(0);
          $('#add_due').val(0);
          $('#hideaddtimelimit').css('display', '');
          $('#add_timelimit').datetimepicker({
            format: 'MMMM DD, YYYY hh:mm A'
          });
        } else {
          $('#hideaddtimelimit').css('display', 'none');
          $('#hideedittimelimit').css('display', 'none');
          $('#add_timelimit').val('');
        }
      });
      $("#edit_reservation_status_selected").change(function(){
        if($(this).val() == 'Booked') {
          $('#hideedittimelimit').css('display', '');
          $('#edit_timelimit').datetimepicker({
            format: 'MMMM DD, YYYY hh:mm A'
          });
        } else {
          $('#hideedittimelimit').css('display', 'none');
          $('#edit_timelimit').val() = '';
        }
      });
      $("#add_price").keyup(function(){
        price = parseFloat($('#add_price').val()) || 0;
        discount = parseFloat($('#add_discount').val())  || 0;
        advance = parseFloat($('#add_advance').val())  || 0;
        due = price - (discount + advance);
        $('#add_due').val(due);
      });
      $("#add_discount").keyup(function(){
        price = parseFloat($('#add_price').val()) || 0;
        discount = parseFloat($('#add_discount').val()) || 0;
        advance = parseFloat($('#add_advance').val()) || 0;
        due = price - (discount + advance);
        $('#add_due').val(due);
      });
      $("#add_advance").keyup(function(){
        price = parseFloat($('#add_price').val()) || 0;
        discount = parseFloat($('#add_discount').val()) || 0;
        advance = parseFloat($('#add_advance').val()) || 0;
        due = price - (discount + advance);
        $('#add_due').val(due);
      });
      $("#edit_price").keyup(function(){
        price = parseFloat($('#edit_price').val()) || 0;
        discount = parseFloat($('#edit_discount').val())  || 0;
        advance = parseFloat($('#edit_advance').val())  || 0;
        due = price - (discount + advance);
        $('#edit_due').val(due);
      });
      $("#edit_discount").keyup(function(){
        price = parseFloat($('#edit_price').val()) || 0;
        discount = parseFloat($('#edit_discount').val()) || 0;
        advance = parseFloat($('#edit_advance').val()) || 0;
        due = price - (discount + advance);
        $('#edit_due').val(due);
      });
      $("#edit_advance").keyup(function(){
        price = parseFloat($('#edit_price').val()) || 0;
        discount = parseFloat($('#edit_discount').val()) || 0;
        advance = parseFloat($('#edit_advance').val()) || 0;
        due = price - (discount + advance);
        $('#edit_due').val(due);
      });
    }); 
  </script>
  @if (count($errors) > 0 && (old('post_type') == 'new'))
  <script>
    $( document ).ready(function() {
        $('#addFormModal').modal({backdrop: "static"});
        $('#add_modal_room_name').text('{{ old('room_name') }}');
        $('#add_modal_today_date_with_format').text('{{ date('F d, Y', strtotime(old('date'))) }}');
    });
  </script>
  @endif
  @if (count($errors) > 0 && (old('post_type') == 'edit'))
  <script>
    $( document ).ready(function() {
        $('#editFormModal').modal({backdrop: "static"});
        $('#edit_modal_room_name').text('{{ old('room_name') }}');
        $('#edit_modal_today_date_with_format').text('{{ date('F d, Y', strtotime(old('date'))) }}');
    });
  </script>
  <script type="text/javascript">
    $(document).ready(function(){
        
    })
  </script>
  @endif
@stop