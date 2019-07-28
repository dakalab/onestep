@extends('web.layout')

@section('htmlheader_title')
	{{ $pageTitle }}
@endsection

@section('meta')
<meta name="keywords" content="{{ array_get($product, 'keywords', $product->name) }}" />
<meta name="description" content="{{ array_get($product, 'meta_desc', $product->name) }}" />
<meta property="og:title" content="{{ $product->name }}"/>
<meta property="og:type" content="product"/>
<meta property="og:url" content="{!! url()->current() !!}"/>
<meta property="og:image" content="{{ asset($photos[0]['url']) }}"/>
@endsection

@section('main-content')

<div class="row">
    <div class="col-md-4">
    @include('web.parts.photos')
    </div>

    <div class="col-md-8">

        @if ($product->hidden)
        <div class="alert alert-danger" role="alert">
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            <span class="sr-only">@lang('product.info'):</span>
            @lang(product.discontinued)
        </div>
        @endif

        <h1 class="push" style="font-size: 24px;">{{ $product->name }}</h1>

        @if ($ratings && !empty($ratings->num))
        <h3 class="push"><rating :score={{ $ratings->rating }}>({{ $ratings->num }} @lang('product.reviews'))</rating></h3>
        @endif

        <h3 class="push">{{ $product->money() }} (@lang('product.free_shipping'))</h3>

        <h4 class="push">@lang('product.code'): {{ $product->sku }}</h4>

        @foreach ($product->getAttributeGroup() as $k => $v)
        <h4 class="push">{{ $k }}: {{ implode(', ', $v) }} </h4>
        @endforeach

        @if (!$product->hidden)
        <form class="form-inline push" action="{{ route('cart.update') }}">
        <input id="input-checkout" type="hidden" name="checkout" value="0">
        <input type="hidden" name="product_id" value="{{ $product->id }}">
            <div class="form-group">
                <label for="input-quantity"><b>@lang('product.qty')</b></label>
                <input name="quantity" type="text" class="form-control" id="input-quantity" value="1">
            </div>
            <button type="submit" class="btn btn-primary">
                <span class="glyphicon glyphicon-shopping-cart"></span>
                @lang('product.add_to_cart')
            </button>
            <button type="button" class="btn btn-warning" onclick="$('#input-checkout').val(1);this.form.submit()">
                <i class="fa fa-paypal"></i>
                @lang('product.paypal_checkout')
            </button>
        </form>
        @endif

        <div class="push">
            <ajax-link url="{{ url('/wishlist?product_id=' . $product->id) }}">
                <span class="glyphicon glyphicon-heart"></span>
                @lang('product.add_to_wishes')
            </ajax-link>
        </div>
    </div>
</div>

<div class="row">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab-description" data-toggle="tab" aria-expanded="true">@lang('product.description')</a></li>
        <li><a href="#tab-review" data-toggle="tab" aria-expanded="false">@lang('product.reviews') ({{ $ratings ? $ratings->num : 0 }})</a></li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="tab-description">
            {!! $product->description !!}
        </div>
        <div class="tab-pane" id="tab-review">

            <div id="review">
                @foreach ($product->reviews() as $review)
                <table class="table table-striped table-bordered">
                    <tbody>
                    <tr>
                        <td style="width: 50%;"><strong>{{ $review->author }}</strong></td>
                        <td class="text-right">{{ date('d/m/Y', strtotime($review->comment_time)) }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <p>{!! $review->comment !!}</p>

                            <rating :score={{ $review->rating }}></rating>
                        </td>
                    </tr>
                    </tbody>
                </table>
                @endforeach
            </div> <!-- review -->

            @include('web.parts.review')

        </div> <!-- tab-review -->
    </div> <!-- tab-content -->
</div>

@endsection
