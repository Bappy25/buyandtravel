@extends('layouts.master')

@section('title', $user->name." || Add Travel Schedule || ")

@section('content')

<!-- Page Content -->
    <div class="container">

      <!-- Page Heading/Breadcrumbs -->
      <h1 class="mt-4 mb-3">
        User Content
      </h1>

      <div class="bc-icons">
          <ol class="breadcrumb blue-gradient">
              <li class="breadcrumb-item"><a class="white-text" href="{{ route('buyandtravel') }}">Home</a></li>
              <li class="breadcrumb-item"><i class="fa fa-hand-o-right mx-2 white-text" aria-hidden="true"></i>User Content</li>
              <li class="breadcrumb-item"><i class="fa fa-hand-o-right mx-2 white-text" aria-hidden="true"></i><a href="{{ route('travel.index') }}" class="white-text">Travel History</a></li>
              <li class="breadcrumb-item active"><i class="fa fa-hand-o-right mx-2 white-text" aria-hidden="true"></i>Add Travel Schedule</li>
          </ol>
      </div>

        <!-- Content Row -->
        <div class="row">

          <!-- Sidebar Column -->
          @include('profile.sidebar')

          <!-- Content Column -->
                    <!-- Content Column -->
          <div class="col-lg-10 mb-4">
            <h2>Add Travel Schedule</h2>
            <p class="font-weight-bold">Please input following datails. Make sure your input dates don't intersect with another already scheduled journey.</p>

              {!! Form::open(['method' => 'post', 'route' => ['travel.store']]) !!}
              <div class="demo-masked-input">

                {!! Form::hidden('user_id', $user->id) !!}

                <select name="country_id" class="mdb-select colorful-select dropdown-primary" searchable="Search here..">
                  <option value="" disabled selected>Country You are Traveling to</option>
                  @foreach($countries as $id => $country)
                    <option value="{{ $id }}">{{ $country }}</option>
                  @endforeach
                </select>

                @if ($errors->has('country_id'))
                    <p class="red-text">{{ $errors->first('country_id') }}</p>
                @endif

                <div class="row">
                  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <!-- Material input text -->
                    <div class="md-form">
                      {!! Form::text('city', null, array('class' =>'form-control', 'id'=>'city')) !!}
                      {!! Form::label('city', 'City') !!}
                    </div>

                    @if ($errors->has('city'))
                        <p class="red-text">{{ $errors->first('city') }}</p>
                    @endif
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <!-- Material input text -->
                    <div class="md-form">
                      {!! Form::text('destination', null, array('class' =>'form-control', 'id'=>'destination')) !!}
                      {!! Form::label('destination', 'Visiting Zone') !!}
                    </div>

                    @if ($errors->has('destination'))
                        <p class="red-text">{{ $errors->first('destination') }}</p>
                    @endif
                  </div>
                </div>

                <div class="row">
                  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <!-- Material input text -->
                    <div class="md-form">
                      {!! Form::text('arrival_date', null, array('class' =>'form-control datepicker', 'id'=>'arrival_date')) !!}
                      {!! Form::label('arrival_date', 'Travel Start Date') !!}
                    </div>

                    @if ($errors->has('arrival_date'))
                        <p class="red-text">{{ $errors->first('arrival_date') }}</p>
                    @endif
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <!-- Material input text -->
                    <div class="md-form">
                      {!! Form::text('leave_date', null, array('class' =>'form-control datepicker', 'id'=>'leave_date')) !!}
                      {!! Form::label('leave_date', 'Travel End Date') !!}
                    </div>

                    @if ($errors->has('leave_date'))
                        <p class="red-text">{{ $errors->first('leave_date') }}</p>
                    @endif
                  </div>
                </div>

                <!-- Material input text -->
                <p class="font-weight-bold my-3">Add Tags</p>
                  {!! Form::text('tags', null, array('placeholder'=>'Seperate tags with commas', 'data-role' =>'tagsinput')) !!}
                <hr>

                @if ($errors->has('tags'))
                    <p class="red-text">{{ $errors->first('tags') }}</p>
                @endif

                <p class="font-weight-bold my-3">Add Travel Details</p>

                @if ($errors->has('additional_details'))
                    <p class="red-text">{{ $errors->first('additional_details') }}</p>
                @endif
                
                <!-- Material Editor -->
                <div class="md-form">
                    {!! Form::textarea('additional_details', null, array('class'=>'editor')) !!}
                </div>

                <div class="text-center my-4">
                    {!! Form::submit('Add Travel Schedule', array('class' =>'btn btn-primary')) !!}
                </div>

                {!! Form::close() !!}
              </div>
          </div>
        </div>
        <!-- /.row -->

    </div>
    <!-- Contents -->

@endsection

