<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Location;
use App\Models\RoomAvailable;
use App\Models\Hotel;
use App\Models\HotelSaraunding;
use App\Models\Room;
use App\Models\RoomAmenities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class WebViewController extends Controller
{
    public function index(){
        $data['locations']=Location::orderBy('id','desc')->get();
        $locationssearch=Location::orderBy('id','desc')->pluck('location_name')->toArray();
        $data['locationssearch']=json_encode($locationssearch);
        return view('web.pages.index',$data);
    }
    public function search(Request $request)
    {
        $location_name = $request->get("location_name");
        $search_date = $request->get("search_date");
        $from_date = '';
        $to_date = '';
    
        if (!empty($search_date)) {
            // Explode and trim to handle dates correctly
            $searchd = explode('-', $search_date);
            $from_date = date('Y-m-d', strtotime(trim($searchd[0])));
            $to_date = date('Y-m-d', strtotime(trim($searchd[1])));
        }
    
        $no_of_travelers = $request->get("no_of_travelers");
    
        $search = DB::select("SELECT * 
                            FROM `hotels` 
                            LEFT JOIN `locations` 
                                ON `locations`.`location_name` = `hotels`.`location`
                            LEFT JOIN `room_available_dates` 
                                ON `room_available_dates`.`rad_hotel_id` = `hotels`.`id`
                            WHERE `rad_available_date` BETWEEN DATE('$from_date') AND DATE('$to_date')
                            AND rad_available_status = 'YES'
                            GROUP BY hotels.id;"
                        );
      
      //dd($location_name);
    
        // Get the raw SQL query
    //     $raw_sql_query = $search_query->toSql();
      
    //     // Execute the query to get the results
    //     $search = $search_query->orderBy('hotels.id', 'desc')->get();
    //   //dd( $search);
    
    //     // Count the number of results
    //     $searchcount = $search->count();
    
        // Return the view with results
        return view('web.pages.search_list', compact('search', 'no_of_travelers','location_name'));
    }
    

    public function property_details($rav_id){

        $roomavailable = RoomAvailable::where('id',$rav_id)->first();
        $data['roomavailable']=$roomavailable;
        $data['hotel']=Hotel::where('id',$roomavailable->hotel_id)->first();

        $data['room']=Room::where('id',$roomavailable->room_id)->first();
        
        $data['rooms']=Room::where('id',$roomavailable->room_id)->get();
        $data['related_rooms']=Room::where('id','!=',$roomavailable->room_id)->get();

        $locations=Location::orderBy('id','desc')->get();
        $data['surrounding']=HotelSaraunding::where('hotel_id',$roomavailable->hotel_id)->orderBy('id','desc')->get();
        //print_r($hotel);
        // print_r($data['rooms']);die;

        return view('web.pages.property_details',$data);
    }
    public function payNow($hotel_id ,$room_id){
        // dd($hotel_id);
        $data['room']=Room::where('id',$room_id)->first();
        $data['hotel']=Hotel::where('id',$hotel_id)->first();

        return view('web.pages.payment',$data);
    }
    public function bookNow(Request $request){
    //   dd($request->all());

      Booking::create([
        'first_name'=>$request->first_name,
        'last_name'=>$request->last_name,
        'email'=>$request->email,
        'phone'=>$request->phone,
        'protect_stay_status'=>$request->protection,
        'room_id'=>$request->room_id,
        // 'check_in_datetime'=>$request->first_name,
        // 'check_out_datetime'=>$request->first_name,
        'total_price'=>100,
      ]);
      return redirect('booking-status')->with('success','Booking Complete');
    }
    public function bookingStatus(Request $request){
    return view('web.pages.payment_status');
    }
}
