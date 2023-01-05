<?php

declare(strict_types=1);

return [
    'issue-1009' => [
        'ua' => 'Mozilla/5.0 (Linux; Android 4.4.4; F5281 Build/KTU84Q) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/26.0.1985.135 Safari/537.36',
        'properties' => [
            'Comment' => 'Chrome 26.0',
            'Browser' => 'Chrome',
            'Browser_Type' => 'Browser',
            'Browser_Bits' => '32',
            'Browser_Maker' => 'Google Inc',
            'Browser_Modus' => 'unknown',
            'Version' => '26.0',
            'Platform' => 'Android',
            'Platform_Version' => '4.4',
            'Platform_Description' => 'Android OS',
            'Platform_Bits' => '32',
            'Platform_Maker' => 'Google Inc',
            'Alpha' => false,
            'Beta' => false,
            'Frames' => true,
            'IFrames' => true,
            'Tables' => true,
            'Cookies' => true,
            'JavaScript' => true,
            'VBScript' => false,
            'JavaApplets' => false,
            'isSyndicationReader' => false,
            'isFake' => false,
            'isAnonymized' => false,
            'isModified' => false,
            'CssVersion' => '3',
            'Device_Name' => 'Sero 8 Pro',
            'Device_Maker' => 'Hisense',
            'Device_Type' => 'Tablet',
            'Device_Pointing_Method' => 'touchscreen',
            'Device_Code_Name' => 'F5281',
            'Device_Brand_Name' => 'Hisense',
            'RenderingEngine_Name' => 'WebKit',
            'RenderingEngine_Version' => 'unknown',
            'RenderingEngine_Maker' => 'Apple Inc',
        ],
        'lite' => false,
        'standard' => false,
        'full' => true,
    ],
    'issue-1009 (standard + lite)' => [
        'ua' => 'Mozilla/5.0 (Linux; Android 4.4.4; F5281 Build/KTU84Q) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/26.0.1985.135 Safari/537.36',
        'properties' => [
            'Comment' => 'Chrome Generic',
            'Browser' => 'Chrome',
            'Browser_Maker' => 'Google Inc',
            'Version' => '0.0',
            'Platform' => 'Android',
            'Device_Type' => 'Tablet',
            'Device_Pointing_Method' => 'touchscreen',
        ],
        'lite' => true,
        'standard' => true,
        'full' => false,
    ],
];
