<?php

namespace Swiftyper;

/**
 * <strong><a href="https://developers.swiftyper.sk/withdrawals">Swiftyper Withdrawals API</a></strong>
 *
 * Records a consumer's complaint (reklamácia) from your own e-shop or order system. The consumer receives
 * a confirmation e-mail and the merchant is notified. Requires the API key of a withdrawal form project.
 *
 * @property string $id Unique identifier of the complaint (UUID)
 * @property string $reference Reference shown to the consumer, e.g. 'RK-2026-0001'
 * @property int $number Sequence number of the complaint within the project
 * @property string $status Processing status, 'new' for a recorded complaint
 * @property string $order_number Order number the complaint relates to
 * @property string $submitted_at Time the complaint was received (ISO 8601)
 * @property string $handling_deadline Last day to settle the complaint (YYYY-MM-DD)
 * @property bool $confirmation_sent Whether the confirmation e-mail was sent to the consumer
 */
class Complaint extends ApiResource
{
    const OBJECT_NAME = 'complaints';

    /**
     * <strong><a href="https://developers.swiftyper.sk/withdrawals">Record a complaint</a></strong>
     *
     * Required parameters: 'name', 'email', 'order_number', 'product' and 'defect'. Optional: 'phone',
     * 'invoice_number', 'serial_number', 'purchased_at' (YYYY-MM-DD), 'requested_resolution'
     * ('repair', 'replacement', 'discount' or 'refund'), 'photos' (up to 5 files given as resources
     * opened with fopen() or \CURLFile instances), 'language', 'ip_address', 'user_agent' and 'source_url'.
     * Every call records a new complaint and sends a confirmation, so do not retry a request that may
     * already have succeeded.
     *
     * @param null|array $params
     * @param null|array|string $opts
     *
     * @throws \Swiftyper\Exception\ApiErrorException if the request fails
     *
     * @return \Swiftyper\SwiftyperObject recorded complaint
     */
    public static function create($params = null, $opts = null)
    {
        static::_validateParams($params);

        list($response, $opts) = static::_staticRequest('post', static::classUrl(), $params, $opts);
        $obj = Util\Util::convertToSwiftyperObject($response->json, $opts);
        $obj->setLastResponse($response);

        return $obj;
    }
}
