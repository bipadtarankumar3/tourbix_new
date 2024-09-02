<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
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
    public function search(Request $request){
        $location_name = $request->get("location_name");
        $search_date = $request->get("search_date");
        $from_date='';
        $to_date='';
        if(!empty($search_date) && $search_date){
            $searchd=explode('-', $search_date);
            $from_date=date('Y-m-d',strtotime($searchd[0]));
            $to_date=date('Y-m-d',strtotime($searchd[1]));
        }

        $no_of_travelers = $request->get("no_of_travelers");
        $search_query = DB::table('hotels')
            ->select('hotels.*', 'rooms_available.amount as room_amount','rooms_available.id as rav_id')
            ->join('rooms_available', 'hotels.id', '=', 'rooms_available.hotel_id')
            ->join('rooms', 'rooms.id', '=', 'rooms_available.room_id')
            ->where('rooms_available.available_status', '1')
            ->where('rooms_available.available_date', '>=', $from_date)
            ->where('rooms_available.available_date', '<=', $to_date)
            ->Where('hotels.location', '=', $location_name )
            ->Where('rooms_available.no_of_rooms', '>=',  $no_of_travelers)
            ->groupBy('hotels.id');
        
        
        $search = $search_query->orderBy('hotels.id', 'desc')->get();
        
        $searchcount=$search->count();
        return view('web.pages.search_list',compact('search','searchcount','no_of_travelers'));
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
}
