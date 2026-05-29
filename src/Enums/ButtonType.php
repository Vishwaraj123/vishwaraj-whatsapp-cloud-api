<?php

namespace Vishwaraj\WhatsAppCloud\Enums;

enum ButtonType: string
{
    case QuickReply  = 'QUICK_REPLY';
    case Url         = 'URL';
    case PhoneNumber = 'PHONE_NUMBER';
    case Otp         = 'OTP';
    case Flow        = 'FLOW';
    case Catalog     = 'CATALOG';
    case Mpm         = 'MPM';
    case Reply       = 'reply';
}
