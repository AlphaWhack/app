<?php

namespace WhackUp\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints as Assert;

class UserType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username','text')
            ->add('mail','text')
            ->add('password','password')
            ->add('passwordConfirm','password')
            /*
            ->add('password', 'repeated', array(
                'first_name' => 'pass',
                'second_name' => 'confirm',
                'type' => 'password',
                'invalid_message' => 'Les mots de passe entrés ne correspondent pas.',
                'error_bubbling' => true
                )
            )*/
            ->add('termsAccepted','checkbox', array(
                'mapped' => false,
                'constraints' => new IsTrue(),
            ))
            ->add('Register','submit')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'WhackUp\UserBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'whackup_userbundle_user';
    }
}
