function submitForm() {
  // Get form values
  const name = document.getElementById("name").value;
  const address = document.getElementById("address").value;
  const phone = document.getElementById("phone").value;
  const email = document.getElementById("email").value;
  const discount = document.getElementById("discount").value;

  // Create customer object
  const customer = {
    name: name,
    address: address,
    phone: phone,
    email: email,
    discount: discount,
  };

  // Display the result
  const resultDiv = document.getElementById("result");
  resultDiv.innerHTML = `<h3>Customer Information:</h3>
                           <p><strong>Name:</strong> ${customer.name}</p>
                           <p><strong>Address:</strong> ${customer.address}</p>
                           <p><strong>Phone:</strong> ${customer.phone}</p>
                           <p><strong>Email:</strong> ${customer.email}</p>
                           <p><strong>Discount:</strong> ${customer.discount}%</p>`;
}
