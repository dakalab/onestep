paypal.Button.render({
    env: '{{ config('paypal.env') }}', // Or 'production',

    locale: '{{ config('paypal.locale') }}',

    client: {
        sandbox:    '{{ Paypal::env('sandbox')->client_id }}',
        production: '{{ Paypal::env('production')->client_id }}'
    },

    commit: true, // Show a 'Pay Now' button

    style: {
        label: 'checkout',
        color: 'gold',
        size: 'responsive',
        shape: 'pill',
        fundingicons: false, // optional
        branding: true, // optional
    },

    payment: function(data, actions) {
        // Make a call to the REST api to create the payment
        return actions.payment.create({
            payment: {
                transactions: [{
                    amount: { total: '{{ array_get($order, 'total', 0) }}', currency: '{{ array_get($order, 'currency') }}' },
                    item_list: {
                        "items": [
                        @foreach ($order->products as $product)
                            {
                                "quantity": "{{ $product->quantity }}",
                                "name": "{{ $product->detail->name }}",
                                "price": "{{ $product->price }}",
                                "currency": "{{ $order->currency }}",
                            },
                        @endforeach
                        ],
                        @if (!empty($order->address))
                        "shipping_address": {
                            "recipient_name": "{{ $order->firstname }} {{ $order->lastname }}",
                            "line1": "{{ $order->address }}",
                            "city": "{{ $order->city }}",
                            "country_code": "{{ Helper::cca2($order->country) }}",
                            "postal_code": "{{ $order->postcode }}",
                            @if ($order->phone)
                            "phone": "{{ $order->phone }}",
                            @endif
                            "state": "{{ $order->province }}"
                        }
                        @endif
                    }
                }],
                @if (!empty(config('paypal.profile_id')))
                "experience_profile_id": "{{ config('paypal.profile_id') }}"
                @endif
            }
        })
    },

    onAuthorize: function(data, actions) {
        console.log(data)
        // Make a call to the REST api to execute the payment
        return actions.payment.execute().then(function() {

            axios.post('/payment/handle', {
                order_id: {{ $order->id }},
                order_no: data.orderID,
                payment_id: data.paymentID,
                token: data.paymentToken,
                payer_id: data.payerID
            })
            .then(function(response) {
                let data = response.data
                if (data.code !== 200) {
                    bootbox.alert({
                        title: '<i class="fa fa-times-circle text-red"></i> @lang('web.error')!',
                        message: data.message,
                        callback: null
                    })
                } else {
                    bootbox.alert({
                        title: '<i class="fa fa-check-circle text-green"></i> @lang('web.success')!',
                        message: '@lang('web.payment_complete')',
                        callback: function() {
                            setTimeout(function () {
                                document.location.href = '{{ route('checkout.done') }}'
                            }, 1000)
                        }
                    })
                }
            })
            .catch(function(error) {
                console.log(error)
                bootbox.alert({
                    title: '<i class="fa fa-times-circle text-red"></i> @lang('web.error')!',
                    message: '@lang('web.transaction_error')',
                    callback: null
                })
            })
        })
    },

    onCancel: function(data, actions) {
        // Buyer cancelled the payment
        bootbox.alert({
            title: '<i class="fa fa-info-circle text-orange"></i> @lang('web.payment_canceled')!',
            message: '@lang('web.payment_canceled_text')',
            callback: null
        })
    },

    onError: function(err) {
        // An error occurred during the transaction
        console.log(err)
        bootbox.alert({
            title: '<i class="fa fa-times-circle text-red"></i> @lang('web.error')!',
            message: '@lang('web.transaction_error')',
            callback: null
        })
    }
}, '#paypal-button')
