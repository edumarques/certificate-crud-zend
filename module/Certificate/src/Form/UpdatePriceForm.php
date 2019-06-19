<?php
namespace Certificate\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class UpdatePriceForm extends Form
{
    
    public function __construct($name = null)
    {
        parent::__construct('certificate');
        
        $this->add([
            'name' => 'id',
            'type' => 'hidden'
        ]);
        
        $element = new Element\Text('isin');
        $element->setLabel('ISIN');
        $element->setAttribute('readonly', 'true');
        $this->add($element);

        $element = new Element\Text('tradingMarket');
        $element->setLabel('Trading Market');
        $element->setAttribute('readonly', 'true');
        $this->add($element);
        
        $element = new Element\Text('currency');
        $element->setLabel('Currency');
        $element->setAttribute('readonly', 'true');
        $this->add($element);
        
        $element = new Element\Text('issuer');
        $element->setLabel('Issuer');
        $element->setAttribute('readonly', 'true');
        $this->add($element);
        
        $element = new Element\Text('issuingPrice');
        $element->setLabel('Issuing Price (in cents)');
        $element->setAttribute('readonly', 'true');
        $this->add($element);
        
        $element = new Element\Text('currentPrice');
        $element->setLabel('Current Price (in cents)');
        $this->add($element);
        
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Go',
                'id' => 'submitbutton'
            ]
        ]);
    }
}

