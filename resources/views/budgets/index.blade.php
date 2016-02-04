@extends('layouts.app')

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
                            <a class="btn btn-default" href="/budgets?basedate={{ (new Carbon\Carbon($basedate))->subMonth() }}"><i class="fa fa-chevron-left"></i></a>
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
                            <a class="btn btn-default"  href="/budgets?basedate={{ (new Carbon\Carbon($basedate))->addMonth() }}"><i class="fa fa-chevron-right"></i></a>
                        </span>
                    </div>
                    <a class="btn btn-xs btn-default pull-right" href="/budgets/create?basedate={{ $basedate }}"><i class="fa fa-plus"></i> New Budget</a>
                </div>
                </form>

                <div class="panel-body">


                    @if (isset($budgets['Income']))
                    <h3>Income</h3>
                    <table class="table table-responsive responsive plain-datatable"
                        data-paging="false" 
                        data-order='[[ 2, "desc" ], [0, "asc"]]' >
                        <thead>
                            <tr>
                                <th class="col-xs-2 col-sm-2">Category</th>
                                <th class="col-xs-1 col-sm-1">Amount</th>
                                <th class="col-xs-1 col-sm-1">Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($budgets['Income'] as $b)
                            <tr>
                                <td>{{ $b->category }}</td>
                                <td>
                                    <a href="#" 
                                        class="editable-amount"
                                        id="amount" 
                                        data-type="text"
                                        data-pk="{{ $b->id }}"
                                        data-url="/budgets/{{ $b->id }}"
                                        data-value= "{{$b->amount}}"
                                        data-title="Enter amount">

                                        {{ money_format("$%n", $b->amount) }}
                                    </a>
                                </td>
                                <td>
                                    <a href="#"
                                        class="editable-variable"
                                        id="variable" 
                                        data-type="select"
                                        data-pk="{{ $b->id }}"
                                        data-url="/budgets/{{ $b->id }}"
                                        data-value= "{{$b->variable}}">

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <th>Total Budgeted</th>
                            <th>{{money_format("$%n", $budgets['Income']->sum('amount'))}}</th>
                            <th></th>
                        </tfoot>
                    </table>
                    <hr/>
                    @endif


                    @if (isset($budgets['Expense']))
                    <h3>Expenses</h3>
                    <table class="table table-responsive responsive grouped-by-variable"
                        data-paging="false" 
                        data-order='[[ 2, "desc" ], [0, "asc"]]' >
                        <thead>
                            <tr>
                                <th class="col-xs-2 col-sm-2">Category</th>
                                <th class="col-xs-1 col-sm-1">Amount</th>
                                <th class="col-xs-1 col-sm-1">Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($budgets['Expense'] as $b)
                            <tr>
                                <td>{{ $b->category }}</td>
                                <td>
                                    <a href="#" 
                                        class="editable-amount"
                                        id="amount" 
                                        data-type="text"
                                        data-pk="{{ $b->id }}"
                                        data-url="/budgets/{{ $b->id }}"
                                        data-value= "{{$b->amount}}"
                                        data-title="Enter amount">

                                        {{ money_format("$%n", $b->amount) }}
                                    </a>
                                </td>
                                <td>
                                    <a href="#"
                                        class="editable-variable"
                                        id="variable" 
                                        data-type="select"
                                        data-pk="{{ $b->id }}"
                                        data-url="/budgets/{{ $b->id }}"
                                        data-value= "{{$b->variable}}">

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <th>Total Budgeted</th>
                            <th>{{money_format("$%n", $budgets['Expense']->sum('amount'))}}</th>
                            <th></th>
                        </tfoot>
                    </table>
                    <hr/>
                    @endif





                    @if (isset($budgets['Ignored']))
                    <h3>Ignored</h3>
                    <table class="table table-responsive responsive plain-datatable"
                        data-paging="false" 
                        data-order='[[ 2, "desc" ], [0, "asc"]]' >
                        <thead>
                            <tr>
                                <th class="col-xs-2 col-sm-2">Category</th>
                                <th class="col-xs-1 col-sm-1">Amount</th>
                                <th class="col-xs-1 col-sm-1">Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($budgets['Ignored'] as $b)
                            <tr>
                                <td>{{ $b->category }}</td>
                                <td>
                                </td>
                                <td>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')

$('.editable-amount').editable({
    mode: 'inline',
    clear: true,
    success: function(response, newValue) {
        if(response.status == 'error') return response.message;
    }
});
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

var table = $('table.plain-datatable').DataTable();

var table = $('table.grouped-by-variable').DataTable({
    "order": [[ 2, 'desc' ]],
    "drawCallback": function ( settings ) {
        var api = this.api();
        var rows = api.rows( {page:'current'} ).nodes();
        var last=null;
        api.column(2, {page:'current'} ).data().each( function ( group, i ) {
            groupval = $(group).text();
            if ( last !== groupval && settings.aLastSort[0].col == 2) {
                $(rows).eq( i ).before(
                    '<tr class="bg-primary"><td colspan="3">'+groupval+'</td></tr>'
                );
                last = groupval;
            }
        } );
    }
} );



@endsection