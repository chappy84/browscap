<?php

declare(strict_types=1);

return [
    'issue-434' => [
        'ua' => 'Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:28.0) Gecko/20100101 Firefox/28.0',
        'properties' => [
            'Comment' => 'Firefox 28.0',
            'Browser' => 'Firefox',
            'Browser_Type' => 'Browser',
            'Browser_Bits' => '32',
            'Browser_Maker' => 'Mozilla Foundation',
            'Browser_Modus' => 'unknown',
            'Version' => '28.0',
            'Platform' => 'Ubuntu',
            'Platform_Version' => 'unknown',
            'Platform_Description' => 'Ubuntu Linux',
            'Platform_Bits' => '32',
            'Platform_Maker' => 'Canonical Foundation',
            'Alpha' => false,
            'Beta' => false,
            'Frames' => true,
            'IFrames' => true,
            'Tables' => true,
            'Cookies' => true,
            'JavaScript' => true,
            'VBScript' => false,
            'JavaApplets' => true,
            'isSyndicationReader' => false,
            'isFake' => false,
            'isAnonymized' => false,
            'isModified' => false,
            'CssVersion' => '3',
            'Device_Name' => 'Linux Desktop',
            'Device_Maker' => 'unknown',
            'Device_Type' => 'Desktop',
            'Device_Pointing_Method' => 'mouse',
            'Device_Code_Name' => 'Linux Desktop',
            'Device_Brand_Name' => 'unknown',
            'RenderingEngine_Name' => 'Gecko',
            'RenderingEngine_Version' => '28.0',
            'RenderingEngine_Maker' => 'Mozilla Foundation',
        ],
        'lite' => false,
        'standard' => false,
        'full' => true,
    ],
    'issue-434 (standard)' => [
        'ua' => 'Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:28.0) Gecko/20100101 Firefox/28.0',
        'properties' => [
            'Comment' => 'Firefox 28.0',
            'Browser' => 'Firefox',
            'Browser_Maker' => 'Mozilla Foundation',
            'Version' => '28.0',
            'Platform' => 'Linux',
            'Device_Type' => 'Desktop',
            'Device_Pointing_Method' => 'mouse',
        ],
        'lite' => false,
        'standard' => true,
        'full' => false,
    ],
    'issue-434 (lite)' => [
        'ua' => 'Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:28.0) Gecko/20100101 Firefox/28.0',
        'properties' => [
            'Comment' => 'Firefox Generic',
            'Browser' => 'Firefox',
            'Version' => '0.0',
            'Platform' => 'Linux',
            'Device_Type' => 'Desktop',
        ],
        'lite' => true,
        'standard' => false,
        'full' => false,
    ],
];
