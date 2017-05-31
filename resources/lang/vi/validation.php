<?php

return [
    'custom' => [
        'domain' => [
            'required' => 'Vui lòng nhập domain',
            'unique' => 'Domain vừa nhập đã tồn tại',
        ],
        'vps_id' => [
            'required' => 'Vui lòng chọn VPS',
            'exists' => 'VPS không tồn tại',
        ],
    ],
];
