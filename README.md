<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Inventory</title>
    <style>
        .product {
            border: 5px solid #e12c2c;
            padding: 10px;
            margin: 10px;
            border-radius: 5px;
        }
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        form {
            border: 5px solid #2b01b6;
            padding: 20px;
            border-radius: 5px;
            background-color: #c5bebe;
        }
        button {
            padding: 10px 15px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 15px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Product Inventory</h1>
    <div class="container">
        <form action="product.php" method="post" id="product-form">
            <div class="form-group">
                <label for="product-id">Product ID:</label>
                <input type="text" id="product-id" name="product-id" required>
            </div>
            <div class="form-group">
                <label for="product-name">Product Name:</label>
                <input type="text" id="product-name" name="product-name" required>
            </div>
            <div class="form-group">
                <label for="product-price">Price:</label>
                <input type="text" id="product-price" name="product-price" required>
            </div>
            <div class="form-group">
                <label for="product-category">Category:</label>
                <input type="text" id="product-category" name="product-category" required>
            </div>
            <div class="form-group">
                <label for="expired-date">Expired Date:</label>
                <input type="date" id="expired-date" name="expired-date" required>
            </div>
            <div class="form-group">
                <label for="availability">Availability:</label>
                <select id="availability" name="availability" required>
                    <option value="true">Available</option>
                    <option value="false">Not Available</option>
                </select>
            </div>
            <button type="submit">Add Product</button>
        </form>
        <div id="product-list"></div>
    </div>
    <script>
        // Product Class
        class Product {
            constructor(id, name, price, category, expiredDate, availability) {
                this.id = id;
                this.name = name;
                this.price = price;
                this.category = category;
                this.expiredDate = expiredDate;
                this.availability = availability;
            }
        }

        // Function to create product HTML
        function createProductHTML(product) {
            return `
                <div class="product">
                    <p><strong>Product ID:</strong> ${product.id}</p>
                    <p><strong>Product Name:</strong> ${product.name}</p>
                    <p><strong>Category:</strong> ${product.category}</p>
                    <p><strong>Price:</strong> ${product.price}</p>
                    <p><strong>Expired Date:</strong> ${product.expiredDate}</p>
                    <p><strong>Availability:</strong> ${product.availability ? 'Available' : 'Not Available'}</p>
                </div>
            `;
        }

        // Add event listener to form
        document.getElementById('product-form').addEventListener('submit', function(event) {
            event.preventDefault();

            // Get form values
            const id = document.getElementById('product-id').value;
            const name = document.getElementById('product-name').value;
            const price = document.getElementById('product-price').value;
            const category = document.getElementById('product-category').value;
            const expiredDate = document.getElementById('expired-date').value;
            const availability = document.getElementById('availability').value === 'true';

            // Create new product
            const product = new Product(id, name, price, category, expiredDate, availability);

            // Add product to the page
            const productList = document.getElementById('product-list');
            productList.innerHTML += createProductHTML(product);

            // Clear form
            document.getElementById('product-form').reset();
        });
    </script>
</body>
</html>
