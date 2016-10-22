<?php

namespace WhackUp\ManageBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use WhackUp\ManageBundle\Entity\ImageDiso;

class DiscoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('adresse')
            ->add('complement')
            ->add('web')
            ->add('connexion')
            ->add('description')
           // ->add('image',ImageDiscoType::class) //ImageDiscoType::class
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'WhackUp\ManageBundle\Entity\Disco'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'whackup_managebundle_disco';
    }
}
