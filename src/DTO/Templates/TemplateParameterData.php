<?php

namespace Vishwaraj\WhatsAppCloud\DTO\Templates;

final class TemplateParameterData
{
    public function __construct(
        public readonly string $type,
        public readonly mixed  $value,
    ) {}

    public static function text(string $text): self
    {
        return new self('text', $text);
    }

    public static function currency(string $fallback, string $code, int $amount1000): self
    {
        return new self('currency', [
            'fallback_value' => $fallback,
            'code'           => $code,
            'amount_1000'    => $amount1000,
        ]);
    }

    public static function dateTime(string $fallback): self
    {
        return new self('date_time', ['fallback_value' => $fallback]);
    }

    public static function image(string $link): self
    {
        return new self('image', ['link' => $link]);
    }

    public static function imageId(string $id): self
    {
        return new self('image', ['id' => $id]);
    }

    public static function document(string $link, ?string $filename = null): self
    {
        $val = ['link' => $link];
        if ($filename) {
            $val['filename'] = $filename;
        }
        return new self('document', $val);
    }

    public static function video(string $link): self
    {
        return new self('video', ['link' => $link]);
    }

    public static function payload(string $payload): self
    {
        return new self('payload', $payload);
    }

    public static function action(array $action): self
    {
        return new self('action', $action);
    }
}
