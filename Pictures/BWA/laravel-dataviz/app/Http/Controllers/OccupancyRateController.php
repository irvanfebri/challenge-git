<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\OccupancyRate;
use ArielMejiaDev\LarapexCharts\LarapexChart;
//use App\Http\Controllers\Carbon;
use Carbon\Carbon;
use App\Models\Room;

  

  

class OccupancyRateController extends Controller
{
  
    public function __construct(OccupancyRate $occupancyRate){
        $this->occupancyRate = $occupancyRate;
      }

      public function index(){
        $occupancy_by_month = (new LarapexChart)->lineChart();
        $occupancy_by_year = (new LarapexChart)->lineChart(); 
        $occupancy_by_month->addData('2016', $this->occupancyRate->byMonth(2016)->pluck('occupancy_rate')->toArray());
        $occupancy_by_month->addData('2017', $this->occupancyRate->byMonth(2017)->pluck('occupancy_rate')->toArray());
        $occupancy_by_month->addData('2018', $this->occupancyRate->byMonth(2018)->pluck('occupancy_rate')->toArray());
        $occupancy_by_month->addData('2019', $this->occupancyRate->byMonth(2019)->pluck('occupancy_rate')->toArray());
        $occupancy_by_month->addData('2020', $this->occupancyRate->byMonth(2020)->pluck('occupancy_rate')->toArray());
    
        $occupancy_by_month->setTitle('Occupancy Rate');
        $occupancy_by_month->setXAxis(["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]);

  
        $occupancy_by_quarter = (new LarapexChart)->lineChart(); 
    
        $occupancy_by_quarter->addData('2016', $this->occupancyRate->byQuarter(2016)->pluck('occupancy_rate')->toArray());
        $occupancy_by_quarter->addData('2017', $this->occupancyRate->byQuarter(2017)->pluck('occupancy_rate')->toArray());
        $occupancy_by_quarter->addData('2018', $this->occupancyRate->byQuarter(2018)->pluck('occupancy_rate')->toArray());
        $occupancy_by_quarter->addData('2019', $this->occupancyRate->byQuarter(2019)->pluck('occupancy_rate')->toArray());
        $occupancy_by_quarter->addData('2020', $this->occupancyRate->byQuarter(2020)->pluck('occupancy_rate')->toArray());
        $occupancy_by_quarter->setXAxis(["Q1", "Q2", "Q3", "Q4"]);

  
        $occupancy_by_year->addData('2016 - 2020', $this->occupancyRate->byYear(2016, 2020)->pluck('occupancy_rate')->toArray());

        //$occupancy_by_month_by_room = (new LarapexChart)->barChart();
       

  
  
  
        return view(
            'occupancy-rate.index',
            compact(
                'occupancy_by_month',
                'occupancy_by_quarter',
                'occupancy_by_year',
                
            )
        );
    }
    
    public function room(Request $request){
        $start_year = $request->start; 
        $end_year = $request->end; 
        $quarter_year = $request->quarter_year;
        $month_year = $request->month_year;
    
        if($end_year - $start_year > 5) {
            $end_year = Carbon::createFromDate($start_year + 5)->year;
        }
    
        if($start_year == NULL) $start_year = Carbon::now()->subYear(5)->year;
        if($end_year == NULL) $end_year = date("Y");
        if($quarter_year == NULL) $quarter_year = date("Y");
        if($month_year == NULL) $month_year = date("Y");
    
        $year_ranges = [];
        for($year = $start_year; $year <= $end_year; $year++){
            $year_ranges[] = $year;
        }
    
        $occupancy_by_month_by_room = (new LarapexChart)->barChart();
        $occupancy_by_month_by_room->setXAxis(["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]);
    
        $occupancy_by_quarter_by_room = (new LarapexChart)->barChart();
        $occupancy_by_quarter_by_room->setXAxis(["Q1", "Q2", "Q3", "Q4"]);

        $occupancy_by_year_by_room = (new LarapexChart)->barChart();
        $occupancy_by_year_by_room->setXAxis($year_ranges);

  
  
  

        $categories = Room::distinct()->get(["category"])->pluck(['category']);
        
       
        $categories
        ->each(function($category) use
            ($occupancy_by_month_by_room, $occupancy_by_quarter_by_room, $month_year, $quarter_year, $occupancy_by_year_by_room, $start_year, $end_year)
        {
 
            $occupancy_by_month_by_room
                ->addData($category, $this->occupancyRate->byMonthByRoom($category, $month_year)->pluck('occupancy_rate')->toArray());
            $occupancy_by_quarter_by_room
                ->addData($category, $this->occupancyRate->byQuarterByRoom($category, $quarter_year)->pluck('occupancy_rate')->toArray());
            $occupancy_by_year_by_room
                ->addData("Occupancy Rate", $this->occupancyRate->byYearByRoom($category, $start_year, $end_year)->pluck('occupancy_rate')->toArray());
 
        });
    
        return view(
            'occupancy-rate.room',
            compact(
                'occupancy_by_month_by_room', 
                'occupancy_by_quarter_by_room',
                'occupancy_by_year_by_room'
            )
        );      
          
    
    }
    
    public function bed(Request $request){
        $start_year = $request->start; 
        $end_year = $request->end; 
        $quarter_year = $request->quarter_year;
        $month_year = $request->month_year;
    
        if($end_year - $start_year > 5) {
            $end_year = Carbon::createFromDate($start_year + 5)->year;
        }
    
        if($start_year == NULL) $start_year = Carbon::now()->subYear(5)->year;
        if($end_year == NULL) $end_year = date("Y");
        if($quarter_year == NULL) $quarter_year = date("Y");
        if($month_year == NULL) $month_year = date("Y");
    
        $year_ranges = [];
        for($year = $start_year; $year <= $end_year; $year++){
            $year_ranges[] = $year;
        }

        $occupancy_by_month_by_bed = (new LarapexChart)->barChart();
        $occupancy_by_month_by_bed->setXAxis(["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]);

        $occupancy_by_quarter_by_bed = (new LarapexChart)->barChart();
        $occupancy_by_quarter_by_bed->setXAxis(["Q1", "Q2", "Q3", "Q4"]);

        $occupancy_by_year_by_bed = (new LarapexChart)->barChart();
        $occupancy_by_year_by_bed->setXAxis($year_ranges);
  

        $bed_types = Room::distinct()->get(['bed_type'])->pluck('bed_type'); 

        

        $bed_types
        ->each(function($bed_type) 
        use ($occupancy_by_month_by_bed, $month_year, $occupancy_by_quarter_by_bed, $quarter_year,$occupancy_by_year_by_bed, $year) {
           $occupancy_by_month_by_bed
             ->addData(
               $bed_type, 
               $this
                 ->occupancyRate
                 ->byMonthByBed($bed_type, $month_year)
                 ->pluck('occupancy_rate')
                 ->toArray()
             );
        
           $occupancy_by_quarter_by_bed
             ->addData(
               $bed_type, 
               $this 
                 ->occupancyRate 
                 ->byQuarterByBed($bed_type, $quarter_year) 
                 ->pluck('occupancy_rate')
                 ->toArray()
             );

             $occupancy_by_year_by_bed
             ->addData(
               $bed_type, 
               $this 
                 ->occupancyRate 
                 ->byYearByBed($bed_type, $year) 
                 ->pluck('occupancy_rate')
                 ->toArray()
             );

        });
        
          
          
        return view(
            'occupancy-rate.bed', 
            compact('occupancy_by_month_by_bed', 'occupancy_by_quarter_by_bed','occupancy_by_year_by_bed')
          );
                 
    }
    
      
    
      
    
      
      
    
      
        
      
       
      
        
      
      
}
