// Total Applications Chart
var total_applications_ctx = document.getElementById('totalApplicationsChart');
var totalApplicationsChart = new Chart(total_applications_ctx, {
    type: 'bar',
    data: {
        labels,
        datasets: [{
            label: [],
            data,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
            position: 'top',
            },
            title: {
                display: false,
                text: 'Promotion Sources'
            },
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
// Total Applications Chart ends
// Tiktok Applications Chart starts
var tiktok__applications_ctx = document.getElementById('TiktokApplicationsChart');
var data = {
    labels: "Tiktok",

};
var myBarChart = new Chart(tiktok__applications_ctx, {
    type: 'bar',
    data: data,
    options: {
        barValueSpacing: 10,
        scales: {
            yAxes: [{
                ticks: {
                    min: 0,
                }
            }]
        }
    }
});
// Tiktok Applications Chart ends
// Facebook Applications Chart starts
var tiktok__applications_ctx = document.getElementById('facebookApplicationsChart');
var data = {
    labels: "Facebook",

};
var myBarChart = new Chart(tiktok__applications_ctx, {
    type: 'bar',
    data: data,
    options: {
        barValueSpacing: 10,
        scales: {
            yAxes: [{
                ticks: {
                    min: 0,
                }
            }]
        }
    }
});
// Facebook Applications Chart ends
// Youtube Applications Chart starts
var youtube_applications_ctx = document.getElementById('youtubeApplicationsChart');
var data = {
    labels: ["Pass","Fail","Absent","Late"],
    // datasets: [
    //     {
    //         label: "Visit Visa",
    //         data: [5,7],
    //         backgroundColor: [
    //             'rgba(54, 162, 235, 0.2)'
    //         ],
    //         borderColor: [
    //             'rgba(54, 162, 235, 1)'
    //         ],
    //         borderWidth: 1
    //     },
    //     {
    //         label: "Company Visa",
    //         data: [4,3,4],
    //         backgroundColor: [
    //             'rgba(255, 99, 132, 0.2)'
    //         ],
    //         borderColor: [
    //             'rgba(255, 99, 132, 1)'
    //         ],
    //         borderWidth: 1
    //     }
    // ]
};
var myBarChart = new Chart(youtube_applications_ctx, {
    type: 'bar',
    data: data,
    options: {
        barValueSpacing: 10,
        scales: {
            yAxes: [{
                ticks: {
                    min: 0,
                }
            }]
        }
    }
});
// Youtube Applications Chart ends
// website Applications Chart
var website_applications_ctx = document.getElementById('websiteApplicationsChart');
var data = {
    labels: ["Pass","Fail","Absent","Late"],
    // datasets: [
    //     {
    //         label: "Visit Visa",
    //         data: [5,7],
    //         backgroundColor: [
    //             'rgba(54, 162, 235, 0.2)'
    //         ],
    //         borderColor: [
    //             'rgba(54, 162, 235, 1)'
    //         ],
    //         borderWidth: 1
    //     },
    //     {
    //         label: "Company Visa",
    //         data: [4,3,4],
    //         backgroundColor: [
    //             'rgba(255, 99, 132, 0.2)'
    //         ],
    //         borderColor: [
    //             'rgba(255, 99, 132, 1)'
    //         ],
    //         borderWidth: 1
    //     }
    // ]
};
var myBarChart = new Chart(website_applications_ctx, {
    type: 'bar',
    data: data,
    options: {
        barValueSpacing: 10,
        scales: {
            yAxes: [{
                ticks: {
                    min: 0,
                }
            }]
        }
    }
});
// website Applications Chart


// Instagram Applications Chart
var instagram_applications_ctx = document.getElementById('instagramApplicationsChart');
var data = {
    labels: ["Pass","Fail","Absent","Late"],
    // datasets: [
    //     {
    //         label: "Visit Visa",
    //         data: [5,7],
    //         backgroundColor: [
    //             'rgba(54, 162, 235, 0.2)'
    //         ],
    //         borderColor: [
    //             'rgba(54, 162, 235, 1)'
    //         ],
    //         borderWidth: 1
    //     },
    //     {
    //         label: "Company Visa",
    //         data: [4,3,4],
    //         backgroundColor: [
    //             'rgba(255, 99, 132, 0.2)'
    //         ],
    //         borderColor: [
    //             'rgba(255, 99, 132, 1)'
    //         ],
    //         borderWidth: 1
    //     }
    // ]
};
var myBarChart = new Chart(instagram_applications_ctx, {
    type: 'bar',
    data: data,
    options: {
        barValueSpacing: 10,
        scales: {
            yAxes: [{
                ticks: {
                    min: 0,
                }
            }]
        }
    }
});
// Instagram Applications Chart


// Friend Applications Chart
var friend_applications_ctx = document.getElementById('friendApplicationsChart');
var data = {
    labels: ["Pass","Fail","Absent","Late"],
    // datasets: [
    //     {
    //         label: "Visit Visa",
    //         data: [5,7],
    //         backgroundColor: [
    //             'rgba(54, 162, 235, 0.2)'
    //         ],
    //         borderColor: [
    //             'rgba(54, 162, 235, 1)'
    //         ],
    //         borderWidth: 1
    //     },
    //     {
    //         label: "Company Visa",
    //         data: [4,3,4],
    //         backgroundColor: [
    //             'rgba(255, 99, 132, 0.2)'
    //         ],
    //         borderColor: [
    //             'rgba(255, 99, 132, 1)'
    //         ],
    //         borderWidth: 1
    //     }
    // ]
};
var myBarChart = new Chart(friend_applications_ctx, {
    type: 'bar',
    data: data,
    options: {
        barValueSpacing: 10,
        scales: {
            yAxes: [{
                ticks: {
                    min: 0,
                }
            }]
        }
    }
});
// Friend Applications Chart

// Other Applications Chart
var other_applications_ctx = document.getElementById('otherApplicationsChart');
var data = {
    labels: ["Pass","Fail","Absent","Late"],
    // datasets: [
    //     {
    //         label: "Visit Visa",
    //         data: [5,7],
    //         backgroundColor: [
    //             'rgba(54, 162, 235, 0.2)'
    //         ],
    //         borderColor: [
    //             'rgba(54, 162, 235, 1)'
    //         ],
    //         borderWidth: 1
    //     },
    //     {
    //         label: "Company Visa",
    //         data: [4,3,4],
    //         backgroundColor: [
    //             'rgba(255, 99, 132, 0.2)'
    //         ],
    //         borderColor: [
    //             'rgba(255, 99, 132, 1)'
    //         ],
    //         borderWidth: 1
    //     }
    // ]
};
var myBarChart = new Chart(other_applications_ctx, {
    type: 'bar',
    data: data,
    options: {
        barValueSpacing: 10,
        scales: {
            yAxes: [{
                ticks: {
                    min: 0,
                }
            }]
        }
    }
});
// Other Applications Chart

// Radio Applications Chart
var radio_applications_ctx = document.getElementById('radioApplicationsChart');
var data = {
    labels: ["Pass","Fail","Absent","Late"],
    // datasets: [
    //     {
    //         label: "Visit Visa",
    //         data: [5,7],
    //         backgroundColor: [
    //             'rgba(54, 162, 235, 0.2)'
    //         ],
    //         borderColor: [
    //             'rgba(54, 162, 235, 1)'
    //         ],
    //         borderWidth: 1
    //     },
    //     {
    //         label: "Company Visa",
    //         data: [4,3,4],
    //         backgroundColor: [
    //             'rgba(255, 99, 132, 0.2)'
    //         ],
    //         borderColor: [
    //             'rgba(255, 99, 132, 1)'
    //         ],
    //         borderWidth: 1
    //     }
    // ]
};
var myBarChart = new Chart(radio_applications_ctx, {
    type: 'bar',
    data: data,
    options: {
        barValueSpacing: 10,
        scales: {
            yAxes: [{
                ticks: {
                    min: 0,
                }
            }]
        }
    }
});
// Radio Applications Chart

// Restaurant Applications Chart
var radio_applications_ctx = document.getElementById('restaurantApplicationsChart');
var data = {
    labels: ["Pass","Fail","Absent","Late"],
    // datasets: [
    //     {
    //         label: "Visit Visa",
    //         data: [5,7],
    //         backgroundColor: [
    //             'rgba(54, 162, 235, 0.2)'
    //         ],
    //         borderColor: [
    //             'rgba(54, 162, 235, 1)'
    //         ],
    //         borderWidth: 1
    //     },
    //     {
    //         label: "Company Visa",
    //         data: [4,3,4],
    //         backgroundColor: [
    //             'rgba(255, 99, 132, 0.2)'
    //         ],
    //         borderColor: [
    //             'rgba(255, 99, 132, 1)'
    //         ],
    //         borderWidth: 1
    //     }
    // ]
};
var myBarChart = new Chart(radio_applications_ctx, {
    type: 'bar',
    data: data,
    options: {
        barValueSpacing: 10,
        scales: {
            yAxes: [{
                ticks: {
                    min: 0,
                }
            }]
        }
    }
});
// Restaurant Applications Chart
