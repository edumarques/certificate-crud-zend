<?php
namespace Certificate\Model;

class BonusCertificate extends Certificate
{    
    private $barrier;
    
    private $type = 'bonusCertificate';

    /**
     * @return mixed
     */
    public function getBarrier()
    {
        return $this->barrier;
    }

    /**
     * @param mixed $barrier
     */
    public function setBarrier($barrier)
    {
        $this->barrier = $barrier;
    }
    
    /**
     * @return boolean
     */
    public function isBarrierHit()
    {
        $historySum = array_sum(explode(',', $this->priceHistory));
        
        if ($this->barrier != null && $historySum >= $this->barrier) {
            return true;
        } else {
            return false;
        }        
    }
    
    public function exchangeArray(array $data)
    {
        $this->id = ! empty($data['id']) ? $data['id'] : null;
        $this->isin = ! empty($data['isin']) ? $data['isin'] : null;
        $this->tradingMarket = ! empty($data['tradingMarket']) ? $data['tradingMarket'] : null;
        $this->currency = ! empty($data['currency']) ? $data['currency'] : null;
        $this->issuer = ! empty($data['issuer']) ? $data['issuer'] : null;
        $this->issuingPrice = ! empty($data['issuingPrice']) ? $data['issuingPrice'] : null;
        $this->currentPrice = ! empty($data['currentPrice']) ? $data['currentPrice'] : null;
        $this->barrier = ! empty($data['barrier']) ? $data['barrier'] : null;
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
            'barrier' => $this->barrier,
            'priceHistory' => $this->priceHistory,
            'additionalDocument' => $this->additionalDocument,
            'type' => $this->type
        ];
    }
    
}

