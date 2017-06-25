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
                                    <th>Xóa website</th>
                                    <th>Xóa sản phẩm không có ảnh</th>
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
                                        {!! Form::open(['action' => ['WebsitesController@destroy', $website->id], 'method' => 'DELETE']) !!}
                                            {!! Form::hidden('id', $website->id) !!}
                                            {!! Form::button('Delete', [
                                                'type' => 'submit',
                                                'onclick' => "return confirm('" . trans('setting.delete') . "');",
                                                'class' => 'btn btn-xs btn-danger',
                                            ]) !!}
                                        {!! Form::close() !!}
                                    </td>
                                    <td>
                                        {!! Form::button('Xóa sản phẩm', ['class' => 'btn btn-xs btn-warning delete-product', 'data-website_id' => $website->id]) !!}
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
