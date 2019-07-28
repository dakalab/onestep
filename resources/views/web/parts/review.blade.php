@if (!Auth::guest())
<form class="form-horizontal ajax" id="form-review" action="{{ url('/review') }}" method="post">
<input type="hidden" name="product_id" value="{{ $product->id }}">
    <h2>@lang('review.write_review')</h2>
    <div class="form-group required">
        <div class="col-sm-12">
        <label class="control-label" for="input-author">@lang('review.your_name')</label>
        <input type="text" name="author" value="" id="input-author" class="form-control">
        </div>
    </div>
    <div class="form-group required">
        <div class="col-sm-12">
        <label class="control-label" for="input-review">@lang('review.your_review')</label>
        <textarea name="comment" rows="5" id="input-review" class="form-control"></textarea>
        <div class="help-block"><span class="text-danger">@lang('review.note')</span> @lang('review.no_html')</div>
        </div>
    </div>
    <div class="form-group required">
        <div class="col-sm-12">
            <label class="control-label">@lang('review.rating')</label>
            &nbsp;&nbsp;&nbsp; @lang('review.bad')&nbsp;
            <input type="radio" name="rating" value="1">
            &nbsp;
            <input type="radio" name="rating" value="2">
            &nbsp;
            <input type="radio" name="rating" value="3">
            &nbsp;
            <input type="radio" name="rating" value="4">
            &nbsp;
            <input type="radio" name="rating" value="5">
            &nbsp;@lang('review.good')</div>
        </div>
        <div class="buttons clearfix">
        <div>
            <button type="submit" role="submit" id="button-review" class="btn btn-primary">@lang('web.submit')</button>
        </div>
    </div>
</form>
@endif
