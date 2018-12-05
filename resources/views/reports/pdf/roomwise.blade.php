<html>
<head>
  <title>{{ $data[0] }} | {{ $data[1] }} | PDF</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="icon" sizes="192x192" href="{{ asset('images/pdf-icon.png') }}">
  <style>
  body {
    font-family: 'kalpurush', sans-serif;
  }
  table {
      border-collapse: collapse;
      width: 100%;
  }

  table, td, th {
      border: 1px solid black;
  }
  th, td{
    padding: 5px;
    font-family: 'kalpurush', sans-serif;
    font-size: 14px;
  }
  </style>
</head>
<body>
  <p align="center">
    <img src="{{ public_path('images/logo.png') }}" width="200">
  </p>
  <p align="center">ব্যালেন্স স্টেটমেন্ট</p>
  <p align="center"><b><u>Room: {{ $data[0] }} | Month: {{ $data[1] }}</u></b></p>
  <div class="">
    <table class="">
      <tr>
        <th>তারিখ</th>
        <th>অতিথির নাম</th>
        <th>ফোন নম্বর</th>
        <th>মোট</th>
        <th>ডিসকাউন্ট</th>
        <th>অগ্রিম</th>
        <th>বাকি</th>
      </tr>
      @foreach($roomwisereservation as $reservation)
        <tr>
          <td>{{ date('F d, Y', strtotime($reservation->date)) }}</td>
          <td>{{ $reservation->name }}</td>
          <td>{{ $reservation->phone }}</td>
          <td align="right">৳{{ $reservation->price }}</td>
          <td align="right">৳{{ $reservation->discount }}</td>
          <td align="right">৳{{ $reservation->advance }}</td>
          <td align="right">৳{{ $reservation->due }}</td>
        </tr>
      @endforeach
      <tr style="background: #D3D3D3;">
        <th colspan="3">মোট</th>
        <td align="right">৳{{ $data[2] }}</td>
        <td align="right">৳{{ $data[3] }}</td>
        <td align="right">৳{{ $data[4] }}</td>
        <td align="right">৳{{ $data[5] }}</td>
      </tr>
    </table>
  </div>
</body>
</html>