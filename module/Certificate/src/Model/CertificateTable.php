<?php
namespace Certificate\Model;

use Zend\Db\TableGateway\TableGatewayInterface;
use RuntimeException;

class CertificateTable
{

    protected $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    public function getCertificate($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select([
            'id' => $id
        ]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf('Could not find row with identifier %d', $id));
        }

        return $row;
    }

    public function saveCertificate($certificate)
    {
        if ($certificate instanceof BonusCertificate) {
            $data = [
                'isin' => $certificate->getIsin(),
                'tradingMarket' => $certificate->getTradingMarket(),
                'issuer' => $certificate->getIssuer(),
                'currency' => $certificate->getCurrency(),
                'issuingPrice' => $certificate->getIssuingPrice(),
                'currentPrice' => $certificate->getCurrentPrice(),
                'priceHistory' => $certificate->getPriceHistory(),
                'barrier' => $certificate->getBarrier(),
                'additionalDocument' => $certificate->getAdditionalDocument()
            ];
        } else if ($certificate instanceof GuaranteeCertificate) {
            $data = [
                'isin' => $certificate->getIsin(),
                'tradingMarket' => $certificate->getTradingMarket(),
                'issuer' => $certificate->getIssuer(),
                'currency' => $certificate->getCurrency(),
                'issuingPrice' => $certificate->getIssuingPrice(),
                'currentPrice' => $certificate->getCurrentPrice(),
                'priceHistory' => $certificate->getPriceHistory(),
                'participationRate' => $certificate->getParticipationRate(),
                'additionalDocument' => $certificate->getAdditionalDocument()
            ];
        } else {
            $data = [
                'isin' => $certificate->getIsin(),
                'tradingMarket' => $certificate->getTradingMarket(),
                'issuer' => $certificate->getIssuer(),
                'currency' => $certificate->getCurrency(),
                'issuingPrice' => $certificate->getIssuingPrice(),
                'currentPrice' => $certificate->getCurrentPrice(),
                'priceHistory' => $certificate->getPriceHistory(),
                'additionalDocument' => $certificate->getAdditionalDocument()
            ];
        }        

        $id = (int) $certificate->getId();

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        try {
            $this->getCertificate($id);
        } catch (RuntimeException $e) {
            throw new RuntimeException(sprintf('Cannot update certificate with identifier %d; does not exist', $id));
        }

        $this->tableGateway->update($data, [
            'id' => $id
        ]);
    }

    public function deleteCertificate($id)
    {
        $this->tableGateway->delete([
            'id' => (int) $id
        ]);
    }
}

