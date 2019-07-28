<form action="{{ url('/') }}">
<div class="input-group push-bottom">
    <input type="text" name="keyword" class="form-control" placeholder="Search product" value="@if (isset($params)) {{ array_get($params, 'keyword') }} @endif">
    <span class="input-group-btn">
        <button class="btn btn-default" type="submit">
        <span class="glyphicon glyphicon-search"></span>
        </button>
    </span>
</div>
</form>

@if (isset($categories) && count($categories))
<div>
    <h4>@lang('web.categories')</h4>
    <div class="list-group">
        @foreach ($categories as $category)
        <a class="list-group-item {{ $category->id == array_get($params, 'category_id') ? 'active' : ''}}" href="{{ url($category->url()) }}">
            <span class="badge">{{ $category->countProducts() }}</span>
            {{ $category->name }}
        </a>
        @endforeach
    </div>
</div>
@endif
