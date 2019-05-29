@extends('frontend.layouts.master')
@section('content')
    <!--Banner section start-->
    <div class="cy_bread_wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <h1>Resort</h1>
                </div>
            </div>
        </div>
    </div>
<!--Events Sevtion Start-->
    <div class="cy_event_wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <h1 class="cy_heading">Exploring the place that you want to visit</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="cy_event_box">
                        <div class="cy_event_img">
                            <a href="{{ route('resort-detail')}}">
                            <img src="public/theme/images/event/event1.jpg" alt="event" class="img-fluid" />
                            </a>
                            <div class="cy_event_detail">
                                <div class="cy_event_time">
                                    <ul>
                                        <li><i><img src="public/theme/images/svg/clock.svg" alt="event time"></i> 12:00 PM to 5:00PM</li>
                                        <li><i><img src="public/theme/images/svg/map.svg" alt="event address"></i>Northumberland</li>
                                    </ul>
                                </div>
                                <div class="cy_event_date">
                                    <span class="ev_date">08 nov</span>
                                    <span class="ev_yr">2018</span>
                                </div>
                            </div>
                        </div>
                        <div class="cy_event_data">
                            <h2><a href="{{ route('resort-detail')}}">Northumberland Cycling Event 2018</a></h2>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer.</p>
                            <a href="event_single.html" class="cy_button">read more</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="cy_event_box">
                        <div class="cy_event_img">
                            <img src="public/theme/images/event/event2.jpg" alt="event" class="img-fluid" />
                            <div class="cy_event_detail">
                                <div class="cy_event_time">
                                    <ul>
                                        <li><i><img src="public/theme/images/svg/clock.svg" alt="event time"></i> 12:00 PM to 5:00PM</li>
                                        <li><i><img src="public/theme/images/svg/map.svg" alt="event address"></i>Northumberland</li>
                                    </ul>
                                </div>
                                <div class="cy_event_date">
                                    <span class="ev_date">08 nov</span>
                                    <span class="ev_yr">2018</span>
                                </div>
                            </div>
                        </div>
                        <div class="cy_event_data">
                            <h2><a href="event_single.html">Tour de Felasco 2018</a></h2>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer.</p>
                            <a href="event_single.html" class="cy_button">read more</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="cy_event_box">
                        <div class="cy_event_img">
                            <img src="public/theme/images/event/event3.jpg" alt="event" class="img-fluid" />
                            <div class="cy_event_detail">
                                <div class="cy_event_time">
                                    <ul>
                                        <li><i><img src="public/theme/images/svg/clock.svg" alt="event time"></i> 12:00 PM to 5:00PM</li>
                                        <li><i><img src="public/theme/images/svg/map.svg" alt="event address"></i>Northumberland</li>
                                    </ul>
                                </div>
                                <div class="cy_event_date">
                                    <span class="ev_date">08 nov</span>
                                    <span class="ev_yr">2018</span>
                                </div>
                            </div>
                        </div>
                        <div class="cy_event_data">
                            <h2><a href="event_single.html">Covered Bridges Ride 2018</a></h2>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer.</p>
                            <a href="event_single.html" class="cy_button">read more</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="cy_event_box">
                        <div class="cy_event_img">
                            <img src="public/theme/images/event/event7.jpg" alt="event" class="img-fluid" />
                            <div class="cy_event_detail">
                                <div class="cy_event_time">
                                    <ul>
                                        <li><i><img src="public/theme/images/svg/clock.svg" alt="event time"></i> 12:00 PM to 5:00PM</li>
                                        <li><i><img src="public/theme/images/svg/map.svg" alt="event address"></i>Northumberland</li>
                                    </ul>
                                </div>
                                <div class="cy_event_date">
                                    <span class="ev_date">08 nov</span>
                                    <span class="ev_yr">2018</span>
                                </div>
                            </div>
                        </div>
                        <div class="cy_event_data">
                            <h2><a href="event_single.html">2018 Tour de Gruene TOURS</a></h2>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer.</p>
                            <a href="event_single.html" class="cy_button">read more</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="cy_event_box">
                        <div class="cy_event_img">
                            <img src="public/theme/images/event/event8.jpg" alt="event" class="img-fluid" />
                            <div class="cy_event_detail">
                                <div class="cy_event_time">
                                    <ul>
                                        <li><i><img src="public/theme/images/svg/clock.svg" alt="event time"></i> 12:00 PM to 5:00PM</li>
                                        <li><i><img src="public/theme/images/svg/map.svg" alt="event address"></i>Northumberland</li>
                                    </ul>
                                </div>
                                <div class="cy_event_date">
                                    <span class="ev_date">08 nov</span>
                                    <span class="ev_yr">2018</span>
                                </div>
                            </div>
                        </div>
                        <div class="cy_event_data">
                            <h2><a href="event_single.html">2018 Giro di San Diego</a></h2>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer.</p>
                            <a href="event_single.html" class="cy_button">read more</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="cy_event_box">
                        <div class="cy_event_img">
                            <img src="public/theme/images/event/event9.jpg" alt="event" class="img-fluid" />
                            <div class="cy_event_detail">
                                <div class="cy_event_time">
                                    <ul>
                                        <li><i><img src="public/theme/images/svg/clock.svg" alt="event time"></i> 12:00 PM to 5:00PM</li>
                                        <li><i><img src="public/theme/images/svg/map.svg" alt="event address"></i>Northumberland</li>
                                    </ul>
                                </div>
                                <div class="cy_event_date">
                                    <span class="ev_date">08 nov</span>
                                    <span class="ev_yr">2018</span>
                                </div>
                            </div>
                        </div>
                        <div class="cy_event_data">
                            <h2><a href="event_single.html">Tour de Pig 2018</a></h2>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer.</p>
                            <a href="event_single.html" class="cy_button">read more</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection