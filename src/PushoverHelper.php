<?php


namespace Burgeramt;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

/**
 * Class PushoverHelper
 * @package phalconmicro\helpers
 */
class PushoverHelper
{
    const PUSHOVER_URL = 'https://api.pushover.net/1/messages.json';

    /** Group Key */
    const GROUP_KEY = '';

    /** App Key */
    const APP_PUSHOVER_TOKEN = '';

    /**
     * @param $msg
     */
    public function sendPushoverNotification($msg)
    {
        curl_setopt_array($ch = curl_init(), array(
            CURLOPT_URL => static::PUSHOVER_URL,
            CURLOPT_POSTFIELDS => array(
                'token'   => static::APP_PUSHOVER_TOKEN,
                'user'    => static::GROUP_KEY,
                'html'    => 1,
                'message' => $msg,
            ),
            CURLOPT_SAFE_UPLOAD => true,
            CURLOPT_RETURNTRANSFER => true,
        ));
        curl_exec($ch);
        curl_close($ch);
    }

    /**
     * @param $queryResult
     * @return string
     */
    public function createDailyMessage($queryResult)
    {
        $text = '';
        $date = new \DateTime();

        $date->modify('-1 day');
        $date = $date->format('d');


        foreach ($queryResult as $results) {

            $amountAfterTaxes = round($results['amount'] * OnebipHelper::PERCENT_AFTER_PAYOUT / 100, 2);
            $amountInEur = round($this->getCurrencyConverted($results['currency'], $results['amount']), 2);
            $amountAfterTaxesInEur = round($this->getCurrencyConverted($results['currency'], $amountAfterTaxes), 2);

            $text .= '<b>Onebip Daily Subs Day: </b>' . $date . "\n";
            $text .= '<b>Country:</b> ' . $results['country'] . "\n";
            $text .= '<b>Subscriptions:</b> ' . $results['subscriptions'] . "\n";
            $text .= '<b>Amount:</b> ' . $results['amount'] . "\n";
            $text .= '<b>Amount (EUR):</b> ' . $amountInEur . "\n";
            $text .= '<b>Amount After Taxes:</b> ' . $amountAfterTaxes . "\n";
            $text .= '<b>Amount After Taxes (EUR):</b> ' . $amountAfterTaxesInEur . "\n";
            $text .= '<b>Currency:</b> ' . $results['currency'] . "\n\n";
        }

        return $text;
    }
}