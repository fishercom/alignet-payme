<?php

namespace LaravelPaymeAlignet;

use Illuminate\Contracts\Config\Repository;

class LaravelPayme
{
    private $config;
    private $url;
    private $acquirer_id;
    private $currency_code;
    private $commerce_id;
    private $wallet_commerce_id;
    private $wallet_commerce_secret;
    private $vpos_secret_key;

    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    /**
     * This take the config/laravel-payme-alignet values and replace this class variables
     */
    private function configure()
    {
        if ($this->config->has('laravel-payme')) {
            foreach ($this->config->get('laravel-payme') as $key => $value) {
                $this->{$key} = $value;
            }
        }
    }

    /**
     * @param $userId int
     * @param $emailUser string
     * @param $nameUser string
     * @param null $lastnameUser
     * @param array $moreData Used for reserved fields. e.g
     * @return bool|mixed
     */
    public function registerUser($userId, $emailUser, $nameUser, $lastnameUser = null, array $moreData = [])
    {
        try {
            $this->configure();

            $client = new \SoapClient($this->url);

            $registerVerification = openssl_digest("{$this->wallet_commerce_id}{$userId}{$emailUser}{$this->wallet_commerce_secret}", 'sha512');

            $userParams = [
                'idEntCommerce'         => $this->wallet_commerce_id,
                'codCardHolderCommerce' => $userId,
                'names'                 => $nameUser,
                'lastNames'             => is_null($lastnameUser) ? $nameUser : $lastnameUser,
                'mail'                  => $emailUser,
                'registerVerification'  => $registerVerification,
            ];

            $params = array_merge($userParams, $moreData);

            $user = $client->RegisterCardHolder($params);

            return $user;

        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Generate a payment order by token user
     *
     * @param null $tokenUser
     * @param int $purchaseUniqueId
     * @param float $purchaseTotal
     * @return bool|string
     */
    public function generatePaymentOrderByTokenUser($tokenUser = null, $purchaseUniqueId = 0, $purchaseTotal = 0.0)
    {
        if (is_null($tokenUser)) {
            return false;
        }

        $purchaseOperationNumber = sprintf('%06d', $purchaseUniqueId);
        $purchaseAmount = intval($purchaseTotal * 100);

        $purchaseVerificationCode = openssl_digest($this->acquirer_id . $this->commerce_id . $purchaseOperationNumber . $purchaseAmount . $this->currency_code . $this->vpos_secret_key, 'sha512');

        return $purchaseVerificationCode;
    }
}