@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">This Month</div>

                <div class="panel-body">

                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <th class="col-xs-4 col-sm-3">Category</th>
                                <th class="col-xs-7 col-sm-8">Used</th>
                                <th class="col-xs-1 col-sm-1">Left</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($budgets as $budget)
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


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
