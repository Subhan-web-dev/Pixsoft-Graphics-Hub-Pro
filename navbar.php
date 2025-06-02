<?php
session_start();
require_once 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        header {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 9999;
            transition: transform 0.3s ease-in-out, background-color 0.3s ease;
        }

        header.scrolled {
            background-color: rgba(25, 25, 25, 0.85);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar {
            background: #191919;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 5px 5px;
        }

        .logo a {
            font-size: 35px;
            font-weight: 600;
            color: white;
            text-decoration: none;
            transition: transform 0.3s ease-in-out;
        }

        .logo span {
            color: #c70049;
        }

        .logo:hover {
            transform: scale(1.07);
        }

        .nav-links {
            list-style: none;
            display: flex;
        }

        .nav-links li {
            margin: 0 15px;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            transition: transform 0.3s ease-in-out, color 0.3s;
        }

        .nav-links a:hover {
            transform: scale(1.10);
            color: #c70049;
        }

        .hamburger {
            display: none;
            font-size: 30px;
            color: white;
            cursor: pointer;
        }

        /* Mobile sidebar overlay */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(5px);
            z-index: 8000;
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar-overlay.active {
            display: block;
            opacity: 1;
        }

        /* Mobile sidebar */
        .mobile-sidebar {
            position: fixed;
            top: 0;
            right: -300px;
            width: 250px;
            height: 100vh;
            background: rgba(25, 25, 25, 0.95);
            backdrop-filter: blur(10px);
            z-index: 9000;
            padding: 20px;
            transition: right 0.3s ease-in-out;
            box-shadow: -5px 0 15px rgba(0, 0, 0, 0.3);
        }

        .mobile-sidebar.active {
            right: 0;
        }

        .close-btn {
            color: white;
            font-size: 30px;
            text-align: right;
            cursor: pointer;
            margin-bottom: 20px;
        }

        .mobile-nav {
            list-style: none;
        }

        .mobile-nav li {
            margin: 20px 0;
            text-align: center;
        }

        .mobile-nav a {
            color: white;
            text-decoration: none;
            font-size: 20px;
            transition: color 0.3s;
            display: block;
            padding: 10px 0;
        }

        .mobile-nav a:hover {
            color: #c70049;
        }

        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }
            .hamburger {
                display: block;
            }
        }
    </style>
</head>
<body>
    <!-- Mobile Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Mobile Sidebar -->
    <div class="mobile-sidebar" id="mobileSidebar">
        <div class="close-btn" id="closeBtn">&times;</div>
        <ul class="mobile-nav">
            <li><a href="home-page.html">Home</a></li>
            <li><a href="About-Us.html">About Us</a></li>
            <li><a href="service-page.php">Services</a></li>
            <li><a href="booking-page.php">Service Booking</a></li>
            <li><a href="contact-me.html">Contact Us</a></li>

            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="dashboard-redirect.php">Profile</a></li>
                <li><a href="logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="Login-Sign-Up.html">Login/SignUp</a></li>
            <?php endif; ?>
        </ul>
    </div>

    

    <header id="navbar">
        <nav class="navbar">
            <div class="logo"><a href="home-page.html">PIX<span>S</span>OFT</a></div>
            <ul class="nav-links">
                <li><a href="About-Us.html">About Us</a></li>
                <li><a href="service-page.php">Services</a></li>
                <li><a href="booking-page.php">Service Booking</a></li>
                <li><a href="contact-me.html">Contact Us</a></li>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="dashboard-redirect.php">Profile</a></li>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="Login-Sign-Up.html">Login/SignUp</a></li>
                <?php endif; ?>
            </ul>

            <div class="hamburger" id="hamburgerBtn">&#9776;</div>
        </nav>
    </header>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Elements
            const navbar = document.getElementById('navbar');
            const hamburgerBtn = document.getElementById('hamburgerBtn');
            const closeBtn = document.getElementById('closeBtn');
            const mobileSidebar = document.getElementById('mobileSidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            
            // Smart sticky navbar functionality
            let lastScrollTop = 0;
            
            window.addEventListener('scroll', function() {
                let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                
                // Add blur effect when scrolling down
                if (scrollTop > 10) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
                
                // Hide navbar when scrolling down, show when scrolling up
                if (scrollTop > lastScrollTop && scrollTop > 100) {
                    // Scrolling down & not at the top
                    navbar.style.transform = 'translateY(-100%)';
                } else {
                    // Scrolling up or at the top
                    navbar.style.transform = 'translateY(0)';
                }
                
                lastScrollTop = scrollTop;
            });
            
            // Toggle mobile sidebar
            function toggleSidebar() {
                mobileSidebar.classList.toggle('active');
                sidebarOverlay.classList.toggle('active');
                document.body.style.overflow = mobileSidebar.classList.contains('active') ? 'hidden' : '';
            }
            
            // Event listeners
            hamburgerBtn.addEventListener('click', toggleSidebar);
            closeBtn.addEventListener('click', toggleSidebar);
            sidebarOverlay.addEventListener('click', toggleSidebar);
            
            // Close sidebar when clicking a link
            document.querySelectorAll('.mobile-nav a').forEach(link => {
                link.addEventListener('click', toggleSidebar);
            });
            
            // Close sidebar on window resize (if desktop size)
            window.addEventListener('resize', function() {
                if (window.innerWidth > 768 && mobileSidebar.classList.contains('active')) {
                    toggleSidebar();
                }
            });
        });
    </script>
</body>
</html>

