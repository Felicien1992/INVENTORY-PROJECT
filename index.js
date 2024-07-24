
    function submitForm() {
      const customer = {
        name: document.getElementById('name').value,
        address: document.getElementById('address').value,
        currency: document.getElementById('currency').value,
        discount: document.getElementById('discount').value,
        email: document.getElementById('email').value,
        phone_number: document.getElementById('phone_number').value
      };
      
      document.getElementById('customerInfo').textContent = JSON.stringify(customer, null, 2);
    }
