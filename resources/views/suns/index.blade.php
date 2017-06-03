@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="panel panel-default">
                @include('layouts.notice')
                <div class="panel-heading">Quản lý Sun Accounts
                    @if (Auth::user()->isAdmin())
                    <a href="{{ action('SunAccountsController@create') }}"> <button class="btn btn-xs btn-primary">@lang('setting.add_sun')</button></a>
                    @endif
                </div>

                <div class="panel-body">
                    <div class="x_content">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Sun ID</th>
                                    @if (Auth::user()->isAdmin())
                                    <th>Username</th>
                                    <th>Password</th>
                                    @endif
                                    <th>Số lượng website đã thêm với Sun ID</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sunAccounts as $sunAccount)
                                <tr>
                                    <th scope="row">{{ $sunAccount->id }}</th>
                                    <td>{{ $sunAccount->sun_id }}</td>
                                    @if (Auth::user()->isAdmin())
                                    <td>{{ $sunAccount->username }}</td>
                                    <td>{{ $sunAccount->password }}</td>
                                    @endif
                                    <td>{{ $sunAccount->websites->count() }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                {{ $sunAccounts->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
