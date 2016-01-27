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
                                <th class="col-xs-1 col-sm-1">Var</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($budgets as $budget)
                            <tr>
                                <td>{{$budget->category or "Uncategorized"}}</td>
                                <td>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-success" role="progressbar" style="width:50%">
                                            ${{money_format("%n", $budget->actual)}}
                                        </div>
                                    </div>
                                </td>
                                <td>$13.00</td>
                            </tr>
                        @endforeach

                            <tr>
                                <td>House Insurance</td>
                                <td>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-success" role="progressbar" style="width:0%">
                                            0%
                                        </div>
                                    </div>
                                </td>
                                <td>$0.00</td>
                            </tr>
                            <tr>
                                <td>Auto Insurance</td>
                                <td>
                                    <div class="progress">
                                    <div class="progress-bar progress-bar-success" style="width:70%">
                                        70%
                                    </div>
                                    </div>
                                </td>
                                <td>$0.00</td>
                            </tr>
                            <tr>
                                <td>Mortgage</td>
                                <td>
                                    <div class="progress">
                                    <div class="progress-bar progress-bar-warning" style="width:98%">
                                        98%
                                    </div>
                                    </div>
                                </td>
                                <td>$0.00</td>
                            </tr>
                            <tr>
                                <td>Gas</td>
                                <td>
                                    <div class="progress">
                                    <div class="progress-bar progress-bar-danger" style="width:125%">
                                        125%
                                    </div>
                                    </div>
                                </td>
                                <td>$250.00</td>
                            </tr>
                        </tbody>
                    </table>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
