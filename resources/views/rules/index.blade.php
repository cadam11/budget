@extends('layouts.app')
@section('pagetitle', 'Rules')
@section('content')
<div id="_token" class="hidden" data-token="{{ csrf_token() }}"></div>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Category Rules
                    <a class="btn btn-xs btn-default pull-right" href="{{ route('admin::rules::create') }}"><i class="fa fa-plus"></i> New Rule</a>
                </div>

                <div class="panel-body">

                    <table class="table table-responsive table-striped">
                        <thead>
                            <tr>
                                <th class="col-xs-2 col-sm-2">Category</th>
                                <th class="col-xs-1 col-sm-2">Pattern</th>
                                <th class="col-xs-1 col-sm-1">Amount</th>
                                <th class="col-xs-1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rules as $r)
                            <tr>
                                <td>
                                    <a href="#" 
                                        class="editable"
                                        id="category" 
                                        data-type="text"
                                        data-pk="{{ $r->id }}"
                                        data-url="{{ route('admin::rules::update', [$r->id]) }}">

                                        {{ $r->category or '' }}
                                    </a>
                                </td>
                                <td>
                                    <a href="#"
                                        class="editable"
                                        id="pattern" 
                                        data-type="text"
                                        data-pk="{{ $r->id }}"
                                        data-url="{{ route('admin::rules::update', [$r->id]) }}">

                                        {{ $r->pattern or '' }}

                                </td>
                                <td>
                                    <a href="#" 
                                        class="editable"
                                        id="amount" 
                                        data-type="text"
                                        data-pk="{{ $r->id }}"
                                        data-url="{{ route('admin::rules::update', [$r->id]) }}"
                                        data-value= "{{$r->amount}}">

                                        {{ $r->amount == null ? '' :  money_format("$%n", $r->amount) }}
                                    </a>
                                </td>
                                <td class="text-right">
                                    <a 
                                        href="#" 
                                        onclick="return false"
                                        data-copy-attributes="onclick"
                                        data-toggle="confirmation"
                                        data-popout="true"
                                        data-singleton="true"
                                        data-btn-ok-icon="fa fa-check"
                                        data-btn-cancel-icon="fa fa-times" 
                                        data-target="{{ route('admin::rules::delete', [$r->id]) }}"
                                        class="text-muted delete">
                                        <i class="fa fa-times"></i>
                                    </a>
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
@section('script')

$('.editable').editable({
    mode: 'inline',
    clear: true,
    success: function(response, newValue) {
        if(response.status == 'error') return response.message;
    }
});

@endsection