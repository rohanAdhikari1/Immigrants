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
                            <th rowspan="2" class="border border-gray-300 py-1">वडा
                                नम्बर</th>
                            <th colspan="3" class="border border-gray-300 py-1">घरधुरी
                            </th>
                            <th colspan="2" class="border border-gray-300 py-1">जनसंख्या
                            </th>
                            <th rowspan="2" class="border border-gray-300 py-1">जम्मा</th>
                        </tr>
                        <tr>
                            <th class="border border-gray-300 py-1">पुरुष घरमुली</th>
                            <th class="border border-gray-300 py-1">महिला घरमुली</th>
                            <th class="border border-gray-300 py-1">जम्मा</th>
                            <th class="border border-gray-300 py-1">पुरुष</th>
                            <th class="border border-gray-300 py-1">महिला</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($i = 1; $i <= 4; $i++)
                            <tr>
                                <td class="border border-gray-300 py-1">{{ $i }}</td>
                                <td class="border border-gray-300 py-1">{{ $ghardhuriDataMale[$i] }}</td>
                                <td class="border border-gray-300 py-1">{{ $ghardhuriDataFemale[$i] }}</td>
                                <td class="border border-gray-300 py-1">
                                    {{ $ghardhuriDataMale[$i] + $ghardhuriDataFemale[$i] }}</td>
                                <td class="border border-gray-300 py-1">{{ $wardWiseDataMale[$i] }}</td>
                                <td class="border border-gray-300 py-1">{{ $wardWiseDataFemale[$i] }}</td>
                                <td class="border border-gray-300 py-1">
                                    {{ $wardWiseDataMale[$i] + $wardWiseDataFemale[$i] }}</td>
                            </tr>
                        @endfor
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="border border-gray-300 py-1">Total</th>
                            <th class="border border-gray-300 py-1">{{ array_sum($ghardhuriDataMale) }}</th>
                            <th class="border border-gray-300 py-1">{{ array_sum($ghardhuriDataFemale) }}</th>
                            <th class="border border-gray-300 py-1">
                                {{ array_sum($ghardhuriDataMale) + array_sum($ghardhuriDataFemale) }}</th>
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
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('barChart');
        const ctx2 = document.getElementById('pieChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['1', '2', '3', '4', '5', '6'],
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
                    label: 'घरधुरी',
                    data: @json($this->ghardhuriData),
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
@endpush
