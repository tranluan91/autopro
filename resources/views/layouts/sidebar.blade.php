<ul class="nav side-menu">
    <li>
        <a href="/home"><i class="fa fa-home"></i> @lang('setting.homepage')</a>
    </li>
    <li>
        <a href="{{ action('SunAccountsController@index') }}"><i class="fa fa-star"></i> @lang('setting.sun_index')</a>
    </li>
    <li>
        <a href="/vps/create"><i class="fa fa-bar-chart-o"></i> @lang('setting.create_vps')</a>
    </li>
    <li>
        <a href="/websites/index"><i class="fa fa-cube"></i> Websites đã thêm</a>
    </li>
    <li>
        <a href="/websites/create"><i class="fa fa-cube"></i> @lang('setting.create_website')</a>
    </li>
    <li>
        <a href="/pin"><i class="fa fa-cube"></i> Quản lý tài khoản PIN</a>
    </li>
    <li>
        <a href="/websites/delete"><i class="fa fa-minus-circle"></i> Xóa Websites đã thêm</a>
    </li>
</ul>
