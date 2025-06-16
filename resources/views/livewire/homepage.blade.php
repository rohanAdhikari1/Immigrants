<div class="max-w-screen-xl mx-auto p-5">
    <div>
        <select wire:model.live="selectedReport">
            <option value="table1">Table 1 - पारिवारिक तथा जनसंख्या विवरण</option>
            <option value="table2">Table 2 - विदेशमा बसोबास गर्ने अनुपस्थित जनसंख्या </option>
            <option value="table3">Table 3 - वैदेशिक रोजगार गएका र फर्केर आएका व्यक्तिहरुको संक्षिप्त विवरण</option>
            {{-- <option value="table4">Table 4 - वैदेशिक रोजगार गएका र फर्केर आएका व्यक्तिहरुको विवरण </option>
            <option value="table5">Table 5 - वैदेशिक रोजगारमा गएका र फर्केको घर सम्बन्धी विवरण</option> --}}
            <option value="table6">Table 6 - वैदेशिक रोजगार गएका व्यक्तिहरुको वडागत विवरण </option>
            <option value="table7">Table 7 - वैदेशिक रोजगारमा गएको देश </option>
            <option value="table8">Table 8 - वैदेशिक रोजगारमा गएका व्यक्तिको शैक्षिक अवस्था </option>
            <option value="table9">Table 9 - वैदेशिक रोजगारमा गएका व्यक्तिको वैवाहिक अवस्था </option>
            <option value="table10">Table 10 - वैदेशिक रोजगारमा गएका व्यक्तिको घरको मुख्य पेशा </option>
            <option value="table11">Table 11 - वैदेशिक रोजगारबाट फर्किएका व्यक्तिहरुको शैक्षिक अवस्था</option>
            <option value="table12">Table 12 - वैदेशिक रोजगारबाट फर्किएका व्यक्तिहरुको वैवाहिक अवस्था</option>
            <option value="table13">Table 13 - वैदेशिक रोजगारबाट फर्केर आएको अवधि</option>
            <option value="table14">Table 14 - वैदेशिक रोजगारबाट फर्किनुको कारण</option>
            <option value="table15">Table 15 - वैदेशिक रोजगारको क्रममा प्राप्त गरेको कामको अनुभवको विवरण</option>
            <option value="table16">Table 16 - वैदेशिक रोजगारबाट फर्किएपछि नेपालमा सीप तालिम लिएको विवरण</option>
            <option value="table17">Table 17 - फर्कि आएका व्यक्तिहरुको फेरि वैदेशिक रोजगार जाने सोच</option>
            <option value="table18">Table 18 - वैदेशिक रोजगारबाट फर्किएका व्यक्तिहरु हालको संलग्नता</option>
            <option value="table19">Table 19 - व्यवसायमा संलग्न व्यक्तिहरुको व्यवसायको प्रकृति</option>
        </select>
    </div>
    <div class="my-5">
        <diV class="shadow-lg backdrop-blur-lg bg-white rounded-sm p-4">
            @switch($selectedReport)
                @case('table1')
                    <livewire:pariwariktathajansankyabibaran />
                @break

                @case('table2')
                    <livewire:table2 />
                @break

                @case('table3')
                    <livewire:table3 />
                @break

                @case('table6')
                    <livewire:wardwise-current-migrant-detail />
                @break

                @case('table7')
                    <livewire:foreign-employement-country-report />
                @break

                @case('table8')
                    <livewire:migrant-worker-education-report />
                @break

                @case('table9')
                    <livewire:migrant-worker-maritial-report />
                @break

                @case('table10')
                    <livewire:migrant-worker-house-major-work-report />
                @break

                @case('table11')
                    <livewire:returned-migrant-worker-education-report />
                @break

                @case('table12')
                    <livewire:returned-migrant-worker-maritial-report />
                @break

                @case('table14')
                    <livewire:migrant-return-reason-report />
                @break

                @case('table15')
                    <livewire:work-experience-during-f-e-report />
                @break

                @default
                    <div>
                        <div class="mx-auto py-3 text-center font-semibold">
                            Something Went Wrong 🤖🙉
                        </div>
                    </div>
            @endswitch
        </div>
    </div>
</div>
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush
