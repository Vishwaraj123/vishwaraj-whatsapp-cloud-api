<?php

namespace Vishwaraj\WhatsAppCloud\Enums;

enum HeaderFormat: string
{
    case Text     = 'TEXT';
    case Image    = 'IMAGE';
    case Video    = 'VIDEO';
    case Document = 'DOCUMENT';
    case Location = 'LOCATION';
}
