@extends('frontEnd.layouts.contact')

@section('content1')
    <div class="container mt-4">
        <h2>Our Location</h2>

        @if($contact->lat && $contact->lng)
            <div style="width: 100%; height: 700px; margin-top: 20px;">
                <iframe width="100%" height="100%" style="border:0" loading="lazy" allowfullscreen
                    referrerpolicy="no-referrer-when-downgrade"
                    src="https://www.google.com/maps?q={{ $contact->lat }},{{ $contact->lng }}&hl=es;z=15&output=embed">
                </iframe>
            </div>
        @else
            <p>Map location unavailable</p>
        @endif

    </div>
@endsection