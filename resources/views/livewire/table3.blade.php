<div class="grid gap-3 grid-cols-12 overflow-hidden">
    <div class="col-span-12 md:col-span-9">
        <div class="shadow p-3">
            <table class="table-auto text-[13px] text-center border-collapse border border-gray-300 w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border border-gray-300 py-1">पुरुष</th>
                        <th class="border border-gray-300 py-1">महिला</th>
                        <th class="border border-gray-300 py-1">जम्मा</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border border-gray-300 py-1">{{ $totalMale }}</td>
                        <td class="border border-gray-300 py-1">{{ $totalFemale }}</td>
                        <td class="border border-gray-300 py-1">
                            {{ $totalMale + $totalFemale }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-span-12 md:col-span-3">
        <div class="shadow p-3">
            <canvas class="h-80" id="pieChart"></canvas>
        </div>
    </div>
</div>
@script
    <script>
        const ctx2 = document.getElementById('pieChart');

        new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: ['पुरुष', 'महिला'],
                datasets: [{
                    label: 'जनसंख्या',
                    data: [{{ $totalMale }}, {{ $totalFemale }}],
                    borderWidth: 1,
                    hoverOffset: 4
                }],

            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
            }
        });
    </script>
@endscript
