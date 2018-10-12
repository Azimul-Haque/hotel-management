@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('css')
  <link rel="stylesheet" type="text/css" href="{{ asset('css/dashboard.css') }}">
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
      <th style="background: #00e676;">G1 (Group)</th>
    </tr>
    <tr>
      <th style="background: #00e676;">G2 (Group)</th>
    </tr>
    <tr>
      <th style="background: #ffd740;">101 (Family)</th>
    </tr>
    <tr>
      <th style="background: #bdbdbd;">102 (Couple)</th>
    </tr>
    <tr>
      <th style="background: #bdbdbd;">103 (Couple)</th>
    </tr>
    <tr>
      <th style="background: #bdbdbd;">201 (Couple)</th>
    </tr>
    <tr>
      <th style="background: #bdbdbd;">202 (Couple)</th>
    </tr>
    <tr>
      <th style="background: #bdbdbd;">203 (Couple)</th>
    </tr>
    <tr>
      <th style="background: #f44336;">301 (E. Double)</th>
    </tr>
    <tr>
      <th style="background: #c2185b; color: #fff;">302 (Double)</th>
    </tr>
    <tr>
      <th style="background: #c2185b; color: #fff;">303 (Triple)</th>
    </tr>
  </table>
</div>
<div class="table-fixed-right" id="MyDiv">
  <table class="table-fixed-right-side">
    <tr>
      <td>Date</td>
      <td>Date</td>
      <td>Date</td>
      <td>Date</td>
      <td>Date</td>
      <td>Date</td>
      <td>Date</td>
      <td>Date</td>
      <td>Date</td>
      <td>Date</td>
      <td>Date</td>
      <td>Date</td>
      <td>Date</td>
      <td>Date</td>
      <td>Date</td>
      <td>Date</td>
      <td>Date</td>
      <td>Date</td>
      <td>Date</td>
      <td>Date</td>
      <td>Date</td>
      <td>Date</td>
      <td>Date</td>
    </tr>

    @for($i = 0; $i < 11; $i++)
    <tr>
      <td id="date{{ $i }}">December 09, 2018</td>
      <td>December 10, 2018</td>
      <td style="background: lightblue;">October 11, 2018</td>
      <td style="background: lightblue;">October 12, 2018</td>
      <td>October 13, 2018</td>
      <td>October 14, 2018</td>
      <td style="background: lightgreen;" id="openModalTd" data-toggle="modal" data-target="#openModal" data-backdrop="static">October 15, 2018</td>
      <td>October 16, 2018</td>
      <td>October 16, 2018</td>
      <td>October 17, 2018</td>
      <td>October 18, 2018</td>
      <td>October 19, 2018</td>
      <td>October 20, 2018</td>
      <td>October 21, 2018</td>
      <td style="background: yellow;">October 22, 2018</td>
      <td>October 23, 2018</td>
      <td>October 24, 2018</td>
      <td>October 25, 2018</td>
      <td>October 26, 2018</td>
      <td>October 27, 2018</td>
      <td>October 28, 2018</td>
      <td>October 29, 2018</td>
      <td>October 30, 2018</td>
    </tr>
    @endfor
  </table>
</div>

<div class="modal fade" id="openModal" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header modal-header-success">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Test</h4>
      </div>
      <div class="modal-body">
        Test
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Save</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

@stop

@section('js')
  <script type="text/javascript">
    $('.table-fixed-right-side td:nth-child(13)').addClass('today');
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
      console.log(offset);
    })
  </script>
@stop