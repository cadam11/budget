@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">This Month
                    <a class="btn btn-xs btn-default pull-right" href="/transactions/create"><i class="fa fa-plus"></i> New Transaction</a>
                </div>

                <div class="panel-body">

                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <th class="col-xs-2 col-sm-2">Account</th>
                                <th class="col-xs-1 col-sm-2">Date</th>
                                <th class="col-xs-6 col-sm-5">Description</th>
                                <th class="col-xs-2 col-sm-2">Category</th>
                                <th class="col-xs-1 col-sm-1">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $t)
                            <tr>
                                <td>{{ $t->account }}</td>
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
                                <td>{{ money_format("$%n", $t->amount) }}</td>
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
    datumTokenizer: function (data) {
        return Bloodhound.tokenizers.whitespace(data.category);
    },
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    prefetch: '{!! url('/categories') !!}'
});

categories.initialize();




$('.editable-category').editable({
    mode: 'inline',
    clear: true,
    typeaheadjs: [
        {
            highlight: true
        }, {
            name: 'categories',
            displayKey: 'category',
            source: categories.ttAdapter()
        }
    ],
    success: function(response, newValue) {
        if(response.status == 'error') return response.message;
    }

});

@endsection