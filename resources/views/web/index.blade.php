@extends('web.layout')

@section('htmlheader_title')
	{{ $pageTitle }}
@endsection

@section('main-content')

    <div class="col-md-3">
    @include('web.parts.categories')
    </div>

    <div class="col-md-9">

      @if (empty($params))
      @include('web.parts.banners')
      @endif

      <section class="products">
        @foreach ($products as $i => $product)
        @if ($i % 3 == 0)
        <div class="row">
        @endif
          <div class="col-xs-12 col-md-4">
            <div class="thumbnail">
              <a href="{{ $product->url() }}">
                <img src="{{ $product->mainPhoto() }}" alt="{{ $product->name }}">
              </a>
              <div class="caption">
                <h4>{{ $product->name }}</h4>
                <p>
                  <a class="btn btn-primary" href="{{ route('cart.update', ['product_id' => $product->id, 'quantity' => 1, 'checkout' => 1]) }}">
                  {{ $product->money() }} <span class="glyphicon glyphicon-shopping-cart"></span>
                  </a>
                  </ajax-link>
                  <a href="{{ $product->url() }}" class="btn btn-default" role="button">@lang('web.details')</a>
                </p>
              </div>
            </div>
          </div>
        @if ($i % 3 == 2)
        </div><!--/row-->
        @endif
        @endforeach

        <div class="clearfix"></div>

        <div class="pull-right">{{ $pagination }}</div>

      </section><!--/products-->
    </div>

@endsection
