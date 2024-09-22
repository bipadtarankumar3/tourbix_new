@extends('web.layouts.main')
@section('content')
    <section class="search-list">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h5 class="mt-4 mb-4">{{ count($tours) }}</h5>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <aside class="sidebar y-gap-40 p-4 p-lg-0">
                        <div data-x-click="filterPopup" class="-icon-close is_mobile pb-0">
                            <i class="icon-close"></i>
                        </div>
                        <div class="sidebar__item -no-border">
                            <h5 class="text-18 fw-500 mb-10">Tour Type</h5>
                            <div class="sidebar-checkbox">
                                <div class="row y-gap-10 items-center justify-between">
                                    <div class="col-auto">
                                        <div class="d-flex items-center">
                                            <div class="form-checkbox ">
                                                <input name="cat_id[]" type="checkbox" value="1" class="has-value">
                                                <div class="form-checkbox__mark">
                                                    <div class="form-checkbox__icon icon-check"></div>
                                                </div>
                                            </div>
                                            <div class="text-15 ml-10"> Wildlife Tour</div>
                                        </div>
                                    </div>

                                    <div class="col-auto">
                                        <div class="text-15 text-light-1"></div>
                                    </div>
                                </div>
                                <div class="row y-gap-10 items-center justify-between">
                                    <div class="col-auto">
                                        <div class="d-flex items-center">
                                            <div class="form-checkbox ">
                                                <input name="cat_id[]" type="checkbox" value="2" class="has-value">
                                                <div class="form-checkbox__mark">
                                                    <div class="form-checkbox__icon icon-check"></div>
                                                </div>
                                            </div>
                                            <div class="text-15 ml-10"> Adventure Tour</div>
                                        </div>
                                    </div>

                                    <div class="col-auto">
                                        <div class="text-15 text-light-1"></div>
                                    </div>
                                </div>
                                <div class="row y-gap-10 items-center justify-between">
                                    <div class="col-auto">
                                        <div class="d-flex items-center">
                                            <div class="form-checkbox ">
                                                <input name="cat_id[]" type="checkbox" value="7" class="has-value">
                                                <div class="form-checkbox__mark">
                                                    <div class="form-checkbox__icon icon-check"></div>
                                                </div>
                                            </div>
                                            <div class="text-15 ml-10">- River Rafting</div>
                                        </div>
                                    </div>

                                    <div class="col-auto">
                                        <div class="text-15 text-light-1"></div>
                                    </div>
                                </div>
                                <div class="row y-gap-10 items-center justify-between">
                                    <div class="col-auto">
                                        <div class="d-flex items-center">
                                            <div class="form-checkbox ">
                                                <input name="cat_id[]" type="checkbox" value="3" class="has-value">
                                                <div class="form-checkbox__mark">
                                                    <div class="form-checkbox__icon icon-check"></div>
                                                </div>
                                            </div>
                                            <div class="text-15 ml-10"> City Tours</div>
                                        </div>
                                    </div>

                                    <div class="col-auto">
                                        <div class="text-15 text-light-1"></div>
                                    </div>
                                </div>
                                <div class="row y-gap-10 items-center justify-between">
                                    <div class="col-auto">
                                        <div class="d-flex items-center">
                                            <div class="form-checkbox ">
                                                <input name="cat_id[]" type="checkbox" value="5" class="has-value">
                                                <div class="form-checkbox__mark">
                                                    <div class="form-checkbox__icon icon-check"></div>
                                                </div>
                                            </div>
                                            <div class="text-15 ml-10"> Beaches Tour</div>
                                        </div>
                                    </div>

                                    <div class="col-auto">
                                        <div class="text-15 text-light-1"></div>
                                    </div>
                                </div>
                                <div class="row y-gap-10 items-center justify-between">
                                    <div class="col-auto">
                                        <div class="d-flex items-center">
                                            <div class="form-checkbox ">
                                                <input name="cat_id[]" type="checkbox" value="6" class="has-value">
                                                <div class="form-checkbox__mark">
                                                    <div class="form-checkbox__icon icon-check"></div>
                                                </div>
                                            </div>
                                            <div class="text-15 ml-10"> Camping</div>
                                        </div>
                                    </div>

                                    <div class="col-auto">
                                        <div class="text-15 text-light-1"></div>
                                    </div>
                                </div>
                                <div class="row y-gap-10 items-center justify-between">
                                    <div class="col-auto">
                                        <div class="d-flex items-center">
                                            <div class="form-checkbox ">
                                                <input name="cat_id[]" type="checkbox" value="9" class="has-value">
                                                <div class="form-checkbox__mark">
                                                    <div class="form-checkbox__icon icon-check"></div>
                                                </div>
                                            </div>
                                            <div class="text-15 ml-10"> Holidays</div>
                                        </div>
                                    </div>

                                    <div class="col-auto">
                                        <div class="text-15 text-light-1"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="sidebar__item pb-30">
                            <h5 class="text-18 fw-500 mb-10">Price</h5>
                            <div class="row x-gap-10 y-gap-30">
                                <div class="col-12">
                                    <div class="js-price-searchPage">
                                        <div class="text-14 fw-500"></div>

                                        <input type="hidden" class="filter-price irs-hidden-input" name="price_range"
                                            data-symbol=" ₹" data-min="10" data-max="650000" data-from="10"
                                            data-to="650000" readonly="" value="">
                                        <div class="d-flex justify-between mb-20">
                                            <div class="text-15 text-dark-1">
                                                <span class="js-lower"> ₹10</span>
                                                -
                                                <span class="js-upper"> ₹650000</span>
                                            </div>
                                        </div>
                                        <div class="px-5">
                                            <div class="js-slider noUi-target noUi-ltr noUi-horizontal noUi-txt-dir-ltr">
                                                <div class="noUi-base">
                                                    <div class="noUi-connects">
                                                        <div class="noUi-connect"
                                                            style="transform: translate(0%, 0px) scale(1, 1);"></div>
                                                    </div>
                                                    <div class="noUi-origin"
                                                        style="transform: translate(-100%, 0px); z-index: 5;">
                                                        <div class="noUi-handle noUi-handle-lower" data-handle="0"
                                                            tabindex="0" role="slider" aria-orientation="horizontal"
                                                            aria-valuemin="10.0" aria-valuemax="650000.0"
                                                            aria-valuenow="10.0" aria-valuetext=" ₹10">
                                                            <div class="noUi-touch-area"></div>
                                                        </div>
                                                    </div>
                                                    <div class="noUi-origin"
                                                        style="transform: translate(0%, 0px); z-index: 4;">
                                                        <div class="noUi-handle noUi-handle-upper" data-handle="1"
                                                            tabindex="0" role="slider" aria-orientation="horizontal"
                                                            aria-valuemin="10.0" aria-valuemax="650000.0"
                                                            aria-valuenow="650000.0" aria-valuetext=" ₹650000">
                                                            <div class="noUi-touch-area"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit"
                                            class="flex-center bg-blue-1 rounded-4 px-3 py-1 mt-3 text-12 fw-600 text-white btn-apply-price-range mt-20">APPLY</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="sidebar__item">
                            <h5 class="text-18 fw-500 mb-10">Travel Styles</h5>
                            <div class="sidebar-checkbox">

                                <div class="row y-gap-10 items-center justify-between">
                                    <div class="col-auto">
                                        <div class="d-flex items-center">
                                            <div class="form-checkbox ">
                                                <input type="checkbox" name="terms[]" value="1" class="has-value">
                                                <div class="form-checkbox__mark">
                                                    <div class="form-checkbox__icon icon-check"></div>
                                                </div>
                                            </div>
                                            <div class="text-15 ml-10">Cultural</div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="text-15 text-light-1"></div>
                                    </div>
                                </div>
                                <div class="row y-gap-10 items-center justify-between">
                                    <div class="col-auto">
                                        <div class="d-flex items-center">
                                            <div class="form-checkbox ">
                                                <input type="checkbox" name="terms[]" value="2" class="has-value">
                                                <div class="form-checkbox__mark">
                                                    <div class="form-checkbox__icon icon-check"></div>
                                                </div>
                                            </div>
                                            <div class="text-15 ml-10">Nature &amp; Adventure</div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="text-15 text-light-1"></div>
                                    </div>
                                </div>
                                <div class="row y-gap-10 items-center justify-between">
                                    <div class="col-auto">
                                        <div class="d-flex items-center">
                                            <div class="form-checkbox ">
                                                <input type="checkbox" name="terms[]" value="3" class="has-value">
                                                <div class="form-checkbox__mark">
                                                    <div class="form-checkbox__icon icon-check"></div>
                                                </div>
                                            </div>
                                            <div class="text-15 ml-10">Marine</div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="text-15 text-light-1"></div>
                                    </div>
                                </div>
                                <div class="row y-gap-10 items-center justify-between">
                                    <div class="col-auto">
                                        <div class="d-flex items-center">
                                            <div class="form-checkbox ">
                                                <input type="checkbox" name="terms[]" value="4" class="has-value">
                                                <div class="form-checkbox__mark">
                                                    <div class="form-checkbox__icon icon-check"></div>
                                                </div>
                                            </div>
                                            <div class="text-15 ml-10">Independent</div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="text-15 text-light-1"></div>
                                    </div>
                                </div>
                                <div class="row y-gap-10 items-center justify-between">
                                    <div class="col-auto">
                                        <div class="d-flex items-center">
                                            <div class="form-checkbox ">
                                                <input type="checkbox" name="terms[]" value="5" class="has-value">
                                                <div class="form-checkbox__mark">
                                                    <div class="form-checkbox__icon icon-check"></div>
                                                </div>
                                            </div>
                                            <div class="text-15 ml-10">Activities</div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="text-15 text-light-1"></div>
                                    </div>
                                </div>
                                <div class="row y-gap-10 items-center justify-between">
                                    <div class="col-auto">
                                        <div class="d-flex items-center">
                                            <div class="form-checkbox ">
                                                <input type="checkbox" name="terms[]" value="6" class="has-value">
                                                <div class="form-checkbox__mark">
                                                    <div class="form-checkbox__icon icon-check"></div>
                                                </div>
                                            </div>
                                            <div class="text-15 ml-10">Festival &amp; Events</div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="text-15 text-light-1"></div>
                                    </div>
                                </div>
                                <div class="row y-gap-10 items-center justify-between">
                                    <div class="col-auto">
                                        <div class="d-flex items-center">
                                            <div class="form-checkbox ">
                                                <input type="checkbox" name="terms[]" value="7" class="has-value">
                                                <div class="form-checkbox__mark">
                                                    <div class="form-checkbox__icon icon-check"></div>
                                                </div>
                                            </div>
                                            <div class="text-15 ml-10">Special Interest</div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="text-15 text-light-1"></div>
                                    </div>
                                </div>


                            </div>
                        </div>

                        <div class="sidebar__item">
                            <h5 class="text-18 fw-500 mb-10">Facilities</h5>
                            <div class="sidebar-checkbox">

                                <div class="row y-gap-10 items-center justify-between">
                                    <div class="col-auto">
                                        <div class="d-flex items-center">
                                            <div class="form-checkbox ">
                                                <input type="checkbox" name="terms[]" value="8" class="has-value">
                                                <div class="form-checkbox__mark">
                                                    <div class="form-checkbox__icon icon-check"></div>
                                                </div>
                                            </div>
                                            <div class="text-15 ml-10">Wifi</div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="text-15 text-light-1"></div>
                                    </div>
                                </div>
                                <div class="row y-gap-10 items-center justify-between">
                                    <div class="col-auto">
                                        <div class="d-flex items-center">
                                            <div class="form-checkbox ">
                                                <input type="checkbox" name="terms[]" value="9" class="has-value">
                                                <div class="form-checkbox__mark">
                                                    <div class="form-checkbox__icon icon-check"></div>
                                                </div>
                                            </div>
                                            <div class="text-15 ml-10">Gymnasium</div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="text-15 text-light-1"></div>
                                    </div>
                                </div>
                                <div class="row y-gap-10 items-center justify-between">
                                    <div class="col-auto">
                                        <div class="d-flex items-center">
                                            <div class="form-checkbox ">
                                                <input type="checkbox" name="terms[]" value="10" class="has-value">
                                                <div class="form-checkbox__mark">
                                                    <div class="form-checkbox__icon icon-check"></div>
                                                </div>
                                            </div>
                                            <div class="text-15 ml-10">Mountain Bike</div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="text-15 text-light-1"></div>
                                    </div>
                                </div>
                                <div class="row y-gap-10 items-center justify-between">
                                    <div class="col-auto">
                                        <div class="d-flex items-center">
                                            <div class="form-checkbox ">
                                                <input type="checkbox" name="terms[]" value="11" class="has-value">
                                                <div class="form-checkbox__mark">
                                                    <div class="form-checkbox__icon icon-check"></div>
                                                </div>
                                            </div>
                                            <div class="text-15 ml-10">Satellite Office</div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="text-15 text-light-1"></div>
                                    </div>
                                </div>
                                <div class="row y-gap-10 items-center justify-between">
                                    <div class="col-auto">
                                        <div class="d-flex items-center">
                                            <div class="form-checkbox ">
                                                <input type="checkbox" name="terms[]" value="12" class="has-value">
                                                <div class="form-checkbox__mark">
                                                    <div class="form-checkbox__icon icon-check"></div>
                                                </div>
                                            </div>
                                            <div class="text-15 ml-10">Staff Lounge</div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="text-15 text-light-1"></div>
                                    </div>
                                </div>
                                <div class="row y-gap-10 items-center justify-between">
                                    <div class="col-auto">
                                        <div class="d-flex items-center">
                                            <div class="form-checkbox ">
                                                <input type="checkbox" name="terms[]" value="13" class="has-value">
                                                <div class="form-checkbox__mark">
                                                    <div class="form-checkbox__icon icon-check"></div>
                                                </div>
                                            </div>
                                            <div class="text-15 ml-10">Golf Cages</div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="text-15 text-light-1"></div>
                                    </div>
                                </div>
                                <div class="row y-gap-10 items-center justify-between">
                                    <div class="col-auto">
                                        <div class="d-flex items-center">
                                            <div class="form-checkbox ">
                                                <input type="checkbox" name="terms[]" value="14" class="has-value">
                                                <div class="form-checkbox__mark">
                                                    <div class="form-checkbox__icon icon-check"></div>
                                                </div>
                                            </div>
                                            <div class="text-15 ml-10">Aerobics Room</div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="text-15 text-light-1"></div>
                                    </div>
                                </div>


                            </div>
                        </div>

                        <div class="sidebar__item">
                            <h5 class="text-18 fw-500 mb-10">Tour Features</h5>
                            <div class="sidebar-checkbox">

                                <div class="row y-gap-10 items-center justify-between">
                                    <div class="col-auto">
                                        <div class="d-flex items-center">
                                            <div class="form-checkbox ">
                                                <input type="checkbox" name="terms[]" value="110" class="has-value">
                                                <div class="form-checkbox__mark">
                                                    <div class="form-checkbox__icon icon-check"></div>
                                                </div>
                                            </div>
                                            <div class="text-15 ml-10">Transport Included</div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="text-15 text-light-1"></div>
                                    </div>
                                </div>
                                <div class="row y-gap-10 items-center justify-between">
                                    <div class="col-auto">
                                        <div class="d-flex items-center">
                                            <div class="form-checkbox ">
                                                <input type="checkbox" name="terms[]" value="111" class="has-value">
                                                <div class="form-checkbox__mark">
                                                    <div class="form-checkbox__icon icon-check"></div>
                                                </div>
                                            </div>
                                            <div class="text-15 ml-10">Meals Included</div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="text-15 text-light-1"></div>
                                    </div>
                                </div>
                                <div class="row y-gap-10 items-center justify-between">
                                    <div class="col-auto">
                                        <div class="d-flex items-center">
                                            <div class="form-checkbox ">
                                                <input type="checkbox" name="terms[]" value="112" class="has-value">
                                                <div class="form-checkbox__mark">
                                                    <div class="form-checkbox__icon icon-check"></div>
                                                </div>
                                            </div>
                                            <div class="text-15 ml-10">Stay Included</div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="text-15 text-light-1"></div>
                                    </div>
                                </div>
                                <div class="row y-gap-10 items-center justify-between">
                                    <div class="col-auto">
                                        <div class="d-flex items-center">
                                            <div class="form-checkbox ">
                                                <input type="checkbox" name="terms[]" value="113" class="has-value">
                                                <div class="form-checkbox__mark">
                                                    <div class="form-checkbox__icon icon-check"></div>
                                                </div>
                                            </div>
                                            <div class="text-15 ml-10">Sightseeing</div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="text-15 text-light-1"></div>
                                    </div>
                                </div>


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
                                    <a href="{{ URL::to('tour-details', $t->id) }}">
                                        <a href="{{ URL::to('tour-details', $t->id) }}">
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




        </div>
    </section>
@endsection
