<?php

namespace Vishwaraj\WhatsAppCloud\Enums;

enum TemplateStatus: string
{
    case Approved  = 'APPROVED';
    case Pending   = 'PENDING';
    case Rejected  = 'REJECTED';
    case Disabled  = 'DISABLED';
    case Paused    = 'PAUSED';
}
