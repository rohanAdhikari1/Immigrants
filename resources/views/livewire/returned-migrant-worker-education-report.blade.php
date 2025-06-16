<div class="grid gap-3 grid-cols-12 overflow-hidden">
    <div class="col-span-12 md:col-span-9">
        <div class="shadow p-3">
            <canvas class="h-80" id="barChart"></canvas>
        </div>
    </div>
    <div class="col-span-12 md:col-span-3">
        <div class="shadow p-3">
            <canvas class="h-80" id="pieChart"></canvas>
        </div>
    </div>
    <div class="col-span-12">
        <div class="shadow p-3">
            <div class="">
                <table class="table-auto text-[13px] text-center border-collapse border border-gray-300 w-full">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border border-gray-300 py-1">क्र.स</th>
                            <th class="border border-gray-300 py-1">शैक्षिक अवस्था</th>
                            <th class="border border-gray-300 py-1">जम्मा
                            </th>
                            <th class="border border-gray-300 py-1">प्रतिशत %</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($educationData as $education => $data)
                            <tr>
                                <td class="border border-gray-300 py-1">{{ $loop->iteration }}</td>
                                <td class="border border-gray-300 py-1">{{ $education }}</td>
                                <td class="border border-gray-300 py-1">{{ $data }}</td>
                                <td class="border border-gray-300 py-1">{{ $educationPercentage[$education] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="2" class="border border-gray-300 py-1">जम्मा</th>
                            <th class="border border-gray-300 py-1">{{ array_sum($educationData) }}</th>
                            <th class="border border-gray-300 py-1">
                                {{ array_sum($educationPercentage) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>

        </div>
    </div>
</div>
@script
    <script>
        const ctx = document.getElementById('barChart');
        const ctx2 = document.getElementById('pieChart');
        new Chart(ctx, {
            type: 'bar',
            data: {
                datasets: [{
                    label: 'शैक्षिक अवस्था',
                    data: @json($this->educationData),
                    borderWidth: 1
                }, ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: Object.keys(@json($this->educationPercentage)),
                datasets: [{
                    label: 'जनसंख्या',
                    data: Object.values(@json($this->educationPercentage)),
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
