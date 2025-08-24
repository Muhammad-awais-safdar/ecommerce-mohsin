@extends('Ecommerce.layouts.app')

@section('content')
    <div class="page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-trail breadcrumbs">
                        <ul class="trail-items breadcrumb">
                            <li class="trail-item trail-begin">
                                <a href="{{ route('home') }}">Home</a>
                            </li>
                            <li class="trail-item trail-end active">
                                {{ $page->name }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="offset-lg-2 col-lg-8 offset-lg-2 col-md-8 col-sm-12 col-xs-12">
                    <div class="content-text clearfix">
                        {!! $page->content !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
