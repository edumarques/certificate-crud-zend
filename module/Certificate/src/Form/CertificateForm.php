<?php
namespace Certificate\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class CertificateForm extends Form
{

    public function __construct($name = null)
    {
        parent::__construct('certificate');

        $this->add([
            'name' => 'id',
            'type' => 'hidden'
        ]);
        $this->add([
            'name' => 'type',
            'type' => 'select',            
            'options' => [
                'label' => 'Type',
                'value_options' => [
                    'certificate' => 'Certificate',
                    'bonusCertificate' => 'Bonus Certificate',
                    'guaranteeCertificate' => 'Guarantee Certificate'
                ]
            ]
        ]);
        $this->add([
            'name' => 'isin',
            'type' => 'text',
            'options' => [
                'label' => 'ISIN'
            ]
        ]);
        $this->add([
            'name' => 'tradingMarket',
            'type' => 'text',
            'options' => [
                'label' => 'Trading Market'
            ]
        ]);
        $this->add([
            'name' => 'currency',
            'type' => 'text',
            'options' => [
                'label' => 'Currency'
            ]
        ]);
        $this->add([
            'name' => 'issuer',
            'type' => 'text',
            'options' => [
                'label' => 'Issuer'
            ]
        ]);
        $this->add([
            'name' => 'issuingPrice',
            'type' => 'text',
            'options' => [
                'label' => 'Issuing Price (in cents)'
            ]
        ]);
        $this->add([
            'name' => 'currentPrice',
            'type' => 'text',
            'options' => [
                'label' => 'Current Price (in cents)'
            ]
        ]);
        $this->add([
            'name' => 'barrier',
            'type' => 'text',
            'options' => [
                'label' => 'Barrier (in cents)'
            ]
        ]);
        $this->add([
            'name' => 'participationRate',
            'type' => 'text',
            'options' => [
                'label' => 'Participation rate (in %)'
            ]
        ]);

        $this->addAdditonalDocument();

        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Go',
                'id' => 'submitbutton'
            ]
        ]);
    }

    public function addAdditonalDocument()
    {
        $file = new Element\File('additionalDocument');
        $file->setLabel('Additional Document Upload');
        $file->setAttribute('id', 'additionalDocument');
        $this->add($file);
    }
}

