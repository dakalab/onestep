<section class="slider-main push-bottom--half">
    <div id="carousel-photo" class="carousel slide" data-ride="carousel">

        <ol class="carousel-indicators">
            @for ($i = 0; $i < count($photos); $i++)
            <li data-target="#carousel-photo" data-slide-to="{{ $i }}" class="{{ $i == 0 ? 'active' : '' }}"></li>
            @endfor
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
            @foreach ($photos as $i => $photo)
            <div class="item {{ $i == 0 ? 'active' : '' }} thumbnail">
                <img src="{{ $photo['url'] }}" class="img-rounded" alt="{{ $photo['name'] }}" >
            </div>
            @endforeach
        </div>

    </div>
</section>
