@extends('Ecommerce.layouts.app')

@section('content')
    <div class="page-content">
        <h1>{{ $page->name }}</h1>
        <div class="page-body">
            {!! nl2br(e($page->content)) !!} <!-- Display the page content with HTML support -->
        </div>
    </div>
@endsection