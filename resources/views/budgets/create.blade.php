@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">New Budget for 
                @if (!$basedate)
                this month
                @else
                {{ $basedate->startOfMonth()->format("F Y")}}
                @endif
                </div>

                <div class="panel-body">

                    <form class="form" action="/budgets" method="post">
                        {!! csrf_field() !!}
                        @if ($basedate)
                        <input type="hidden" name="month" value="{{$basedate->startOfMonth()->toDateTimeString()}}">
                        @endif

                        <div class="form-group">
                            <label for="category">Category</label>
                            <input name="category" id="category" class="typeahead form-control" type="text" placeholder="Category">
                        </div>

                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="text" class="form-control" id="amount" name="amount" placeholder="Amount">
                        </div>
                        <div class="form-group">
                            <label for="variable">Type</label>
                            <select class="form-control" id="variable" name="variable">
                                <option selected value="0">Fixed</option>
                                <option value="1">Variable</option>
                            </select>
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
