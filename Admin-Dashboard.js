// Navigation
document.querySelectorAll('.nav-item').forEach(item => {
    item.addEventListener('click', () => {
        const sectionId = item.dataset.section;
        if (sectionId) {
            // Update active nav item
            document.querySelectorAll('.nav-item').forEach(nav => nav.classList.remove('active'));
            item.classList.add('active');

            // Show active section
            document.querySelectorAll('.section').forEach(section => section.classList.remove('active'));
            document.getElementById(sectionId).classList.add('active');
        }
    });
});


// Website Traffic Chart
const trafficCtx = document.getElementById('trafficChart').getContext('2d');

$.ajax({
    url: "get_traffic_data.php",
    method: "GET",
    dataType: "json",
    success: function (response) {
        if (response.status === "success") {
            new Chart(trafficCtx, {
                type: 'line',
                data: {
                    labels: response.labels,
                    datasets: [{
                        label: 'Website Traffic',
                        data: response.data,
                        borderColor: '#c70049',
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            ticks: { color: 'white' },
                            grid: { color: 'rgba(255,255,255,0.2)' }
                        },
                        y: {
                            ticks: { color: 'white' },
                            grid: { color: 'rgba(255,255,255,0.2)' }
                        }
                    },
                    plugins: {
                        title: {
                            display: true,
                            text: 'Monthly Website Traffic',
                            color: 'white'
                        },
                        legend: {
                            labels: { color: 'white' }
                        }
                    }
                }
            });
        }
    },
    error: function () {
        console.error("Error loading traffic chart data.");
    }
});

// Website Traffic Chart



// Total Completed Orders by category Chart
const ordersCtx = document.getElementById('ordersChart').getContext('2d');

// Fetch dynamic data from PHP
$.ajax({
    url: "get_orders_by_service.php",
    method: "GET",
    dataType: "json",
    success: function (response) {
        if (response.status === "success") {
            const labels = response.data.map(item => item.service);
            const totals = response.data.map(item => item.total);

            new Chart(ordersCtx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Total orders completed by category',
                        data: totals,
                        backgroundColor: '#c70049'
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            ticks: { color: 'white' },
                            grid: { color: 'rgba(255,255,255,0.2)' }
                        },
                        y: {
                            ticks: { color: 'white' },
                            grid: { color: 'rgba(255,255,255,0.2)' }
                        }
                    },
                    plugins: {
                        title: {
                            display: true,
                            text: 'Orders by Service Type',
                            color: 'white'
                        },
                        legend: {
                            labels: { color: 'white' }
                        }
                    }
                }
            });
        }
    },
    error: function () {
        console.error("Failed to fetch chart data.");
    }
});

// Total Completed Orders by category Chart


// const revenueCtx = document.getElementById('revenueChart').getContext('2d');

// new Chart(revenueCtx, {
//     type: 'line',
//     data: {
//         labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
//         datasets: [{
//             label: 'Monthly Revenue',
//             data: [8500, 10200, 12000, 11500, 12450, 13100],
//             borderColor: '#c70049',
//             tension: 0.4
//         }]
//     },
//     options: {
//         responsive: true,
//         scales: {
//             x: {
//                 ticks: {
//                     color: 'white'
//                 },
//                 grid: {
//                     color: 'rgba(255,255,255,0.2)'
//                 }
//             },
//             y: {
//                 ticks: {
//                     color: 'white'
//                 },
//                 grid: {
//                     color: 'rgba(255,255,255,0.2)'
//                 }
//             }
//         },
//         plugins: {
//             title: {
//                 display: true,
//                 text: 'Revenue Trends',
//                 color: 'white'
//             },
//             legend: {
//                 labels: {
//                     color: 'white'
//                 }
//             }
//         }
//     }
// });




// Service Distribution Pie Chart
const serviceCtx = document.getElementById('serviceChart').getContext('2d');

$.ajax({
    url: "get_service_distribution.php",
    method: "GET",
    dataType: "json",
    success: function (response) {
        if (response.status === "success") {
            new Chart(serviceCtx, {
                type: 'pie',
                data: {
                    labels: response.labels,
                    datasets: [{
                        data: response.data,
                        backgroundColor: [
                            '#ff4d7a', '#ff1a5c', '#c70049', '#9c0039', '#730028', '#FF9900', '#4CAF50'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Service Distribution',
                            color: 'white'
                        },
                        legend: {
                            labels: {
                                color: 'white'
                            }
                        }
                    }
                }
            });
        } else {
            console.error("No data found for pie chart.");
        }
    },
    error: function () {
        console.error("Failed to load service distribution data.");
    }
});

// Service Distribution Pie Chart
