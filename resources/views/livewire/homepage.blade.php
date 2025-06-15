<div class="max-w-screen-xl mx-auto p-5">
    <div>
        <select wire:model.live="selectedReport">
            <option value="table1">Table 1 - पारिवारिक तथा जनसंख्या विवरण</option>
            <option value="table2">Table 2 - विदेशमा बसोबास गर्ने अनुपस्थित जनसंख्या </option>
            <option value="table3">Table 3 - वैदेशिक रोजगार गएका र फर्केर आएका व्यक्तिहरुको विवरण</option>
            <option value="table4">Table 4 - वैदेशिक रोजगार गएका व्यक्तिहरुको वडागत विवरण </option>
            <option value="table5">Table 5 - मिदशिा बसोबास गन अनपमस्थत जनसख्या </option>
            <option value="table6">Table 6 - मिदशिा बसोबास गन अनपमस्थत जनसख्या </option>
            <option value="table7">Table 7 - मिदशिा बसोबास गन अनपमस्थत जनसख्या </option>
            <option value="table8">Table 8 - मिदशिा बसोबास गन अनपमस्थत जनसख्या </option>
            <option value="table9">Table 9 - मिदशिा बसोबास गन अनपमस्थत जनसख्या </option>
            <option value="table10">Table 10 - मिदशिा बसोबास गन अनपमस्थत जनसख्या </option>
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
