<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Dashboard with Bootstrap</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>

        /* Sidebar styles */
        .sidebar {
            background-color: #2c3e50;
            color: #fff;
            width: 250px;
            padding-top: 20px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 999;
            transition: left 0.3s ease;
        }

        .sidebar.active {
            left: 0;
        }

        .sidebar.inactive {
            left: -250px;
        }

        .sidebar a {
            display: block;
            padding: 15px;
            color: #fff;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .sidebar a:hover {
            background-color: #34495e;
        }

        /* Main content styles */
        .content {
            padding: 20px;
            margin-left: 250px;
        }

        .content-section {
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }

        h1 {
            color: #2c3e50;
        }

        p {
            color: #333;
        }

        /* Top bar styles */
        .top-bar {
            background-color: #34495e;
            color: #fff;
            padding: 10px;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            margin: 0;
            color: white;
            text-align: center
        }

        /* Hamburger Menu styles for mobile */
        .hamburger {
            display: none;
        }

        .hamburger.active .line-1 {
            transform: rotate(-45deg) translate(-4px, 6px);
        }

        .hamburger.active .line-2 {
            opacity: 0;
        }

        .hamburger.active .line-3 {
            transform: rotate(45deg) translate(-4px, -6px);
        }

        @media (max-width: 767px) {
            .sidebar {
                left: -250px;
            }

            .content {
                margin-left: 0;
            }

            .sidebar.active {
                left: 0;
            }

            .hamburger {
                display: block;
                cursor: pointer;
                position: fixed;
                top: 10px;
                left: 10px;
                z-index: 1000;
            }

            .hamburger-icon {
                font-size: 24px;
                display: inline-block;
                position: relative;
            }

            .line {
                display: block;
                width: 24px;
                height: 3px;
                background-color: #fff;
                margin: 5px auto;
                transition: transform 0.3s ease, opacity 0.3s ease;
            }
            .custom-file-upload {
                display: inline-block;
                padding: 12px 20px;
                cursor: pointer;
                background-color: #007bff;
                color: #fff;
                border: none;
                border-radius: 4px;
                font-size: 16px;
            }
            .custom-file-upload:hover {
                background-color: #0056b3;
            }
            .upload-button {
                display: block;
                text-align: center;
                margin-top: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-10">
                    <h3 class="logo text-white">Welcome, <?php echo $username; ?></h3>
                    <!-- Logout button -->
                </div>
                <div class="col-2">
                <a href="<?= base_url() ?>/logout" class="logout">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Hamburger Menu Icon -->
    <div class="hamburger" onclick="toggleSidebar()">
        <div class="hamburger-icon">
            <div class="line line-1"></div>
            <div class="line line-2"></div>
            <div class="line line-3"></div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <a href="#" data-content="dashboard">Dashboard</a>
        <a href="#" data-content="users">Users</a>
        <a href="#" data-content="analytics">Analytics</a>
        <a href="#" data-content="exel">Upload Exel</a>
        <a href="#" data-content="settings">Settings</a>
        <a href="#" data-content="print">Print</a>
    </div>

    <!-- Main Content -->
    <div class="content">
        <div id="dashboard" class="content-section">
            <h1>Welcome to the Dashboard</h1>
            <p>This is a modern dashboard layout created with HTML, Bootstrap, and CSS.</p>
            <p>You can add various components and charts here to display data.</p>
        </div>
        <div id="users" class="content-section" style="display:none;">
            <h1>Users Page</h1>
            <p>Content for Users page goes here.</p>
        </div>
        <div id="analytics" class="content-section" style="display:none;">
            <h1>Analytics Page</h1>
            <p>Content for Analytics page goes here.</p>
        </div>
        <div id="exel" class="content-section" style="display:none;">
            <h1>Upload Exel</h1>
            <?php if ($role === 'admin' || $role === 'super_admin') : ?>
                <p>uploading exel here.</p>
                <form action="/excel" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <label class="custom-file-upload">
                    Choose File
                    <input type="file" name="excel_file" accept=".xlsx, .xls">
                </label>
                <div class="upload-button">
                    <input type="submit" value="Upload" class="btn btn-primary">
                </div>
                </form>
            <?php endif; ?>
        </div>
        <div id="settings" class="content-section" style="display:none;">
            <h1>Maintenance Mode Toggle</h1>
        </div>
        
        <div id="print" class="content-section" style="display:none;">
            <div class="mt-5">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                    <div class="card">
                            <div class="card-header">
                                <ul class="nav nav-tabs card-header-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#tab1">Front Card</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#tab2">Back Card</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="tab1">
                                        <h5 class="card-title">Print front of the card</h5>
                                        <p class="card-text">Enter details</p>
                                        <h2 class="pb-2">Print Card</h2>
                                        <div class="card p-4">
                                            <div class="mb-3">
                                            <label for="rangeInput" class="form-label">Enter Voter Range:</label>
                                            <input type="text" class="form-control" id="rangeInput">
                                            </div>
                                            <div class="mb-3">
                                            <label for="address" class="form-label">Enter Address:</label>
                                            <input type="text" class="form-control" id="address">
                                            </div>
                                            <button class="btn btn-primary" onclick="generateLink()">Generate Card</button>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="tab2">
                                        <h5 class="card-title">Print back of the card</h5>
                                        <p class="card-text">Enter details</p>
                                        <h2 class="pb-2">Print Card</h2>
                                        <div class="card p-4">
                                            <div class="mb-3">
                                            <label for="rangeInputBack" class="form-label">Enter Voter Range:</label>
                                            <input type="text" class="form-control" id="rangeInputBack">
                                            </div>
                                            <button class="btn btn-primary" onclick="generateLink()">Generate Card</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const printButton = document.getElementById('printButton');
        printButton.addEventListener('click', () => {
            window.print();
        });
    </script>

    <!-- Footer -->
	<footer class="footer bg-light mt-4">
		<div class="container text-center">
			<span class="text-muted">Search Landing &copy; 2023. All rights reserved.</span>
        </div>
    </footer>

    <!-- Bootstrap JS and Font Awesome (required for hamburger menu icon) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    <script>
        function generateLink() {
            var rangeInput = document.getElementById('rangeInput').value;
            var rangeInputBack = document.getElementById('rangeInputBack').value;
            var address = document.getElementById('address').value;
            var rangeArray = rangeInput.split('-');
            var rangeArrayBack = rangeInputBack.split('-');
            
            if (rangeArrayBack.length === 2 && rangeInputBack !== '' && address == '') {
                var start = parseInt(rangeArrayBack[0]);
                var end = parseInt(rangeArrayBack[1]);
                
                if (!isNaN(start) && !isNaN(end) && start <= end) {
                var link = '<?= base_url() ?>/print_back?voterRange=' + start + '-' + end + '&address=' + address;
                window.open(link, '_blank');
                } else {
                alert('Invalid range input. Please enter a valid range.');
                }
            } else if (rangeArray.length === 2 && rangeInput !== ''){
                var start = parseInt(rangeArray[0]);
                var end = parseInt(rangeArray[1]);
                
                if (!isNaN(start) && !isNaN(end) && start <= end) {
                var link = '<?= base_url() ?>/print?voterRange=' + start + '-' + end + '&address=' + address;
                window.open(link, '_blank');
                } else {
                alert('Invalid range input. Please enter a valid range.');
                }
            } else {
                alert('Invalid range input format. Please use the format "1-infinity".');
            }

            
            if (rangeArray.length === 2 && rangeInput !== null) {
                var start = parseInt(rangeArray[0]);
                var end = parseInt(rangeArray[1]);
                
                if (!isNaN(start) && !isNaN(end) && start <= end) {
                var link = '<?= base_url() ?>/print?voterRange=' + start + '-' + end + '&address=' + address;
                window.open(link, '_blank');
                } else {
                alert('Invalid range input. Please enter a valid range.');
                }
            } else {
                alert('Invalid range input format. Please use the format "1-infinity".');
            }
        }
        // JavaScript to handle sidebar menu click events
        document.addEventListener("DOMContentLoaded", function () {
            const sidebarLinks = document.querySelectorAll(".sidebar a");
            const contentSections = document.querySelectorAll(".content-section");
            const hamburgerIcon = document.querySelector(".hamburger-icon");
            const sidebar = document.getElementById("sidebar");

            hamburgerIcon.addEventListener("click", function () {
                this.classList.toggle("active");
                toggleSidebar();
            });

            sidebarLinks.forEach(link => {
                link.addEventListener("click", function (event) {
                    event.preventDefault();
                    const contentId = link.getAttribute("data-content");
                    contentSections.forEach(section => {
                        section.style.display = "none";
                    });
                    document.getElementById(contentId).style.display = "block";

                    // Close sidebar on mobile when a link is clicked
                    if (window.innerWidth <= 767) {
                        hamburgerIcon.classList.remove("active");
                        toggleSidebar();
                    }
                });
            });

            // Function to toggle sidebar on mobile
            function toggleSidebar() {
                sidebar.classList.toggle("active");
                sidebar.classList.toggle("inactive");
            }
        });

        function resetInputFields(tabId) {
        const inputs = document.querySelectorAll(`#${tabId} input`);
        inputs.forEach(input => {
            input.value = ''; // Clear the input value
        });
        }

        document.addEventListener("DOMContentLoaded", function() {
            // Add event listeners to tab toggling
            $('[data-toggle="tab"]').on('shown.bs.tab', function(event) {
                const targetTabId = $(event.target).attr('href').slice(1); // Get the tab ID
                resetInputFields(targetTabId); // Reset input fields of the target tab
            });
        });
    </script>
</body>
</html>
