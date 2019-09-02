<?php declare(strict_types=1);

namespace App\Slack;

use Illuminate\Support\Fluent;
use Image;
use Intervention\Image\ImageCache;

class Accessory extends Fluent
{
    private const REQUIRED = [
        'type',
        'image_url',
        'alt_text',
    ];

    public function __construct($attributes = [])
    {
        foreach (self::REQUIRED as $requiredKey) {
            if (!array_key_exists($requiredKey, $attributes)) {
                throw new \InvalidArgumentException('Missing required key: ' . $requiredKey);
            }
        }
        parent::__construct($attributes);
    }

    public static function make(string $imageUrl, string $description): Accessory
    {
        return new self([
            'type'      => 'image',
            'image_url' => $imageUrl,
            'alt_text'  => $description,
        ]);
    }

    public static function makeInverted(string $imageUrl, string $description): Accessory
    {
        Image::cache(function (ImageCache $image) use ($imageUrl) {
            /** @var \Intervention\Image\Image $originalImage */
            $originalImage = Image::make($imageUrl);
            /** @var \Intervention\Image\Image $convertedImage */
            $convertedImage = $image->canvas($originalImage->width(), $originalImage->height(), '#0E0E0E');
            $convertedImage->fill($originalImage)->save(storage_path('app/public/' . basename($imageUrl)));
        }, 10080, true);

        return new self([
            'type'      => 'image',
            'image_url' => asset('storage/' . basename($imageUrl)),
            'alt_text'  => $description,
        ]);
    }
}
