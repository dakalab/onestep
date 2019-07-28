<!-- REQUIRED JS SCRIPTS -->

<script src="{{ mix('/js/app.js') }}?v=20181222" type="text/javascript"></script>
<script src="{{ url('/plugins/ckeditor/ckeditor.js') }}"></script>
<script src="{{ url('/plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ url('/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ mix('/js/custom.js') }}" type="text/javascript"></script>

<script type="text/javascript">
$(function () {
    setInterval(function () {
        axios.get('{{ route('cart.refresh') }}')
        .then(function (response) {
            // console.log(response)
            let data = response.data
            if (data.code == 200) {
                $('#cart-item-qty').text(data.data.qty)
            }
        })
        .catch(function (error) {
            // console.log(error)
        })
    }, 10000)

    @if (!empty($address))
    $('#select-province').provinces($('#select-country').val(), '{{ $address->province }}')
    @else
    $('#select-province').provinces($('#select-country').val())
    @endif

    $('#select-country').on('change', function() {
        $('#select-province').provinces(this.value)
    })
})
</script>
