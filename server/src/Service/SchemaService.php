<?php


namespace App\Service;


use App\Exception\SchemaValidationException;
use App\Exception\ValidationError;
use Symfony\Component\HttpKernel\KernelInterface;

class SchemaService
{
    protected KernelInterface $kernel;
    protected array $schemaCache = [];

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @param string $filename
     * @return object
     * @throws SchemaValidationException
     */
    public function loadSchema(string $filename): object
    {
        if (isset($this->schemaCache[$filename])) {
            return $this->schemaCache[$filename];
        }

        $path = $this->getFullSchemaPath($filename);
        $content = file_get_contents($path);

        $decoded = json_decode($content);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->throwJsonExceptionError(json_last_error_msg(), $filename);
        }

        $this->schemaCache[$filename] = $decoded;

        return $decoded;
    }

    private function getFullSchemaPath(string $filename): string
    {
        return sprintf('%s/schema/%s', $this->kernel->getProjectDir(), $filename);
    }

    /**
     * @param string $message
     * @param string $pointer
     * @return array
     * @throws SchemaValidationException
     */
    private function throwJsonExceptionError(string $message, string $pointer): array
    {
        throw new SchemaValidationException([new ValidationError($message, $pointer)]);
    }
}
