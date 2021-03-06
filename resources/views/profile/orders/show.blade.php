@extends('layouts.master')

@section('title', $user->name." || View Order Details || ")

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
              <li class="breadcrumb-item"><a class="white-text" href="{{ route('orders.index') }}"><i class="fa fa-hand-o-right mx-2 white-text" aria-hidden="true"></i>Orders</a></li>
              <li class="breadcrumb-item active"><i class="fa fa-hand-o-right mx-2 white-text" aria-hidden="true"></i>View Order Details</li>
          </ol>
      </div>

        <!-- Content Row -->
        <div class="row">

          <!-- Sidebar Column -->
          @include('profile.sidebar')

            <!-- Content Column -->
            <div class="col-lg-10">
              <h2>View Order Details</h2>
              <h5 class="my-3 font-weight-bold">{{ $order->product_name }}</h5>
              <h6><i class="fa fa-tags fa-sm pr-2"></i><span class="dark-grey-text">{{ $order->product_type->product_type }}</span></h6>
              <hr class="mb-4">
              <p class="mt-4">
                <i class="fa fa-clock-o fa-sm pr-2"></i><span class="font-weight-bold light-blue-text">{{$order->created_at->format('l d F Y, h:i A')}}</span>
              </p>
              {!! Form::open(['route' => ['orders.destroy', $order->id], 'method'=>'delete']) !!}
                  <a href="{{ $order->reference_link }}" class="btn btn-blue btn-sm" target="_blank"><i class="fa fa-external-link fa-sm pr-2"" aria-hidden="true"></i>Reference Link</a>
                  <a href="#offers" class="btn btn-primary btn-sm"><i class="fa fa-eye fa-sm pr-2"" aria-hidden="true"></i>View Offers</a>
                  <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-indigo btn-sm"><i class="fa fa-edit fa-sm pr-2" aria-hidden="true"></i>Update Order</a>
                  {!! Form::button('<i class="fa fa-trash fa-sm pr-2"" aria-hidden="true"></i>Delete', array('class' => 'btn btn-unique btn-sm form_warning_sweet_alert', 'title'=>'Are you sure?', 'text'=>'Your order will disapper!', 'confirmButtonText'=>'Yes, delete order!', 'type'=>'submit')) !!}
              {!! Form::close() !!}

                <!-- Portfolio Section -->
                <div class="item my-4" id="aniimated-thumbnials">
                  <ul id="content-slider" class="content-slider">
                    @foreach($order->images as $image)
                      <li>
                          <a href="{{ asset($image->src) }}" data-sub-html="{{ $order->product_name.' '.$loop->iteration }}"> 
                            <img class="img-fluid" src="{{ asset($image->src) }}" alt="{{ $image->alt.' '.$loop->iteration }}">
                          </a>
                          {!! Form::open(['route' => ['order.image.delete', $image->id], 'method'=>'delete']) !!}
                            {!! Form::button('<i class="fa fa-trash"" aria-hidden="true"></i>', array('class' => 'btn btn-unique btn-sm form_warning_sweet_alert', 'title'=>'Are you sure?', 'text'=>'This image can not be recovered!', 'confirmButtonText'=>'Yes, delete image!', 'type'=>'submit')) !!}
                          {!! Form::close() !!}
                      </li>
                    @endforeach  
                  </ul>
                  @if(count($order->images) < 5)
                    <button type="button" class="btn blue-gradient btn-sm" data-toggle="modal" data-target="#updateimage">
                      <i class="fa fa-plus fa-sm pr-2"" aria-hidden="true"></i>Add  a new image
                    </button>
                  @endif
                </div>
                <!-- #End# Portfolio Section -->

                <button class="btn btn-primary btn-md mb-4" id="showDetailsButton" type="button" data-toggle="collapse" data-target="#showDetails" aria-expanded="false" aria-controls="showDetails">
                  <i class="fa fa-folder-open fa-sm pr-2"></i>Click Here to Show Details
                </button>
                <div class="collapse" id="showDetails">
                  {!! $order->additional_details !!}
                </div>

                <h5 class="my-4"><i class="fa fa-money fa-sm pr-2"></i>{{ $order->expected_price }}/=</h5>
                <h6 class="my-4"><i class="fa fa-map-signs fa-sm pr-2"></i>{{ $order->delivery_location }}</h6>
                <p class="my-4">
                  @if( !empty($order->tags) )
                    @php $tags = explode(',', $order->tags); @endphp
                    @foreach($tags as $tag) <div class="chip blue lighten-1 white-text">{{ $tag }}</div> @endforeach
                  @endif
                </p>
                <p class="grey-text">Views: {{ $order->views }}</p>
                @if(empty($order->accepted))
                  <h4 id="offers">Offers</h4><hr>
                  <div class="table-responsive my-5">
                    <table class="table table-striped table-fixed" id="dataTable">
                      <thead>
                          <tr>
                            <th>#</th>
                            <th>
                              <i class="fa fa-user fa-sm pr-2"></i>Added By
                              <i class="fa fa-sort float-right" aria-hidden="true"></i>
                            </th>
                            <th>
                              <i class="fa fa-cart-plus fa-sm pr-2"></i>Quantity
                              <i class="fa fa-sort float-right" aria-hidden="true"></i>
                            </th>
                            <th>
                              <i class="fa fa-dollar fa-sm pr-2"></i>Asking Price
                              <i class="fa fa-sort float-right" aria-hidden="true"></i>
                            </th>
                            <th>
                              <i class="fa fa-calendar-check-o fa-sm pr-2"></i>Delivery Date
                              <i class="fa fa-sort float-right" aria-hidden="true"></i>
                            </th>
                            <th>
                              <i class="fa fa-clock-o fa-sm pr-2"></i>Add Date
                              <i class="fa fa-sort float-right" aria-hidden="true"></i>
                            </th>
                            <th>
                              <i class="fa fa-gears fa-sm pr-2"></i>Actions
                              <i class="fa fa-sort float-right" aria-hidden="true"></i>
                            </th>
                          </tr>
                      </thead>
                      <tbody>
                        @foreach($order->offers as $offer)
                          <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $offer->user->name }}</td>
                            <td>{{ $offer->product_quantity }}</td>
                            <td>{{ $offer->asking_price }}/=</td>
                            <td>{{ date('l d F Y', strtotime($offer->delivery_date)) }}</td>
                            <td>{{ $offer->created_at->format('l d F Y, h:i A') }}</td>
                            <td>
                                <div class="dropdown" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Actions
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                      <button class="dropdown-item view_offer_details_button" data-offer="{{ $offer->id }}" data-order="{{ $order->id }}" data-toggle="modal" data-target="#viewOfferDetails">
                                        <i class="fa fa-eye fa-sm pr-2" aria-hidden="true"></i>View Details
                                      </button>
                                      <a class="dropdown-item" href="{{ route('messages.show', $offer->message_subject_id) }}" target="_blank"><i class="fa fa-comments fa-sm pr-2" aria-hidden="true"></i>Offer Conversation</a>
                                      {!! Form::open(['route' => ['order.offer.accept'], 'method'=>'post']) !!}
                                      {!! Form::hidden('offer_id', $offer->id) !!}
                                      {!! Form::hidden('order_id', $order->id) !!}
                                        {!! Form::button('<i class="fa fa-check fa-sm pr-2" aria-hidden="true"></i>Accept Offer', array('class' => 'dropdown-item form_warning_sweet_alert', 'title'=>'Are you sure to accept this offer?', 'text'=>'Rest of the offers will disappear and updating or deleting the order will be disabled! Make sure you have read the offer thoroughly and confirmed the deal with the offerer!', 'confirmButtonText'=>'Yes, accept offer!', 'type'=>'submit')) !!}
                                      {!! Form::close() !!} 
                                    </div>
                                </div>
                            </td>
                          </tr>
                        @endforeach   
                      </tbody>
                      <tfoot>
                        <tr>
                          <th>#</th>
                          <th><i class="fa fa-shopping-bag fa-sm pr-2"></i>Added By</th>
                          <th><i class="fa fa-cart-plus fa-sm pr-2"></i>Quantity</th>
                          <th><i class="fa fa-dollar fa-sm pr-2"></i>Asking Price</th>
                          <th><i class="fa fa-calendar-check-o fa-sm pr-2"></i>Delivery Date</th>
                          <th><i class="fa fa-clock-o fa-sm pr-2"></i>Add Date</th>
                          <th><i class="fa fa-gears fa-sm pr-2"></i>Actions</th>
                        </tr>
                      </tfoot>
                  </table>
                </div>
              @else
                <h4 id="offers">Accpeted Offer</h4><hr>
                <p class="mt-4">
                  <i class="fa fa-clock-o fa-sm pr-2"></i><span class="font-weight-bold light-blue-text">{{$order->accepted->created_at->format('l d F Y, h:i A')}}</span>
                </p>
                <div class="row">
                  <div class="col-xl-5 col-lg-4 col-sm-4">
                    <a class="btn btn-blue btn-sm" href="#" target="_blank"><i class="fa fa-comments fa-sm pr-2" aria-hidden="true"></i>Offer Conversation</a>
                  </div>
                  <div class="col-xl-5 col-lg-5 col-sm-5">
                    @if(empty($order->accepted->recieved))
                      {!! Form::open(['route' => ['order.offer.recieve', $order->accepted->id], 'method'=>'put']) !!}
                        {!! Form::button('<i class="fa fa-question-circle fa-sm pr-2"" aria-hidden="true"></i>Set reciept status', array('class' => 'btn btn-warning btn-sm', 'type'=>'submit')) !!}
                      {!! Form::close() !!}
                    @else
                      <button class="btn btn-green btn-sm">
                        <i class="fa fa-check fa-sm pr-2"" aria-hidden="true"></i>Received {{ date('l d F Y', strtotime($order->accepted->recieved)) }}
                      </button>
                    @endif
                  </div>
                  <div class="col-xl-2 col-lg-3 col-sm-3">
                    {!! Form::open(['route' => ['order.offer.remove', $order->accepted->id], 'method'=>'delete']) !!}
                      {!! Form::button('<i class="fa fa-trash fa-sm pr-2"" aria-hidden="true"></i>Remove', array('class' => 'btn btn-unique btn-sm form_warning_sweet_alert', 'title'=>'Are you sure?', 'text'=>'Once accepted offer is removed other offers will resurface and the order will reappear in the front page list!', 'confirmButtonText'=>'Yes, remove accepted offer!', 'type'=>'submit')) !!}
                    {!! Form::close() !!}
                  </div>
                </div>
                <ul class="list-group list-group-flush my-4">
                  <li class="list-group-item">
                    <i class="fa fa-user fa-sm pr-2"></i>
                    <strong>Added By:</strong> 
                    {{ $order->accepted->offer->user->name }}
                  </li>
                  <li class="list-group-item">
                    <i class="fa fa-cart-plus fa-sm pr-2"></i>
                    <strong>Quantity:</strong> 
                    {{ $order->accepted->offer->product_quantity }}
                  </li>
                  <li class="list-group-item">
                    <i class="fa fa-dollar fa-sm pr-2"></i>
                    <strong>Asking Price:</strong> 
                    {{ $order->accepted->offer->asking_price }}/=
                  </li>
                  <li class="list-group-item">
                    <i class="fa fa-calendar-check-o fa-sm pr-2"></i>
                    <strong>Delivery Date:</strong> 
                    {{ date('l d F Y', strtotime($order->accepted->offer->delivery_date)) }}
                  </li>
                </ul>
                {!! $order->accepted->offer->additional_details !!}
              @endif
            <!-- #END# Content Column -->
        </div>
        <!-- /.row -->

    </div>
    <!-- Contents -->

    <!-- Image Modal -->
    <div class="modal fade" id="updateimage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Order Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body image_modal">
                  <div class="text-center">
                    <img src="http://placehold.it/200" class="img-fluid z-depth-1 preview_input" alt="Responsive image">
                    <p class="text-center mt-4">Maximum Allowed Size: 500 KB</p>
                  </div>
                    {!! Form::open(['class'=>'md-form upload_image', 'method' => 'post', 'route' => ['order.image.add'], 'enctype' => 'multipart/form-data']) !!}
                      {!! Form::hidden('id', $order->id) !!}
                      <div class="file-field">
                          <div class="btn btn-primary btn-sm float-left">
                              <span>Select</span>
                              {!! Form::file("image", ['class'=>'input_image']) !!}
                          </div>
                          <div class="file-path-wrapper">
                              {!! Form::text('', null, ['class'=>'file-path validate', 'placeholder'=>'Choose your file']) !!}
                          </div>
                      </div>
                      <div class="text-center mt-4">
                          {{ Form::button('Upload Image <i class="fa fa-upload ml-1"></i>', ['type' => 'submit', 'class' => 'btn primary-color-dark mt-1 btn-md'] ) }}
                      </div>
                    {!! Form::close() !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Image Modal -->

    <!-- Offer Details Modal -->
    <div class="modal fade" id="viewOfferDetails" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title w-100" id="viewDetailsTitle">View Offer Details</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div id="modal_offer_details"></div>
          </div>
          <div class="modal-footer">
            {!! Form::open(['route' => ['order.offer.accept'], 'method'=>'post']) !!}
              {!! Form::hidden('offer_id', '', ['id'=>'modal_offer_id']) !!}
              {!! Form::hidden('order_id', '', ['id'=>'modal_order_id']) !!}
              {!! Form::button('<i class="fa fa-check fa-sm pr-2" aria-hidden="true"></i>Accept Offer', array('class' => 'btn btn-indigo btn-sm form_warning_sweet_alert', 'id'=>'modal_accept_offer_btn', 'title'=>'Are you sure to accept this offer?', 'text'=>'Rest of the offers will disappear and updating or deleting the order will be disabled! Make sure you have read the offer thoroughly and confirmed the deal with the offerer!', 'confirmButtonText'=>'Yes, accept offer!', 'type'=>'submit', 'disabled'=>'true')) !!}
              <button type="button" class="btn btn-warning btn-sm" data-dismiss="modal">Close</button>
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
    <!-- Offer Details Modal -->

@endsection

