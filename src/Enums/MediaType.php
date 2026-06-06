<?php

namespace Vishwaraj\WhatsAppCloud\Enums;

enum MediaType: string
{
    case Image    = 'image';
    case Video    = 'video';
    case Audio    = 'audio';
    case Document = 'document';
    case Sticker  = 'sticker';
}
