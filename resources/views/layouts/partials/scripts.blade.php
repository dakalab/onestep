<!-- REQUIRED JS SCRIPTS -->

<script src="{{ mix('/js/app.js') }}" type="text/javascript"></script>
<script src="{{ url('/plugins/ckeditor/ckeditor.js') }}"></script>
<script src="{{ url('/plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ url('/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ mix('/js/custom.js') }}" type="text/javascript"></script>

<script type="text/javascript">
@if (!Auth::guest() && Auth::user()->isAdmin())
axios.defaults.headers.common['Authorization'] = 'Bearer {{ Auth::user()->api_token }}';
@endif

$(document).on('hidden.bs.modal', function (e) {
    $(e.target).removeData('bs.modal');
});

@yield('script-init')

</script>
