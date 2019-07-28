@if (isset($banners) && count($banners))
<section class="slider-main push-bottom--half">
    <div id="carousel-banner" class="carousel slide" data-ride="carousel">

        <ol class="carousel-indicators">
            @for ($i = 0; $i < count($banners); $i++)
            <li data-target="#carousel-banner" data-slide-to="{{ $i }}" class="{{ $i == 0 ? 'active' : '' }}"></li>
            @endfor
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
            @foreach ($banners as $i => $banner)
            <div class="item {{ $i == 0 ? 'active' : '' }}">
                <a href="{{ $banner->url }}" target="_blank">
                <img src="{{ $banner->photo->url() }}" alt="{{ $banner->name }}">
                </a>
            </div>
            @endforeach
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#carousel-banner" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#carousel-banner" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>

    </div>
</section>
@endif
