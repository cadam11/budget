@extends('layouts.app')
@section('pagetitle', 'Settings')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">System settings</div>

                <div class="panel-body">

                    <form class="form-horizontal" action="{{ route('admin::saveSettings') }}" method="post">
                        {!! csrf_field() !!}

                        <div class="form-group">
                            <label for="enable-api" class="col-sm-2 control-label">Enable API</label>
                            <div class="col-sm-4">
                                <select class="form-control selectpicker" id="enable-api" name="enable-api">
                                    <option selected value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
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
