document.addEventListener('DOMContentLoaded', () => {
    const stockForm = document.getElementById('stockForm');
    const stockTable = document.getElementById('stockTable').getElementsByTagName('tbody')[0];
    let stockData = [];

    stockForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const item = document.getElementById('item').value.trim();
        const quantity = parseInt(document.getElementById('quantity').value.trim());

        if (item && quantity) {
            addStockItem(item, quantity);
            stockForm.reset();
        }
    });

    function addStockItem(item, quantity) {
        const index = stockData.findIndex(stock => stock.item === item);
        if (index >= 0) {
            stockData[index].quantity += quantity;
        } else {
            stockData.push({ item, quantity });
        }
        renderStockTable();
    }

    function renderStockTable() {
        stockTable.innerHTML = '';
        stockData.forEach((stock, index) => {
            const row = stockTable.insertRow();
            row.insertCell(0).textContent = stock.item;
            row.insertCell(1).textContent = stock.quantity;
            const actionsCell = row.insertCell(2);

            const editButton = document.createElement('button');
            editButton.textContent = 'Edit';
            editButton.className = 'edit';
            editButton.addEventListener('click', () => editStockItem(index));
            actionsCell.appendChild(editButton);

            const deleteButton = document.createElement('button');
            deleteButton.textContent = 'Delete';
            deleteButton.className = 'delete';
            deleteButton.addEventListener('click', () => deleteStockItem(index));
            actionsCell.appendChild(deleteButton);
        });
    }

    function editStockItem(index) {
        const newQuantity = prompt('Enter new quantity:', stockData[index].quantity);
        if (newQuantity !== null && !isNaN(newQuantity) && newQuantity > 0) {
            stockData[index].quantity = parseInt(newQuantity);
            renderStockTable();
        }
    }

    function deleteStockItem(index) {
        if (confirm('Are you sure you want to delete this item?')) {
            stockData.splice(index, 1);
            renderStockTable();
        }
    }
});
