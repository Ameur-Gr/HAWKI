<?php
declare(strict_types=1);

namespace App\Services\Ai\Providers\Adapters\Implementations;

use App\Services\Storage\Interfaces\FileInterface;
use App\Services\Storage\Values\FileType;

class BlabladorAdapter extends OpenAiLikeAdapter
{
    public function supportsFileAsAttachment(FileInterface $file): bool
    {
        return $file->getFileType() === FileType::IMAGE;
    }
}