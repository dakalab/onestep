@extends('web.layout')

@section('htmlheader_title')
	{{ $pageTitle }}
@endsection

@section('main-content')

    <div class="col-md-3">
    @include('web.account.menus')
    </div>

    <div class="col-md-9">

        <h2>{{ $pageTitle }}</h2>

        <table class="table table-hover">
        <tr>
            <th>@lang('cart.image')</th>
            <th>@lang('cart.product_name')</th>
            <th>@lang('cart.price')</th>
            <th>@lang('web.status')</th>
            <th>@lang('account.added_time')</th>
            <th>@lang('account.delete')</th>
        </tr>
        @foreach ($data as $row)
        <tr>
            <td>
                <a href="{{ $row->product->url() }}">
                <img src="{{ $row->product->mainPhoto() }}" height=100 />
                </a>
            </td>
            <td style="vertical-align: middle">
                <a href="{{ $row->product->url() }}">{{ $row->product->name }}</a>
            </td>
            <td style="vertical-align: middle">{{ $row->product->money() }}</td>
            <td style="vertical-align: middle">
            @if ($row->product->hidden)
            <span class="label label-danger" title="out of stock"><i class="fa fa-times"></i></span>
            @else
            <span class="label label-success" title="in stock"><i class="fa fa-check"></i></span>
            @endif
            </td>
            <td style="vertical-align: middle">{{ $row->created_at }}</td>
            <td style="vertical-align: middle">
                <ajax-link url="{{ route('account.wishlist.delete', ['product_id' => $row->product->id]) }}" msg="@lang('web.confirm_delete')">
                <i class="fa fa-trash"></i>
                </ajax-link>
            </td>
        </tr>
        @endforeach
        </table>

        <div class="clearfix"></div>

        <div class="pull-right">{{ $data->links() }}</div>
    </div>

@endsection
