@extends('layouts.app')
@section('pagetitle', 'To Do')
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
                        <li>Manage notifications for approaching/over budget</li>
                        <li>Control user access by command line</li>
                        <li>Auditing of user actions</li>
                        <li>API key authentication</li>
                        <li>User administration &amp; roles</li>
                        <li>Sumamry Income vs Expense on Budget Screen</li>
                        <li>Sumamry Income vs Expense on Home Screen</li>
                    </ul>

                    <h3>Past things, now done</h3>
                    <ul class="done">
                        <li>Manage rules for auto-assignment of categories</li>
                        <li>Handle income categories as well</li>
                        <li>Deal with duplicate incoming transactions</li>
                        <li>Better duplicate transaction matching</li>
                    </ul>                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
