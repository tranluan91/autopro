@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <div class="x_content">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tên</th>
                                    <th>Số lượng</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Số VPS đã được Add</td>
                                    <td>{{ $vps }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>Số lượng website được tạo</td>
                                    <td>{{ $website }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">3</th>
                                    <td>Số lượng account PIN</td>
                                    <td>{{ $users[0]->user }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">4</th>
                                    <td>Số lượng link đã PIN</td>
                                    <td>{{ $users[0]->pin }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
