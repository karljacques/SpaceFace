<?php


namespace App\Service\Factories\Command;


use App\Command\CommandInterface;
use App\Entity\Ship;
use App\Entity\User;
use App\Exception\SchemaValidationException;
use App\Exception\ValidationError;
use App\Service\SchemaService;
use JsonSchema\Validator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Contracts\Service\ServiceSubscriberInterface;
use Symfony\Contracts\Service\ServiceSubscriberTrait;

abstract class AbstractCommandParamConverter implements ParamConverterInterface, ServiceSubscriberInterface
{
    use ServiceSubscriberTrait;

    /**
     * @param Request $request
     * @param ParamConverter $configuration
     * @throws SchemaValidationException
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        $schemaFilename = $this->getSchemaFilename();

        if ($schemaFilename !== null) {
            $schema = $this->schemaService()->loadSchema($this->getSchemaFilename());
            $data = (object)$request->request->all();

            $validator = new Validator();

            $validator->validate($data, $schema);

            if (!$validator->isValid()) {
                throw new SchemaValidationException($this->transformValidationErrors($validator->getErrors()));
            }
        }

        /** @var User $user */
        $user = $this->security()->getUser();
        $ship = $user->getCharacters()->first()->getShips()->first();

        $command = $this->createCommand($request, $ship);

        $name = $configuration->getName();
        $request->attributes->set($name, $command);

        return true;
    }

    abstract protected function getSchemaFilename(): ?string;

    protected function schemaService(): SchemaService
    {
        return $this->container->get(__METHOD__);
    }

    /**
     * @param array $errors
     * @return ValidationError[]
     */
    private function transformValidationErrors(array $errors): array
    {
        return collect($errors)
            ->map(fn(array $error) => new ValidationError($error['message'], $error['pointer']))
            ->toArray();
    }

    protected function security(): Security
    {
        return $this->container->get(__METHOD__);
    }

    abstract protected function createCommand(Request $request, Ship $ship): CommandInterface;
}
