<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Reservation;
use Session;

class ReservationController extends Controller
{
    public function store(Request $request)
    {
        //validation
        $this->validate($request, array(
            'unique_key'=>'required|unique:reservations,unique_key',
            'date'=>'required',
            'room_name'=>'required',
            'reservation_status'=>'required',
            'name'=>'required|max:255',
            'email'=>'required|max:255',
            'phone'=>'required|max:255',
            'price'=>'required|numeric',
            'discount'=>'required|numeric',
            'advance'=>'required|numeric',
            'due'=>'required|numeric'
        ));

        //store to DB
        $reservation = new Reservation;
        $reservation->unique_key = $request->unique_key;
        $reservation->date = $request->date;
        $reservation->room_name = $request->room_name;
        $reservation->reservation_status = $request->reservation_status;
        $reservation->name = $request->name;
        $reservation->email = $request->email;
        $reservation->phone = $request->phone;
        $reservation->price = $request->price;
        $reservation->discount = $request->discount;
        $reservation->advance = $request->advance;
        $reservation->due = $request->due;
        $reservation->save();

        Session::flash('success', 'Saved Successfully!');
        //redirect
        return redirect()->route('dashboard.index');
    }

    public function update(Request $request, $id)
    {
        //validation
        $this->validate($request, array(
            'unique_key'=>'required',
            'date'=>'required',
            'room_name'=>'required',
            'reservation_status'=>'required',
            'name'=>'required|max:255',
            'email'=>'required|max:255',
            'phone'=>'required|max:255',
            'price'=>'required|numeric',
            'discount'=>'required|numeric',
            'advance'=>'required|numeric',
            'due'=>'required|numeric'
        ));

        // if rewuest is Vacant redirect to delete route
        if($request->reservation_status == 'Vacant') {
          return redirect()->route('reservation.delete', $id); 
        }

        //update to DB
        $reservation = Reservation::find($id);
        $reservation->unique_key = $request->unique_key;
        $reservation->date = $request->date;
        $reservation->room_name = $request->room_name;
        $reservation->reservation_status = $request->reservation_status;
        $reservation->name = $request->name;
        $reservation->email = $request->email;
        $reservation->phone = $request->phone;
        $reservation->price = $request->price;
        $reservation->discount = $request->discount;
        $reservation->advance = $request->advance;
        $reservation->due = $request->due;
        $reservation->save();

        Session::flash('success', 'Updated Successfully!');
        //redirect
        return redirect()->route('dashboard.index');
    }

    public function delete($id)
    {
        $reservation = Reservation::find($id);
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
            $date_substring = date('d_m_Y', strtotime($date. ' -1 day'));
            $unique_key_substring = substr($unique_key, 0, -10);
            $new_unique_key = $unique_key_substring.$date_substring;
            
            $reservation = Reservation::where('unique_key', $new_unique_key)->first();
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
