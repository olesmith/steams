paypal.Button.render({
  // Configure environment
  env: 'sandbox',
  client: {
    sandbox: 'Acu4vvLkITLhNNegjFNbuUVu7-v0E7kEJkeI9A6BPePkguFZkJHra8KQusWtCXi1aqosKGp-Yh4saVDC',
    production: 'demo_production_client_id'
  },
  // Customize button (optional)
  locale: 'en_US',
  style: {
    size: 'small',
    color: 'gold',
    shape: 'pill',
  },
  // Set up a payment
  payment: function (data, actions) {
    return actions.payment.create({
      transactions: [{
        amount: {
          total: '0.01',
          currency: 'USD'
        }
      }]
    });
  },
  // Execute the payment
  onAuthorize: function (data, actions) {
    return actions.payment.execute()
      .then(function () {
        // Show a confirmation message to the buyer
        window.alert('Thank you for your purchase!');
      });
  }
}, '#paypal-button');
