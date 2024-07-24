import { createConnection } from "mysql";

// Create a MySQL connection
const connection = createConnection({
  host: 'localhost',
  user: 'root',
  password: '', 
  database: 'pricesdb'
});
connection.connect(err => {
    if (err) throw err;
    console.log('Connected to MySQL');
  });
  // Create (Insert)

  const createPrice = (priceData, callback) => {
    const query = 'INSERT INTO prices (productId, amount, priceType, partnerId, taxRate, netPrice) VALUES (?, ?, ?, ?, ?, ?)';
    connection.query(query, [priceData.productId, priceData.amount, priceData.priceType, priceData.partnerId, priceData.taxRate, priceData.netPrice], (err, results) => {
      if (err) return callback(err);
      callback(null, results);
    });
  };
  // Read (Select All)
const getAllPrices = (callback) => {
  const query = 'SELECT * FROM prices';
  connection.query(query, (err, results) => {
      if (err) return callback(err);
      callback(null, results);
  });
};
  // Read (Select)
  const getPriceById = (id, callback) => {
    const query = 'SELECT * FROM prices WHERE id = ?';
    connection.query(query, [id], (err, results) => {
      if (err) return callback(err);
      callback(null, results);
    });
  };
  
  // Update
  const updatePrice = (id, priceData, callback) => {
    const query = 'UPDATE prices SET productId = ?, amount = ?, priceType = ?, partnerId = ?, taxRate = ?, netPrice = ? WHERE id = ?';
    connection.query(query, [priceData.productId, priceData.amount, priceData.priceType, priceData.partnerId, priceData.taxRate, priceData.netPrice, id], (err, results) => {
      if (err) return callback(err);
      callback(null, results);
    });
  };
  getAllPrices((err, results) => {
    if (err) throw err;
    console.log('All prices:', results);
  });
  // // Delete
  // const deletePrice = (id, callback) => {
  //   const query = 'DELETE FROM prices WHERE id = ?';
  //   connection.query(query, [id], (err, results) => {
  //     if (err) return callback(err);
  //     callback(null, results);
  //   });
  // };
  
  // Example usage
  // createPrice({
  //   productId: 33,
  //   amount: 100,
  //   priceType: 'retail',
  //   partnerId: 2,
  //   taxRate: 0.15,
  //   netPrice: 85.00
  // }, (err, results) => {
  //   if (err) throw err;
  //   console.log('Price created:', results.insertId);
  // });
  
  // getPriceById(1, (err, results) => {
  //   if (err) throw err;
  //   console.log('Price details:', results);
  // });
  
  // updatePrice(1, {
  //   productId: 1,
  //   amount: 150,
  //   priceType: 'wholesale',
  //   partnerId: 2,
  //   taxRate: 0.10,
  //   netPrice: 135.00
  // }, (err, results) => {
  //   if (err) throw err;
  //   console.log('Price updated');
  // });
  
  // deletePrice(1, (err, results) => {
  //   if (err) throw err;
  //   console.log('Price deleted');
  // });
  
  // Close the connection
  connection.end();