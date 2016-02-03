@extends('layouts.app')

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

                    <form action="/import" id="my-awesome-dropzone" method="post">
                        {!! csrf_field() !!}
                        <div class="fallback">
                            <input name="file" type="file" />
                        </div>
                    </form>

                    <pre id="response" class="text-danger">
                    </pre>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="hidden">
    <form action="/import" id="direct-upload" method="post" enctype="multipart/form-data">
        {!! csrf_field() !!}
        <input name="file" id="direct-file" type="file" />
    </form>
</div>
@endsection

@section('srcscript')
<script src="{{ elixir('js/dropzone.js') }}"></script>
@endsection

@section('script')

@endsection