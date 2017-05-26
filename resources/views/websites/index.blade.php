@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="panel panel-default">
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
                                                'class' => 'btn btn-warning',
                                            ]) !!}
                                        {!! Form::close() !!}
                                    </td>
                                    <td>
                                        {!! Form::open(['action' => ['WebsitesController@continuedeploy'], 'method' => 'POST']) !!}
                                            {!! Form::hidden('id', $website->id) !!}
                                            {!! Form::button('Thêm tiếp data', [
                                                'type' => 'submit',
                                                'onclick' => "return confirm('" . trans('setting.continuedeploy') . "');",
                                                'class' => 'btn btn-primary',
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
