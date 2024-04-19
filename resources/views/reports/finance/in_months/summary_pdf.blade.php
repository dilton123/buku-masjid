@extends('layouts.print')

@section('title', __('report.monthly'))

@section('content')
<htmlpageheader name="wpHeader">
    @include('reports.partials.letterhead')

    <h2 class="text-center strong">
        @if (isset(auth()->activeBook()->report_titles['finance_summary']))
            {{ auth()->activeBook()->report_titles['finance_summary'] }}
        @else
            {{ __('report.monthly') }}
        @endif
        @if (request('month') != '00')
            - {{ $currentMonthEndDate->isoFormat('MMMM Y') }}
        @else
            - {{ $currentMonthEndDate->isoFormat('Y') }}
        @endif
    </h2>
</htmlpageheader>

@if ($showBudgetSummary)
    <br>
    @include('reports.finance._internal_periode_summary')
    <br>
@endif

<div class="">
    @include('reports.finance._internal_content_summary')
</div>

@include('reports.finance._signature_content')
@endsection

@section('style')
<style>
    @page {
        size: auto;
        margin-top: @if($showLetterhead) 170px; @else 100px; @endif
        margin-bottom: 50px;
        margin-left: 50px;
        margin-right: 50px;
        margin-header: 40px;
        margin-footer: 40px;
        header: html_wpHeader;
    }
</style>
@endsection
