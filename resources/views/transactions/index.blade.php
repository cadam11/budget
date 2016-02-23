@extends('layouts.app')
@section('pagetitle', 'Transactions')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <form class="form-inline">
                <div class="panel-heading">
                    @if (isset($title)) {{ $title }}
                    @elseif (isset($basedate))
                    <div class="input-group">
                        <span class="input-group-btn">
                            <a class="btn btn-default" href="{{ route('transactions::index', ['basedate' => (new Carbon\Carbon($basedate->startOfMonth()))->subMonth()->toDateTimeString()]) }}"><i class="fa fa-chevron-left"></i><span class="sr-only">Previous Month</span></a>
                        </span>                    
                        <select name="basedate" class="selectpicker form-control" onchange="this.form.submit()">
                            @for ($i = -3; $i <= 3; $i++)
                            <option 
                                @if ($i == 0) selected @endif 
                                value="{{ (new Carbon\Carbon($basedate->startOfMonth()))->addMonths($i) }}">
                                {{ (new Carbon\Carbon($basedate))->addMonths($i)->format('F Y') }}
                            </option>
                            @endfor
                        </select>
                        <span class="input-group-btn">
                            <a class="btn btn-default"  href="{{ route('transactions::index', ['basedate' => (new Carbon\Carbon($basedate->startOfMonth()))->addMonth()->toDateTimeString()]) }}"><i class="fa fa-chevron-right"></i><span class="sr-only">Next Month</span></a>
                        </span>
                    </div>
                    @else
                    This month
                    @endif
                    <div class="btn-group pull-right">
                        <a class="btn btn-xs btn-default" href="{{ route('transactions::create') }}"><i class="fa fa-plus"></i> New Transaction</a>
                        <button type="button" class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('transactions::import') }}"><i class="fa fa-cloud-upload"></i> Import transactions</a></li>
                        </ul>
                    </div>

                </div>
                </form>

                <div class="panel-body">

                    <table class="table responsive" 
                        data-paging="false" 
                        data-order='[[ 0, "desc" ]]' >
                        <thead>
                            <tr>
                                <th class="col-xs-1 col-sm-2" data-priority="1">Date</th>
                                <th class="col-xs-6 col-sm-4" data-priority="3">Description</th>
                                <th class="col-xs-2 col-sm-2">Category</th>
                                <th class="col-xs-2 col-sm-2">Account</th>
                                <th class="col-xs-1 col-sm-1" data-priority="2">Amount</th>
                                <th class="col-xs-1 col-sm-1" data-orderable="false"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions->sortBy('date') as $t)
                            <tr>
                                <td>{{ $t->date->format('Y-m-d') }}</td>
                                <td>{{ $t->description }}</td>
                                <td>
                                    <a href="#" 
                                        class="editable-category"
                                        id="category" 
                                        data-type="text"
                                        data-pk="{{ $t->id }}"
                                        data-url="{{ route('transactions::update', ['id'=>$t->id]) }}"
                                        data-title="Enter category">

                                        {{ $t->category or "" }}
                                    </a>
                                    @if (isset($budgets) && !in_array($t->category, $budgets))
                                    <div class="hidden">Unbudgeted</div>
                                    @endif
                                </td>
                                <td>{{ $t->account }}</td>
                                <td>{{ money_format("$%n", $t->amount) }}</td>
                                <td class="text-right">
                                    <a 
                                        href="#" 
                                        onclick="return false"
                                        data-copy-attributes="onclick"
                                        data-toggle="confirmation"
                                        data-popout="true"
                                        data-singleton="true"
                                        data-btn-ok-icon="fa fa-check"
                                        data-btn-cancel-icon="fa fa-times" 
                                        data-target="{{ route('transactions::delete', [$t->id]) }}"
                                        class="text-muted delete">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Total</th>
                                <th>
                                    <span id="total-credits"></span> 
                                    <span id="total-debits"></span>
                                </th>
                                <th></th>
                                <th></th>
                                <th id="total-net"></th>
                                <th></th>
                            </tr>

                        </tfoot>
                    </table>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')

var categories = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.whitespace,
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    prefetch: {
        cache: false,
        url: '{!! route('categories') !!}'
    }
});


categories.initialize();


$('.editable-category').editable({
    mode: 'inline',
    clear: true,
    typeaheadjs: {
        highlight: true,
        name: 'categories',
        source: categories.ttAdapter()
    },
    success: function(response, newValue) {
        if(response.status == 'error') return response.message;
    }

});


var table = $('table').DataTable({

        "search": {
            "search": "{{ $search or '' }}"
        },

        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get numeric data for summation

            var format = function(n){
                var abs = Math.abs(n);
                var s = abs.toFixed(2).replace(/./g, function(c, i, a) {
                    return i && c !== "." && ((a.length - i) % 3 === 0) ? ',' + c : c;
                });
                return '$' + (n < 0 ? '-':'') + s;
            }

            var credit = function(i){
                var amt = typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*-1 :
                    typeof i === 'number' ?
                        i : 0;
                return amt < 0 ? 0 : amt;
            }
 
            var debit = function(i){
                var amt = typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
                return amt < 0 ? 0 : amt;
            }
 

            // Total over all pages
            credits = api
                .column(4, {'filter': 'applied'})
                .data()
                .reduce( function (a, b) {
                    return credit(a) + credit(b);
                }, 0 );
 
            // Total over this page
            debits = api
                .column(4, {'filter': 'applied'})
                .data()
                .reduce( function (a, b) {
                    return debit(a) + debit(b);
                }, 0 );
 
            // Update footer
            if (credits == 0) $("#total-credits").parent("tr").hide();
            else $("#total-credits").html(format(credits) + " CR").parent("tr").show();
            
            if (debits == 0) $("#total-debits").parent("tr").hide();
            else $("#total-debits").html(format(debits) + " DR").parent("tr").show();
            
            $("#total-net").html(format(debits-credits));
        }
    });



@endsection