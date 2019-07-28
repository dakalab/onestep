@if (!empty($breadcrumbs))
<ul class="breadcrumb">
    <li><a href="{{ url('/') }}"><i class="fa fa-home"></i></a></li>
    @foreach ($breadcrumbs as $b)
    <li><a href="{{ $b['url'] }}">{{ $b['name'] }}</a></li>
    @endforeach
</ul>
@endif
