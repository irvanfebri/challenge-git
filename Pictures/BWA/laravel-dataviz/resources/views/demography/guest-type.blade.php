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

<div class="row">
    <h2 class="p-3">Demography By Guest Type</h2>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="text-center pb-5">
            @foreach($dg_by_type_data as $item)
                <div class="d-inline-block bg-white m-2 rounded  text-center py-2 px-5">
                    <div class="h6">
                        {{$item->guest_type}}
                    </div>
                    <div class="h3">
                        {{$item->percentage}}%
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

  

<div class="row">
  <div class="col-md-6">
      <div class="bg-white rounded p-2">
        <h2 class="p-2">All time</h2>
        {{-- grafik all time horizontal bar chart --}}
        {!! $dg_by_type->container() !!}
      </div>
   </div>
  <div class="col-md-6">
      <div class="bg-white rounded p-2">
        <h2 class="p-2">All time</h2>
        {{-- grafik all time donut chart --}}
        {!! $dg_by_type_donut->container() !!}
      </div>
  </div>
</div>

<div class="row my-5">
  <div class="col-md-6">
      <div class="bg-white rounded p-2">
        <h2 class="p-2">Quarterly</h2>
        {{-- grafik quarterly --}}
        <form class="form-inline p-2" action="{{\Request::url()}}">
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
        {!! $dg_by_type_by_quarter->container() !!}
      </div>
   </div>
  <div class="col-md-6">
      <div class="bg-white rounded p-2">
        <h2 class="p-2">Year on Year</h2>
        {{-- grafik year on year --}}
        <form class="form-inline p-2" action="{{Request::url()}}">

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
        {!! $dg_by_type_by_year->container() !!}
      </div>
  </div>
</div>

<div class="row my-5">
    <div class="col-md-12">
        <div class="bg-white rounded p-2">
            <h2 class="p-2">Monthly</h2>
            {{-- grafik monthly --}}
            <form class="form-inline p-2" action="{{\Request::url()}}">

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
            {!! $dg_by_type_by_month->container() !!}
        </div>
    </div>
</div>

<script src="{{ LarapexChart::cdn() }}"></script>
{{ $dg_by_type->script() }}
{{ $dg_by_type_donut->script() }}
{{ $dg_by_type_by_month->script() }}
{{ $dg_by_type_by_quarter->script() }}
{{ $dg_by_type_by_year->script() }}
@endsection

  