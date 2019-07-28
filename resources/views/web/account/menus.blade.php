<div>
    <div class="list-group">
        @foreach (config('account-menu') as $r => $t)
        <a class="list-group-item {{ Route::currentRouteName() == $r ? 'active' : ''}}" href="{{ route($r) }}">
            {{ __($t) }}
        </a>
        @endforeach
    </div>
</div>
