@extends('layouts.app')
@section('pagetitle', 'Create Transaction')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">New Transaction</div>

                <div class="panel-body">

                    <form class="form" action="{{route('transactions::save')}}" method="post">
                        {!! csrf_field() !!}

                        <div class="form-group">
                            <label for="account">Account</label>
                            <input type="text" class="form-control" id="account" name="account" placeholder="Account">
                        </div>
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="text" class="form-control" id="date"  name="date" placeholder="Date">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" class="form-control" id="description" name="description" placeholder="Description">
                        </div>

                        <div class="form-group">
                            <label for="category">Category</label>
                            <input name="category" id="category" class="typeahead form-control" type="text" placeholder="Category">
                        </div>

                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="text" class="form-control" id="amount" name="amount" placeholder="Amount">
                        </div>

                        <div class="col-sm-12 text-right">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                   </form>

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

$('input#category').typeahead({
    highlight: true
}, {
    name: 'categories',
    source: categories.ttAdapter()
});

// --------------------------------------------------------

var accounts = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.whitespace,
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    local: ["MasterCard", "Chequing"]
});


accounts.initialize();

$('input#account').typeahead({
    highlight: true
}, {
    name: 'accounts',
    source: accounts.ttAdapter()
});

@endsection
