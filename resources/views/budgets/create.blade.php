@extends('layouts.app')
@section('pagetitle', 'Create Budget')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">New Budget for 
                @if (isset($basedate))
                {{ $basedate->startOfMonth()->format("F Y")}}
                @else
                this month
                @endif
                </div>

                <div class="panel-body">

                    <form class="form" action="{{ route('budgets::save') }}" method="post">
                        {!! csrf_field() !!}
                        @if ($basedate)
                        <input type="hidden" name="basedate" value="{{$basedate->startOfMonth()->toDateTimeString()}}">
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
                            <label for="variable">Variability</label>
                            <select class="form-control selectpicker" id="variable" name="variable">
                                <option selected value="0">Fixed</option>
                                <option value="1">Variable</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="type">Type</label>
                            <select class="form-control selectpicker" id="type" name="type">
                                <option selected value="Expense">Expense</option>
                                <option value="Income">Income</option>
                                <option value="Ignored">Ignored</option>
                            </select>
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
    }});


categories.initialize();

$('input#category').typeahead({
    highlight: true
}, {
    name: 'categories',
    source: categories.ttAdapter()
});


@endsection
