<?php

namespace Vishwaraj\WhatsAppCloud\Enums;

enum OtpType: string
{
    case CopyCode = 'COPY_CODE';
    case OneTap   = 'ONE_TAP';
    case ZeroTap  = 'ZERO_TAP';
}
