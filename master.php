<?php
// PHP code can be added here for server-side processing if required
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            position: relative;
        }
        table th {
            background-color: #f5f5f5;
            cursor: pointer;
        }
        .sort-toggle {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            font-size: 12px;
            cursor: pointer;
        }
        .pagination {
            margin-top: 20px;
            text-align: center;
        }
        .pagination button {
            margin: 0 5px;
            padding: 8px 12px;
            cursor: pointer;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #f5f5f5;
        }
        .pagination button.active {
            background-color: #007bff;
            color: #fff;
            border-color: #007bff;
        }
        .form-group {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Attendance Dashboard</h1>

        <div class="form-group">
            <label for="fromDate">From:</label>
            <input type="date" id="fromDate">
            <label for="toDate">To:</label>
            <input type="date" id="toDate">
            <button onclick="filterAttendance()">Apply</button>
        </div>

        <table id="attendanceTable">
            <thead>
                <tr>
                    <th onclick="sortTable(0)">Serial No</th>
                    <th onclick="sortTable(1)">Name<span class="sort-toggle" id="nameSortToggle">▼</span></th>
                    <th onclick="sortTable(2)">Date<span class="sort-toggle" id="dateSortToggle">▼</span></th>
                    <th onclick="sortTable(3)">Entry Time<span class="sort-toggle" id="entryTimeSortToggle">▼</span></th>
                    <th onclick="sortTable(4)">Exit Time<span class="sort-toggle" id="exitTimeSortToggle">▼</span></th>
                </tr>
            </thead>
            <tbody id="tableBody">
                <!-- Data will be populated here -->
            </tbody>
        </table>

        <div class="pagination" id="pagination">
            <!-- Pagination buttons will be added here -->
        </div>

    </div>

    <script>
        const attendanceData = generateRandomAttendanceData(50); // Generate 50 random records for demo
        let currentPage = 1;
        const pageSize = 10;
        let sortConfig = { column: null, direction: null };

        function generateRandomAttendanceData(count) {
            const names = ['John Doe', 'Jane Smith', 'David Johnson', 'Sarah Adams', 'Michael Brown'];
            const statuses = ['Present', 'Absent'];
            const data = [];

            for (let i = 1; i <= count; i++) {
                const randomName = names[Math.floor(Math.random() * names.length)];
                const randomDate = getRandomDate(new Date(2022, 0, 1), new Date());
                const randomEntryTime = getRandomTime();
                const randomExitTime = getRandomTime();
                const randomStatus = statuses[Math.floor(Math.random() * statuses.length)];

                data.push({
                    serialNo: i,
                    name: randomName,
                    date: randomDate,
                    entryTime: randomEntryTime,
                    exitTime: randomExitTime,
                    status: randomStatus
                });
            }

            return data;
        }

        function getRandomDate(startDate, endDate) {
            const start = startDate.getTime();
            const end = endDate.getTime();
            const randomTime = start + Math.random() * (end - start);
            const randomDate = new Date(randomTime);
            return randomDate.toISOString().split('T')[0];
        }

        function getRandomTime() {
            const hours = Math.floor(Math.random() * 24);
            const minutes = Math.floor(Math.random() * 60);
            return `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}`;
        }

        function renderTable(page) {
            const tableBody = document.getElementById('tableBody');
            tableBody.innerHTML = '';

            const startIndex = (page - 1) * pageSize;
            const endIndex = startIndex + pageSize;
            const pageData = attendanceData.slice(startIndex, endIndex);

            pageData.forEach((record) => {
                const row = `<tr>
                    <td>${record.serialNo}</td>
                    <td>${record.name}</td>
                    <td>${record.date}</td>
                    <td>${record.entryTime}</td>
                    <td>${record.exitTime}</td>
                </tr>`;
                tableBody.innerHTML += row;
            });

            renderPagination();
        }

        function renderPagination() {
            const pagination = document.getElementById('pagination');
            const totalPages = Math.ceil(attendanceData.length / pageSize);

            let buttons = '';
            for (let i = 1; i <= totalPages; i++) {
                buttons += `<button onclick="goToPage(${i})" ${currentPage === i ? 'class="active"' : ''}>${i}</button>`;
            }
            pagination.innerHTML = buttons;
        }

        function goToPage(page) {
            currentPage = page;
            renderTable(currentPage);
        }

        function sortTable(colIndex) {
            const headers = document.querySelectorAll('th');
            headers.forEach(header => header.classList.remove('asc', 'desc'));

            const currentHeader = headers[colIndex];
            const toggle = currentHeader.querySelector('.sort-toggle');

            if (sortConfig.column === colIndex && sortConfig.direction === 'asc') {
                // If currently ascending, toggle to descending
                sortConfig.direction = 'desc';
                toggle.textContent = '▼';
            } else {
                // Default to ascending
                sortConfig.column = colIndex;
                sortConfig.direction = 'asc';
                toggle.textContent = '▲';
            }

            attendanceData.sort((a, b) => {
                const keyA = colIndex === 0 ? a.serialNo : a[Object.keys(a)[colIndex]];
                const keyB = colIndex === 0 ? b.serialNo : b[Object.keys(b)[colIndex]];

                if (sortConfig.direction === 'asc') {
                    return keyA < keyB ? -1 : 1;
                } else {
                    return keyA > keyB ? -1 : 1;
                }
            });

            renderTable(currentPage);
        }

        function filterAttendance() {
            const fromDate = document.getElementById('fromDate').value;
            const toDate = document.getElementById('toDate').value;

            // Implement filter logic based on date range
            // Example: attendanceData.filter(record => record.date >= fromDate && record.date <= toDate);

            renderTable(1); // Render first page after applying filter
        }

        // Initial rendering
        renderTable(currentPage);
    </script>
</body>
</html>
