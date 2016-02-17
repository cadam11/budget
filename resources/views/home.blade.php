@extends('layouts.app')
@section('pagetitle', 'Overview')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <form class="form-inline">
                <div class="panel-heading">
                    <div class="input-group">
                        <span class="input-group-btn">
                            <a class="btn btn-default" href="/home?basedate={{ (new Carbon\Carbon($basedate))->subMonth() }}"><i class="fa fa-chevron-left"></i></a>
                        </span>                    
                        <select name="basedate" class="selectpicker form-control" onchange="this.form.submit()">
                            @for ($i = -3; $i <= 3; $i++)
                            <option 
                                @if ($i == 0) selected @endif 
                                value="{{ (new Carbon\Carbon($basedate))->addMonths($i) }}">
                                {{ (new Carbon\Carbon($basedate))->addMonths($i)->format('F Y') }}
                            </option>
                            @endfor
                        </select>
                        <span class="input-group-btn">
                            <a class="btn btn-default"  href="/home?basedate={{ (new Carbon\Carbon($basedate))->addMonth() }}"><i class="fa fa-chevron-right"></i></a>
                        </span>
                    </div>
                </div>
                </form>

                <div class="panel-body">

                    @if (isset($budgets['Income']))
                    <h3>Income</h3>
                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <th class="col-xs-4 col-sm-3">Category</th>
                                <th class="col-xs-7 col-sm-8">Received</th>
                                <th class="col-xs-1 col-sm-1">Left</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($budgets['Income'] as $budget)
                            <tr>
                                <td>{{$budget->category or "Uncategorized"}}</td>
                                <td>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-{{$budget->status}}" role="progressbar" style="width:{{$budget->used}}%">
                                            {{money_format("$%n", $budget->actual)}}
                                        </div>
                                    </div>
                                </td>
                                <td class="{{ ($budget->left < 0) ? 'over-budget' : '' }}">
                                    {{money_format("$%n", $budget->left)}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @endif
                    

                    @if (isset($budgets['Expense']))
                    <h3>Expenses</h3>
                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <th class="col-xs-4 col-sm-3">Category</th>
                                <th class="col-xs-7 col-sm-8">Used</th>
                                <th class="col-xs-1 col-sm-1">Left</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($budgets['Expense'] as $budget)
                            <tr>
                                <td>{{$budget->category or "Uncategorized"}}</td>
                                <td>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-{{$budget->status}}" role="progressbar" style="width:{{$budget->used}}%">
                                            {{money_format("$%n", $budget->actual)}}
                                        </div>
                                    </div>
                                </td>
                                <td class="{{ ($budget->left < 0) ? 'over-budget' : '' }}">
                                    {{money_format("$%n", $budget->left)}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
