<?php
/**
 * Snipcart plugin for Craft CMS 3.x
 *
 * @link      https://workingconcept.com
 * @copyright Copyright (c) 2018 Working Concept Inc.
 */

namespace workingconcept\snipcart\base;

use workingconcept\snipcart\models\Order as SnipcartOrder;
use workingconcept\snipcart\models\Package;
use craft\base\Component;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Craft;

class ShippingProvider extends Component implements ShippingProviderInterface
{
    /**
     * @var array Settings specifically for this provider.
     * @todo consider making these validated models
     */
    protected $providerSettings;

    /**
     * @var Client Guzzle client instance.
     */
    protected $client;


    // Static Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public static function refHandle()
    {
        return '';
    }

    /**
     * @inheritdoc
     */
    public static function getApiBaseUrl(): string
    {
        return '';
    }


    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function isConfigured(): bool
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    public function getRatesForOrder(SnipcartOrder $snipcartOrder, Package $package): array
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function createOrder(SnipcartOrder $snipcartOrder)
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getClient(): Client
    {
        return new Client();
    }

    /**
     * @inheritdoc
     */
    public function getOrderById($providerId)
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getOrderBySnipcartInvoice(string $snipcartInvoice)
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function createShippingLabelForOrder(SnipcartOrder $snipcartOrder)
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function get(string $endpoint, array $params = [])
    {
        if (count($params) > 0)
        {
            $endpoint .= '?' . http_build_query($params);
        }

        try
        {
            $response = $this->getClient()->get($endpoint);
            return $this->prepResponseData(
                $response->getBody()
            );
        }
        catch(RequestException $exception)
        {
            $this->handleRequestException($exception, $endpoint);
            return null;
        }
    }

    /**
     * @inheritdoc
     */
    public function post(string $endpoint, array $data = [])
    {
        try
        {
            $response = $this->getClient()->post($endpoint, [
                \GuzzleHttp\RequestOptions::JSON => $data
            ]);

            return $this->prepResponseData($response->getBody());
        }
        catch (RequestException $exception)
        {
            $this->handleRequestException($exception, $endpoint);
            return null;
        }
    }

    /**
     * Extract the value from a specific custom field, if it exists.
     *
     * @param array|null $customFields Custom fields data from Snipcart,
     *                                 an array of objects
     * @param string     $fieldName    Name of the field as seen in the order.
     * @param bool       $emptyAsNull  Return null rather than an empty value.
     *                                 (defaults to false)
     *
     * @return string|null
     */
    public function getValueFromCustomFields($customFields, $fieldName, $emptyAsNull = false)
    {
        if ( ! is_array($customFields))
        {
            return null;
        }

        foreach ($customFields as $customField)
        {
            if ($customField->name === $fieldName)
            {
                if ($emptyAsNull && empty($customField->value))
                {
                    return null;
                }

                return $customField->value;
            }
        }

        return null;
    }

    /**
     * Take the raw response body and give it back as data that's ready to use.
     *
     * @param mixed  $body The raw response from the REST API.
     * @return mixed Appropriate PHP type, or null if json cannot be decoded
     *               or encoded data is deeper than the recursion limit.
     */
    public function prepResponseData($body)
    {
        return json_decode($body, false);
    }

    /**
     * Handle a failed request.
     *
     * @param RequestException  $exception  the exception that was thrown
     * @param string            $endpoint   the endpoint that was queried
     *
     * @return null
     */
    public function handleRequestException(
        $exception,
        string $endpoint
    )
    {
        /**
         * Get the status code, which should be 200 or 201 if things went well.
         */
        $statusCode = $exception->getResponse()->getStatusCode() ?? null;

        /**
         * If there's a response we'll use its body, otherwise default
         * to the request URI.
         */
        $reason = $exception->getResponse()->getBody() ?? null;

        if ($statusCode !== null && $reason !== null)
        {
            // return code and message
            Craft::warning(sprintf(
                '%s API responded with %d: %s',
                self::displayName(),
                $statusCode,
                $reason
            ), 'snipcart');
        }
        else
        {
            // report mystery
            Craft::warning(sprintf(
                '%s API request to %s failed.',
                self::displayName(),
                $endpoint
            ), 'snipcart');
        }

        return null;
    }

}
