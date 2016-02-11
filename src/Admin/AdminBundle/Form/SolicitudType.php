<?php

namespace Admin\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SolicitudType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('image', 'file', array(
                    'required' => false,
                    'data_class' => null,
                    'label'=>'Logotipo',
                    'attr'=>array('class'=>'form-control','accept'=>'image/x-png, image/gif, image/jpeg')
            ))
            ->add('fechainicio', 'date',array(
                'required' => false,
                'label' => 'Inicio de proyecto',
                'empty_value' => array('year' => 'Año', 'month' => 'Mes', 'day' => 'Dia')
            ))
            ->add('fechafin', 'date',array(
                'required' => false,
                'label' => 'Fin de proyecto',
                'empty_value' => array('year' => 'Año', 'month' => 'Mes', 'day' => 'Dia')
            ))
            ->add('Nombre','text',array('label'=>'Nombre de la grabacion*','attr'=>array('class'=>'form-control')))
            ->add('observaciones','textarea',array('label'=>'Describa detalladamente la solicitud*','attr'=>array('class'=>'form-control'),'required' => true,))
                ->add('File', 'file', array(
                    'required' => false,
                    'data_class' => null,
                    'label'=>'Archivo',
                    'attr'=>array('class'=>'form-control')
                ))
                ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Admin\AdminBundle\Entity\Solicitud'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_adminbundle_solicitud';
    }
}
