@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="panel panel-default">
                @include('layouts.notice')
                <div class="panel-heading">Quản lý VPS
                    <a href="{{ action('VpsController@create') }}"> <button class="btn btn-xs btn-primary">@lang('setting.create_vps')</button></a>
                </div>

                <div class="panel-body">
                    <div class="x_content">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>IP</th>
                                    <th>Username</th>
                                    <th>Password</th>
                                    <th>Port</th>
                                    <th>Số lượng website đã thêm</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($vpsList as $vps)
                                <tr>
                                    <th scope="row">{{ $vps->id }}</th>
                                    <td>{{ $vps->ip }}</td>
                                    <td>{{ $vps->username }}</td>
                                    <td>{{ $vps->password }}</td>
                                    <td>{{ $vps->port }}</td>
                                    <td>{{ $vps->websites->count() }}</td>
                                    <td>
                                        <a href="{{ action('VpsController@edit', $vps->id) }}"><button class="btn btn-xs btn-success">Edit</button></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                {{ $vpsList->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
