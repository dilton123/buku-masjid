<div wire:init="getFinancialStatuses">
    @if ($isLoading)
        <div class="loading-state text-center w-100">
            <img src="{{ asset('images/spinner.gif') }}" alt="Data loading spinner">
        </div>
    @else
        <div class="row align-items-end">
            <div class="col-12 col-sm-8">
                <div class="h3">{{ __('partner.financial_status') }}</div>
            </div>
            <div class="col-12 col-sm-4 text-right mb-2"></div>
        </div>

        <div class="card table-responsive-sm">
            <table class="table-sm table-striped table-bordered small">
                <thead>
                    <tr>
                        <th class="text-center">{{ __('app.table_no') }}</th>
                        <th>{{ __('partner.financial_status') }}</th>
                        @foreach ($genders as $genderCode => $genderName)
                            <th class="text-center">{{ $genderName }}</th>
                        @endforeach
                        <th class="text-center">{{ __('app.total') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @foreach (__('partner.financial_statuses') as $statusId => $statusName)
                        <tr>
                            <td class="text-center">{{ $no++ }}</td>
                            <td>{{ $statusName }}</td>
                            @foreach ($genders as $genderCode => $genderName)
                                @php
                                    $financialStatusCount = $financialStatuses->filter(function ($financialStatus) use ($statusId, $genderCode) {
                                        return $financialStatus->gender_code == $genderCode && $financialStatus->financial_status_id == $statusId;
                                    })->sum('partners_count');
                                @endphp
                                <td class="text-center">
                                    {{ link_to_route('partners.search', $financialStatusCount, ['gender_code' => $genderCode, 'financial_status_id' => $statusId, 'type_code' => $partnerTypeCode]) }}
                                </td>
                            @endforeach
                            @php
                                $financialStatusCount = $financialStatuses->filter(function ($financialStatus) use ($statusId) {
                                    return $financialStatus->financial_status_id == $statusId;
                                })->sum('partners_count');
                            @endphp
                            <td class="text-center">
                                {{ link_to_route('partners.search', $financialStatusCount, ['financial_status_id' => $statusId, 'type_code' => $partnerTypeCode]) }}
                            </td>
                        </tr>
                    @endforeach
                    @php
                        $unknownFinancialStatusCount = $financialStatuses->filter(function ($financialStatus) use ($statusId) {
                            return is_null($financialStatus->financial_status_id);
                        })->sum('partners_count');
                    @endphp
                    @if ($unknownFinancialStatusCount)
                        <tr>
                            <td class="text-center">{{ $no }}</td>
                            <td>{{ __('app.unknown') }}</td>
                            @foreach ($genders as $genderCode => $genderName)
                                @php
                                    $financialStatusCount = $financialStatuses->filter(function ($financialStatus) use ($statusId, $genderCode) {
                                        return $financialStatus->gender_code == $genderCode && is_null($financialStatus->financial_status_id);
                                    })->sum('partners_count');
                                @endphp
                                <td class="text-center">
                                    {{ link_to_route('partners.search', $financialStatusCount, ['gender_code' => $genderCode, 'financial_status_id' => 'null', 'type_code' => $partnerTypeCode]) }}
                                </td>
                            @endforeach
                         @php
                                $financialStatusCount = $financialStatuses->filter(function ($financialStatus) use ($statusId) {
                                    return is_null($financialStatus->financial_status_id);
                                })->sum('partners_count');
                            @endphp
                            <td class="text-center">
                                {{ link_to_route('partners.search', $financialStatusCount, ['financial_status_id' => 'null', 'type_code' => $partnerTypeCode]) }}
                            </td>
                        </tr>
                    @endif
                </tbody>
                <tfoot>
                    <tr class="strong">
                        <td colspan="2" class="text-right">{{ __('app.total') }}</td>
                        @foreach ($genders as $genderCode => $genderName)
                            @php
                                $financialStatusCount = $financialStatuses->filter(function ($financialStatus) use ($genderCode) {
                                    return $financialStatus->gender_code == $genderCode;
                                })->sum('partners_count');
                            @endphp
                            <td class="text-center">
                                {{ link_to_route('partners.search', $financialStatusCount, ['gender_code' => $genderCode, 'type_code' => $partnerTypeCode]) }}
                            </td>
                        @endforeach
                        <td class="text-center">
                            {{ link_to_route('partners.search', $financialStatuses->sum('partners_count'), ['type_code' => $partnerTypeCode]) }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    @endif
</div>