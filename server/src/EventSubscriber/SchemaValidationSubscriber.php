<?php


namespace App\EventSubscriber;


use App\Exception\SchemaValidationException;
use JsonSchema\Validator;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\KernelInterface;

class SchemaValidationSubscriber implements EventSubscriberInterface
{
    protected KernelInterface $kernel;
    protected array $schemaCache = [];

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @param RequestEvent $event
     * @throws SchemaValidationException
     */
    public function onRequest(RequestEvent $event)
    {
        $request = $event->getRequest();

        $schemaFilename = $request->get('_schema');

        if (null === $schemaFilename || '' === $schemaFilename)
            return;

        $schema = $this->loadSchema($schemaFilename);

        $validator = new Validator;

        $data = json_decode($request->getContent());

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->throwJsonExceptionError(json_last_error_msg(), 'request_body');
        }

        $validator->validate($data, $schema);

        if (!$validator->isValid()) {
            throw new SchemaValidationException($validator->getErrors());
        }
    }

    /**
     * @param string $filename
     * @return object
     * @throws SchemaValidationException
     */
    private function loadSchema(string $filename): object
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
        throw new SchemaValidationException([[
            'message' => $message,
            'pointer' => $pointer
        ]]);
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => 'onRequest'
        ];
    }
}
