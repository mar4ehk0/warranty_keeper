<?php

namespace App\OCR\Exception;

use Exception;
use Throwable;

class CouldNotRecognizeTextException extends Exception
{
    private const MESSAGE = 'Could not send request to OCR service for FileId: %s ';

    private function __construct(string $message, ?Throwable $previous = null)
    {
        parent::__construct($message, $code = 0, $previous);
    }

    public static function withFileId(string $fileId, ?Throwable $previous = null): self
    {
        $msg = sprintf(self::MESSAGE, $fileId);

        return new self($msg, $previous);
    }

    public static function withFileIdThatWrongToken(string $fileId, ?Throwable $previous = null): self
    {
        $msg = sprintf(self::MESSAGE . 'that wrong token.', $fileId);

        return new self($msg, $previous);
    }

    public static function withFileIdThatClientHasException(string $fileId, ?Throwable $previous = null): self
    {
        $msg = sprintf(self::MESSAGE . 'that client has exception .', $fileId);

        return new self($msg, $previous);
    }

    public static function withFileIdThatWasNotValid(string $fileId, ?Throwable $previous = null): self
    {
        $msg = sprintf('Could not validate Response from OCR service for File: %s.', $fileId);

        return new self($msg, $previous);
    }
}
