paypal.Buttons({
    style : {
        color: 'blue',
        shape: 'pill'
    },
    createOrder: function (data, actions) {
        return actions.order.create({
            purchase_units : [{
                "amount": {
                    "currency_code": "USD",
                    "value": '1100'
                    
                }
            }]
        });
    },

    onApprove: function (data, actions) {
        return actions.order.capture().then(function (details) {
            console.log(details);
            window.location.replace("http://localhost/bondStreet/paypal/success.php");
        })
    },
    onCancel: function (data) {
        window.location.replace("http://localhost/bondStreet/paypal/Oncancel.php");
    }
}).render('#paypal-payment-button');