<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Carbon;

use App\Reservation;
use App\Blackout;
use Session;

use Illuminate\Support\Facades\DB;
use PDF;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $blackouts = Blackout::whereBetween('date', [Carbon::today()->addDays(-15), Carbon::today()->addDays(15)])->get();
        $reservations = Reservation::whereBetween('date', [Carbon::today()->addDays(-15), Carbon::today()->addDays(15)])->get();
        return view('dashboard.index')
                 ->withBlackouts($blackouts)
                 ->withReservations($reservations);
    }

    public function getBlackouts()
    {   
        $blackouts = Blackout::orderBy('date', 'desc')->get();
        // dd($blackouts);
        return view('dashboard.blackout')->withBlackouts($blackouts);
    }

    public function storeBlackouts(Request $request) {
        //validation
        $this->validate($request, array(
            'occasion'=>'required',
            'date'=>'required|unique:blackouts,date'
        ));

        //store to DB
        $blackout = Blackout::where('date', new Carbon($request->date))->first();
        if($blackout==null) {
            $blackout = new Blackout;
            $blackout->occasion = $request->occasion;
            $blackout->date = new Carbon($request->date);
            $blackout->save();
            Session::flash('success', 'Saved Successfully!');
        } else {
            Session::flash('warning', 'Already exists!');
        }

        //redirect
        return redirect()->route('dashboard.blackout');
    }

    public function updateBlackouts(Request $request, $id) {
        //validation
        $this->validate($request, array(
            'occasion'=>'required',
            'date'=>'required|unique:blackouts,date'
        ));

        //update to DB
        $blackout = Blackout::find($id);
        if($blackout == true && $blackout->date == new Carbon($request->date)) {
            $blackout->occasion = $request->occasion;
            $blackout->save();
            Session::flash('success', 'Updated Successfully!');
        } else {
            try{
                $blackout->occasion = $request->occasion;
                $blackout->date = new Carbon($request->date);
                $blackout->save();
                Session::flash('success', 'Saved Successfully!');
            } 
            catch (\Exception $e) {
              Session::flash('warning', 'Possible Duplicaties! Could not perform operation');
            }
        }

        //redirect
        return redirect()->route('dashboard.blackout');
    }

    public function deleteBlackouts($id) {
        $blackout = Blackout::find($id);
        $blackout->delete();
        Session::flash('success', 'Deleted Successfully!');

        //redirect
        return redirect()->route('dashboard.blackout');
    }

    public function getStement() {
        $reservation_months = DB::table('reservations')
                                ->select('date')
                                ->groupBy(DB::raw("DATE_FORMAT(date, '%Y-%m')"))
                                ->orderBy('date', 'desc')
                                ->get();
        return view('dashboard.statement')->withReservation_months($reservation_months);
    }

    public function getRangePDF(Request $request)
    {
        //validation
        $this->validate($request, array(
          'from' => 'required',
          'to' => 'required',
        ));
        $from = new Carbon($request->from);
        $to = new Carbon($request->to);
        $reservations = Reservation::whereBetween('date', [$from, $to])
                        ->orderBy('date', 'asc')
                        ->get();
        $reservation_total = DB::table('reservations')
                        ->select(DB::raw('SUM(price) as totalprice'), DB::raw('SUM(discount) as totaldiscount'), DB::raw('SUM(advance) as totaladvance'), DB::raw('SUM(due) as totaldue'))
                        ->whereBetween('date', [$from, $to])
                        ->first();

        $pdf = PDF::loadView('reports.pdf.range', ['reservations' => $reservations], ['data' => [$request->from, $request->to, $reservation_total->totalprice, $reservation_total->totaldiscount, $reservation_total->totaladvance, $reservation_total->totaldue]]);
        $fileName = date("d_M_Y", strtotime($request->from)) .'-'. date("d_M_Y", strtotime($request->to)) .'.pdf';
        return $pdf->stream($fileName);
    }

    public function getMonthPDF(Request $request)
    {
        //validation
        $this->validate($request, array(
          'month' => 'required',
        ));
        $month = new Carbon($request->month);
        $monthlyreservation = DB::table('reservations')
                        ->select('*')
                        ->where(DB::raw("DATE_FORMAT(date, '%Y-%m')"), "=", $month->format('Y-m'))
                        ->orderBy('date', 'asc')
                        ->get();

        $monthlyreservation_total = DB::table('reservations')
                        ->select(DB::raw('SUM(price) as totalprice'), DB::raw('SUM(discount) as totaldiscount'), DB::raw('SUM(advance) as totaladvance'), DB::raw('SUM(due) as totaldue'))
                        ->where(DB::raw("DATE_FORMAT(date, '%Y-%m')"), "=", $month->format('Y-m'))
                        ->first();

        $pdf = PDF::loadView('reports.pdf.month', ['monthlyreservation' => $monthlyreservation], ['data' => [date("F Y", strtotime($request->month)), $monthlyreservation_total->totalprice, $monthlyreservation_total->totaldiscount, $monthlyreservation_total->totaladvance, $monthlyreservation_total->totaldue]]);
        $fileName = date("F_Y", strtotime($request->month)) . '.pdf';
        return $pdf->stream($fileName);
    }

    public function getRoomWisePDF(Request $request)
    {
        //validation
        $this->validate($request, array(
          'room_name' => 'required',
          'month' => 'required',
        ));
        $month = new Carbon($request->month);
        $roomwisereservation = DB::table('reservations')
                        ->select('*')
                        ->where(DB::raw("DATE_FORMAT(date, '%Y-%m')"), "=", $month->format('Y-m'))
                        ->orderBy('date', 'asc')
                        ->where('room_name', $request->room_name)
                        ->get();

        $roomwisereservation_total = DB::table('reservations')
                        ->select(DB::raw('SUM(price) as totalprice'), DB::raw('SUM(discount) as totaldiscount'), DB::raw('SUM(advance) as totaladvance'), DB::raw('SUM(due) as totaldue'))
                        ->where(DB::raw("DATE_FORMAT(date, '%Y-%m')"), "=", $month->format('Y-m'))
                        ->where('room_name', $request->room_name)
                        ->first();

        $pdf = PDF::loadView('reports.pdf.roomwise', ['roomwisereservation' => $roomwisereservation], ['data' => [$request->room_name, date("F Y", strtotime($request->month)), $roomwisereservation_total->totalprice, $roomwisereservation_total->totaldiscount, $roomwisereservation_total->totaladvance, $roomwisereservation_total->totaldue]]);
        $fileName = strtok($request->room_name, ' ').'_'.date("F_Y", strtotime($request->month)) . '.pdf';
        return $pdf->stream($fileName);
    }
}
