<?php

namespace Amaxlab\Bundle\FormBundle\Form\Type;

use Amaxlab\Bundle\FormBundle\Validator\Constraints\ValidRecaptcha;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class Recaptcha2Type.
 */
class Recaptcha2Type extends AbstractType
{
    /**
     * The recaptcha2 api URL.
     */
    const RECAPTCHA2_API_SERVER = '//www.google.com/recaptcha/api.js';

    /**
     * The public key.
     *
     * @var string
     */
    protected $publicKey;

    /**
     * Enable recaptcha2?
     *
     * @var Boolean
     */
    protected $enabled;

    /**
     * Language.
     *
     * @var string
     */
    protected $language;

    /**
     * Construct.
     *
     * @param string $publicKey Recaptcha2 public key
     * @param bool   $enabled   Recaptcha status
     * @param string $language  language or locale code
     */
    public function __construct($publicKey, $enabled, $language)
    {
        $this->publicKey = $publicKey;
        $this->enabled = $enabled;
        $this->language = $language;
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars = array_replace($view->vars, array(
            'recaptcha2_enabled' => $this->enabled,
        ));

        if (!$this->enabled) {
            return;
        }

        $view->vars = array_replace($view->vars, array(
            'public_key' => $this->publicKey,
            'recaptcha2_api' => self::RECAPTCHA2_API_SERVER,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'compound' => false,
            'public_key' => null,
            'attr' => array(),
            'translation_domain' => 'amaxlab_form_bundle',
            'constraints' => array(
                new ValidRecaptcha(),
            ),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'form';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'amaxlab_recaptcha2';
    }

    /**
     * Gets the public key.
     *
     * @return string The javascript source URL
     */
    public function getPublicKey()
    {
        return $this->publicKey;
    }
}
