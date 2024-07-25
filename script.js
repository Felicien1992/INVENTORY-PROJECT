let employees = [];

function addOrUpdateEmployee() {
    const employeeId = document.getElementById('employeeId').value;
    const name = document.getElementById('name').value;
    const position = document.getElementById('position').value;
    const address = document.getElementById('address').value;
    const account = document.getElementById('account').value;
    const status = document.getElementById('status').value;
    const gender = document.getElementById('gender').value;
    const dob = document.getElementById('dob').value;

    const existingEmployeeIndex = employees.findIndex(emp => emp.employeeId === employeeId);

    if (existingEmployeeIndex !== -1) {
        // Update existing employee
        employees[existingEmployeeIndex] = {
            employeeId, name, position, address, account, status, gender, dob
        };
    } else {
        // Add new employee
        employees.push({
            employeeId, name, position, address, account, status, gender, dob
        });
    }

    renderEmployeeTable();
    clearForm();
}

function editEmployee(employeeId) {
    const employee = employees.find(emp => emp.employeeId === employeeId);

    if (employee) {
        document.getElementById('employeeId').value = employee.employeeId;
        document.getElementById('name').value = employee.name;
        document.getElementById('position').value = employee.position;
        document.getElementById('address').value = employee.address;
        document.getElementById('account').value = employee.account;
        document.getElementById('status').value = employee.status;
        document.getElementById('gender').value = employee.gender;
        document.getElementById('dob').value = employee.dob;
    }
}

function deleteEmployee(employeeId) {
    employees = employees.filter(emp => emp.employeeId !== employeeId);
    renderEmployeeTable();
}

function renderEmployeeTable() {
    const employeeTableBody = document.getElementById('employeeTable').getElementsByTagName('tbody')[0];
    employeeTableBody.innerHTML = '';

    employees.forEach(employee => {
        const row = employeeTableBody.insertRow();

        row.insertCell(0).innerText = employee.employeeId;
        row.insertCell(1).innerText = employee.name;
        row.insertCell(2).innerText = employee.position;
        row.insertCell(3).innerText = employee.address;
        row.insertCell(4).innerText = employee.account;
        row.insertCell(5).innerText = employee.status;
        row.insertCell(6).innerText = employee.gender;
        row.insertCell(7).innerText = employee.dob;

        const actionsCell = row.insertCell(8);
        actionsCell.className = 'actions';

        const editButton = document.createElement('button');
        editButton.className = 'edit';
        editButton.innerText = 'Edit';
        editButton.onclick = () => editEmployee(employee.employeeId);

        const deleteButton = document.createElement('button');
        deleteButton.className = 'delete';
        deleteButton.innerText = 'Delete';
        deleteButton.onclick = () => deleteEmployee(employee.employeeId);

        actionsCell.appendChild(editButton);
        actionsCell.appendChild(deleteButton);
    });
}

function clearForm() {
    document.getElementById('employeeForm').reset();
}
