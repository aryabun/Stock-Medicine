<?php

namespace App\Models\Enumeration;

class SettingEnum
{
    public const TYPE_EXTERNAL_ADMIN = 'external_admin';
    public const TYPE_INTERNAL_ADMIN = 'internal_admin';
    const GUARDS = [SettingEnum::TYPE_INTERNAL_ADMIN, SettingEnum::TYPE_EXTERNAL_ADMIN];
    const NUMBER_EN_KH = [
        1 => '១',
        2 => '២',
        3 => '៣',
        4 => '៤',
        5 => '៥',
        6 => '៦',
        7 => '៧',
        8 => '៨',
        9 => '៩',
        0 => '០',
    ];
    const MONITORING_STATUS = [
        'Pendding',
        'In-Progress',
        'Completed',
        'Overdue'
    ];

    const REPORT_STATUS = [
        'Draft',
        'Validated',
        'Evaluated'
    ];

    const PENDDING = SettingEnum::MONITORING_STATUS[0];
    const INPROGRESS = SettingEnum::MONITORING_STATUS[1];
    const COMPLETED = SettingEnum::MONITORING_STATUS[2];
    const OVERDUE = SettingEnum::MONITORING_STATUS[3];


    public const REPORT_DRAFT = SettingEnum::REPORT_STATUS[0];
    public const REPORT_EVALUATED = SettingEnum::REPORT_STATUS[1];
    public const REPORT_VALIDATED = SettingEnum::REPORT_STATUS[2];

    const QUARTER = [
        [
            'name_en' => 'Quarter 1',
            'name_km' => 'ត្រីមាសទី១',
            'value' => 1,
            'month' => 3
        ],
        [
            'name_en' => 'Quarter 2',
            'name_km' => 'ត្រីមាសទី២',
            'value' => 2,
            'month' => 3
        ],
        [
            'name_en' => 'Quarter 3',
            'name_km' => 'ត្រីមាសទី៣',
            'value' => 3,
            'month' => 3
        ],
        [
            'name_en' => 'Quarter 1',
            'name_km' => 'ត្រីមាសទី៤',
            'value' => 4,
            'month' => 3
        ]
    ];

}
