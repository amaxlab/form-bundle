<?php

/**
 * Created by PhpStorm.
 * User: Игорь
 * Date: 26.08.14
 * Time: 11:39.
 */
namespace Amaxlab\Bundle\FormBundle\Form\Type;

use Amaxlab\Bundle\FormBundle\Form\DataTransformer\SelectOrAddTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class SelectOrAddType.
 */
class SelectOrAddType extends AbstractType
{
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setOptional(array(
            'default',
            'query_builder',
            'choices',
        ));
        $resolver->setAllowedTypes(array(
            'choices' => 'array',
        ));
        $resolver->setRequired(array(
            'create_form_type',
            'class',
            'property',
        ));
        $resolver->setDefaults(array(
            'multiple' => false,
            'to_select_text' => 'Выбрать',
            'to_new_text' => 'Создать',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['multiple'] = $options['multiple'];
        $view->vars['to_select_text'] = $options['to_select_text'];
        $view->vars['to_new_text'] = $options['to_new_text'];
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $entityParams = array(
            'property' => $options['property'],
            'class' => $options['class'],
            'required' => $options['required'],
            'multiple' => $options['multiple'],
            'horizontal_input_wrapper_class' => ' ',
        );
        if (isset($options['default'])) {
            $entityParams['data'] = $options['default'];
        }
        if (isset($options['query_builder'])) {
            $entityParams['query_builder'] = $options['query_builder'];
        }
        if (isset($options['choices'])) {
            $entityParams['choices'] = $options['choices'];
        }

        $builder
            ->add('state', 'hidden', array())
            ->add('entity', 'entity', $entityParams)
            ->add('new_entity', $options['create_form_type'], array(
                'error_bubbling' => $options['error_bubbling'],
            ))
        ;

        if ($options['multiple']) {
            $builder
                ->add('new_entities', 'collection', array(
                    'type' => $options['create_form_type'],
                    'allow_add' => true,
                    'allow_delete' => true,
                    'label' => ' ',
                    'delete_empty' => true,
                    'show_legend' => false,
                    'error_bubbling' => $options['error_bubbling'],
                    'widget_remove_btn' => array('label' => 'Удалить'),
                    'widget_add_btn' => array('label' => 'Добавить'),
                    'options' => array(
                        'label_render' => false,
                        'horizontal_input_wrapper_class' => 'col-lg-8',
                    ),
                ));
        }
        $builder->addViewTransformer(new SelectOrAddTransformer($options['class'], $options['multiple']));
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return 'form';
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'select_or_add';
    }
}
