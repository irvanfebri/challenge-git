<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Behaviour;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\Guest;
use App\Models\Room;
use App\Models\Booking;

  

  

  

  

class BehaviourController extends Controller
{
    public function __construct(Behaviour $behaviour){
        $this->behaviour = $behaviour;
    }

    public function rooms(Request $request){
        $year = $request->year;
 
        $rooms_overview = (new LarapexChart)->donutChart();
        $rooms_overview->setTitle("Rooms Selection Overview"); 
       
        $rooms_overview_data = $this->behaviour->rooms($year);
        $rooms_overview->setLabels($rooms_overview_data->pluck('room_category')->toArray());
        $rooms_overview->addData($rooms_overview_data->pluck('count')->toArray());
        
          
  

        $guest_origins = Guest::distinct()->get('origin')->pluck('origin')->toArray();
        $rooms_category = Room::distinct()->orderBy('category')->get('category')->pluck('category')->toArray();
 
        $rooms_by_guest_origin = (new LarapexChart)->barChart();
        $rooms_by_guest_origin->setTitle("Room Selection by Guest Origin");
        $rooms_by_guest_origin->setLabels($guest_origins);
 
        $age_ranges = $this->behaviour->getAgeRanges($year);
 
        $rooms_by_age = (new LarapexChart)->barChart();
        $rooms_by_age->setTitle("Room Selection By Age Range");
        $rooms_by_age->setLabels($age_ranges);
        $age_ranges = $this->behaviour->getAgeRanges($year);
        $rooms_by_age->setLabels($age_ranges);

        $rooms_by_guest_type = (new LarapexChart)->barChart();
        $rooms_by_guest_type->setTitle("Room Selection by Guest Type");
        $guest_types = Guest::distinct()->get('type')->pluck('type')->toArray();
        $rooms_by_guest_type->setLabels($guest_types);

  
  
  
  
  
 
        for($i = 0; $i < count($rooms_category); $i++){
             $category = $rooms_category[$i];
             $rooms_by_guest_origin->addData($category, $this->behaviour->roomsByGuestOrigin($category, $year)->pluck('count')->toArray());
             $rooms_by_age->addData($category, $this->behaviour->roomsByAgeRange($category, $year)->pluck('count')->toArray());
             $rooms_by_guest_type->addData($category, $this->behaviour->roomsByGuestType($category, $year)->pluck('count')->toArray());

  
            }
 
        return view(
           'behaviour.rooms', 
           compact(
             'rooms_overview', 
             'rooms_by_guest_origin', 
             'rooms_by_age',
             'rooms_by_guest_type',
             'rooms_overview_data'
           )
        );
     }
 


     public function duration(Request $request){ 

        $year = $request->year;
  
        $addNights = function($dur){
            return "$dur night(s)";
        };
  
        $duration_overview = (new LarapexChart)->donutChart(); 
        $duration_overview->setTitle('Stay Duration Overview');
     
        $duration_overview_data = $this->behaviour->duration($year);
        $duration_overview->addData($duration_overview_data->pluck('count')->toArray());
        $duration_overview->setLabels($duration_overview_data->pluck('duration')->map($addNights)->toArray());
        
          
  


        $duration_by_guest_origin = (new LarapexChart)->barChart();
        $duration_by_guest_origin->setTitle('Stay Duration By Guest Origin');
        $guest_origins = Guest::distinct()->get('origin')->pluck('origin')->toArray();
        $duration_by_guest_origin->setLabels($guest_origins);
  
        $duration_by_age = (new LarapexChart)->barChart();
        $duration_by_age->setTitle('Stay Duration By Age Range');
        $age_ranges = $this->behaviour->getAgeRanges($year);
        $duration_by_age->setLabels($age_ranges);
  
        $duration_by_guest_type = (new LarapexChart)->barChart();
        $duration_by_guest_type->setTitle('Stay Duration By Guest Type');
        $guest_types = Guest::distinct()->get('type')->pluck('type')->toArray();
        $duration_by_guest_type->setLabels($guest_types);
  
  
        $durations = Booking::distinct()
         ->orderBy('duration')
         ->get('duration')
         ->pluck('duration')
         ->map($addNights)
         ->toArray();
  
  
  
        for($i = 0; $i < count($durations); $i++){
            // dapatkan durasi di tiap-tiap item array
            $duration = $durations[$i];
            $duration_by_guest_origin->addData($duration, $this->behaviour->durationByOrigin($duration, $year)->pluck('count')->toArray());
            $duration_by_age->addData($duration, $this->behaviour->durationByAgeRange($duration, $year)->pluck('count')->toArray());
            $duration_by_guest_type->addData($duration, $this->behaviour->durationByGuestType($duration, $year)->pluck('count')->toArray());
        }
  
        return view(
            'behaviour.duration', 
            compact(
                'duration_overview', 
                'duration_by_guest_origin', 
                'duration_by_age', 
                'duration_by_guest_type',
                'duration_overview_data'
            )
        );
  
     }
  
    





    }