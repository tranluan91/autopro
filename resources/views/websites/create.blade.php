@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="panel panel-default">
                @include('layouts.notice')
                <div class="panel-heading">@lang('setting.create_website')</div>

                <div class="panel-body">
                    {!! Form::open(['url' => 'websites/store', 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'create-web']) !!}
                    <div class="form-group">
                        {!! Form::label('website', __('setting.list'), ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            {!! Form::select('website_id', $websites, null, ['class' => 'form-control col-md-7 col-xs-12']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('domain', __('setting.domain'), ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            {!! Form::text('domain', null, ['class' => 'form-control col-md-7 col-xs-12', 'placeholder' => 'google.com']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-sm-3 col-xs-12 control-label">Giao thức
                        <br>
                        <small class="text-navy">http/https</small>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <div class="radio">
                                <label>
                                <input type="radio" checked="" value="http://" id="optionsRadios1" name="protocol"> http
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                <input type="radio" value="https://" id="optionsRadios2" name="protocol"> https
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('vps', __('setting.vps_select'), ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            {!! Form::select('vps_id', $vpsList, null, ['class' => 'form-control col-md-7 col-xs-12']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            {!! Form::submit(__('setting.add_website'), ['class' => 'btn btn-success add-website']) !!}
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
