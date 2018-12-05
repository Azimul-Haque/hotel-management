<html>
<head>
  <title>Invoice | PDF</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="icon" sizes="192x192" href="{{ asset('images/pdf-icon.png') }}">
  <style>
  body {
    font-family: 'roboto', sans-serif;
  }
  table {
      border-collapse: collapse;
      width: 100%;
  }

  .maintable tr td, .maintable tr th {
      border: 1px solid black;
  }
  .maintable tr td, .maintable tr th {
    padding: 5px;
    font-family: 'roboto', sans-serif;
    font-size: 14px;
  }
  @page {
    header: page-header;
    footer: page-footer;
  }
  </style>
</head>
<body>
  <htmlpageheader name="page-header">

  </htmlpageheader>
  <table>
    <tr>
      <td width="90%"></td>
      <td>
        <img src="{{ public_path('images/meghkabbo.png') }}" width="200">
      </td>
    </tr>
  </table>
  <h2 align="center" style="border-bottom: 1px solid #000;">Cottage Booking Invoice</h2>
  <table>
    <tr>
      <td width="20%">
        Date: {{ date('d/m/Y') }}
      </td>
      <td  width="60%"></td>
      <td  width="20%">
        PNR: {{ $invoicedata->pnr }}
      </td>
    </tr>
  </table>
  <table class="maintable">
    <tr>
      <td width="25%">Name:</td>
      <td colspan="3">{{ $invoicedata->name }}</td>
    </tr>
    <tr>
      <td width="25%">Contact No:</td>
      <td colspan="3">{{ $invoicedata->phone }} [✉ {{ $invoicedata->email }}]</td>
    </tr>
    <tr>
      <td width="25%">Booked by:</td>
      <td colspan="3">{{ $invoicedata->booked_by }}</td>
    </tr>
    <tr>
      <td width="25%">Room Type:</td>
      <td colspan="3">{{ $invoicedata->room_type }}</td>
    </tr>
    <tr>
      <td width="25%">Check In:</td>
      <td width="20%">{{ date('d/m/Y', strtotime($invoicedata->checkin)) }}</td>
      <td width="20%">12:30 PM</td>
      <td rowspan="2">{{ Carbon::parse($invoicedata->checkin)->diffInDays(Carbon::parse($invoicedata->checkout)) }} Night(s)</td>
    </tr>
    <tr>
      <td width="25%">Check Out:</td>
      <td width="20%">{{ date('d/m/Y', strtotime( $invoicedata->checkout)) }}</td>
      <td width="20%">10:00 AM</td>
    </tr>
    <tr>
      <td width="25%">Total Amount:</td>
      <td colspan="3">{{ $invoicedata->price }}/-</td>
    </tr>
    <tr>
      <td width="25%">Discount:</td>
      <td colspan="3">
        {{ $invoicedata->discount }}
        @if($invoicedata->discount_tk_or_percentage == 'Tk')
        /-
        @elseif($invoicedata->discount_tk_or_percentage == '%')
        %
        @endif
      </td>
    </tr>
    <tr>
      <td width="25%">Advance:</td>
      <td colspan="3">{{ $invoicedata->advance }}/-</td>
    </tr>
    <tr>
      <td width="25%">Dues:</td>
      <td colspan="3">{{ $invoicedata->due }}/-</td>
    </tr>
    <tr>
      <td width="25%">Payment Method:</td>
      <td colspan="3">{{ $invoicedata->payment_method }}</td>
    </tr>
    <tr>
      <td width="25%">Note:</td>
      <td colspan="3"><b>{{ $invoicedata->note }}</b></td>
    </tr>
    <tr>
      <td width="25%">Information:</td>
      <td colspan="3">
        <ul>
          <li>Please bring <b>Robi/ Aritel</b> for SAJEK as other operators don't work</li>
          <li>Army escort tume: 10:00 AM &amp; 03:30 PM from Bagaighat to Sajek</li>
          <li>Reception: Aung Sing Marma (Sujon), ✆ 01859759377</li>
        </ul>
      </td>
    </tr>
  </table><br/><br/>
  <table>
    <tr>
      <td width="70%"></td>
      <td width="30%">
        <center>
          <img src="{{ public_path('images/sign.png') }}" width="150">
        </center>
        <b>For Megh Kabbo</b><br/>
        Md. Moniruzaman (Masud)<br/>
        Director &amp;<br/>
        Head of Operation
      </td>
    </tr>
  </table><br/><br/><br/><br/><br/><br/><br/>
  <p><b><i>* A concern of <b>Gungchil Group</i></b></p>

  <htmlpagefooter name="page-footer">
    <center>
      <img src="{{ public_path('images/footer.png') }}">
    </center>
  </htmlpagefooter>
</body>
</html>