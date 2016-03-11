@extends('layouts.app')
@section('pagetitle', 'Import')
@section('srcstyle')
<link rel="stylesheet" href="{{ elixir('css/dropzone.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Import transactions</div>

                <div class="panel-body">

                    <form action="{{ route('transactions::saveImport') }}" class="dropzone" id="my-awesome-dropzone" method="post" style="border: 2px dashed #999">
                        {!! csrf_field() !!}
                        <div class="fallback">
                            <input name="file" type="file" />
                        </div>
                        <div class="dz-message">
                            <p class="lead">Drop files here or click to upload.</p>
                            <ul class="list-group text-muted">
                                <li class="list-group-item">File type must be text/csv</li>
                                <li class="list-group-item">First row must contain column names</li>
                                <li class="list-group-item">Requires: <code>transaction_date</code>, <code>account_type</code>, <code>description_1</code>, <code>cad</code></li>
                            </ul>
                        </div>
                    </form>

                    <pre id="response" class="text-danger" style="display: none">
                    </pre>

                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-body">
                    <h2>
                        <span class="fa-stack fa-lg">
                            <i class="fa fa-circle-o fa-stack-2x"></i>
                            <i class="fa fa-stack-1x fa-info"></i>
                        </span>
                        How importing transactions works    
                    </h2>
                    <p>
                        The software expects a CSV file with headers that include (at least) the required
                        columns given above. It parses the CSV into a <a href="https://laravel.com/docs/master/collections">Laravel Collection</a> using <a href="https://github.com/Maatwebsite/Laravel-Excel">Laravel Excel</a>, then filters that collection based on hard-coded (currently) values in the <code>account_type</code> column:
                        <ul>
                            <li>Chequing</li>
                            <li>MasterCard</li>
                        </ul>
                    </p>
                    <p>
                        <h4>Tentative transactions</h4>
                        Before actually creating any new records, it first deletes any transactions marked as tentative (based on a true value in the <code>tentative</code> optional column). The intention here is that tentative transasctions, if they're not confirmed, will just disappear from the imported data. If they're present and still tentative, they'll be re-imported. If they're present, but no longer tentative, they'll be re-imported as regular tranasctions (as if they'd never been tentative in the first place). There are a few downsides to this approach:
                        <ul class="fa-ul">
                            <li><i class="fa fa-li fa-times text-danger"></i>Any manual categorization of tentative transcations is lost at each import run</li>
                            <li><i class="fa fa-li fa-times text-danger"></i>If transactions are imported one <code>account_type</code> at a time, then tentative transactions from the first import will be wiped out by the second import.</li>
                        </ul>
                    </p>
                    <p>
                        <h4>Matching duplicates</h4>
                        The system attemps to match up duplicate transactions. It uses a fuzzy matching component to compare descriptions, <a href="https://github.com/TomLingham/Laravel-Searchy">Laravel Searchy</a>. For a duplicate transaction to match, it must have identical amount (<code>cad</code>) and <code>transaction_date</code>. The <code>description_1</code> may be only a partial match.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('srcscript')
<script src="{{ elixir('js/dropzone.js') }}"></script>
@endsection

@section('script')
Dropzone.options.myAwesomeDropzone = {
    success: function(file, done) {
        location.href="{{ route('transactions::parseImport') }}";
    },
    error: function(file, response) {
        $("#response").show().html("ERROR: " + response.message);
    }
}
@endsection
