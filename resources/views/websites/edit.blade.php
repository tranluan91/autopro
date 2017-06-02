@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="panel panel-default">
                @include('layouts.notice')
                <div class="panel-heading">@lang('setting.create_website')</div>

                <div class="panel-body form-horizontal">
                    <div class="form-group">
                        {!! Form::hidden('id', $website->id, ['id' => 'website_id']) !!}
                        {!! Form::label('domain', __('setting.domain'), ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            {!! Form::text('domain', $website->domain, ['class' => 'form-control col-md-7 col-xs-12', 'placeholder' => 'google.com', 'id' => 'website-domain']) !!}
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
                                <input type="radio" {{ ($website->protocol == 'http://') ? "checked=" : ""  }} value="http://" name="protocol"> http
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                <input type="radio" {{ ($website->protocol == 'https://') ? "checked=" : "" }} value="https://" name="protocol"> https
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('vps', __('setting.vps_select'), ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            {!! Form::select('vps_id', $vpsList, $website->vps_id, ['class' => 'form-control col-md-7 col-xs-12', 'id' => 'website-vps_id']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            {!! Form::button(__('setting.add_website'), ['class' => 'btn btn-success edit-website']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
