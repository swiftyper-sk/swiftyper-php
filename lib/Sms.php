<?php

namespace Swiftyper;

/**
 * <strong><a href="https://developers.swiftyper.sk/sms">Swiftyper SMS API</a></strong>
 *
 * Sends text messages through an Android phone with the Swiftyper SMS app connected to your project.
 * The phone sends them from its own number and SIM card and reports whether they were sent and delivered.
 * Requires the API key of an SMS gateway project.
 *
 * @property string $id Unique identifier of the message (UUID)
 * @property string $to Recipient's phone number in international format, e.g. '+421905123456'
 * @property string $status 'queued', 'sending', 'sent', 'delivered', 'undelivered', 'expired', 'failed' or 'cancelled'
 * @property null|int $error_code Android error code when sending failed
 * @property null|string $device ID of the phone that took the message, or of the phone chosen with 'device' while it waits
 * @property string $created_at Time the message was accepted (ISO 8601)
 * @property null|string $send_at Time a scheduled message will be sent (ISO 8601)
 * @property null|string $sent_at Time the phone sent the message (ISO 8601)
 * @property null|string $delivered_at Time the network confirmed delivery (ISO 8601)
 */
class Sms extends ApiResource
{
    const OBJECT_NAME = 'sms';

    /**
     * <strong><a href="https://developers.swiftyper.sk/sms#odoslanie-spravy">Send a message</a></strong>
     *
     * Required parameters: 'to' and 'text' (up to 1600 characters). Optional: 'country' (ISO 3166-1
     * alpha-2 code used to read a national number, 'SK' by default), 'send_at' (ISO 8601 time,
     * up to 14 days ahead) to schedule the message and 'device' (ID of a phone from devices()) to send
     * it from that phone only; without it the phone seen most recently sends it. The message is queued
     * and its result is reported later, read it with retrieve().
     *
     * @param null|array $params
     * @param null|array|string $opts
     *
     * @throws \Swiftyper\Exception\ApiErrorException if the request fails
     *
     * @return \Swiftyper\SwiftyperObject queued message
     */
    public static function send($params = null, $opts = null)
    {
        static::_validateParams($params);

        return static::_post(static::classUrl() . '/send', $params, $opts);
    }

    /**
     * <strong><a href="https://developers.swiftyper.sk/sms#zoznam-telefonov">List connected phones</a></strong>
     *
     * Phones connected to the project, the one seen most recently first. Each has 'id' (pass it as
     * 'device' to send()), 'name', 'model', 'online' (seen in the last 30 minutes), 'push' (false when it
     * only checks for messages every 15 minutes), 'daily_limit', 'remaining_today' (null = no limit),
     * 'last_seen_at' and 'created_at'.
     *
     * @param null|array|string $opts
     *
     * @throws \Swiftyper\Exception\ApiErrorException if the request fails
     *
     * @return \Swiftyper\Collection<\Swiftyper\SwiftyperObject> connected phones
     */
    public static function devices($opts = null)
    {
        return static::_post(static::classUrl() . '/devices', null, $opts);
    }

    /**
     * <strong><a href="https://developers.swiftyper.sk/sms#stav-spravy">Retrieve a message</a></strong>
     *
     * @param string $id
     * @param null|array|string $opts
     *
     * @throws \Swiftyper\Exception\ApiErrorException if the request fails
     *
     * @return \Swiftyper\SwiftyperObject message with its current status
     */
    public static function retrieve($id, $opts = null)
    {
        return static::_post(static::resourceUrl($id), null, $opts);
    }

    /**
     * <strong><a href="https://developers.swiftyper.sk/sms#opatovne-odoslanie">Send a failed message again</a></strong>
     *
     * Only messages with the status 'failed', 'undelivered' or 'expired' sent in the last 7 days.
     *
     * @param string $id
     * @param null|array|string $opts
     *
     * @throws \Swiftyper\Exception\ApiErrorException if the request fails
     *
     * @return \Swiftyper\SwiftyperObject queued message
     */
    public static function retry($id, $opts = null)
    {
        return static::_post(static::resourceUrl($id) . '/retry', null, $opts);
    }

    /**
     * <strong><a href="https://developers.swiftyper.sk/sms#zrusenie-spravy">Cancel a waiting message</a></strong>
     *
     * Only messages with the status 'queued', typically scheduled ones.
     *
     * @param string $id
     * @param null|array|string $opts
     *
     * @throws \Swiftyper\Exception\ApiErrorException if the request fails
     *
     * @return \Swiftyper\SwiftyperObject cancelled message
     */
    public static function cancel($id, $opts = null)
    {
        return static::_post(static::resourceUrl($id) . '/cancel', null, $opts);
    }

    private static function _post($url, $params, $opts)
    {
        list($response, $opts) = static::_staticRequest('post', $url, $params, $opts);
        $obj = Util\Util::convertToSwiftyperObject($response->json, $opts);
        $obj->setLastResponse($response);

        return $obj;
    }
}
