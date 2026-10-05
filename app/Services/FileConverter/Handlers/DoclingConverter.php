<?php
declare(strict_types=1);

namespace App\Services\FileConverter\Handlers;

use App\Services\FileConverter\Exception\ConversionFailedException;
use App\Services\Storage\Values\FileCollection;
use App\Services\Storage\Values\FileReference;
use Illuminate\Support\Facades\Http;
use Symfony\Component\Mime\MimeTypes;

class DoclingConverter extends AbstractFileConverter
{
    public static function isValidConfig(array $config): bool
    {
        return isset($config['api_url'])
            && is_string($config['api_url'])
            && filter_var($config['api_url'], FILTER_VALIDATE_URL);
    }

    public function convert(FileReference $file): FileCollection
    {
        $response = Http::timeout($this->getRequestTimeout())
            ->acceptJson()
            ->attach(
                'files',
                $file->getStream(),
                $file->getOriginalFilename()
            )
            ->post(rtrim($this->config['api_url'], '/') . '/v1/convert/file', [
                'to_formats' => 'md',
            ]);

        if (!$response->successful()) {
            throw ConversionFailedException::forFailedResponse($this, $response);
        }

        $result = $response->json();

        $markdown = $result['document']['md_content'] ?? null;

        if (!$markdown) {
            return new FileCollection();
        }

        return new FileCollection(
            FileReference::fromContent(
                originalFilename: pathinfo(
                    $file->getOriginalFilename(),
                    PATHINFO_FILENAME
                ) . '.md',
                content: $markdown,
            )
        );
    }

    public function isAvailable(): bool
    {
        return true;
    }

    public function getAllowedMimeTypes(): array
    {
        $mime = new MimeTypes();

        return array_values(array_unique([
            ...$mime->getMimeTypes('pdf'),
            ...$mime->getMimeTypes('docx'),
            ...$mime->getMimeTypes('pptx'),
            ...$mime->getMimeTypes('xlsx'),
            ...$mime->getMimeTypes('html'),
            ...$mime->getMimeTypes('htm'),
            ...$mime->getMimeTypes('md'),
            ...$mime->getMimeTypes('csv'),
            ...$mime->getMimeTypes('png'),
            ...$mime->getMimeTypes('jpg'),
            ...$mime->getMimeTypes('jpeg'),
            ...$mime->getMimeTypes('tiff'),
            ...$mime->getMimeTypes('tif'),
            ...$mime->getMimeTypes('bmp'),
            ...$mime->getMimeTypes('webp'),
        ]));
    }
}
