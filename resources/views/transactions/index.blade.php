@extends('layouts.app')

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
                            <a class="btn btn-default" href="/transactions?basedate={{ (new Carbon\Carbon($basedate->startOfMonth()))->subMonth() }}"><i class="fa fa-chevron-left"></i></a>
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
                            <a class="btn btn-default"  href="/transactions?basedate={{ (new Carbon\Carbon($basedate->startOfMonth()))->addMonth() }}"><i class="fa fa-chevron-right"></i></a>
                        </span>
                    </div>
                    @else
                    This month
                    @endif
                    <a class="btn btn-xs btn-default pull-right" href="/transactions/create"><i class="fa fa-plus"></i> New Transaction</a>
                </div>
                </form>

                <div class="panel-body">

                    <table class="table responsive" 
                        data-paging="false" 
                        data-order='[[ 0, "asc" ]]' >
                        <thead>
                            <tr>
                                <th class="col-xs-1 col-sm-2" data-priority="1">Date</th>
                                <th class="col-xs-6 col-sm-4">Description</th>
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
                                        data-url="/transactions/{{ $t->id }}"
                                        data-title="Enter category">

                                        {{ $t->category or "" }}
                                    </a>
                                </td>
                                <td>{{ $t->account }}</td>
                                <td>{{ money_format("$%n", $t->amount) }}</td>
                                <td class="text-right">
                                    <a 
                                        href="#" 
                                        id="delete"
                                        data-toggle="confirmation"
                                        data-popout="true"
                                        data-singleton="true"
                                        data-btn-ok-icon="fa fa-check"
                                        data-btn-cancel-icon="fa fa-times" 
                                        data-pk="{{ $t->id }}"
                                        class="text-muted">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
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
        url: '{!! url('/categories') !!}'
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

var table = $('table').DataTable();

$('[data-toggle="confirmation"]').confirmation({
    onConfirm: function() {
        var row = $(this).parents('tr');
       $.get('/transactions/' + $(this).data('pk') + '/delete')
        .done(function(response){
            console.log("Row deleted");
            console.log($(row));
            table.row(row).remove().draw();
        })
        .fail(function(response){ 
            console.error(response);
        });
    }
});



@endsection