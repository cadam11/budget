@extends('layouts.app')
@section('pagetitle', 'Budgets')
@section('content')
<div id="_token" class="hidden" data-token="{{ csrf_token() }}"></div>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <form class="form-inline">
                <div class="panel-heading">
                    <div class="input-group">
                        <span class="input-group-btn">
                            <a class="btn btn-default" href="{{ route('budgets::index', ['basedate' => (new Carbon\Carbon($basedate->startOfMonth()))->subMonth()->toDateTimeString()]) }}"><i class="fa fa-chevron-left"></i><span class="sr-only">Previous Month</span></a>
                        </span>
                        <select name="basedate" class="selectpicker form-control" onchange="this.form.submit()">
                            @for ($i = -3; $i <= 3; $i++)
                            <option 
                                @if ($i == 0) selected @endif 
                                value="{{ (new Carbon\Carbon($basedate))->addMonths($i) }}">
                                {{ (new Carbon\Carbon($basedate))->addMonths($i)->format('F Y') }}
                            </option>
                            @endfor
                        </select>
                        <span class="input-group-btn">
                            <a class="btn btn-default"  href="{{ route('budgets::index', ['basedate' => (new Carbon\Carbon($basedate->startOfMonth()))->addMonth()->toDateTimeString()]) }}"><i class="fa fa-chevron-right"></i><span class="sr-only">Next Month</span></a>
                        </span>
                    </div>
                    <div class="btn-group pull-right">
                        <a class="btn btn-xs btn-default" href="{{ route('budgets::create', ['basedate', $basedate]) }}"><i class="fa fa-plus"></i> New Budget</a>
                        <button type="button" class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('budgets::copy', ['basedate', $basedate]) }}"><i class="fa fa-clone"></i> Copy from last month</a></li>
                        </ul>
                    </div>
                </div>
                </form>

                <div class="panel-body">

                    @if (isset($budgets['Income']) && isset($budgets['Expense']))                    

                        <h3>Budgeted</h3>
                        <div class="row">
                            <div class="col-sm-2">
                            Income
                            </div>
                            <div class="col-sm-8">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-primary" role="progressbar" 
                                        style="width:{{ $incomePct }}%">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                            {{money_format("$%n", $budgets['Income']->sum('amount'))}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                            Expenses
                            </div>
                            <div class="col-sm-8">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-primary" role="progressbar" 
                                        style="width:{{ $expensePct }}%">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                            {{money_format("$%n", $budgets['Expense']->sum('amount'))}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 lead text-center
                            @if ($net < 0) text-danger @endif
                            ">
                            {{ ($net<0?'Deficit':'Surplus') }} <strong>{{money_format("$%n", $net)}}</strong>
                            </div>
                        </div>

                    @endif




                    @if (isset($budgets['Income']))
                    @include('budgets.partials.table', [
                        'title' => 'Income',
                        'budgets' => $budgets['Income'],
                        ])
                    @endif




                    @if (isset($budgets['Expense']))
                    @include('budgets.partials.table', [
                        'title' => 'Expense',
                        'budgets' => $budgets['Expense'],
                        ])
                    @endif




                    @if (isset($budgets['Ignored']))
                    @include('budgets.partials.table', [
                        'title' => 'Ignored',
                        'budgets' => $budgets['Ignored'],
                        'showFooter' => false,
                        'showAmount' => false,
                        'showType' => false,
                        ])
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')

$('.editable-variable').editable({
    mode: 'inline',
    source: [
        {value: 0, text: 'Fixed'},
        {value: 1, text: 'Variable'}
    ],
    success: function(response, newValue) {
        if(response.status == 'error') return response.message;
    }
});

$('table[data-grouping="Type"]').DataTable({
    "order": [[ 2, 'desc' ]],
    "drawCallback": function ( settings ) {
        var api = this.api();
        var rows = api.rows( {page:'current'} ).nodes();
        var last=null;
        api.column(2, {page:'current'} ).data().each( function ( group, i ) {
            groupval = $(group).text();
            if ( last !== groupval && settings.aLastSort[0].col == 2) {
                $(rows).eq( i ).before(
                    '<tr class="bg-primary"><td colspan="4">'+groupval+'</td></tr>'
                );
                last = groupval;
            }
        } );
    }
} );




@endsection