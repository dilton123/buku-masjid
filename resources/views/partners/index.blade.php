@extends('layouts.settings')

@section('title', __('partner.list'))

@section('content_settings')
<div class="page-header">
    <h1 class="page-title">{{ __('partner.list') }}</h1>
    <div class="page-subtitle">{{ __('app.total') }} : {{ $partners->count() }} {{ __('partner.partner') }}</div>
    <div class="page-options d-flex">
        @can('create', new App\Models\Partner)
            {{ link_to_route('partners.index', __('partner.create'), ['action' => 'create'], ['class' => 'btn btn-success']) }}
        @endcan
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card table-responsive">
            <table class="table table-sm table-responsive-sm table-hover mb-0">
                <thead>
                    <tr>
                        <th class="text-center">{{ __('app.table_no') }}</th>
                        <th class="text-nowrap">{{ __('partner.name') }}</th>
                        <th class="text-nowrap">{{ __('partner.phone') }}</th>
                        <th class="text-center">{{ __('app.status') }}</th>
                        <th class="text-center">{{ __('app.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($partners as $key => $partner)
                    <tr>
                        <td class="text-center">{{ 1 + $key }}</td>
                        <td>{{ $partner->name }}</td>
                        <td>{{ $partner->phone }}</td>
                        <td class="text-nowrap text-center">{{ $partner->status }}</td>
                        <td class="text-center text-nowrap">
                            @can('view', $partner)
                                {{ link_to_route(
                                    'partners.show',
                                    __('app.show'),
                                    $partner,
                                    [
                                        'id' => 'show-partner-'.$partner->id,
                                        'class' => 'btn btn-sm btn-secondary',
                                    ]
                                ) }}
                            @endcan
                            @can('update', $partner)
                                {{ link_to_route(
                                    'partners.index',
                                    __('app.edit'),
                                    ['action' => 'edit', 'id' => $partner->id],
                                    [
                                        'id' => 'edit-partner-'.$partner->id,
                                        'class' => 'btn btn-sm text-dark btn-warning',
                                    ]
                                ) }}
                            @endcan
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5">{{ __('partner.not_found') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-4">
        @if(Request::has('action'))
            @include('partners.forms')
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
(function () {
    $('#partnerModal').modal({
        show: true,
        backdrop: 'static',
    });
})();
</script>
@endpush