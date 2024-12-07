// chart.js (inside js folder)

// Appointment data
const appointmentLabels = <?= json_encode($appointmentLabels); ?>;
const appointmentCounts = <?= json_encode($appointmentCounts); ?>;

// Referral data
const referralLabels = <?= json_encode($referralLabels); ?>;
const referralCounts = <?= json_encode($referralCounts); ?>;

// Render Appointment Chart
const ctx1 = document.getElementById('appointmentChart').getContext('2d');
new Chart(ctx1, {
    type: 'bar',
    data: {
        labels: appointmentLabels,
        datasets: [{
            label: 'Number of Appointments',
            data: appointmentCounts,
            backgroundColor: 'rgba(54, 162, 235, 0.6)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Render Referral Chart
const ctx2 = document.getElementById('referralChart').getContext('2d');
new Chart(ctx2, {
    type: 'pie',
    data: {
        labels: referralLabels,
        datasets: [{
            label: 'Number of Referrals',
            data: referralCounts,
            backgroundColor: [
                'rgba(255, 99, 132, 0.6)',
                'rgba(54, 162, 235, 0.6)',
                'rgba(255, 206, 86, 0.6)',
                'rgba(75, 192, 192, 0.6)',
                'rgba(153, 102, 255, 0.6)',
                'rgba(255, 159, 64, 0.6)'
            ]
        }]
    }
});
