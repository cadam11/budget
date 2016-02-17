@extends('layouts.app')
@section('pagetitle', 'Create Rule')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">New Rule</div>

                <div class="panel-body">

                    <form class="form" action="/settings/rules" method="post">
                        {!! csrf_field() !!}

                        <div class="form-group">
                            <label for="category">Category</label>
                            <input name="category" id="category" class="typeahead form-control" type="text" placeholder="Category">
                        </div>

                        <div class="form-group">
                            <label for="pattern">Pattern</label>
                            <input type="text" class="form-control" id="pattern" name="pattern" placeholder="Pattern">
                        </div>

                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="text" class="form-control" id="amount" name="amount" placeholder="Amount">
                        </div>

                        <input type="submit" value="Save" class="btn btn-primary">
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
        url: '{!! url('/categories') !!}'
    }});


categories.initialize();

$('input#category').typeahead({
    highlight: true
}, {
    name: 'categories',
    source: categories.ttAdapter()
});


@endsection
