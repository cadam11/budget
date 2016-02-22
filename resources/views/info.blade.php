@extends('layouts.app')
@section('pagetitle', 'Info')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">System info</div>

                <div class="panel-body">

                    <div class="col-md-2">
                        <strong>Git commit:</strong>
                    </div>
                    <div class="col-md-10">
                        {{ $git }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
