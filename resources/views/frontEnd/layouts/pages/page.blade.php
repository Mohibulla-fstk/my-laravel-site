@extends('frontEnd.layouts.master')
<title>{{ $page->title ?? 'Site Name' }}</title>
@section('title')

@section('content')
    <div class="blankspace"></div>
    <div class="gradient-bg">
        <span>{{ $page->title }}</span>
    </div>
    <section class="createpage-section">
        <div class="max-width5">
            <div class="col-sm-12">
                <div class="page-content">
                    <div class="page-description">
                        <span>{!! $page->description !!}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection