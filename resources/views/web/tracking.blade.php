@extends('web.layout')

@section('htmlheader_title')
	{{ $pageTitle }}
@endsection

@section('main-content')

<div class="push-bottom">
<form action="{{ url('/tracking') }}" class="form-inline">
    <input type="text" size="35" class="form-control input-large" name="number" value="{{ $number }}" placeholder="Order Number or Tracking Number">
    <input type="submit" class="btn btn-primary">
</form>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-truck"></i> Shipment Tracking</h3>
    </div>
    <div class="panel-body">
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <td>Date</td>
                <td>Address</td>
                <td>Content</td>
            </tr>
            </thead>
            <tbody>
            @foreach ($result as $row)
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

@endsection
