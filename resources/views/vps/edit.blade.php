@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="panel panel-default">
                @include('layouts.notice')
                <div class="panel-heading">@lang('setting.edit_vps')</div>

                <div class="panel-body">
                    {!! Form::model($vps, ['action' => ['VpsController@update', $vps->id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
                    {!! Form::hidden('id', $vps->id) !!}
                    <div class="form-group">
                        {!! Form::label('ip', __('setting.ip'), ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            {!! Form::text('ip', null, ['class' => 'form-control col-md-7 col-xs-12']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('username', __('setting.username'), ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            {!! Form::text('username', null, ['class' => 'form-control col-md-7 col-xs-12']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('password', __('setting.password'), ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            {!! Form::password('password', ['class' => 'form-control col-md-7 col-xs-12']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('port', __('setting.port'), ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            {!! Form::text('port', null, ['class' => 'form-control col-md-7 col-xs-12']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('port', __('setting.website_deployed'), ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            @foreach ($vps->websites as $website)
                            {!! Form::text('website', $website->domain, ['class' => 'form-control col-md-7 col-xs-12', 'disabled' => 'disabled']) !!}
                            @endforeach
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            {!! Form::submit(__('setting.edit_vps'), ['class' => 'btn btn-success']) !!}
                            {!! Form::close() !!}
                            {!! Form::open(['action' => ['VpsController@destroy', $vps->id], 'method' => 'DELETE']) !!}
                                {!! Form::hidden('id', $vps->id) !!}
                                {!! Form::button(trans('setting.delete_vps'), [
                                    'type' => 'submit',
                                    'onclick' => "return confirm('" . trans('setting.delete_vps_confirm') . "');",
                                    'class' => 'btn btn-danger',
                                ]) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
