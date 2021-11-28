<?php

namespace Codenom\Xendit;

use Xendit\Xendit as BaseXendit;
use Xendit\Balance;

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
     * @return Xendit::getBalance
     * @throws \Xendit\Exceptions\ApiException
     */
    public function getBalance(string $account_type = null, array $param = [])
    {
        try {
            $this->getSecretKey();
            return Balance::getBalance($account_type, $param);
        } catch (\Exception $e) {
            $e->getMessage();
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
        return $this->secretKey;
    }
}
