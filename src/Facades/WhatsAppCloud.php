<?php

namespace Vishwaraj\WhatsAppCloud\Facades;

use Illuminate\Support\Facades\Facade;
use Vishwaraj\WhatsAppCloud\WhatsAppCloudManager;

/**
 * @method static \Vishwaraj\WhatsAppCloud\Builders\Messages\TextMessageBuilder      text()
 * @method static \Vishwaraj\WhatsAppCloud\Builders\Messages\ImageMessageBuilder     image()
 * @method static \Vishwaraj\WhatsAppCloud\Builders\Messages\VideoMessageBuilder     video()
 * @method static \Vishwaraj\WhatsAppCloud\Builders\Messages\AudioMessageBuilder     audio()
 * @method static \Vishwaraj\WhatsAppCloud\Builders\Messages\DocumentMessageBuilder  document()
 * @method static \Vishwaraj\WhatsAppCloud\Builders\Messages\StickerMessageBuilder   sticker()
 * @method static \Vishwaraj\WhatsAppCloud\Builders\Messages\LocationMessageBuilder  location()
 * @method static \Vishwaraj\WhatsAppCloud\Builders\Messages\ContactMessageBuilder   contact()
 * @method static \Vishwaraj\WhatsAppCloud\Builders\Messages\ReactionMessageBuilder  reaction()
 * @method static \Vishwaraj\WhatsAppCloud\Builders\Interactive\InteractiveBuilder   interactive()
 * @method static \Vishwaraj\WhatsAppCloud\Builders\Templates\TemplateSendBuilder    template()
 * @method static \Vishwaraj\WhatsAppCloud\Services\TemplateManagementService        templates()
 * @method static \Vishwaraj\WhatsAppCloud\Services\MediaService                     media()
 * @method static bool                                                                markRead(string $messageId)
 * @method static bool                                                                sendTypingIndicator(string $messageId)
 * @method static \Vishwaraj\WhatsAppCloud\WhatsAppCloudManager                      usingPhoneNumber(string $phoneNumberId)
 * @method static \Vishwaraj\WhatsAppCloud\WhatsAppCloudManager                      usingToken(string $token)
 * @method static \Vishwaraj\WhatsAppCloud\WhatsAppCloudManager                      usingVersion(string $version)
 *
 * @see \Vishwaraj\WhatsAppCloud\WhatsAppCloudManager
 */
class WhatsAppCloud extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return WhatsAppCloudManager::class;
    }
}
