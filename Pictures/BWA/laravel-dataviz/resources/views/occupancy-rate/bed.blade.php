@extends('layouts.dashboard') 

@php 
 $current_year = date("Y");
 $begin_year = date("Y") - 20;

 $start_year = \Request::get('start');
 $end_year = \Request::get('end');
 $quarter_year = \Request::get('quarter_year');
 $month_year = \Request::get('month_year');

 if(NULL == $end_year) $end_year = date("Y");
 if(NULL == $start_year) $start_year = $end_year - 5;
 if(NULL == $quarter_year) $quarter_year = $end_year;
 if(NULL == $month_year) $month_year = $end_year;

@endphp

@section('main-content')

    <h1 class="ml-2"> Occupancy Rate By Bed Type </h1>

    
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="bg-white rounded p-2 m-2 shadow-sm">
                <h2>Quarterly</h2>
                {{-- grafik quarter --}}
                <form class="form-inline p-2" action="{{url('/occupancy-rate/bed')}}" method="GET">

                    <input type="hidden" name="start" value="{{$start_year}}"/>
                    <input type="hidden" name="end" value="{{$end_year}}"/>
                    <input type="hidden" name="month_year" value="{{$month_year}}" />
                
                    <div class="form-group">
                        <select class="form-control" name="quarter_year">
                            @for($year = $current_year; $year >= $begin_year; $year--)
                                <option value="{{$year}}" {{$year == $quarter_year ? "selected" : ""}}> {{$year}}</option>
                            @endfor
                        </select>
                    </div>
                    <button class="ml-3 btn btn-primary"> Go </button>
                </form>
                
                  
                {!! $occupancy_by_quarter_by_bed->container() !!}

  
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="bg-white rounded p-2 m-2 shadow-sm">
                <h2>Year on year</h2>
                <form class="form-inline p-2" action="{{url('/occupancy-rate/bed')}}">
                    <input type="hidden" name="quarter_year" value="{{$quarter_year}}" />
                    <input type="hidden" name="month_year" value="{{$month_year}}" />
                    
                    <div class="form-group">
                        <select class="form-control" name="start">
                            @for($year = $current_year; $year >= $begin_year; $year--)
                                <option value="{{$year}}" {{$year == $start_year ? "selected" : ""}}> {{$year}}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="px-3">s.d</div>
                    <div class="form-group">
                        <select class="form-control" name="end">
                            @for($year = $current_year; $year >= $begin_year; $year--)
                                <option value="{{$year}}" {{$year == $end_year ? "selected" : ""}}> {{$year}}</option>
                            @endfor
                        </select>
                    </div>
                
                    <button class="ml-3 btn btn-primary"> Go </button>
                </form>
                
                {{-- grafik year on year --}}
                {!! $occupancy_by_year_by_bed->container() !!}
            </div>
        </div>
    </div>

    <div class="bg-white rounded p-2 m-2 shadow-sm">
        <h2>Monthly</h2>
        {{-- grafik monthly --}}
        <form class="form-inline p-2" action="{{url('/occupancy-rate/bed')}}" method="GET">

            <input type="hidden" name="start" value="{{$start_year}}"/>
            <input type="hidden" name="end" value="{{$end_year}}"/>
            <input type="hidden" name="quarter_year" value="{{$quarter_year}}" />

            <div class="form-group">
                <select class="form-control" name="month_year">
                    @for($year = $current_year; $year >= $begin_year; $year--)
                        <option value="{{$year}}" {{$year == $month_year ? "selected" : ""}}> {{$year}}</option>
                    @endfor
                </select>
            </div>
            <button class="ml-3 btn btn-primary"> Go </button>
        </form>
        {!! $occupancy_by_month_by_bed->container() !!}
    </div>

    <script src="{{ LarapexChart::cdn() }}"></script>
    {{ $occupancy_by_month_by_bed->script() }}
    {{ $occupancy_by_quarter_by_bed->script() }}
    {{ $occupancy_by_year_by_bed->script() }}

  

@endsection

  