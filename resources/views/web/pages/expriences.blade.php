@extends('web.layouts.main')
@section('content')
    <section class="search-list">
        <div class="container">
           
            <form action="">

                <section class="pt-40 pb-40 bg-light-2">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="text-center">
                                    <h1 class="text-30 fw-600">Search for expriences</h1>
                                </div>
                        
                                        <div class="row w-100 m-0">
                                                                                
                                            <div class="col-lg-10 align-self-center px-30 lg:py-20 lg:px-0">
                                                <div class="form-group col-md-4">
                                                    <label for="exampleInputDate"><i class="fa fa-calendar"
                                                            aria-hidden="true"></i></label>
                                                    <input type="text" name="search_date" class="form-control"
                                                        id="datetimesl" placeholder="{{ request('search_date') ?? 'Apr 29 - May 3' }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <button class="mainSearch__submit button  -dark-1 py-15 col-12 bg-blue-1 text-white w-100 rounded-4" type="submit" fdprocessedid="a5im7m">
                                                    <i class="icon-search text-20 mr-10"></i>
                                                    <span class="text-search">Search</span>
                                                </button>
                                            </div>
                                        </div>
                            
                            </div>
                        </div>
                    </div>
                </section>

                <div class="row my-4">
                    <div class="col-md-4">
                        <aside class="sidebar y-gap-40 p-4 p-lg-0">
                            <div data-x-click="filterPopup" class="-icon-close is_mobile pb-0">
                                <i class="icon-close"></i>
                            </div>

                            <div class="sidebar__item -no-border">
                                <h5 class="text-18 fw-500 mb-10">Location</h5>
                                <div class="sidebar-checkbox">

                                    @foreach ($locations as $item)
                                    <div class="row y-gap-10 items-center justify-between">
                                        <div class="col-auto">
                                            <div class="d-flex items-center">
                                                <div class="form-checkbox ">
                                                    <input name="location_id[]" type="checkbox"  onchange="this.form.submit()" value="{{$item->id}}" {{ in_array($item->id, request()->input('location_id', [])) ? 'checked' : '' }} class="has-value">
                                                    <div class="form-checkbox__mark">
                                                        <div class="form-checkbox__icon icon-check"></div>
                                                    </div>
                                                </div>
                                                <div class="text-15 ml-10"> {{$item->location_name}}</div>
                                            </div>
                                        </div>

                                        <div class="col-auto">
                                            <div class="text-15 text-light-1"></div>
                                        </div>
                                    </div>
                                    @endforeach
                                    
                                
                                </div>
                            </div>

                            <div class="sidebar__item -no-border">
                                <h5 class="text-18 fw-500 mb-10">Tour Type</h5>
                                <div class="sidebar-checkbox">
                                
                                    
                                    @foreach ($experianceCategory as $item)
                                    <div class="row y-gap-10 items-center justify-between">
                                        <div class="col-auto">
                                            <div class="d-flex items-center">
                                                <div class="form-checkbox ">
                                                    <input name="category_id[]" type="checkbox"  onchange="this.form.submit()" value="{{$item->id}}" {{ in_array($item->id, request()->input('category_id', [])) ? 'checked' : '' }} class="has-value">
                                                    <div class="form-checkbox__mark">
                                                        <div class="form-checkbox__icon icon-check"></div>
                                                    </div>
                                                </div>
                                                <div class="text-15 ml-10"> {{$item->category_name}}</div>
                                            </div>
                                        </div>

                                        <div class="col-auto">
                                            <div class="text-15 text-light-1"></div>
                                        </div>
                                    </div>
                                    @endforeach

                                </div>
                            </div>


                            <div class="sidebar__item pb-30">
                                <h5 class="text-18 fw-500 mb-10">Price</h5>
                                <div class="row x-gap-10 y-gap-30">
                                    <div class="col-12">
                                        <div class="container my-5">
                                            <label for="priceRange" class="form-label">Price Range</label>
                                            <div class="d-flex justify-content-between">
                                                <span id="minPrice">₹{{ request('minPrice', 1000) }}</span>
                                                <span id="maxPrice">₹{{ request('maxPrice', 100000) }}</span>
                                            </div>
                                            <input type="range" class="form-range" id="priceRange" min="1000" max="100000" step="1" 
                                                   value="{{ request('maxPrice', 100000) }}" onchange="updatePriceLabels()">
                            
                                            <!-- Hidden fields to store the min and max values -->
                                            <input type="hidden" id="minHidden" name="minPrice" value="{{ request('minPrice', 1000) }}">
                                            <input type="hidden" id="maxHidden" name="maxPrice" value="{{ request('maxPrice', 100000) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            

                            <div class="sidebar__item">
                                <h5 class="text-18 fw-500 mb-10">Travel Styles</h5>
                                <div class="sidebar-checkbox">

                                    @foreach ($travel_style as $item)
                                    <div class="row y-gap-10 items-center justify-between">
                                        <div class="col-auto">
                                            <div class="d-flex items-center">
                                                <div class="form-checkbox ">
                                                    <input name="travel_style_id[]" type="checkbox"  onchange="this.form.submit()" value="{{$item->id}}" {{ in_array($item->id, request()->input('travel_style_id', [])) ? 'checked' : '' }} class="has-value">
                                                    <div class="form-checkbox__mark">
                                                        <div class="form-checkbox__icon icon-check"></div>
                                                    </div>
                                                </div>
                                                <div class="text-15 ml-10"> {{$item->attribute_name}}</div>
                                            </div>
                                        </div>

                                        <div class="col-auto">
                                            <div class="text-15 text-light-1"></div>
                                        </div>
                                    </div>
                                    @endforeach


                                </div>
                            </div>

                            <div class="sidebar__item">
                                <h5 class="text-18 fw-500 mb-10">Facilities</h5>
                                <div class="sidebar-checkbox">

                                    @foreach ($facilities as $item)
                                    <div class="row y-gap-10 items-center justify-between">
                                        <div class="col-auto">
                                            <div class="d-flex items-center">
                                                <div class="form-checkbox ">
                                                    <input name="facilitie_id[]" type="checkbox"  onchange="this.form.submit()" value="{{$item->id}}" {{ in_array($item->id, request()->input('facilitie_id', [])) ? 'checked' : '' }} class="has-value">
                                                    <div class="form-checkbox__mark">
                                                        <div class="form-checkbox__icon icon-check"></div>
                                                    </div>
                                                </div>
                                                <div class="text-15 ml-10"> {{$item->attribute_name}}</div>
                                            </div>
                                        </div>

                                        <div class="col-auto">
                                            <div class="text-15 text-light-1"></div>
                                        </div>
                                    </div>
                                    @endforeach


                                </div>
                            </div>

                            <div class="sidebar__item">
                                <h5 class="text-18 fw-500 mb-10">Tour Features</h5>
                                <div class="sidebar-checkbox">

                                    @foreach ($tour_feature as $item)
                                    <div class="row y-gap-10 items-center justify-between">
                                        <div class="col-auto">
                                            <div class="d-flex items-center">
                                                <div class="form-checkbox ">
                                                    <input name="feature_id[]" onchange="this.form.submit()" value="{{$item->id}}" {{ in_array($item->id, request()->input('feature_id', [])) ? 'checked' : '' }} type="checkbox" class="has-value">
                                                    <div class="form-checkbox__mark">
                                                        <div class="form-checkbox__icon icon-check"></div>
                                                    </div>
                                                </div>
                                                <div class="text-15 ml-10"> {{$item->attribute_name}}</div>
                                            </div>
                                        </div>

                                        <div class="col-auto">
                                            <div class="text-15 text-light-1"></div>
                                        </div>
                                    </div>
                                    @endforeach


                                </div>
                            </div>
                        </aside>
                    </div>
                
                    <div class="col-md-8">
                        <div class="row">
                    @foreach ($tours as $t)
                        <div class="col-md-6 mb-4">
                            <div class="listing-box">
                                <div class="listing-box-slider">
                                    <div class="owl-product-list owl-carousel owl-theme">
                                        @if ($t->feature_image)
                                            <div class="item"><img src="{{ URL::to('public/' . $t->feature_image) }}"
                                                    alt="{{ $t->title }}" /></div>
                                        @else
                                            <div class="item"><img src="{{ URL::to('public/images/no-image2.png') }}"
                                                    alt="{{ $t->title }}" /></div>
                                        @endif

                                        <div class="listing-box-top">
                                            <div class=" pull-left"><button class="btn btn-custom">Guest favourite</button>
                                            </div>
                                            <div class=" pull-right">
                                                <div class="rit-sid-i"><i class="fa fa-heart" aria-hidden="true"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                    <h4>
                                        <a href="{{ URL::to('exprience-details', $t->id) }}">
                                            <a href="{{ URL::to('exprience-details', $t->id) }}">
                                                {{ $t->title }}
                                            </a>
                                        </a>

                                        {{-- <span><i class="fa fa-star" aria-hidden="true"></i> 4.8 (101)</span> --}}
                                    </h4>
                                    <p>{{ $t->content }}</p>
                                    <p>{{ $t->real_address }}</p>
                                    <h5> <span>₹{{ $t->amount }}</span> total</u></h5>
                                </div>
                            </div>
                        </div>
                    @endforeach
                        </div>
                </div>
                </div>
            </form>



        </div>
    </section>
