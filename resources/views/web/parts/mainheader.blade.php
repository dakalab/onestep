<!-- Main Header -->

<header>
    <nav class="navbar {{ \Setting::getValue('navbar_color') ? 'navbar-inverse' : 'navbar-default' }} navbar-static-top">
        <div class="container">
            <div class="navbar-header" @if (\Setting::getValue('logo')) {!! 'style="margin-bottom:15px"' !!} @endif >
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
                <span class="sr-only">@lang('web.toggle_nav')</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">
                @if (\Setting::getValue('logo'))
                <img src="{{ \Setting::getLogo() }}" class="logo-lg">
                @else
                <div>{!! \Setting::getValue('site_name') !!}</div>
                @endif
                </a>
            </div>

            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li class="navbar-text text-center">
                        <span class="glyphicon glyphicon-globe"></span>
                        @lang('web.currency')
                        <select name="currency" onchange="location='{{ url('currency?currency=') }}' + this.value">
                        @foreach (config('currency') as $currency => $monetary)
                            <option value={{ $currency }} {{ $currency == session('currency') ? 'selected' : '' }}>{{ $currency }}</option>
                        @endforeach
                        </select>
                    </li>

                    <li>
                        <a class="text-center" href="{{ route('cart') }}">
                            <span class="glyphicon glyphicon-shopping-cart"></span>
                            @lang('web.cart') (<span id="cart-item-qty">{{ Cart::countItems() }}</span>)
                        </a>
                    </li>

                    <li>
                        <a class="text-center" href="{{ route('tracking') }}">
                            <i class="fa fa-truck"></i> @lang('order.tracking')
                        </a>
                    </li>

                    @if (Auth::guest())
                    <li><a class="text-center" href="{{ url('/login') }}">{{ trans('adminlte_lang::message.login') }}</a></li>
                    <li><a class="text-center" href="{{ url('/register') }}">{{ trans('adminlte_lang::message.register') }}</a></li>
                    @else

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle text-center" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <span class="glyphicon glyphicon-user"></span> {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu">
                            @if (Auth::user()->isAdmin())
                            <li><a href="/admin">@lang('web.admin_panel')</a></li>
                            @endif
                            <li><a href="/account">@lang('account.my_account')</a></li>
                            <li><a href="/account/orders">@lang('account.order_history')</a></li>
                            <li>
                                <logout>{{ trans('adminlte_lang::message.signout') }}</logout>
                            </li>
                        </ul>
                    </li>

                    @endif

                </ul>
            </div>

        </div>
    </nav>
</header>
