<?php

return [

    'default_models' => [
        'default_model' => env('DEFAULT_MODEL', 'alias-fast'),
        'default_web_search_model' => env('DEFAULT_WEBSEARCH_MODEL', 'alias-fast'),
        'default_file_upload_model' => env('DEFAULT_FILEUPLOAD_MODEL', 'alias-huge'),
        'default_vision_model' => env('DEFAULT_VISION_MODEL', 'alias-huge'),
    ],

    'default_models_ext_app' => [
    ],

    'system_models' => [
        'title_generator' => env('TITLE_GENERATOR_MODEL', 'alias-fast'),
        'prompt_improver' => env('PROMPT_IMPROVEMENT_MODEL', 'alias-fast'),
        'summarizer' => env('SUMMARIZER_MODEL', 'alias-fast'),
    ],

    'system_models_ext_app' => [
    ],

    'providers' => [
        'blablador' => [
            'active' => env('BLABLADOR_ACTIVE', true),
            'adapter_key' => 'blablador',
            'api_key' => null,
            'api_url' => env('BLABLADOR_API_URL'),
            'ping_url' => env('BLABLADOR_PING_URL'),
            'models' => require __DIR__ . '/model_lists/blablador_models.php',
        ],
    ],
];