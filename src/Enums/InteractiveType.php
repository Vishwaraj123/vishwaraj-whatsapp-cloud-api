<?php

namespace Vishwaraj\WhatsAppCloud\Enums;

enum InteractiveType: string
{
    case Button       = 'button';
    case List         = 'list';
    case Product      = 'product';
    case ProductList  = 'product_list';
    case Flow         = 'flow';
    case CtaUrl       = 'cta_url';
    case Catalog      = 'catalog_message';
    case OrderDetails = 'order_details';
    case OrderStatus  = 'order_status';
}
