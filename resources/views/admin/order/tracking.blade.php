<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
<h4 class="modal-title">
    <strong><i class="fa fa-truck"></i> 快递跟踪</strong>
</h4>
</div>

<div class="modal-body">

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">快递公司：{{ $order->express }}，快递单号：{{ $order->tracking_no }}</h3>
        </div>
        <div class="panel-body">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <td>时间</td>
                    <td>地址</td>
                    <td>备注</td>
                </tr>
                </thead>
                <tbody>
                @foreach ($order->tracking() as $row)
                <tr>
                    <td>{{ object_get($row, 'occurDate') }}</td>
                    <td>{{ object_get($row, 'occurAddress') }}</td>
                    <td>{{ object_get($row, 'trackContent') }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">
    <i class="fa fa-times"></i> 关闭
</button>
</div>
