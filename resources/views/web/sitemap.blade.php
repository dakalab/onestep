@extends('web.layout')

@section('htmlheader_title')
	{{ $pageTitle }}
@endsection

@section('main-content')

  <h1>Site Map</h1>

  @foreach ($categories as $category)
  <div class="row">
    <a href="{{ $category->url() }}">
   {{ $category->name }}
    </a>
  </div>
  @endforeach

@endsection
