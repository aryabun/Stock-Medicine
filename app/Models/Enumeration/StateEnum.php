<?php

namespace App\Models\Enumeration;

class StateEnum{
    const TRANSFER_STATUS = [
        'Draft',
        'Submit',
        'Approved',
        'Transit',
        'Done',
        'Rejected',
        'Canceled'
    ];
    public const TRANSFER_DRAFT = StateEnum::TRANSFER_STATUS[0];
    public const TRANSFER_SUBMIT = StateEnum::TRANSFER_STATUS[1];
    public const TRANSFER_APPROVED = StateEnum::TRANSFER_STATUS[2];
    public const TRANSFER_TRANSIT = StateEnum::TRANSFER_STATUS[3];
    public const TRANSFER_DONE = StateEnum::TRANSFER_STATUS[4];
    public const TRANSFER_REJECTED = StateEnum::TRANSFER_STATUS[5];
    public const TRANSFER_CANCELED = StateEnum::TRANSFER_STATUS[6];
}