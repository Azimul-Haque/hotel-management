<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Reservation;
use Session;
use Artisan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    public function clear()
    {
        Artisan::call('cache:clear');
        Artisan::call('optimize');
        Artisan::call('route:cache');
        Artisan::call('config:cache');
        Artisan::call('view:clear');
        Artisan::call('key:generate');
        echo 'Config and Route Cached. All Cache Cleared';
    }

    public function store(Request $request)
    {
        //validation
        $this->validate($request, array(
            'unique_key'=>'required|unique:reservations,unique_key',
            'date'=>'required',
            'timelimit'=>'sometimes',
            'room_name'=>'required',
            'reservation_status'=>'required',
            'name'=>'required|max:255',
            'email'=>'required|max:255',
            'phone'=>'required|max:255',
            'price'=>'required|numeric',
            'discount'=>'required|numeric',
            'discount_tk_or_percentage'=>'required',
            'advance'=>'required|numeric',
            'due'=>'required|numeric',
            'booked_by'=>'sometimes'
        ));
        
        //store to DB
        $reservation = new Reservation;
        $reservation->unique_key = $request->unique_key;
        $last_reservation = DB::table('reservations')
                            ->select('*')
                            ->where(DB::raw("DATE_FORMAT(date, '%Y-%m')"), "=", (new Carbon($request->date))->format('Y-m'))
                            ->orderBy('date', 'asc')
                            ->get();

        $monthslashdate = (new Carbon($request->date))->format('m/d');
        $reservation_serial = count($last_reservation) + 1;
        $serial = str_pad($reservation_serial, 3, '0', STR_PAD_LEFT);
        $reservation->pnr = 'GIT/'.$monthslashdate.'/'.$serial;

        //dd($reservation->pnr);
        $reservation->date = $request->date;
        $reservation->timelimit = new Carbon($request->timelimit);
        $reservation->room_name = $request->room_name;
        $reservation->reservation_status = $request->reservation_status;
        $reservation->name = $request->name;
        $reservation->email = $request->email;
        $reservation->phone = $request->phone;
        $reservation->price = $request->price;
        $reservation->discount = $request->discount;
        $reservation->discount_tk_or_percentage = $request->discount_tk_or_percentage;
        $reservation->advance = $request->advance;
        $reservation->due = $request->due;
        $reservation->booked_by = $request->booked_by;
        $reservation->save();

        Session::flash('success', 'Saved Successfully!');
        //redirect
        return redirect()->route('dashboard.index');
    }

    public function update(Request $request)
    {
        //validation
        $this->validate($request, array(
            'unique_key'=>'required',
            'date'=>'required',
            'date'=>'required',
            'room_name'=>'required',
            'reservation_status'=>'required',
            'name'=>'required|max:255',
            'email'=>'required|max:255',
            'phone'=>'required|max:255',
            'price'=>'required|numeric',
            'discount'=>'required|numeric',
            'discount_tk_or_percentage'=>'required',
            'advance'=>'required|numeric',
            'due'=>'required|numeric',
            'booked_by'=>'sometimes'
        ));

        // if rewuest is Vacant redirect to delete route
        if($request->reservation_status == 'Vacant') {
          return redirect()->route('reservation.delete', $request->unique_key); 
        }

        //update to DB
        $reservation = Reservation::where('unique_key', $request->unique_key)->first();
        $reservation->unique_key = $request->unique_key;
        $reservation->date = $request->date;
        $reservation->timelimit = new Carbon($request->timelimit);
        $reservation->room_name = $request->room_name;
        $reservation->reservation_status = $request->reservation_status;
        $reservation->name = $request->name;
        $reservation->email = $request->email;
        $reservation->phone = $request->phone;
        $reservation->price = $request->price;
        $reservation->discount = $request->discount;
        $reservation->discount_tk_or_percentage = $request->discount_tk_or_percentage;
        $reservation->advance = $request->advance;
        $reservation->due = $request->due;
        $reservation->booked_by = $request->booked_by;
        $reservation->save();

        Session::flash('success', 'Updated Successfully!');
        //redirect
        return redirect()->route('dashboard.index');
    }

    public function delete($unique_key)
    {
        $reservation = Reservation::where('unique_key', $unique_key)->first();
        return view('dashboard.vacant')->withReservation($reservation);
    }

    public function destroy($id)
    {
        $reservation = Reservation::find($id);
        $reservation->delete();
        Session::flash('success', 'Deleted Successfully!');
        //redirect
        return redirect()->route('dashboard.index');
    }

    public function getYesterdayDataAPI($unique_key, $date) {
        try{
            $date_substring = new Carbon($date);
            $date_substring = $date_substring->subDay();

            $reservations = Reservation::where('date', $date_substring)->get();
            if($reservations->count() > 0) {
                return $reservations;
            } else {
                return 'N/A';
            }
        } 
        catch (\Exception $e) {
          return 'N/A';
        }
    }

    public function fillYesterdayDataAPI($unique_key) {
        try{            
            $reservation = Reservation::where('unique_key', $unique_key)->first();
            if($reservation == true) {
                return $reservation;
            } else {
                return 'N/A';
            }
        } 
        catch (\Exception $e) {
          return 'N/A';
        }
        
    }
}
