@extends('layouts.app')
@section('pagetitle', 'Info')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">System info</div>

                <div class="panel-body">

                    <div class="col-md-3">
                        <strong>Git commit:</strong>
                    </div>
                    <div class="col-md-9">
                        {{ $git }}
                    </div>

                    <div class="col-md-3">
                        <strong>Uncommitted changes:</strong>
                    </div>
                    <div class="col-md-9">
                        @if (count($changes) == 0)
                        None, up-to-date.
                        @else
                        <ul class="list-group">
                            @foreach ($changes as $c)
                            <li class="list-group-item">
                                <span class="badge">{{ $c->change }}</span>
                                 <code>{{ $c->item }}</code>
                            </li>
                            @endforeach
                        </ul>
                        @endif
                        
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
