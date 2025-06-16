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
                            <th class="border border-gray-300 py-1">वडा
                                नम्बर</th>
                            <th class="border border-gray-300 py-1">वैदेशिक रोजगारमा गएकाहरु मात्र घरधुरी संख्या
                            </th>
                            <th class="border border-gray-300 py-1">वैदेशिक रोजगारबाट फर्केका आएका मात्र घरधुरी संख्या
                            </th>
                            <th class="border border-gray-300 py-1">जम्मा</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($wards as $ward)
                            <tr>
                                <td class="border border-gray-300 py-1">{{ $ward }}</td>
                                <td class="border border-gray-300 py-1">{{ $wardWiseDataMale[$ward] }}</td>
                                <td class="border border-gray-300 py-1">{{ $wardWiseDataFemale[$ward] }}</td>
                                <td class="border border-gray-300 py-1">
                                    {{ $wardWiseDataMale[$ward] + $wardWiseDataFemale[$ward] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="border border-gray-300 py-1">जम्मा</th>
                            <th class="border border-gray-300 py-1">{{ array_sum($wardWiseDataMale) }}</th>
                            <th class="border border-gray-300 py-1">{{ array_sum($wardWiseDataFemale) }}</th>
                            <th class="border border-gray-300 py-1">
                                {{ array_sum($wardWiseDataMale) + array_sum($wardWiseDataFemale) }}</th>
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
                        label: 'पुरुष',
                        data: @json($this->wardWiseDataMale),
                        borderWidth: 1
                    },
                    {
                        label: 'महिला',
                        data: @json($this->wardWiseDataFemale),
                        borderWidth: 1
                    }
                ]
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
                labels: ['पुरुष', 'महिला'],
                datasets: [{
                    label: 'जनसंख्या',
                    data: [{{ array_sum($wardWiseDataMale) }}, {{ array_sum($wardWiseDataFemale) }}],
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
