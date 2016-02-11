<?php

namespace Admin\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('username','text',array( 'label' => 'Username*'))
                ->add('nombre','text',array( 'label' => 'Nombres*'))
                ->add('apellidos','text',array( 'label' => 'Apellidos*'))
                ->add('email','email',array( 'label' => 'Email*'))
                ->add('plainPassword', 'repeated', array(
                'type' => 'password',
                'options' => array('translation_domain' => 'FOSUserBundle', 'label' => 'Contraseña*'),
                'invalid_message' => 'fos_user.password.mismatch',
            ))
                ->add('telefono')
                ->add('fechaNaci', 'date', array(
                    'years' => range(date('Y') - 95, date('Y') - 17),
                    'required' => True,
                    'label' => 'Fecha de nacimimiento *',
                    'empty_value' => array('year' => 'Año', 'month' => 'Mes', 'day' => 'Dia'),
                ))
                ->add('roles', 'choice', array('label' => 'Rol', 'required' => true, 
                           'choices' => array( 'ROLE_ADMIN' => 'ADMINISTRADOR',
                                               'ROLE_USER' => 'USUARIO',
                                               'ROLE_CLIEN' => 'CLIENTE',
                                               'ROLE_CORDI' => 'COORDINADOR',
                                                'ROLE_CORCA' => 'COORDINADOR DE CAMPO'
                               ), 'multiple' => true))
                ->add('enabled')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Admin\AdminBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'admin_adminbundle_user';
    }

}
