@extends('web.layout')

@section('htmlheader_title')
	{{ $pageTitle }}
@endsection

@section('meta')
<meta name="keywords" content="{{ array_get($page, 'keywords', $page->title) }}" />
<meta name="description" content="{{ array_get($page, 'meta_desc', $page->title) }}" />
<meta property="og:title" content="{{ $page->title }}"/>
<meta property="og:url" content="{!! url()->current() !!}"/>
@endsection

@section('main-content')

<div class="row">
{!! $page->content !!}
</div>


@endsection
