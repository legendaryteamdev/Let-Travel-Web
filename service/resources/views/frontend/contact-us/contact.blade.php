@extends('frontend.layouts.master')

@section('content')


    <!--Contact section start-->
    <div class="cy_contact_wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <h1 class="cy_heading">Get In touch</h1>
                </div>
            </div>
            <div class="row padder_top50">
                <div class="col-lg-4 col-md-12">
                    <div class="cy_con_box">
                        <img src="public/theme/images/contact/con_img1.jpg" alt="phone" class="img-fluid" />
                        <div class="cy_con_overlay">
                            <div class="cy_con_data">
                                <h3>phone</h3>
                                <p>07700 900002</p>
                                <p> 07700 900980</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="cy_con_box">
                        <img src="public/theme/images/contact/con_img2.jpg" alt="email" class="img-fluid" />
                        <div class="cy_con_overlay">
                            <div class="cy_con_data">
                                <h3>Email</h3>
                                <p>cycling@yourclub.com</p>
                                <p> help@yourmail.com</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="cy_con_box">
                        <img src="public/theme/images/contact/con_img3.jpg" alt="address" class="img-fluid" />
                        <div class="cy_con_overlay">
                            <div class="cy_con_data">
                                <h3>Address</h3>
                                <p>22 Grandrose Street</p>
                                <p> North Fort Myers, FL 33917</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Map section start-->
    <div class="cy_form_wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <h1 class="cy_heading">How we can help you ?</h1>
                    <div class="cy_form padder_top50">
                        <form>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 padder_left">
                                    <div class="form-group">
                                        <input type="text" name="first_name" class="form-control require" placeholder="Name">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 padder_right">
                                    <div class="form-group">
                                        <input type="text" name="email" class="form-control require" placeholder="Email" data-valid="email" data-error="Email should be valid.">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 padder_left padder_right">
                                    <div class="form-group">
                                        <input type="text" name="subject" class="form-control" placeholder="Subject">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 padder_left padder_right">
                                    <div class="form-group">
                                        <textarea name="message" class="form-control" placeholder="Message"></textarea>
                                    </div>
                                </div>
                                <div class="response"></div>
                                <div class="col-lg-12 col-md-12 padder_left padder_right">
                                    <input type="hidden" name="form_type" value="contact">
                                    <button type="button" class="cy_button submitForm">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="cy_map">
                        <div id="contact_map"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection