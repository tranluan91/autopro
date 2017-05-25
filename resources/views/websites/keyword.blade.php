@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="panel panel-default">
                @include('layouts.notice')
                <div class="panel-heading">@lang('setting.add_data')</div>

                <div class="panel-body">
                    {!! Form::open(['url' => 'websites/keyword', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
                    {!! Form::hidden('domain', $website->domain) !!}
                    <div class="form-group">
                        {!! Form::label('keyword', __('setting.keyword'), ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            {!! Form::text('keyword', null, ['class' => 'form-control col-md-7 col-xs-12']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            {!! Form::submit(__('setting.add_data'), ['class' => 'btn btn-success']) !!}
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
