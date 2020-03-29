<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class JsonSchemaTest extends AbstractController
{
    public function index(Request $request) {
        $validator = new \JsonSchema\Validator;

        $schema = <<<EOT
{
    "type": "object",
    "required": ["greeting", "expected_response"],
    "properties": {
        "greeting": {
            "type": "string",
            "enum": [
                "yo",
                "sup"
            ]
        },
        "expected_response": {
            "type": "object",
            "properties": {
                "name": {
                    "type": "string"
                }
            }
        }
    },
    "additionalProperties": false
}
EOT;
        $data = json_decode($request->getContent());
        dump($data);
        $validator->validate($data, (object)json_decode($schema));

        dump((object)json_decode($schema));
        dump($validator->isValid());
        dump($validator->getErrors());

        return $this->json('yo');
    }
}
