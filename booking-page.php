<?php
session_start(); // Start session to get logged-in user info
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Page - PIXSOFT GRAPHICS HUB</title>
    <link rel="stylesheet" href="Booking-page.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>

   <!-- navbar -->
    <!-- Navbar (loaded via fetch) -->
    <div id="navbar-container"></div>

    <script>
        function initNavbar() {
            console.log("Navbar Loaded!");

            // Elements
            const navbar = document.getElementById('navbar');
            const hamburgerBtn = document.getElementById('hamburgerBtn');
            const closeBtn = document.getElementById('closeBtn');
            const mobileSidebar = document.getElementById('mobileSidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');

            let lastScrollTop = 0;

            // Smart Sticky Navbar (Hides on Scroll Down, Shows on Scroll Up)
            window.addEventListener('scroll', function () {
                let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

                if (scrollTop > 10) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }

                if (scrollTop > lastScrollTop && scrollTop > 100) {
                    navbar.style.transform = 'translateY(-100%)';
                } else {
                    navbar.style.transform = 'translateY(0)';
                }

                lastScrollTop = scrollTop;
            });

            // Toggle Sidebar Function
            function toggleSidebar() {
                console.log("Toggling Sidebar!");
                mobileSidebar.classList.toggle('active');
                sidebarOverlay.classList.toggle('active');

                if (mobileSidebar.classList.contains('active')) {
                    document.body.style.overflow = 'hidden';
                } else {
                    document.body.style.overflow = '';
                }
            }

            // Attach Event Listeners
            if (hamburgerBtn) {
                hamburgerBtn.addEventListener('click', function () {
                    console.log("Hamburger Clicked!");
                    toggleSidebar();
                });
            }

            if (closeBtn) {
                closeBtn.addEventListener('click', function () {
                    console.log("Close Button Clicked!");
                    toggleSidebar();
                });
            }

            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', function () {
                    console.log("Overlay Clicked!");
                    toggleSidebar();
                });
            }

            // Close sidebar when clicking a menu item
            document.querySelectorAll('.mobile-nav a').forEach(link => {
                link.addEventListener('click', function () {
                    console.log("Sidebar Link Clicked!");
                    toggleSidebar();
                });
            });

            // Close sidebar on window resize (if resized to desktop)
            window.addEventListener('resize', function () {
                if (window.innerWidth > 768 && mobileSidebar.classList.contains('active')) {
                    toggleSidebar();
                }
            });
        }

        // Load Navbar and then Initialize it
        fetch('navbar.php')
            .then(response => response.text())
            .then(data => {
                document.getElementById("navbar-container").innerHTML = data;
                setTimeout(() => {
                    initNavbar();  // Call the function after navbar is loaded
                }, 500);
            })
            .catch(error => console.error("Error loading navbar:", error));
    </script>

    <!-- Navbar (loaded via fetch) -->
    <!-- navbar -->

    <div class="container">
        <div class="header">
            <h1>Design & Printing Services</h1>
            <p>Professional solutions for all your creative needs</p>
        </div>

        <div class="tab-container">
            <div class="tabs">
                <div class="tab active" onclick="switchTab('design')">Design Services</div>
                <div class="tab" onclick="switchTab('printing')">Printing Solutions</div>
                <div class="tab" onclick="switchTab('specialized')">Specialized Services</div>
            </div>

            <!-- Design Services Tab -->
            <div id="design" class="tab-content active">
                <div class="service-card" onclick="selectService(this, 'Packaging Design')">
                    <h3>Packaging Design</h3>
                    <p>Custom packaging solutions that make your products stand out</p>
                </div>
                <div class="service-card" onclick="selectService(this, 'Branding')">
                    <h3>Branding</h3>
                    <p>Complete brand identity development and design</p>
                </div>
            </div>

            <!-- Printing Solutions Tab -->
            <div id="printing" class="tab-content">
                <div class="service-card" onclick="selectService(this, 'Digital Printing')">
                    <h3>Digital Printing</h3>
                    <p>High-quality digital printing services</p>
                </div>
            </div>

            <!-- Specialized Services Tab -->
            <div id="specialized" class="tab-content">
                <div class="service-card" onclick="selectService(this, 'Stationery')">
                    <h3>Stationery</h3>
                    <p>Business cards, letterheads, and complete stationery sets</p>
                </div>
                <div class="service-card" onclick="selectService(this, 'Social Media Design')">
                    <h3>Social Media Design</h3>
                    <p>Brand Logo, Social Media Banners, Social Media Posts etc.</p>
                </div>
            </div>
        </div>

        <!-- Booking Form -->
        <div class="booking-form">
            <h2>Book Your Service</h2>
            <form id="bookingForm" action="submit_booking.php" method="POST">
    <input type="hidden" name="user_id" value="<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : ''; ?>">

    <div class="form-row">
        <div class="form-group">
            <label for="service">Selected Service</label>
            <input type="text" id="service" name="service" readonly required>
        </div>
        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" required>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="tel" id="phone" name="phone" required>
        </div>
    </div>

    <div class="form-group">
        <label for="date">Preferred Date</label>
        <input type="date" id="date" name="date" required>
    </div>

    <div class="form-group">
        <label for="details">Project Details</label>
        <textarea id="details" name="details" required></textarea>
    </div>

    <button type="submit" class="submit-btn">Book Service</button>
</form>

        </div>
    </div>

    <!-- Footer  -->
    <div id="footer-content"></div>

    <script>$('#footer-content').load('footer.html');</script>
    <!-- Footer  -->

    <script>
        document.getElementById("footer-content").innerHTML = '<p>© 2025 Pixsoft Graphics Hub</p>';

        function switchTab(tabId) {
            document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
            document.querySelectorAll('.tab').forEach(tab => tab.classList.remove('active'));
            document.getElementById(tabId).classList.add('active');
            event.currentTarget.classList.add('active');
        }

        function selectService(card, serviceName) {
            document.querySelectorAll('.service-card').forEach(c => c.classList.remove('selected'));
            card.classList.add('selected');
            document.getElementById('service').value = serviceName;
            document.querySelector('.booking-form').scrollIntoView({ behavior: 'smooth' });
        }

        document.getElementById('date').min = new Date().toISOString().split('T')[0];
    </script>
</body>
</html>