@endsection



@section('scripts')

<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.0/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://code.jquery.com/ui/1.14.0/jquery-ui.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <script>
            $(function() {
    var startDate = moment().subtract(29, 'days');  // Set default start date
    var endDate = moment();  // Set default end date

    $('#datetimesl').daterangepicker({
        startDate: startDate,
        endDate: endDate,
        locale: {
            format: 'MMM D, YYYY'  // Customize date format
        }
    });

    // Optional: Prepopulate the date picker with previously selected dates (if available)
    @if(request('search_date'))
        var dates = "{{ request('search_date') }}".split(' - ');
        $('#datetimesl').data('daterangepicker').setStartDate(dates[0]);
        $('#datetimesl').data('daterangepicker').setEndDate(dates[1]);
    @endif
});

    </script>



  <script>
   function updatePriceLabels() {
    var priceRange = document.getElementById("priceRange");
    var minPrice = document.getElementById("minPrice");
    var maxPrice = document.getElementById("maxPrice");
    var minHidden = document.getElementById("minHidden");
    var maxHidden = document.getElementById("maxHidden");

    // Assuming you want to keep the min price constant at 1000
    var minValue = 1000; 
    var maxValue = priceRange.value;  // Current value of the slider

    minPrice.textContent = "₹" + minValue;
    maxPrice.textContent = "₹" + maxValue;

    // Update hidden inputs
    minHidden.value = minValue;
    maxHidden.value = maxValue;

    // Submit the form
    priceRange.form.submit();
}


  </script>

@endsection
