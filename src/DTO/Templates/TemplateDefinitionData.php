<?php

namespace Vishwaraj\WhatsAppCloud\DTO\Templates;

use Vishwaraj\WhatsAppCloud\Enums\TemplateCategory;

final class TemplateDefinitionData
{
    public function __construct(
        public readonly string           $name,
        public readonly string           $language,
        public readonly TemplateCategory $category,
        public readonly array            $components,
        public readonly bool             $allowCategoryChange = false,
    ) {}
}
