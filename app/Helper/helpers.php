<?php

function bankLogoUrl($bankName)
{
    $bankName = strtolower($bankName);

    $logos = [
        'bca' => 'https://images.seeklogo.com/logo-png/23/1/bca-bank-logo-png_seeklogo-232742.png',
        'mandiri' => 'https://upload.wikimedia.org/wikipedia/commons/9/99/Mandiri_logo.svg',
        'bni' => 'https://upload.wikimedia.org/wikipedia/commons/3/32/BNI_logo.svg',
        'bri' => 'https://upload.wikimedia.org/wikipedia/commons/5/55/Logo_BRI.svg',
        'gopay' => 'https://images.seeklogo.com/logo-png/36/1/gopay-logo-png_seeklogo-369813.png',
        'ovo' => 'https://upload.wikimedia.org/wikipedia/commons/f/f2/Logo_OVO.svg',
        'dana' => 'https://upload.wikimedia.org/wikipedia/commons/3/37/Dana-logo.svg',
        'linkaja' => 'https://seeklogo.com/images/L/linkaja-logo-EC06F8E1AC-seeklogo.com.png',
        'shopeepay' => 'https://seeklogo.com/images/S/shopee-pay-logo-4F60A126C4-seeklogo.com.png',
        'jenius' => 'https://seeklogo.com/images/J/jenius-logo-08F1F64A46-seeklogo.com.png',
        'permata' => 'https://seeklogo.com/images/P/permata-bank-logo-DA33CCF48B-seeklogo.com.png',
        'cimb' => 'https://seeklogo.com/images/C/cimb-bank-logo-18204DA36D-seeklogo.com.png',
        'danamon' => 'https://seeklogo.com/images/D/danamon-logo-232AF9D76B-seeklogo.com.png',
        'bsi' => 'https://seeklogo.com/images/B/bsi-logo-F2D9F8B2A4-seeklogo.com.png',
        // dst, tinggal tambah sesuai merchant
    ];

    $default = 'https://upload.wikimedia.org/wikipedia/commons/1/14/No_image_available_600_x_600.svg';

    return $logos[$bankName] ?? $default;
}
