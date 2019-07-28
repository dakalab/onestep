<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
<h4 class="modal-title">
    <strong><i class="fa fa-shopping-cart"></i> 订单详情</strong>
</h4>
</div>

<div class="modal-body">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-info-circle"></i> Basic Info</h3>
        </div>
        <div class="panel-body">
            <table class="table table-hover table-bordered table-striped">
                <tr>
                    <th>ID</th>
                    <th>Order NO.</th>
                    <th>Order Date</th>
                    <th>Total</th>
                    <th>Paid</th>
                    <th>Status</th>
                </tr>
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->order_no }}</td>
                    <td>{{ $order->created_at }}</td>
                    <td>{{ $order->totalMoney() }}</td>
                    <td>{{ $order->paidMoney() }}</td>
                    <td>{!! $order->showStatus() !!}</td>
                </tr>
            </table>
            <p class="text-info"><b>Remark:</b> {{ $order->comment }}</p>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-truck"></i> Shipping ({{ $order->shipping_method }})</h3>
        </div>
        <div class="panel-body">
            <p><b>Express:</b> {{ $order->express }} </p>
            <p><b>Tracking NO.:</b> {{ $order->tracking_no }} </p>
            <p><b>Name:</b> {{ $order->firstname }} {{ $order->lastname }} </p>
            <p><b>Email:</b> {{ $order->email }}</p>
            <p><b>Phone:</b> {{ $order->fullPhone() }}</p>
            <p><b>Address:</b> {{ $order->concatAddress() }}</p>
            <p><b>Post Code:</b> {{ $order->postcode }}</p>
            <p><b>Company:</b> {{ $order->company }}</p>
        </div>
    </div>

    @if (count($order->transactions))
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-usd"></i> Payment ({{ $order->payment_method }})</h3>
        </div>
        <div class="panel-body">
            <table class="table table-hover table-bordered table-striped">
                <tr>
                    <th>Transaction NO.</th>
                    <th>Transaction Time</th>
                    <th>Amount</th>
                </tr>
                @foreach ($order->transactions as $transaction)
                <tr>
                    <td>{{ $transaction->transaction_no }}</td>
                    <td>{{ $transaction->created_at }}</td>
                    <td>{{ $transaction->money() }}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
    @endif

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-gift"></i> Product List</h3>
        </div>
        <div class="panel-body">
            <table class="table table-hover table-bordered table-striped">
                <tr>
                    <th>Product Name</th>
                    <th>SKU</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Subtotal</th>
                </tr>
                @if ($order->products->count())
                @foreach ($order->products as $product)
                <tr>
                    <td><a href="{{ $product->detail->url() }}" target="_blank">{{ $product->detail->name }}</a></td>
                    <td>{{ $product->detail->sku }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>{{ $product->money() }}</td>
                    <td>{{ $product->subtotal() }}</td>
                </tr>
                @endforeach
                @else
                <tr><td colspan=5>No records</td></tr>
                @endif
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><b>Subtotal</b></td>
                    <td>{{ $order->productMoney() }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>

<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">
    <i class="fa fa-times"></i> 关闭
</button>
</div>
