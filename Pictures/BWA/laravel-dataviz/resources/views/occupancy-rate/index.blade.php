@extends('layouts.dashboard')

@php 
 $current_year = date("Y");
 $begin_year = date("Y") - 20;

 $start_year = \Request::get('start');
 $end_year = \Request::get('end');

 if(NULL == $end_year) $end_year = date("Y");
 if(NULL == $start_year) $start_year = $end_year - 5;

@endphp

@section('main-content')

    <div class="row mb-10">
        <div class="col-md-12">
            <h1>Occupancy Rate</h1>
        </div>
    </div>

   <form class="form-inline p-2" action="{{url('/occupancy-rate')}}">
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

    <div class="row mb-5">
        <div class="col-md-6">
            <div class="bg-white p-2 rounded">
                <h2 class="p-2"> Quarterly </h2>
                {!! $occupancy_by_quarter->container() !!}
            </div>
        </div>

        <div class="col-md-6">
            <div class="bg-white p-2 rounded">
              <h2 class="p-2"> Year on Year </h2>
              {!! $occupancy_by_year->container() !!}
            </div>
        </div>
    </div>


    <div class="bg-white p-2 rounded">
       <h2 class="p-2">Monthly</h2>
       {!! $occupancy_by_month->container() !!} 
    </div>

    <script src="{{ LarapexChart::cdn() }}"></script>
    {{ $occupancy_by_month->script() }}
    {{ $occupancy_by_quarter->script() }}
    {{ $occupancy_by_year->script() }}

@endsection

  