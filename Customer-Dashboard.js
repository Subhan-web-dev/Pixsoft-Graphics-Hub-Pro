// Navigation functionality
document.addEventListener("DOMContentLoaded", () => {
    // Sidebar toggle functionality for mobile
    const sidebarToggleBtn = document.getElementById("sidebar-toggle")
    const sidebar = document.querySelector(".sidebar")
  
    if (sidebarToggleBtn) {
      sidebarToggleBtn.addEventListener("click", () => {
        sidebar.classList.toggle("active")
      })
    }
  
    // Close sidebar when clicking outside on mobile
    document.addEventListener("click", (event) => {
      if (
        window.innerWidth <= 768 &&
        sidebar &&
        sidebar.classList.contains("active") &&
        !sidebar.contains(event.target) &&
        event.target !== sidebarToggleBtn
      ) {
        sidebar.classList.remove("active")
      }
    })
  
    // Navigation functionality
    document.querySelectorAll(".nav-item").forEach((item) => {
      item.addEventListener("click", function () {
        if (this.id === "logout") {
          if (confirm("Are you sure you want to logout?")) {
            alert("Logging out...")
            // Add logout logic here
          }
          return
        }
  
        // Remove active class from all nav items and sections
        document.querySelectorAll(".nav-item").forEach((nav) => nav.classList.remove("active"))
        document.querySelectorAll(".section").forEach((section) => section.classList.remove("active"))
  
        // Add active class to clicked nav item
        this.classList.add("active")
  
        // Show corresponding section
        const sectionId = this.getAttribute("data-section")
        document.getElementById(sectionId).classList.add("active")
  
        // Close sidebar on mobile after navigation
        if (window.innerWidth <= 768 && sidebar) {
          sidebar.classList.remove("active")
        }
      })
    })
  
    // Form submission handlers
    // const forms = ["profile-form", "booking-form", "feedback-form", "support-form", "password-form"]
    // forms.forEach((formId) => {
    //   const form = document.getElementById(formId)
    //   if (form) {
    //     form.addEventListener("submit", function (e) {
    //       e.preventDefault()
    //       alert("Form submitted successfully!")
    //       this.reset()
    //     })
    //   }
    // })
  
    // FAQ functionality
    document.querySelectorAll(".faq-question").forEach((question) => {
      question.addEventListener("click", function () {
        const faqItem = this.parentElement
        faqItem.classList.toggle("active")
      })
    })
  })
  
  // Notification system
  function addNotification(title, message) {
    const notificationsSection = document.getElementById("notifications")
    if (notificationsSection) {
      const notification = document.createElement("div")
      notification.className = "notification"
      notification.innerHTML = `
              <h4>${title}</h4>
              <p>${message}</p>
              <small>Just now</small>
          `
      notificationsSection.insertBefore(notification, notificationsSection.firstChild)
    }
  }
  
  // Page transition effect
  document.addEventListener("DOMContentLoaded", () => {
    document.body.classList.add("loaded")
  })
  
  // Fix for links to use page transition effect
  document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll("a").forEach((link) => {
      link.addEventListener("click", function (event) {
        if (
          this.hostname === window.location.hostname &&
          this.getAttribute("href").indexOf("#") !== 0 &&
          this.target !== "_blank"
        ) {
          event.preventDefault()
          const href = this.getAttribute("href")
          document.body.style.opacity = "0"
          setTimeout(() => {
            window.location.href = href
          }, 500)
        }
      })
    })
  })

  document.addEventListener("DOMContentLoaded", () => {
    // Sidebar toggle functionality for mobile
    const sidebarToggleBtn = document.getElementById("sidebar-toggle");
    const sidebar = document.querySelector(".sidebar");
    
    if (sidebarToggleBtn) {
        sidebarToggleBtn.addEventListener("click", () => {
            sidebar.classList.toggle("active");
        });
    }
    
    // Close sidebar when clicking outside on mobile
    document.addEventListener("click", (event) => {
        if (
            window.innerWidth <= 768 &&
            sidebar &&
            sidebar.classList.contains("active") &&
            !sidebar.contains(event.target) &&
            event.target !== sidebarToggleBtn
        ) {
            sidebar.classList.remove("active");
        }
    });
    
    // Navigation functionality
    document.querySelectorAll(".nav-item").forEach((item) => {
        item.addEventListener("click", function () {
            if (this.id === "logout") {
                if (confirm("Are you sure you want to logout?")) {
                    alert("Logging out...");
                    // Add logout logic here
                }
                return;
            }
    
            // Remove active class from all nav items and sections
            document.querySelectorAll(".nav-item").forEach((nav) => nav.classList.remove("active"));
            document.querySelectorAll(".section").forEach((section) => section.classList.remove("active"));
    
            // Add active class to clicked nav item
            this.classList.add("active");
    
            // Show corresponding section
            const sectionId = this.getAttribute("data-section");
            document.getElementById(sectionId).classList.add("active");
    
            // Close sidebar on mobile after navigation
            if (window.innerWidth <= 768 && sidebar) {
                sidebar.classList.remove("active");
            }
    
            // Mark notifications as read when opening the notification tab
            if (sectionId === "notifications") {
                markNotificationsAsRead();
            }
        });
    });
    
    // Notification Badge & Fetching Notifications
    function loadNotifications() {
        $.ajax({
            url: "fetch_status_notifications.php",
            method: "GET",
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    let notificationsHtml = "";
                    let unreadCount = response.unread_count || 0;
    
                    response.notifications.forEach(notification => {
                        let readClass = notification.is_read == 0 ? "unread" : "read";
                        notificationsHtml += `
                            <div class="notification-item ${readClass}">
                                <p>${notification.message}</p>
                                <small class="notif-time">${notification.created_at}</small>
                            </div>`;
                    });
    
                    $("#notification-list").html(notificationsHtml);
    
                    // Update unread notification badge dynamically
                    if (unreadCount > 0) {
                        $("#notification-badge").text(unreadCount).show();
                    } else {
                        $("#notification-badge").hide();
                    }
                } else {
                    $("#notification-list").html("<p>No new notifications.</p>");
                    $("#notification-badge").hide();
                }
            },
            error: function () {
                console.error("Error loading notifications.");
                $("#notification-list").html("<p>Error loading notifications.</p>");
            }
        });
    }
    
    function markNotificationsAsRead() {
        $.ajax({
            url: "mark_notifications_read.php",
            method: "POST",
            success: function () {
                loadNotifications();
            },
            error: function () {
                console.error("Error marking notifications as read.");
            }
        });
    }
    
    loadNotifications(); // Load notifications on page load
});

  
  