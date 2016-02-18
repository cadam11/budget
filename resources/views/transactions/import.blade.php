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

                    <form action="/transactions/import" class="dropzone" id="my-awesome-dropzone" method="post" style="border: 2px dashed #999">
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
        location.href="/transactions/import/parse";
    },
    error: function(file, response) {
        $("#response").show().html("ERROR: " + response.message);
    }
}
@endsection