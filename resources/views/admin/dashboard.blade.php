@php
    use App\Models\Settings;
    $settings = Settings::me();
@endphp
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    @vite(['resources/css/app.css', 'resources/css/app.css'])
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1, h2 {
            color: #333;
        }

        .tabs {
            display: flex;
            margin-bottom: 20px;
            border-bottom: 1px solid #ddd;
        }

        .tab {
            padding: 10px 20px;
            cursor: pointer;
            background-color: #f1f1f1;
            border: 1px solid #ddd;
            border-bottom: none;
            border-radius: 5px 5px 0 0;
            margin-right: 5px;
        }

        .tab.active {
            background-color: #fff;
            border-bottom: 1px solid #fff;
            margin-bottom: -1px;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        form {
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"],
        select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .btn-danger {
            background-color: #f44336;
        }

        .btn-danger:hover {
            background-color: #d32f2f;
        }

        .btn-warning {
            background-color: #ff9800;
        }

        .btn-warning:hover {
            background-color: #fb8c00;
        }

        .actions {
            display: flex;
            gap: 5px;
        }

        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 20px 0;
        }

        .pagination li {
            margin-right: 5px;
        }

        .pagination a {
            display: block;
            padding: 8px 12px;
            text-decoration: none;
            background-color: #f1f1f1;
            color: #333;
            border-radius: 4px;
        }

        .pagination a.active {
            background-color: #4CAF50;
            color: white;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .alert-success {
            background-color: #dff0d8;
            color: #3c763d;
            border: 1px solid #d6e9c6;
        }

        .alert-danger {
            background-color: #f2dede;
            color: #a94442;
            border: 1px solid #ebccd1;
        }

        .search-box {
            margin-bottom: 20px;
        }

        .search-box input {
            width: 300px;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Admin Panel</h1>

    <div class="tabs">
        <div class="tab active" onclick="openTab('settings')">Settings</div>
        <div class="tab" onclick="openTab('visitors')">Visitors</div>
    </div>

    <!-- Settings Tab -->
    <div id="settings" class="tab-content active">
        <h2>Settings</h2>

        <div id="settingsAlert" class="alert" style="display: none;"></div>
        @session('settings-updated')
        <div class="alert alert-success" style="display: block;">{{$value}}</div>
        @endsession
        @foreach($errors->getMessages() as $key => $errors)
            <div class="alert alert-danger" style="display: block;">{{$key}}: {{$errors[0]}}</div>
        @endforeach

        <form id="settingsForm" onsubmit="updateSettings(this)">
            @csrf
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="{{ $settings->username }}" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter new password">
                <small>Leave blank to keep current password</small>
                @error('password')
                <div class="alert alert-danger" style="display: block;">{{$message}}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="admin_panel">admin_panel</label>
                <input type="text" id="admin_panel" name="admin_panel" value="{{ $settings->admin_panel }}" required>
            </div>
            <div class="form-group">
                <label for="stopbot_key">stopbot_key</label>
                <input type="text" id="stopbot_key" name="stopbot_key" value="{{ $settings->stopbot_key }}">
            </div>
            <div class="form-group">
                <label for="email_result">email_result</label>
                <input type="text" id="email_result" name="email_result" value="{{ $settings->email_result }}" required>
            </div>
            <div class="form-group">
                <label for="redirect_on_finish">redirect_on_finish</label>
                <input type="checkbox" id="redirect_on_finish" name="redirect_on_finish"
                       checked="{{ $settings->redirect_on_finish ? 'checked' : '' }}">
            </div>
            <div class="form-group">
                <label for="double_cards">double_cards</label>
                <input type="checkbox" checked="{{$settings->double_cards ? 'checked' : ''}}" id="double_cards"
                       name="double_cards" required>
            </div>
            <div class="form-group">
                <label for="parameter">parameter</label>
                <input type="text" id="parameter" name="parameter" value="{{ $settings->parameter }}">
            </div>
            <div class="form-group">
                <label for="external_redirect">external_redirect</label>
                <input type="url" id="external_redirect" name="external_redirect"
                       value="{{ $settings->external_redirect }}" required>
            </div>
            <button type="submit">Save Settings</button>
        </form>
    </div>

    <!-- Visitors Tab -->
    <div id="visitors" class="tab-content">
        <h2>Visitors</h2>
        <table id="visitorsTable">
            <thead>
            <tr>
                <th>User</th>
                <th>Pass</th>
                <th>Card Count</th>
                <th>Finished</th>
                <th>Parameter Status</th>
                <th>Browser</th>
                <th>User Type</th>
                <th>ISP</th>
                <th>Location</th>
                <th>IP Address</th>
                <th>Created At</th>
            </tr>
            </thead>
            <tbody>
            <!-- This will be populated dynamically -->
            </tbody>
        </table>

        <ul class="pagination" id="visitorsPagination">
            <!-- Pagination will be added here -->
        </ul>
    </div>
</div>
<script>
    function openTab(tabName) {
        const tabs = document.getElementsByClassName('tab');
        const tabContents = document.getElementsByClassName('tab-content');

        for (let i = 0; i < tabs.length; i++) {
            tabs[i].classList.remove('active');
            tabContents[i].classList.remove('active');
        }

        document.getElementById(tabName).classList.add('active');
        document.querySelector(`.tab[onclick="openTab('${tabName}')"]`).classList.add('active');
    }

    // Settings CRUD
    function updateSettings(event) {
        event.preventDefault();
        const form = event.target;
        const formData = new FormData(form);
        axios.post(form.action, formData)
            .then(response => {
                showAlert('settingsAlert', 'Settings updated successfully!', 'success');
            })
            .catch(error => {
                const errors = error.response.data.errors;
                let errorMessage = '';
                for (const key in errors) {
                    errorMessage += `${key}: ${errors[key][0]}<br>`;
                }
                showAlert('settingsAlert', errorMessage, 'danger');
            });
    }

    // Visitors CRUD
    let visitors = []; // This would be populated from your backend
    let currentPage = 1;
    const itemsPerPage = 10;

    function loadVisitors() {
        // In a real application, this would fetch data from your backend
        // For demonstration, we'll create some sample data
        visitors = [
            {
                id: 1,
                user: 'user1',
                pass: 'pass1',
                card_count: 2,
                is_finished: true,
                parameter_status: 'matched',
                browser: 'Chrome',
                user_type: 'Residential',
                isp: 'Comcast',
                city: 'New York',
                state: 'NY',
                country: 'USA',
                ip: '192.168.1.1',
                created_at: '2025-05-01 10:00:00'
            },
            {
                id: 2,
                user: 'user2',
                pass: 'pass2',
                card_count: 0,
                is_finished: false,
                parameter_status: 'unmatched',
                browser: 'Firefox',
                user_type: 'Business',
                isp: 'AT&T',
                city: 'Los Angeles',
                state: 'CA',
                country: 'USA',
                ip: '192.168.1.2',
                created_at: '2025-05-02 11:30:00'
            }
        ];

        renderVisitorsTable();
        renderPagination();
    }

    function renderVisitorsTable() {
        const tbody = document.querySelector('#visitorsTable tbody');
        tbody.innerHTML = '';

        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        const paginatedVisitors = visitors.slice(startIndex, endIndex);

        if (paginatedVisitors.length === 0) {
            const tr = document.createElement('tr');
            tr.innerHTML = '<td colspan="13" style="text-align: center;">No visitors found</td>';
            tbody.appendChild(tr);
            return;
        }

        paginatedVisitors.forEach(visitor => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                    <td>${visitor.user || '-'}</td>
                    <td>${visitor.pass || '-'}</td>
                    <td>${visitor.card_count}</td>
                    <td>${visitor.is_finished ? 'Yes' : 'No'}</td>
                    <td>${visitor.parameter_status}</td>
                    <td>${visitor.browser}</td>
                    <td>${visitor.user_type}</td>
                    <td>${visitor.isp}</td>
                    <td>${visitor.city}, ${visitor.state}, ${visitor.country}</td>
                    <td>${visitor.ip}</td>
                    <td>${visitor.created_at}</td>
                `;
            tbody.appendChild(tr);
        });
    }

    function renderPagination() {
        const pagination = document.getElementById('visitorsPagination');
        pagination.innerHTML = '';

        const totalPages = Math.ceil(visitors.length / itemsPerPage);

        for (let i = 1; i <= totalPages; i++) {
            const li = document.createElement('li');
            li.innerHTML = `<a href="#" onclick="changePage(${i})" class="${i === currentPage ? 'active' : ''}">${i}</a>`;
            pagination.appendChild(li);
        }
    }

    function changePage(page) {
        currentPage = page;
        renderVisitorsTable();
        renderPagination();
        return false;
    }

    function searchVisitors() {
        const searchTerm = document.getElementById('visitorSearch').value.toLowerCase();

        if (searchTerm === '') {
            loadVisitors(); // Reset to original data
            return;
        }

        // Filter visitors based on search term
        visitors = visitors.filter(visitor => {
            return (
                (visitor.user && visitor.user.toLowerCase().includes(searchTerm)) ||
                (visitor.ip && visitor.ip.toLowerCase().includes(searchTerm)) ||
                (visitor.browser && visitor.browser.toLowerCase().includes(searchTerm)) ||
                (visitor.city && visitor.city.toLowerCase().includes(searchTerm)) ||
                (visitor.country && visitor.country.toLowerCase().includes(searchTerm))
            );
        });
        currentPage = 1;
        renderVisitorsTable();
        renderPagination();
    }

    function editVisitor(id) {
        const visitor = visitors.find(v => v.id === id);
        if (!visitor) return;

        document.getElementById('visitorId').value = visitor.id;
        document.getElementById('visitorUser').value = visitor.user || '';
        document.getElementById('visitorPass').value = visitor.pass || '';
        document.getElementById('cardCount').value = visitor.card_count;
        document.getElementById('isFinished').value = visitor.is_finished ? '1' : '0';
        document.getElementById('parameterStatus').value = visitor.parameter_status;
        document.getElementById('browser').value = visitor.browser;
        document.getElementById('userType').value = visitor.user_type;
        document.getElementById('isp').value = visitor.isp;
        document.getElementById('city').value = visitor.city;
        document.getElementById('state').value = visitor.state;
        document.getElementById('country').value = visitor.country;
        document.getElementById('ipAddress').value = visitor.ip;

        document.getElementById('visitorSubmitBtn').textContent = 'Update Visitor';
        document.getElementById('visitors').scrollIntoView();
    }

    function deleteVisitor(id) {
        if (!confirm('Are you sure you want to delete this visitor?')) return;

        const index = visitors.findIndex(v => v.id === id);
        if (index !== -1) {
            visitors.splice(index, 1);
            showAlert('visitorAlert', 'Visitor deleted successfully!', 'success');
            renderVisitorsTable();
            renderPagination();
        }
    }

    function showAlert(elementId, message, type) {
        const alertElement = document.getElementById(elementId);
        alertElement.textContent = message;
        alertElement.className = `alert alert-${type}`;
        alertElement.style.display = 'block';

        setTimeout(() => {
            alertElement.style.display = 'none';
        }, 3000);
    }

    // Initialize the page
    document.addEventListener('DOMContentLoaded', function () {
        loadVisitors();
    });
</script>
</body>
</html>
