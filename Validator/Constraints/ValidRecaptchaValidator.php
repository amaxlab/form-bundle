<?php

namespace Amaxlab\Bundle\FormBundle\Validator\Constraints;

use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\ValidatorException;

/**
 * Class ValidValidator.
 */
class ValidRecaptchaValidator extends ConstraintValidator
{
    /**
     * Enable recaptcha2?
     *
     * @var bool
     */
    protected $enabled;

    /**
     * Recaptcha2 Private Key.
     *
     * @var bool
     */
    protected $privateKey;

    /**
     * Request Stack.
     *
     * @var \Symfony\Component\HttpFoundation\RequestStack
     */
    protected $requestStack;

    /**
     * The recaptcha2 server URL's.
     */
    const RECAPTCHA2_VERIFY_SERVER = 'https://www.google.com/recaptcha/api/siteverify';

    /**
     * @param bool         $enabled
     * @param string       $privateKey
     * @param RequestStack $requestStack
     */
    public function __construct($enabled, $privateKey, RequestStack $requestStack)
    {
        $this->enabled = $enabled;
        $this->privateKey = $privateKey;
        $this->requestStack = $requestStack;
    }

    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint)
    {
        // if recaptcha2 is disabled, always valid
        if (!$this->enabled) {
            return true;
        }

        // define variable for recaptcha2 check answer
        $remoteip = $this->requestStack->getMasterRequest()->server->get('REMOTE_ADDR');
        $response = $this->requestStack->getMasterRequest()->get('g-recaptcha-response');

        if (!$this->checkAnswer($this->privateKey, $remoteip, $response)) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();

            return false;
        }

        return true;
    }

    /**
     * Calls an HTTP POST function to verify if the user's guess was correct.
     *
     * @param string $privateKey
     * @param string $remoteip
     * @param string $response
     *
     * @throws ValidatorException When missing remote ip
     *
     * @return Boolean
     */
    private function checkAnswer($privateKey, $remoteip, $response)
    {
        if ($remoteip == null || $remoteip == '') {
            throw new ValidatorException('For security reasons, you must pass the remote ip to recaptcha2');
        }

        $response = $this->httpPost(self::RECAPTCHA2_VERIFY_SERVER, array(
            'secret' => $privateKey,
            'remoteip' => $remoteip,
            'response' => $response,
        ));

        if ($response && isset($response['success']) && $response['success']) {
            return true;
        }

        return false;
    }

    /**
     * Submits an HTTP POST to a recaptcha2 server.
     *
     * @param string $host
     * @param array  $data
     *
     * @return mixed
     */
    private function httpPost($host, $data)
    {
        $client = new Client(array(
            'defaults' => array(
                'headers' => array(
                    'User-Agent' => 'recaptcha2/PHP',
                ),
            ),
        ));
        $request = $client->createRequest('GET', $host, array(
            'query' => $data,
        ));
        $response = $client->send($request);

        return $response->json();
    }
}
