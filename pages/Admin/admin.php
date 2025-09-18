<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: sans-serif;
        }

        body {
            display: flex;
            height: 100vh;
            overflow: hidden;
            background: #f5f5f5;
        }

        aside {
            width: 250px;
            background: #fff;
            box-shadow: 1px 0 10px rgba(0, 0, 0, 0.4);
            border-right: 1px solid #ccc;
            min-height: 100vh;
            padding: 20px;
            overflow-y: auto;
            scrollbar-width: none;
        }

        aside::-webkit-scrollbar {
            display: none;
        }

        aside nav ul {
            list-style: none;
        }

        aside nav ul li {
            margin: 20px 0;
        }

        aside nav ul li a {
            color: #333;
            text-decoration: none;
            display: block;
            padding: 10px;
            border-radius: 6px;
        }

        aside nav ul li a.active,
        aside nav ul li a:hover {
            background: #e6f0ea;
            color: #f00000;
        }

        main {
            flex: 1;
            display: flex;
            flex-direction: column;
            height: 100vh;
            padding: 20px;
        }

        .tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            flex-shrink: 0;
        }

        .tab {
            background: #f0f0f0;
            padding: 10px 20px;
            border-radius: 20px;
            cursor: pointer;
        }

        .tab.active {
            background: #f00000;
            color: #fff;
        }

        .content-wrapper {
            flex: 1;
            overflow-y: auto;
            scrollbar-width: none;
        }

        .content-wrapper::-webkit-scrollbar {
            display: none;
        }

        .content-section {
            display: none;
        }

        .content-section.active {
            display: block;
        }

        .table-container {
            max-height: calc(100vh - 120px);
            overflow-y: auto;
            background: #fff;
            border-radius: 10px;
            position: relative;
            scrollbar-width: none;
        }

        .table-container::-webkit-scrollbar {
            display: none;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
        }

        th,
        td {
            text-align: left;
            padding: 15px;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }

        th {
            background: #fafafa;
            font-weight: 600;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        th:nth-child(1),
        td:nth-child(1) {
            width: 20%;
        }

        th:nth-child(2),
        td:nth-child(2) {
            width: 15%;
        }

        th:nth-child(3),
        td:nth-child(3) {
            width: 20%;
        }

        th:nth-child(4),
        td:nth-child(4) {
            width: 15%;
        }

        th:nth-child(5),
        td:nth-child(5) {
            width: 15%;
        }

        th:nth-child(6),
        td:nth-child(6) {
            width: 15%;
        }

        .status {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            display: inline-block;
        }

        .accepted {
            background: #e2f4e6;
            color: #f00000;
        }

        .pending {
            background: #fff3cd;
            color: #d39e00;
        }

        .rejected {
            background: #f8d7da;
            color: #721c24;
        }

        .view-btn {
            background: #f00000;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 6px;
            font-size: 12px;
            cursor: pointer;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            background: #f00000;
            color: white;
            padding: 8px 15px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .back-btn i {
            margin-right: 8px;
        }
    </style>
</head>

<body>
    <aside>
        <nav>
            <ul>
                <li>Dashboard</li>
                <li><a href="#" class="sidebar-tab active" data-section="hustle">Hustle Requests</a></li>
                <li><a href="#" class="sidebar-tab" data-section="orders">Marketplace Requests</a></li>
            </ul>
        </nav>
    </aside>
    <main>
        <div class="tabs">
            <div class="tab active" data-tab="all">All</div>
            <div class="tab" data-tab="accepted">Accepted</div>
            <div class="tab" data-tab="rejected">Rejected</div>
            <div class="tab" data-tab="pending">Pending</div>
        </div>
        <div class="content-wrapper">
            <div id="hustle" class="content-section active">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>User Name</th>
                                <th>Status</th>
                                <th>UserId</th>
                                <th>Location</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="hustle-body"></tbody>
                    </table>
                </div>
            </div>
            <div id="orders" class="content-section">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>User Name</th>
                                <th>Status</th>
                                <th>UserId</th>
                                <th>Location</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="marketplace-body"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <script>
        const hustle = [{
                userName: "David Kamau",
                status: "rejected",
                userId: "L2M3N4O5P6Q7R8",
                location: "Nairobi, KE",
                date: "Feb 14, 2025"
            },
            {
                userName: "Dennis Ortega",
                status: "pending",
                userId: "X9Y8Z7A6B5C4D3",
                location: "Mombasa, KE",
                date: "Sep 10, 2023"
            },
            {
                userName: "Ann Nyakweru",
                status: "accepted",
                userId: "MIN203P4QSR6S7",
                location: "Kisumu, KE",
                date: "Aug 5, 2026"
            },
            {
                userName: "Omondi David",
                status: "accepted",
                userId: "A1B2C3D4E5F6G3",
                location: "Nakuru, KE",
                date: "Jun 20, 2025"
            },
            {
                userName: "Sakura Kenji",
                status: "pending",
                userId: "T8U9V0W1X2Y3Z4",
                location: "Eldoret, KE",
                date: "Mar 5, 2026"
            },
            {
                userName: "John Doe",
                status: "accepted",
                userId: "S9T0U1V2W3X4Y5",
                location: "Thika, KE",
                date: "Jul 30, 2024"
            },
            {
                userName: "Mary Wanjiru",
                status: "pending",
                userId: "Z1A2B3C4D5E6F7",
                location: "Nairobi, KE",
                date: "Apr 12, 2025"
            },
            {
                userName: "Peter Mwangi",
                status: "rejected",
                userId: "G8H9I0J1K2L3M4",
                location: "Nyeri, KE",
                date: "Oct 25, 2024"
            },
            {
                userName: "Grace Atieno",
                status: "accepted",
                userId: "N5O6P7Q8R9S0T1",
                location: "Kisumu, KE",
                date: "Jan 15, 2026"
            },
            {
                userName: "James Ochieng",
                status: "pending",
                userId: "U2V3W4X5Y6Z7A8",
                location: "Mombasa, KE",
                date: "May 8, 2025"
            },
            {
                userName: "Faith Muthoni",
                status: "rejected",
                userId: "B9C0D1E2F3G4H5",
                location: "Eldoret, KE",
                date: "Dec 10, 2024"
            },
            {
                userName: "Joseph Kiptoo",
                status: "accepted",
                userId: "I6J7K8L9M0N1O2",
                location: "Nakuru, KE",
                date: "Nov 5, 2025"
            },
            {
                userName: "Esther Wambui",
                status: "pending",
                userId: "P3Q4R5S6T7U8V9",
                location: "Thika, KE",
                date: "Feb 20, 2025"
            },
            {
                userName: "Samuel Njoroge",
                status: "accepted",
                userId: "W0X1Y2Z3A4B5C6",
                location: "Nairobi, KE",
                date: "Mar 15, 2025"
            },
            {
                userName: "Lucy Njeri",
                status: "rejected",
                userId: "D7E8F9G0H1I2J3",
                location: "Mombasa, KE",
                date: "Jan 25, 2025"
            },
            {
                userName: "Brian Kipchumba",
                status: "pending",
                userId: "K4L5M6N7O8P9Q0",
                location: "Kisumu, KE",
                date: "Apr 30, 2025"
            },
            {
                userName: "Mercy Achieng",
                status: "accepted",
                userId: "R1S2T3U4V5W6X7",
                location: "Nyeri, KE",
                date: "Jul 10, 2025"
            },
            {
                userName: "Daniel Mutua",
                status: "rejected",
                userId: "Y8Z9A0B1C2D3E4",
                location: "Eldoret, KE",
                date: "Jun 15, 2025"
            },
            {
                userName: "Rose Wanjiku",
                status: "pending",
                userId: "F5G6H7I8J9K0L1",
                location: "Nairobi, KE",
                date: "Aug 25, 2025"
            },
            {
                userName: "Thomas Odhiambo",
                status: "accepted",
                userId: "M2N3O4P5Q6R7S8",
                location: "Mombasa, KE",
                date: "Sep 20, 2025"
            }
        ];

        const marketplace = [{
                userName: "Mika Kubaya",
                status: "accepted",
                userId: "K7L8M9N0P1Q2R3",
                location: "Nairobi, KE",
                date: "Jan 10, 2025"
            },
            {
                userName: "Ryo Hussain",
                status: "pending",
                userId: "B4C5D6E7F8G9H0",
                location: "Mombasa, KE",
                date: "Nov 15, 2024"
            },
            {
                userName: "Emi Majimoto",
                status: "rejected",
                userId: "J1K2L3M4N5O6P7",
                location: "Kisumu, KE",
                date: "Mar 22, 2025"
            },
            {
                userName: "Joanna Kenyatta",
                status: "accepted",
                userId: "Q8R9S0T1U2V3W4",
                location: "Malindi, KE",
                date: "Dec 5, 2024"
            },
            {
                userName: "Haruka Sakura",
                status: "pending",
                userId: "X5Y6Z7A8B9C0D1",
                location: "Nyeri, KE",
                date: "Feb 28, 2025"
            },
            {
                userName: "Samuel Njoroge",
                status: "rejected",
                userId: "E2F3G4H5I6J7K8",
                location: "Eldoret, KE",
                date: "Jun 10, 2025"
            },
            {
                userName: "Lucy Wambui",
                status: "accepted",
                userId: "L9M0N1O2P3Q4R5",
                location: "Nairobi, KE",
                date: "Aug 20, 2025"
            },
            {
                userName: "Brian Kipchumba",
                status: "pending",
                userId: "S6T7U8V9W0X1Y2",
                location: "Nakuru, KE",
                date: "Sep 5, 2024"
            },
            {
                userName: "Esther Njeri",
                status: "accepted",
                userId: "Z3A4B5C6D7E8F9",
                location: "Thika, KE",
                date: "Jul 15, 2025"
            },
            {
                userName: "Michael Otieno",
                status: "rejected",
                userId: "G0H1I2J3K4L5M6",
                location: "Mombasa, KE",
                date: "Nov 30, 2024"
            },
            {
                userName: "Jane Wanjiku",
                status: "pending",
                userId: "N7O8P9Q0R1S2T3",
                location: "Kisumu, KE",
                date: "Oct 10, 2025"
            },
            {
                userName: "Paul Mutisya",
                status: "accepted",
                userId: "U4V5W6X7Y8Z9A0",
                location: "Nairobi, KE",
                date: "Dec 15, 2024"
            },
            {
                userName: "Sarah Auma",
                status: "rejected",
                userId: "B1C2D3E4F5G6H7",
                location: "Eldoret, KE",
                date: "May 20, 2025"
            },
            {
                userName: "David Kimani",
                status: "pending",
                userId: "I8J9K0L1M2N3O4",
                location: "Nyeri, KE",
                date: "Apr 5, 2025"
            },
            {
                userName: "Mercy Chebet",
                status: "accepted",
                userId: "P5Q6R7S8T9U0V1",
                location: "Nakuru, KE",
                date: "Jun 25, 2025"
            },
            {
                userName: "Isaac Omondi",
                status: "rejected",
                userId: "W2X3Y4Z5A6B7C8",
                location: "Mombasa, KE",
                date: "Feb 10, 2025"
            },
            {
                userName: "Faith Wairimu",
                status: "pending",
                userId: "D9E0F1G2H3I4J5",
                location: "Thika, KE",
                date: "Aug 30, 2025"
            },
            {
                userName: "Josephine Atieno",
                status: "accepted",
                userId: "K6L7M8N9O0P1Q2",
                location: "Kisumu, KE",
                date: "Jul 5, 2025"
            },
            {
                userName: "Kevin Ndegwa",
                status: "rejected",
                userId: "R3S4T5U6V7W8X9",
                location: "Nairobi, KE",
                date: "Sep 15, 2025"
            },
            {
                userName: "Nancy Wanjala",
                status: "pending",
                userId: "Y0Z1A2B3C4D5E6",
                location: "Malindi, KE",
                date: "Nov 20, 2025"
            }
        ];

        const hustleTbody = document.getElementById("hustle-body");
        const marketplaceTbody = document.getElementById("marketplace-body");
        const tabs = document.querySelectorAll(".tab");
        const sections = document.querySelectorAll(".content-section");
        const sidebarTabs = document.querySelectorAll(".sidebar-tab");
        const mainContent = document.querySelector("main");

        function renderTable(data, tbody, filter = "all") {
            tbody.innerHTML = "";
            let filtered = filter === "all" ? data : data.filter(s => s.status === filter);
            filtered.sort((a, b) => b.date.localeCompare(a.date));
            filtered.forEach(item => {
                tbody.innerHTML += `
          <tr>
            <td>${item.userName}<br><small>${item.location}</small></td>
            <td><span class="status ${item.status}">${capitalize(item.status)}</span></td>
            <td>${item.userId}</td>
            <td>${item.location}</td>
            <td>${item.date}</td>
            <td><button class="view-btn" data-userid="${item.userId}" data-section="${data === hustle ? 'hustle' : 'marketplace'}">View More</button></td>
          </tr>
        `;
            });

            // Add event listeners to the "View More" buttons
            document.querySelectorAll(".view-btn").forEach(button => {
                button.addEventListener("click", () => {
                    const userId = button.dataset.userid;
                    const section = button.dataset.section;
                    loadDetails(userId, section);
                });
            });
        }

        function capitalize(text) {
            return text.charAt(0).toUpperCase() + text.slice(1);
        }

        function loadDetails(userId, section) {
            fetch(`partials/Admin-details/details.php?userId=${userId}§ion=${section}`)
                .then(response => response.text())
                .then(data => {
                    // Replace the main content with the back button at the top
                    mainContent.innerHTML = `
                <div class="details">
                    <a href="#" class="back-btn" onclick="restoreMainContent()"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
                    ${data}
                </div>
            `;
                })
                .catch(error => {
                    console.error("Error fetching details:", error);
                    mainContent.innerHTML = `
                <div class="details">
                    <a href="#" class="back-btn" onclick="restoreMainContent()"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
                    <p>Error loading details. Please try again.</p>
                </div>
            `;
                });
        }

        function restoreMainContent() {
            // Restore the original main content
            mainContent.innerHTML = `
        <div class="tabs">
            <div class="tab active" data-tab="all">All</div>
            <div class="tab" data-tab="accepted">Accepted</div>
            <div class="tab" data-tab="rejected">Rejected</div>
            <div class="tab" data-tab="pending">Pending</div>
        </div>
        <div class="content-wrapper">
            <div id="hustle" class="content-section active">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>User Name</th>
                                <th>Status</th>
                                <th>UserId</th>
                                <th>Location</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="hustle-body"></tbody>
                    </table>
                </div>
            </div>
            <div id="orders" class="content-section">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>User Name</th>
                                <th>Status</th>
                                <th>UserId</th>
                                <th>Location</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="marketplace-body"></tbody>
                    </table>
                </div>
            </div>
        </div>
    `;

            // Re-attach event listeners and render the table
            attachTabListeners();
            attachSidebarListeners();
            renderTable(hustle, document.getElementById("hustle-body"), "all");
        }

        function attachTabListeners() {
            document.querySelectorAll(".tab").forEach(tab => {
                tab.addEventListener("click", () => {
                    document.querySelector(".tab.active")?.classList.remove("active");
                    tab.classList.add("active");
                    const activeSection = document.querySelector(".content-section.active").id;
                    if (activeSection === "hustle") {
                        renderTable(hustle, hustleTbody, tab.dataset.tab);
                    } else if (activeSection === "orders") {
                        renderTable(marketplace, marketplaceTbody, tab.dataset.tab);
                    }
                });
            });
        }

        function attachSidebarListeners() {
            document.querySelectorAll(".sidebar-tab").forEach(tab => {
                tab.addEventListener("click", e => {
                    e.preventDefault();
                    document.querySelector(".sidebar-tab.active")?.classList.remove("active");
                    tab.classList.add("active");

                    sections.forEach(sec => sec.classList.remove("active"));
                    document.getElementById(tab.dataset.section).classList.add("active");

                    // Reset to "All" tab and render the appropriate table
                    document.querySelector(".tab.active")?.classList.remove("active");
                    document.querySelector(".tab[data-tab='all']").classList.add("active");
                    if (tab.dataset.section === "hustle") {
                        renderTable(hustle, hustleTbody, "all");
                    } else if (tab.dataset.section === "orders") {
                        renderTable(marketplace, marketplaceTbody, "all");
                    }
                });
            });
        }

        // Initial render and event listeners
        renderTable(hustle, hustleTbody, "all");
        attachTabListeners();
        attachSidebarListeners();
    </script>
</body>

</html>