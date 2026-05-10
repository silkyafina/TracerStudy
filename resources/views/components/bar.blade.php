@props(['id', 'labels' => [], 'data' => []])

<canvas id="{{ $id }}" height="120"></canvas>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const el = document.getElementById('{{ $id }}');
    if (!el) return;

    new Chart(el, {
        type: 'bar',
        data: {
            labels: @json($labels),
            datasets: [{
                label: 'Jumlah Alumni',
                data: @json($data),
                backgroundColor: '#4e73df'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0 }
                }
            }
        }
    });
});
</script>
