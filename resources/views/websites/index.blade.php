@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="panel panel-default">
                @include('layouts.notice')
                <div class="panel-heading">Quản lý websites</div>

                <div class="panel-body">
                    <div class="x_content">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Domain</th>
                                    <th>VPS</th>
                                    <th>Keyword Data</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($websites as $website)
                                <tr>
                                    <th scope="row">{{ $website->id }}</th>
                                    <td>{{ $website->domain }}</td>
                                    <td>{{ $website->vps->ip }}</td>
                                    <td>{{ $website->keyword }}</td>
                                    <td>
                                        {!! Form::open(['action' => ['WebsitesController@redeploy'], 'method' => 'POST']) !!}
                                            {!! Form::hidden('id', $website->id) !!}
                                            {!! Form::button('Deploy lại', [
                                                'type' => 'submit',
                                                'onclick' => "return confirm('" . trans('setting.redeploy') . "');",
                                                'class' => 'btn btn-xs btn-warning',
                                            ]) !!}
                                        {!! Form::close() !!}
                                    </td>
                                    <td>
                                        <div class="form-horizontal">
                                            <div class="form-group">
                                                {!! Form::label('keyword', __('setting.keyword'), ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!}
                                                <div class="col-md-9 col-sm-9 col-xs-12">
                                                    {!! Form::text('keyword', null, ['class' => 'form-control col-md-7 col-xs-12 data-keyword']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                    {!! Form::button(__('setting.add_data'), ['class' => 'btn btn-xs btn-success add-keyword', 'data-website_id' => $website->id]) !!}
                                                    {!! Form::button(__('setting.daily_deploy', ['daily_deploy' => $website->daily_deploy]), ['class' => 'btn btn-xs btn-danger']) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        {!! Form::open(['action' => ['WebsitesController@undeploy'], 'method' => 'POST']) !!}
                                            {!! Form::hidden('id', $website->id) !!}
                                            {!! Form::button('Undeploy', [
                                                'type' => 'submit',
                                                'onclick' => "return confirm('" . trans('setting.undeploy') . "');",
                                                'class' => 'btn btn-xs btn-primary',
                                            ]) !!}
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                {{ $websites->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
