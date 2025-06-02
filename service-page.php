<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'config.php';

// Fetch services grouped by category
$query = "SELECT * FROM services ORDER BY category, id";
$result = mysqli_query($conn, $query);

$services = [];
while ($row = mysqli_fetch_assoc($result)) {
    $services[$row['category']][] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PIXSOFT GRAPHICS HUB - Services</title>
    <link rel="stylesheet" href="service-page.css?v=3">





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

    <section class="services-section">
        <div class="container">
            <h2 class="section-title">Our <span class="highlight">Services</span></h2>

            <?php if (!empty($services)): ?>
            <?php foreach ($services as $category => $servicesList): ?>
            <h3 class="service-category">
                <?php echo $category; ?>
            </h3>
            <div class="services-grid">
                <?php foreach ($servicesList as $service): ?>
                <div class="service-card">
                    <h3>
                        <?php echo htmlspecialchars($service['title']); ?>
                    </h3>
                    <p>
                        <?php echo htmlspecialchars($service['description']); ?>
                    </p>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <p style="text-align:center; color:red;">No services found.</p>
            <?php endif; ?>
        </div>
    </section>




</body>
<!-- Footer -->
<?php include 'footer.html'; ?>
<!-- Footer -->

</html>