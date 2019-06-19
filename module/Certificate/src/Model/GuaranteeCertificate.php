<?php
namespace Certificate\Model;

class GuaranteeCertificate extends Certificate
{
    private $participationRate;
    
    private $type = 'guaranteeCertificate';
    
    /**
     * @return mixed
     */
    public function getParticipationRate()
    {
        return $this->participationRate;
    }
    
    /**
     * @param mixed $barrier
     */
    public function setParticipationRate($participationRate)
    {
        $this->participationRate = $participationRate;
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
        $this->participationRate = ! empty($data['participationRate']) ? $data['participationRate'] : null;
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
            'participationRate' => $this->participationRate,
            'priceHistory' => $this->priceHistory,
            'additionalDocument' => $this->additionalDocument,
            'type' => $this->type
        ];
    }
}

