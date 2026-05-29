<?php

namespace Vishwaraj\WhatsAppCloud\Enums;

enum MessageType: string
{
    case Text        = 'text';
    case Image       = 'image';
    case Video       = 'video';
    case Audio       = 'audio';
    case Document    = 'document';
    case Sticker     = 'sticker';
    case Location    = 'location';
    case Contacts    = 'contacts';
    case Reaction    = 'reaction';
    case Template    = 'template';
    case Interactive = 'interactive';
}
