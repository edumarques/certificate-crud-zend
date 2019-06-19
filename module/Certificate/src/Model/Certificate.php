<?php
namespace Certificate\Model;

use Zend\Validator\StringLength;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\Validator\Digits;
use Zend\InputFilter\FileInput;
use Zend\Validator\File\UploadFile;
use Zend\Filter\File\RenameUpload;

class Certificate implements InputFilterAwareInterface
{

    protected $id;

    protected $isin;

    protected $tradingMarket;

    protected $currency;

    protected $issuer;

    protected $issuingPrice;

    protected $currentPrice;

    protected $priceHistory;

    protected $additionalDocument;

    protected $inputFilter;
    
    private $type = 'certificate';

    public function exchangeArray(array $data)
    {
        $this->id = ! empty($data['id']) ? $data['id'] : null;
        $this->isin = ! empty($data['isin']) ? $data['isin'] : null;
        $this->tradingMarket = ! empty($data['tradingMarket']) ? $data['tradingMarket'] : null;
        $this->currency = ! empty($data['currency']) ? $data['currency'] : null;
        $this->issuer = ! empty($data['issuer']) ? $data['issuer'] : null;
        $this->issuingPrice = ! empty($data['issuingPrice']) ? $data['issuingPrice'] : null;
        $this->currentPrice = ! empty($data['currentPrice']) ? $data['currentPrice'] : null;
        $this->priceHistory = ! empty($data['priceHistory']) ? $data['priceHistory'] : $data['currentPrice'];
        
        if(!empty($data['additionalDocument'])) {
            if(is_array($data['additionalDocument'])) {
                $this->additionalDocument = str_replace("./public", "",
                    $data['additionalDocument']['tmp_name']);
            } else {
                $this->additionalDocument = $data['additionalDocument'];
            }
        } else {
            $data['additionalDocument'] = null;
        }
    }

    public function getArrayCopy()
    {
        return [
            'id' => $this->id,
            'isin' => $this->isin,
            'tradingMarket' => $this->tradingMarket,
            'currency' => $this->currency,
            'issuer' => $this->issuer,
            'issuingPrice' => $this->issuingPrice,
            'currentPrice' => $this->currentPrice,
            'priceHistory' => $this->priceHistory,
            'additionalDocument' => $this->additionalDocument,
            'type' => $this->type
        ];
    }

    /**
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @return mixed
     */
    public function getIsin()
    {
        return $this->isin;
    }

    /**
     *
     * @return mixed
     */
    public function getTradingMarket()
    {
        return $this->tradingMarket;
    }

    /**
     *
     * @return mixed
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     *
     * @return mixed
     */
    public function getIssuer()
    {
        return $this->issuer;
    }

    /**
     *
     * @return mixed
     */
    public function getIssuingPrice()
    {
        return $this->issuingPrice;
    }

    /**
     *
     * @return mixed
     */
    public function getCurrentPrice()
    {
        return $this->currentPrice;
    }

    /**
     *
     * @return mixed
     */
    public function getPriceHistory()
    {
        return $this->priceHistory;
    }

    /**
     *
     * @return mixed
     */
    public function getAdditionalDocument()
    {
        return $this->additionalDocument;
    }
    
    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
    
    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     *
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     *
     * @param mixed $isin
     */
    public function setIsin($isin)
    {
        $this->isin = $isin;
    }

    /**
     *
     * @param mixed $tradingMarket
     */
    public function setTradingMarket($tradingMarket)
    {
        $this->tradingMarket = $tradingMarket;
    }

    /**
     *
     * @param mixed $currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    /**
     *
     * @param mixed $issuer
     */
    public function setIssuer($issuer)
    {
        $this->issuer = $issuer;
    }

    /**
     *
     * @param mixed $issuingPrice
     */
    public function setIssuingPrice($issuingPrice)
    {
        $this->issuingPrice = $issuingPrice;
    }

    /**
     *
     * @param mixed $currentPrice
     */
    public function setCurrentPrice($currentPrice)
    {
        $this->currentPrice = $currentPrice;
    }

    /**
     *
     * @param mixed
     */
    public function setPriceHistory($priceHistory)
    {
        $this->priceHistory = $priceHistory;
    }

    /**
     *
     * @param mixed $additionalDocument
     */
    public function setAdditionalDocument($additionalDocument)
    {
        $this->additionalDocument = $additionalDocument;
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \DomainException(sprintf('%s does not allow injection of an alternate input filter', __CLASS__));
    }

    public function getInputFilter()
    {
        if ($this->inputFilter) {
            return $this->inputFilter;
        }

        $inputFilter = new InputFilter();

        $inputFilter->add([
            'name' => 'id',
            'required' => true,
            'filters' => [
                [
                    'name' => ToInt::class
                ]
            ]
        ]);

        $inputFilter->add([
            'name' => 'isin',
            'required' => true,
            'filters' => [
                [
                    'name' => StripTags::class
                ],
                [
                    'name' => StringTrim::class
                ]
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 100
                    ]
                ]
            ]
        ]);

        $inputFilter->add([
            'name' => 'tradingMarket',
            'required' => true,
            'filters' => [
                [
                    'name' => StripTags::class
                ],
                [
                    'name' => StringTrim::class
                ]
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 100
                    ]
                ]
            ]
        ]);
        
        $inputFilter->add([
            'name' => 'issuer',
            'required' => true,
            'filters' => [
                [
                    'name' => StripTags::class
                ],
                [
                    'name' => StringTrim::class
                ]
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 100
                    ]
                ]
            ]
        ]);
        
        $inputFilter->add([
            'name' => 'currency',
            'required' => true,
            'filters' => [
                [
                    'name' => StripTags::class
                ],
                [
                    'name' => StringTrim::class
                ]
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 100
                    ]
                ]
            ]
        ]);
        
        $inputFilter->add([
            'name' => 'issuingPrice',
            'required' => true,
            'filters' => [
                [
                    'name' => ToInt::class
                ]
            ],
            'validators' => [
                [
                    'name' => Digits::class,
                    
                ]
            ]
        ]);
        
        $inputFilter->add([
            'name' => 'currentPrice',
            'required' => true,
            'filters' => [
                [
                    'name' => ToInt::class
                ]
            ],
            'validators' => [
                [
                    'name' => Digits::class,
                    
                ]
            ]
        ]);
        
        $file = new FileInput('additionalDocument');
        $file->setRequired(false);
        $file->getValidatorChain()->attach(new UploadFile());
        $file->getFilterChain()->attach(
            new RenameUpload([
                'target'    => './public/uploads/document',
                'randomize' => true,
                'use_upload_extension' => true
            ]));
        $inputFilter->add($file);

        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }
}


