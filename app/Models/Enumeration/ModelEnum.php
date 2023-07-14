<?php

namespace App\Models\Enumeration;

class ModelEnum
{
    const MODEL_PROP = [
        'requestapplication' => [
            'name' => ModelEnum::ARRAY_MODEL[0],
            'table' => ModelEnum::ARRAY_MODEL_TABLE[0],
            'prefix' => '',
            'length' => 6
        ],
        'internaladmin' => [
            'name' => ModelEnum::ARRAY_MODEL[1],
            'table' => ModelEnum::ARRAY_MODEL_TABLE[1],
            'prefix' => 'IN',
            'length' => 3
        ],
        'externaladmin' => [
            'name' => ModelEnum::ARRAY_MODEL[2],
            'table' => ModelEnum::ARRAY_MODEL_TABLE[2],
            'prefix' => 'EX',
            'length' => 8
        ],
    ];

    const ARRAY_MODEL_TABLE = [
        'request_applications',
        'internal_admins',
        'external_admins',
    ];
    const ARRAY_MODEL = [
        'RequestApplication',
        'InternalAdmin',
        'ExternalAdmin',
    ];
    const REQUESTAPPLICATION = ModelEnum::ARRAY_MODEL[0];
    const INTERNALADMIN = ModelEnum::ARRAY_MODEL[1];
    const EXTERNALADMIN = ModelEnum::ARRAY_MODEL[2];
}
