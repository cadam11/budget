@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">To do</div>

                <div class="panel-body">

                    <h3>My list of things to do</h3>
                    <ul>
                        <li>Set which accounts are included in import (Currently hard-coded to MasterCard and Chequing)</li>
                        <li><del>Manage rules for auto-assignment of categories</del></li>
                        <li>Manage notifications for approaching/over budget</li>
                        <li>Handle income categories as well</li>
                        <li>Deal with duplicate incoming transactions</li>
                    </ul>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
