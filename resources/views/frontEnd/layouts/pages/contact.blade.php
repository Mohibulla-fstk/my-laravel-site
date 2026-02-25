@extends('frontEnd.layouts.master')
@section('title', 'Customer Account')

@section('content')
    <div class="blankspace"></div>
    <div class="gradient-bg ">
        <span>Contact Us</span>
    </div>


    <section class="comn_sec">

        <div style="width: 100%; height: 700px;">
            <iframe width="100%" height="100%" style="border:0" loading="lazy" allowfullscreen src="{{ $maplink }}">
            </iframe>




        </div>
        <!-- <div class="container">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="cmn_menu">
                                            <ul>
                                                @foreach($cmnmenu as $key => $value)
                                                    <li>
                                                        <a href="{{route('page', $value->slug)}}">{{$value->name}}</a>
                                                    </li>
                                                @endforeach

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
    </section>


    <section class="contact-section">
        <div class="container">

            <!-- <div class="row">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <div class="col-sm-6">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <div class="cont_item">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <a href="tel:{{$contact->hotline}}">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <i data-feather="phone"></i>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    {{$contact->hotline}}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </a>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div>

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <div class="col-sm-6">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <div class="cont_item">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <a href="">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <i data-feather="mail"></i>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    {{$contact->email}}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </a>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </div> -->

            <div class="row justify-content-center">
                <div style="margin-bottom: 10px;" class="col-sm-6">
                    <div class="contactleftpart">
                        <li style="padding: 20px 5px; font-weight: 600;">
                            <h3>Contact Us</h3>
                        </li>

                        <div class="cont_item">
                            <i class="fa-solid fa-location-dot"></i> <span>Adress</span> <br>
                            <div class="area-lock-set">
                                <a href="{{ $contact->maplink }}">
                                    {{$contact->address}}
                                </a>
                            </div>
                        </div>
                        <div class="cont_item">
                            <i class="fa-solid fa-phone"></i> <span>Phone</span> <br>
                            <div class="area-lock-set">
                                <a href="tel:{{$contact->hotline}}">
                                    {{$contact->hotline}}
                                </a>
                            </div>
                        </div>
                        <div class="cont_item">
                            <i class="fa-solid fa-envelope"></i> <span>Email</span><br>
                            <div class="area-lock-set">
                                <a href="mailto:{{$contact->email}}">
                                    {{$contact->email}}
                                </a>
                            </div>
                        </div>
                        <div class="cont_item">
                            <i class="fa-solid fa-clock"></i> <span>Open Time</span><br>
                            <div class="area-lock-set">
                                <a>
                                    {{$contact->opentime}}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="contact-form">
                        <form action="{{route('contact')}}" method="get" class="row" enctype="multipart/form-data"
                            data-parsley-validate="">
                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                            @csrf
                            <div class="cont_item">
                                <h3>Get in Touch</h3><br>
                                <a>If you’ve got great products your making or looking to work with us then drop us a
                                    line.</a>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name"></label>
                                    <input type="text" id="name" class="form-control @error('name') is-invalid @enderror"
                                        name="name" value="{{old('name')}}" placeholder="Full Name  *" required>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col-end -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="phone"></label>
                                    <input type="number" id="phone"
                                        class="form-control @error('phone') is-invalid @enderror" name="phone"
                                        value="{{old('phone')}}" placeholder="Phone Number *" required>
                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col-end -->
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="email"></label>
                                    <input type="email" id="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{old('email')}}" placeholder="E-mail Address *" required>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col-end -->
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="subject"></label>
                                    <input type="text" id="subject"
                                        class="form-control @error('subject') is-invalid @enderror" name="subject"
                                        value="{{old('subject')}}" placeholder="Subject *" required>
                                    @error('subject')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col-end -->
                            <div class="col-sm-12">
                                <div class="form-group mb-3">
                                    <label for="message"></label>
                                    <textarea type="text" id="message"
                                        class="form-control @error('message') is-invalid @enderror" name="message"
                                        value="{{old('message')}}" placeholder="Type Message *" required></textarea>
                                    @error('message')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col-end -->
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <button type="submit" class="submit-btn btn-sub">Send Message</button>
                                </div>
                            </div>
                            <!-- col-end -->
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
@push('script')
    <script src="{{asset('public/frontEnd/')}}/js/parsley.min.js"></script>
    <script src="{{asset('public/frontEnd/')}}/js/form-validation.init.js"></script>
@endpush