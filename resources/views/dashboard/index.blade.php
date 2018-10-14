@extends('adminlte::page')

@section('title', 'GaanChil | Dashboard')

@section('css')
  <link rel="stylesheet" type="text/css" href="{{ asset('css/dashboard.css') }}">
  <script src="{{ asset('vendor/adminlte/vendor/jquery/dist/jquery.min.js') }}"></script>
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
      <th style="background: #d1c4e9;">G1 (Group)</th>
    </tr>
    <tr>
      <th style="background: #d1c4e9;">G2 (Group)</th>
    </tr>
    <tr>
      <th style="background: #f0f4c3;">101 (Family)</th>
    </tr>
    <tr>
      <th style="background: #00e676;">102 (Couple)</th>
    </tr>
    <tr>
      <th style="background: #00e676;">103 (Couple)</th>
    </tr>
    <tr>
      <th style="background: #00e676;">201 (Couple)</th>
    </tr>
    <tr>
      <th style="background: #00e676;">202 (Couple)</th>
    </tr>
    <tr>
      <th style="background: #00e676;">203 (Couple)</th>
    </tr>
    <tr>
      <th style="background: #ccff90;">301 (E. Double)</th>
    </tr>
    <tr>
      <th style="background: #795548; color: #fff;">302 (Double)</th>
    </tr>
    <tr>
      <th style="background: #795548; color: #fff;">303 (Triple)</th>
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
            {{ date('F d, Y', strtotime(Carbon::today()->addDays($j))) }}
          @endif
      </td>
      @endfor
    </tr>
    {{-- flag to reopen the modal --}}
    @php $flagModal = 0; @endphp
    {{-- flag to reopen the modal --}}

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
              $room_name = 'G1 (Group)';
              $unique_key = $i.'_g1_'.date('d_m_Y', strtotime(Carbon::today()->addDays($j)));
          } elseif($i == 1) {
              $room_name = 'G2 (Group)';
              $unique_key = $i.'_g2_'.date('d_m_Y', strtotime(Carbon::today()->addDays($j)));
          } elseif($i == 2) {
              $room_name = '101 (Family)';
              $unique_key = $i.'_101_'.date('d_m_Y', strtotime(Carbon::today()->addDays($j)));
          } elseif($i == 3) {
              $room_name = '102 (Couple)';
              $unique_key = $i.'_102_'.date('d_m_Y', strtotime(Carbon::today()->addDays($j)));
          } elseif($i == 4) {
              $room_name = '103 (Couple)';
              $unique_key = $i.'_103_'.date('d_m_Y', strtotime(Carbon::today()->addDays($j)));
          } elseif($i == 5) {
              $room_name = '201 (Couple)';
              $unique_key = $i.'_201_'.date('d_m_Y', strtotime(Carbon::today()->addDays($j)));
          } elseif($i == 6) {
              $room_name = '202 (Couple)';
              $unique_key = $i.'_202_'.date('d_m_Y', strtotime(Carbon::today()->addDays($j)));
          } elseif($i == 7) {
              $room_name = '203 (Couple)';
              $unique_key = $i.'_203_'.date('d_m_Y', strtotime(Carbon::today()->addDays($j)));
          } elseif($i == 8) {
              $room_name = '301 (E. Double)';
              $unique_key = $i.'_301_'.date('d_m_Y', strtotime(Carbon::today()->addDays($j)));
          } elseif($i == 9) {
              $room_name = '302 (Double)';
              $unique_key = $i.'_302_'.date('d_m_Y', strtotime(Carbon::today()->addDays($j)));
          } elseif($i == 10) {
              $room_name = '303 (Triple)';
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
        <td style="{{ $css }}" data-toggle="modal" @if($availability != 'N/A') data-target="#openModal{{ $unique_key }}" data-backdrop="static" @endif>
          {!! $availability !!}
        </td>
      
      @if($availability != 'N/A')
      {{-- Modal --}}
      <div class="modal fade" id="openModal{{ $unique_key }}" role="dialog">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header modal-header-success">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">
                <i class="fa fa-bed" aria-hidden="true"></i>
                {{ $room_name }}, 
                <i class="fa fa-calendar" aria-hidden="true"></i> {{ date('F d, Y', strtotime(Carbon::today()->addDays($j))) }}
              </h4>
            </div>
            <div class="modal-body">
              <center><small style=""><u><b>{{ $blackout_day_occation }}</b></u></small></center>
              @if($reservation_data == null)
              {!! Form::open(['route' => 'reservation.store', 'method' => 'POST']) !!}
              @else
              {!! Form::model($reservation_data, ['route' => ['reservation.update', $reservation_data->id], 'method' => 'PUT']) !!}
              @endif
                {!! Form::hidden('unique_key', $unique_key) !!}
                {!! Form::hidden('date', Carbon::today()->addDays($j)) !!}
                {!! Form::hidden('room_name', $room_name) !!}
                <div class="form-group">
                  {!! Form::label('reservation_status', 'Reservation Status:') !!}
                  <select name="reservation_status" class="form-control" id="reservation_status_selected_{{ $unique_key }}">
                    <option value="" selected="" disabled="">Select Reservation Status</option>
                    <option value="Booked" 
                    @if($reservation_data == true && $reservation_data->reservation_status == 'Booked')
                      selected="" 
                    @endif
                    >Booked</option>
                    <option value="Paid"
                    @if($reservation_data == true && $reservation_data->reservation_status == 'Paid')
                      selected="" 
                    @endif
                    >Paid</option>
                    @if($reservation_data == true && $reservation_data->reservation_status == 'Booked')
                      <option value="Vacant" style="background: #ef9a9a; color: #000;">Vacant</option>
                    @endif
                  </select> 
                </div>
                <div class="form-group">
                  {!! Form::label('name', 'Guest Name:') !!}
                  {!! Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Guest Name', 'required' => '')) !!}
                </div>
                <div class="form-group">
                  {!! Form::label('email', 'Email Address:') !!}
                  {!! Form::text('email', null, array('class' => 'form-control', 'placeholder' => 'Email Address', 'required' => '')) !!}
                </div>
                <div class="form-group">
                  {!! Form::label('phone', 'Contact Number:') !!}
                  {!! Form::text('phone', null, array('class' => 'form-control', 'placeholder' => 'Contact Number', 'required' => '')) !!}
                </div>
                <h4><i class="fa fa-handshake-o" aria-hidden="true"></i> <u>Financial Data</u></h4>
                <div class="row">
                  <div class="col-md-6 col-sm-6 col-xs-6">
                    <div class="form-group">
                      {!! Form::label('price', 'Room Price:') !!}
                      {!! Form::text('price', null, array('class' => 'form-control', 'placeholder' => 'Room Price', 'required' => '', 'id' => 'price'.$unique_key )) !!}
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-6">
                    <div class="form-group">
                      {!! Form::label('discount', 'Discount:') !!}
                      {!! Form::text('discount', null, array('class' => 'form-control', 'placeholder' => 'Discount', 'required' => '', 'id' => 'discount'.$unique_key)) !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 col-sm-6 col-xs-6">
                    <div class="form-group">
                      {!! Form::label('advance', 'Advance:') !!}
                      {!! Form::text('advance', null, array('class' => 'form-control', 'placeholder' => 'Advance', 'required' => '', 'id' => 'advance'.$unique_key)) !!}
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-6">
                    <div class="form-group">
                      {!! Form::label('due', 'Due:') !!}
                      {!! Form::text('due', null, array('class' => 'form-control', 'placeholder' => 'Due', 'required' => '', 'id' => 'due'.$unique_key)) !!}
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                  {!! Form::submit('Save', array('class' => 'btn btn-success')) !!}
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
              </div>
              {!! Form::close() !!}
              <script type="text/javascript">
                $(document).ready(function(){
                  $("#reservation_status_selected_{{ $unique_key }}").change(function(){
                    if($(this).val() == 'Booked') {
                      $('#price{{ $unique_key }}').val(0);
                      $('#discount{{ $unique_key }}').val(0);
                      $('#advance{{ $unique_key }}').val(0);
                      $('#due{{ $unique_key }}').val(0);
                    }
                  });
                }); 
              </script>
            </div>
          </div>
        </div>

        @if ((count($errors) > 0) && ($flagModal == 0))
          <script>
              $( document ).ready(function() {
                  $('#openModal{{ $unique_key }}').modal('show');
              });
          </script>
          @php $flagModal = 1; @endphp
        @endif
      {{-- Modal --}}
      @endif

      @endfor
    </tr>
    @endfor
  </table>
</div>
@stop

@section('js')
  <script type="text/javascript">
    $('.table-fixed-right-side td:nth-child(16)').addClass('today');
    $(document).ready(function(){
      let offset = $('.today').position().left;
      if(screen.width >= 768) {
        offset = offset - 400;
      } else {
        offset = offset - 150;
      }
      $('.table-fixed-right').animate({
          scrollLeft: offset
      }, 300);
    })
  </script>
@stop