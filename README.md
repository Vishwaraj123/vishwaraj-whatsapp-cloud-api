# WhatsApp Cloud API — Laravel Package

[![Tests](https://github.com/Vishwaraj123/vishwaraj-whatsapp-cloud-api/actions/workflows/tests.yml/badge.svg?branch=main)](https://github.com/Vishwaraj123/vishwaraj-whatsapp-cloud-api/actions/workflows/tests.yml)
[![Latest Version](https://img.shields.io/packagist/v/vishwaraj/whatsapp-cloud-api.svg?label=packagist&cacheSeconds=300)](https://packagist.org/packages/vishwaraj/whatsapp-cloud-api)
[![Total Downloads](https://img.shields.io/packagist/dt/vishwaraj/whatsapp-cloud-api.svg?cacheSeconds=300)](https://packagist.org/packages/vishwaraj/whatsapp-cloud-api)
[![PHP](https://img.shields.io/badge/PHP-8.2%2B-blue?logo=php)](https://www.php.net)
[![Laravel](https://img.shields.io/badge/Laravel-10%2C%2011%2C%2012-red?logo=laravel)](https://laravel.com)
[![License](https://img.shields.io/packagist/l/vishwaraj/whatsapp-cloud-api)](LICENSE)
[![Stars](https://img.shields.io/github/stars/Vishwaraj123/vishwaraj-whatsapp-cloud-api?style=social)](https://github.com/Vishwaraj123/vishwaraj-whatsapp-cloud-api/stargazers)

A Laravel-native WhatsApp Cloud API package with fluent message builders, full template management, media handling, and every interactive message type supported by the Meta Cloud API.

---

## Requirements

| Dependency | Version   |
|------------|-----------|
| PHP        | ^8.2      |
| Laravel    | 10, 11, 12|

---

## Installation

```bash
composer require vishwaraj/whatsapp-cloud-api
```

Publish config:

```bash
php artisan vendor:publish --tag=whatsapp-cloud-api-config
```

---

## Environment

```env
WHATSAPP_ACCESS_TOKEN=your_access_token
WHATSAPP_PHONE_NUMBER_ID=your_phone_number_id
WHATSAPP_WABA_ID=your_waba_id
WHATSAPP_BUSINESS_ID=your_business_id
WHATSAPP_API_VERSION=v22.0
```

---

## Usage

### Text Message

```php
use Vishwaraj\WhatsAppCloud\Facades\WhatsAppCloud;

$response = WhatsAppCloud::text()
    ->to('919999999999')
    ->body('Hello from WhatsApp Cloud API!')
    ->send();

echo $response->messageId(); // wamid.xxx
```

### Reply to a Message

```php
WhatsAppCloud::text()
    ->to('919999999999')
    ->body('This is a reply')
    ->replyTo('wamid.previous_message_id')
    ->send();
```

### Text with URL Preview

```php
WhatsAppCloud::text()
    ->to('919999999999')
    ->body('Visit https://example.com')
    ->previewUrl()
    ->send();
```

---

### Image

```php
// From URL
WhatsAppCloud::image()
    ->to('919999999999')
    ->fromUrl('https://example.com/photo.jpg')
    ->caption('A beautiful photo')
    ->send();

// From uploaded media ID
WhatsAppCloud::image()
    ->to('919999999999')
    ->fromMediaId('media-object-id')
    ->send();

// Auto-upload from local path
WhatsAppCloud::image()
    ->to('919999999999')
    ->fromPath('/path/to/image.jpg')
    ->caption('Uploaded photo')
    ->send();
```

### Video

```php
WhatsAppCloud::video()
    ->to('919999999999')
    ->fromUrl('https://example.com/video.mp4')
    ->caption('Watch this')
    ->send();
```

### Audio

```php
WhatsAppCloud::audio()
    ->to('919999999999')
    ->fromUrl('https://example.com/audio.ogg')
    ->send();
```

### Document

```php
WhatsAppCloud::document()
    ->to('919999999999')
    ->fromUrl('https://example.com/invoice.pdf')
    ->filename('invoice.pdf')
    ->caption('Your invoice')
    ->send();
```

### Sticker

```php
WhatsAppCloud::sticker()
    ->to('919999999999')
    ->fromUrl('https://example.com/sticker.webp')
    ->send();
```

### Location

```php
WhatsAppCloud::location()
    ->to('919999999999')
    ->latitude(18.5204)
    ->longitude(73.8567)
    ->name('Pune Office')
    ->address('123 MG Road, Pune')
    ->send();
```

### Contact

```php
use Vishwaraj\WhatsAppCloud\DTO\Messages\ContactData;

WhatsAppCloud::contact()
    ->to('919999999999')
    ->addContact(new ContactData(
        formattedName: 'John Smith',
        firstName:     'John',
        lastName:      'Smith',
        phones:        [['phone' => '+1 650 555 1234', 'type' => 'WORK']],
        emails:        [['email' => 'john@example.com', 'type' => 'WORK']],
    ))
    ->send();
```

### Reaction

```php
// Add reaction
WhatsAppCloud::reaction()
    ->to('919999999999')
    ->messageId('wamid.xxx')
    ->emoji('👍')
    ->send();

// Remove reaction
WhatsAppCloud::reaction()
    ->to('919999999999')
    ->messageId('wamid.xxx')
    ->remove()
    ->send();
```

---

## Interactive Messages

### Reply Buttons

```php
WhatsAppCloud::interactive()
    ->replyButtons()
    ->to('919999999999')
    ->body('Choose an option:')
    ->footer('Powered by WhatsApp')
    ->addButton('btn_yes', 'Yes')
    ->addButton('btn_no', 'No')
    ->addButton('btn_later', 'Later')
    ->send();
```

### List Message

```php
WhatsAppCloud::interactive()
    ->list()
    ->to('919999999999')
    ->headerText('Select a product')
    ->body('Browse our catalog')
    ->footer('Tap to select')
    ->buttonLabel('View Options')
    ->section('Fruits', [
        ['id' => 'apple',  'title' => 'Apple',  'description' => 'Fresh red apple'],
        ['id' => 'mango',  'title' => 'Mango',  'description' => 'Alphonso mango'],
    ])
    ->section('Vegetables', [
        ['id' => 'carrot', 'title' => 'Carrot', 'description' => 'Fresh carrots'],
    ])
    ->send();
```

### Single Product

```php
WhatsAppCloud::interactive()
    ->product()
    ->to('919999999999')
    ->body('Check out this product')
    ->catalogId('your-catalog-id')
    ->productId('product-sku-123')
    ->send();
```

### Multi-Product

```php
WhatsAppCloud::interactive()
    ->productList()
    ->to('919999999999')
    ->headerText('Our Top Picks')
    ->body('Browse and order directly')
    ->catalogId('your-catalog-id')
    ->section('Electronics', ['sku-laptop', 'sku-phone', 'sku-tablet'])
    ->section('Accessories', ['sku-case', 'sku-charger'])
    ->send();
```

### Flow Message

```php
// Published flow
WhatsAppCloud::interactive()
    ->flow()
    ->to('919999999999')
    ->body('Complete your registration')
    ->footer('Tap to open')
    ->flowId('550000000000001')
    ->flowToken('unique-token-per-user')
    ->cta('Register Now')
    ->screen('WELCOME_SCREEN')
    ->screenData(['prefill_name' => 'John'])
    ->send();

// Draft flow (for testing)
WhatsAppCloud::interactive()
    ->flow()
    ->to('919999999999')
    ->flowId('550000000000001')
    ->flowToken('test-token')
    ->draft()
    ->send();
```

### CTA URL Button

```php
WhatsAppCloud::interactive()
    ->ctaUrl()
    ->to('919999999999')
    ->body('Visit our website')
    ->displayText('Open Website')
    ->url('https://example.com')
    ->send();
```

### Catalog Message

```php
WhatsAppCloud::interactive()
    ->catalog()
    ->to('919999999999')
    ->body('Browse our catalog')
    ->footer('Best deals on WhatsApp!')
    ->thumbnail('product-sku-123')
    ->send();
```

### Order Details (Payments)

```php
WhatsAppCloud::interactive()
    ->orderDetails()
    ->to('919999999999')
    ->body('Your order summary')
    ->referenceId('ORD-2024-001')
    ->paymentType('upi')
    ->paymentConfig('my-payment-config')
    ->currency('INR')
    ->addItem('SKU-BREAD', 'Sourdough Bread', 1000, 2, 900)
    ->total(1800)
    ->send();
```

### Order Status

```php
WhatsAppCloud::interactive()
    ->orderStatus()
    ->to('919999999999')
    ->body('Order update')
    ->referenceId('ORD-2024-001')
    ->status('processing')
    ->description('Your order is being prepared')
    ->send();
```

---

## Templates

### Send Template

```php
// Basic template
WhatsAppCloud::template()
    ->to('919999999999')
    ->name('hello_world')
    ->language('en_US')
    ->send();

// Template with body variables
WhatsAppCloud::template()
    ->to('919999999999')
    ->name('summer_sale')
    ->language('en_US')
    ->body(['John', 'SAVE25', '25%'])
    ->send();

// Template with image header
WhatsAppCloud::template()
    ->to('919999999999')
    ->name('promo_banner')
    ->language('en_US')
    ->headerImageUrl('https://example.com/banner.jpg')
    ->body(['Mark', 'Tuscan Getaway', '800'])
    ->quickReplyButton(0, 'STOP_PROMOTIONS')
    ->send();

// Template with URL button
WhatsAppCloud::template()
    ->to('919999999999')
    ->name('order_confirmation')
    ->language('en_US')
    ->body(['Mark', '#123456'])
    ->urlButton(0, 'order/123456')
    ->send();

// Catalog template
WhatsAppCloud::template()
    ->to('919999999999')
    ->name('intro_catalog_offer')
    ->language('en_US')
    ->body(['100', '400', '3'])
    ->catalogButton(0, 'product-sku-123')
    ->send();

// Flow template
WhatsAppCloud::template()
    ->to('919999999999')
    ->name('appointment_booking')
    ->language('en_US')
    ->body(['John'])
    ->flowButton(0, 'unique-flow-token', ['prefill_name' => 'John'])
    ->send();
```

### Manage Templates

```php
use Vishwaraj\WhatsAppCloud\DTO\Templates\TemplateDefinitionData;
use Vishwaraj\WhatsAppCloud\Enums\TemplateCategory;

// Create template
$template = new TemplateDefinitionData(
    name:     'summer_promo_2024',
    language: 'en_US',
    category: TemplateCategory::Marketing,
    components: [
        [
            'type'   => 'HEADER',
            'format' => 'TEXT',
            'text'   => 'Summer Sale 🌞',
        ],
        [
            'type' => 'BODY',
            'text' => 'Hi {{1}}, use code {{2}} for {{3}} off!',
            'example' => ['body_text' => [['John', 'SAVE25', '25%']]],
        ],
        [
            'type' => 'FOOTER',
            'text' => 'Tap Stop to unsubscribe',
        ],
        [
            'type'    => 'BUTTONS',
            'buttons' => [
                ['type' => 'QUICK_REPLY', 'text' => 'Stop promotions'],
            ],
        ],
    ],
);

$response = WhatsAppCloud::templates()->create($template);
echo $response->id;     // template id
echo $response->status; // PENDING or APPROVED

// List all templates
$templates = WhatsAppCloud::templates()->list();

// Find by name
$results = WhatsAppCloud::templates()->find('summer_promo_2024');

// Delete by name
WhatsAppCloud::templates()->delete('summer_promo_2024');
```

---

## Media

```php
// Upload
$upload = WhatsAppCloud::media()->upload('/path/to/image.jpg');
echo $upload->id; // use this as media ID

// Get media info
$info = WhatsAppCloud::media()->get('media-id-123');
echo $info->url;      // temporary download URL (valid 5 min)
echo $info->mimeType;

// Download to file
WhatsAppCloud::media()->download('media-id-123', '/local/save/path.jpg');

// Download as string
$bytes = WhatsAppCloud::media()->download('media-id-123');

// Get download URL only
$url = WhatsAppCloud::media()->downloadUrl('media-id-123');

// Delete
WhatsAppCloud::media()->delete('media-id-123');
```

---

## Mark Message as Read

```php
WhatsAppCloud::markRead('wamid.incoming_message_id');
```

## Typing Indicator

```php
WhatsAppCloud::sendTypingIndicator('wamid.incoming_message_id');
```

---

## Multi-WABA / Per-Request Overrides

```php
// Use a different phone number for this request
WhatsAppCloud::usingPhoneNumber('987654321')
    ->text()
    ->to('919999999999')
    ->body('From a different number')
    ->send();

// Use a different token
WhatsAppCloud::usingToken('another-access-token')
    ->text()
    ->to('919999999999')
    ->body('With different token')
    ->send();

// Use a different API version
WhatsAppCloud::usingVersion('v24.0')
    ->text()
    ->to('919999999999')
    ->body('Using v24')
    ->send();
```

---

## Exception Handling

```php
use Vishwaraj\WhatsAppCloud\Exceptions\WhatsAppApiException;
use Vishwaraj\WhatsAppCloud\Exceptions\AuthenticationException;
use Vishwaraj\WhatsAppCloud\Exceptions\RateLimitException;

try {
    WhatsAppCloud::text()->to('919999999999')->body('Hello')->send();
} catch (AuthenticationException $e) {
    // Invalid or expired token
} catch (RateLimitException $e) {
    // Too many requests
} catch (WhatsAppApiException $e) {
    echo $e->getCode();    // Meta error code
    echo $e->getMessage(); // Human-readable message
    echo $e->getDetails(); // Additional details if available
}
```

---

## Testing

```bash
composer test
```

The package uses Laravel's `Http::fake()` — no real API calls in tests.

---

## License

MIT — [LICENSE](LICENSE)
