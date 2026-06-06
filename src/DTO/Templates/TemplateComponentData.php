<?php

namespace Vishwaraj\WhatsAppCloud\DTO\Templates;

use Vishwaraj\WhatsAppCloud\Enums\ComponentType;

final class TemplateComponentData
{
    public function __construct(
        public readonly ComponentType $type,
        public readonly array         $parameters = [],
        public readonly ?string       $subType = null,
        public readonly ?int          $index = null,
    ) {}
}
