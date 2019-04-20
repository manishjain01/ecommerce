@extends('layouts.home')
@section('content') 

<section id="mustHave-products-area" class="pt-90 pt-md-60 pt-sm-50 products_listing_sec">
    <div class="container">
        <div class="row no-gutters">
           
            <h2>{{ $cmslist->title}}</h2>
        </div>
        {!! $cmslist->description !!}
    </div>
</section>
@stop
