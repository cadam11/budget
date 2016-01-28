@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Settings</div>

                <div class="panel-body">

                    <h3>To do list</h3>
                    <ul>
                        <li>Set which accounts are included in import (Currently hard-coded to MasterCard and Chequing)</li>
                        <li>Manage rules for auto-assignment of categories</li>
                        <li>Manage notifications for approaching/over budget</li>
                    </ul>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
