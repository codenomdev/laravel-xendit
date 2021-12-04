<?php

namespace Codenom\Xendit;

// use Exception;

use Exception;
use Xendit\Exceptions\ApiException;
use Xendit\Xendit as BaseXendit;
use Xendit\Balance;
use Xendit\VirtualAccounts;
use Xendit\PaymentChannels;
use Xendit\Invoice;

class Xendit
{
    /**
     * Secret key.
     * 
     * @var string
     */
    protected $secretKey;

    /**
     * Public key.
     * 
     * @var string
     */
    protected $publicKey;

    /**
     * Constructor Class.
     * 
     * @var $secretKey
     * @var $publicKey
     */
    public function __construct(string $secretKey = null, string $publicKey = null)
    {
        $this->secretKey = $this->setSecretKey($secretKey);
        $this->publicKey = $publicKey ?? config('xendit.public_key');
    }

    /**
     * Send GET request to retrieve data
     *
     * @param string $account_type account type (CASH|HOLDING|TAX)
     * @param array $param = []
     * @return \Xendit::getBalance
     * @throws \Xendit\Exceptions\ApiException
     */
    public function getBalance(string $account_type = 'CASH', array $param = [])
    {
        try {
            $this->getSecretKey();
            return Balance::getBalance($account_type, $param);
        } catch (ApiException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Get available VA banks
     *
     * @return \Xendit\VirtualAccounts
     * @throws \Exceptions\ApiException
     */
    public function getVABanks()
    {
        try {
            $this->getSecretKey();
            return VirtualAccounts::getVABanks();
        } catch (ApiException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Get FVA payment.
     *
     * @param string $payment_id payment ID
     *
     * @return \Xendit\VirtualAccounts::getFVAPayment
     * @throws Exceptions\ApiException
     */
    public function getFVAPayment(array $params = [])
    {
        if (\array_key_exists('external_id', $params) === false) {
            throw new Exception(
                \sprintf('external_id must be a required')
            );
        }
        if (\array_key_exists('bank_code', $params) === false) {
            throw new Exception(
                \sprintf('bank_code must be a required')
            );
        }
        if (\array_key_exists('name', $params) === false) {
            throw new Exception(
                \sprintf('name must be a required')
            );
        }
        $this->getSecretKey();
        return VirtualAccounts::create($params);
    }

    /**
     * Payment channel list
     *
     * @return \Xendit\PaymentChannels::list
     * @see https://developers.xendit.co/api-reference/#get-payment-channels
     * @throws Exceptions\ApiException
     */
    public function getPaymentChannels()
    {
        try {
            $this->getSecretKey();
            return PaymentChannels::list();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Create new invoice.
     * 
     * @param array $param
     * @return JSON
     * @throws \Xendit\Exceptions\ApiException
     */
    public function createInvoice(array $param)
    {
        try {
            $this->getSecretKey();
            $invoice = Invoice::create($param);
            return $invoice;
        } catch (ApiException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Retrieve spesified w/ ID invoice.
     * 
     * @param string $id
     * @return JSON
     * @throws \Xendit\Exceptions\ApiException
     */
    public function retrieveInvoice(string $id)
    {
        try {
            $this->getSecretKey();
            $invoice = Invoice::retrieve($id);
            return $invoice;
        } catch (ApiException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Get all retrieve invoice.
     * 
     * @return JSON
     * @throws \Xendit\Exceptions\ApiException
     */
    public function retrieveInvoices()
    {
        try {
            $this->getSecretKey();
            $invoice = Invoice::retrieveAll();
            return $invoice;
        } catch (ApiException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Expire invoice.
     * 
     * @param string $id
     * @return JSON
     * @throws \Xendit\Exceptions\ApiException
     */
    public function expireInvoice(string $id)
    {
        try {
            $this->getSecretKey();
            $invoice = Invoice::expireInvoice($id);
            return $invoice;
        } catch (ApiException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Set the value of apiKey
     *
     * @param string $apiKey Secret API key
     *
     * @return \Codenom\Xendit\Xendit
     */
    public function setSecretKey(string $apikey = null)
    {
        $apikey = $apikey ?? config('xendit.secret_key');
        $this->secretKey = BaseXendit::setApiKey($apikey);
        return $this;
    }

    /**
     * Get the value of apiKey
     *
     * @return string Secret API key
     */
    public function getSecretKey()
    {
        return $this->secretKey = BaseXendit::getApiKey();
    }
}
