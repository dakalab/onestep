<?php
use App\Models\PageCategory;
?>

<!-- Main Footer -->
<footer class="web-footer">
    <div class="row">
        <div class="col-md-1"></div>
        <?php foreach (PageCategory::get() as $category) {?>
        <div class="col-md-3" style="text-align:left">
            <h4>{{ $category->name }}</h4>

            <?php foreach ($category->pages as $page) {?>
            <div><a href="/{{ $page->seo_url }}">{{ $page->title }}</a></div>
            <?php }?>

        </div>
        <?php }?>
    </div>
    <div class="row push">
        <strong>Copyright &copy; {{ date('Y') }} {!! \Setting::getValue('site_name') !!}</strong>
    </div>
</footer>
