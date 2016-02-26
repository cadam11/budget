<h3>{{ $title }}</h3>
<table class="table table-responsive responsive plain-datatable"
    data-grouping="{{ $grouping or '' }}"
    data-paging="false" 
    data-order='[[ 2, "desc" ], [0, "asc"]]' >
    <thead>
        <tr>
            <th class="col-xs-2 col-sm-2">Category</th>
            <th class="col-xs-1 col-sm-1">Amount</th>
            <th class="col-xs-1 col-sm-1">Type</th>
            <th class="col-xs-1" data-orderable="false"></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($budgets as $b)
        <tr>
            <td>{{ $b->category }}</td>
            <td>
                @if (!isset($showAmount) || $showAmount)
                <a href="#" 
                    class="editable"
                    id="amount" 
                    data-type="text"
                    data-pk="{{ $b->id }}"
                    data-url="{{ route('budgets::update', [$b->id]) }}"
                    data-value= "{{$b->amount}}"
                    data-title="Enter amount">

                    {{ money_format("$%n", $b->amount) }}
                </a>
                @endif
            </td>
            <td>
                @if (!isset($showType) || $showType)
                <a href="#"
                    class="editable-variable"
                    id="variable" 
                    data-type="select"
                    data-pk="{{ $b->id }}"
                    data-url="{{ route('budgets::update', [$b->id]) }}"
                    data-value= "{{$b->variable}}">
                @endif
            </td>
            <td class="text-right">
                <a 
                    href="#" 
                    data-toggle="confirmation"
                    data-target="{{ route('budgets::delete', [$b->id]) }}"
                    class="text-muted delete">
                    <i class="fa fa-times"></i>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
    @if (!isset($showFooter) || $showFooter)
    <tfoot>
        <th>Total Budgeted</th>
        <th>{{money_format("$%n", $budgets->sum('amount'))}}</th>
        <th></th>
        <th></th>
    </tfoot>
    @endif
</table>