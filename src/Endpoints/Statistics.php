<?php

namespace Needletail\Endpoints;

use DateTime;
use GuzzleHttp\Exception\GuzzleException;
use Needletail\Entities\Bucket;
use Needletail\Entities\Statistic;
use Needletail\Exceptions\NeedletailException;
use Needletail\Helpers\BaseEndpoint;

use function is_null;

class Statistics extends BaseEndpoint
{
    /**
     * @var Bucket|null
     */
    public Bucket $bucket;

    /**
     * @var string
     */
    protected string $endPoint;

    /**
     * Alternatives constructor.
     *
     * @param  string  $apiKey
     * @param  Bucket|null  $bucket
     */
    public function __construct(string $apiKey, Bucket $bucket = null)
    {
        parent::__construct($apiKey);

        $this->bucket = $bucket;
    }

    /**
     * @param  DateTime|null  $from
     * @param  DateTime|null  $to
     * @return Statistic
     * @throws GuzzleException
     * @throws NeedletailException
     */
    public function dailyOperationsPerDay(DateTime $from = null, DateTime $to = null): Statistic
    {
        return $this->find('analytics/daily-operations/per-day', $from, $to, false);
    }

    /**
     * @param  string  $endpoint
     * @param  DateTime|null  $from
     * @param  DateTime|null  $to
     * @param  bool  $bucketSpecific
     * @return Statistic
     * @throws GuzzleException
     * @throws NeedletailException
     */
    protected function find(
        string $endpoint,
        DateTime $from = null,
        DateTime $to = null,
        bool $bucketSpecific = true
    ): Statistic {
        $this->endPoint = $endpoint;

        $id = '';
        if (!is_null($from)) {
            $id .= $from->format('Y-m-d');

            if (!is_null($to)) {
                $id .= $to->format('Y-m-d');

                if (!empty($this->bucket) && $bucketSpecific) {
                    $id .= '/'.$this->bucket->getName();
                }
            }
        }
        $response = $this->get($id);
        $data = $this->toObject($response);

        return $this->toEntity($data);
    }

    /**
     * @param  object  $item
     * @return Statistic
     */
    protected function toEntity(object $item): Statistic
    {
        $statistic = (new Statistic())
            ->setApiKey($this->apiKey);

        foreach ($item as $key => $value) {
            $function = 'set'.str_replace('_', '', ucwords($key, '_'));
            if (method_exists($statistic, $function)) {
                $statistic->$function($value);
            }
        }

        return $statistic;
    }

    /**
     * @param  DateTime|null  $from
     * @param  DateTime|null  $to
     * @return Statistic
     * @throws GuzzleException
     * @throws NeedletailException
     */
    public function dailyOperationsPerHour(DateTime $from = null, DateTime $to = null): Statistic
    {
        return $this->find('analytics/daily-operations/per-hour', $from, $to, false);
    }

    /**
     * @param  DateTime|null  $from
     * @param  DateTime|null  $to
     * @return Statistic
     * @throws GuzzleException
     * @throws NeedletailException
     */
    public function dailyOperationsPerWeek(DateTime $from = null, DateTime $to = null): Statistic
    {
        return $this->find('analytics/daily-operations/per-week', $from, $to, false);
    }

    /**
     * @param  DateTime|null  $from
     * @param  DateTime|null  $to
     * @return Statistic
     * @throws GuzzleException
     * @throws NeedletailException
     */
    public function noResultQueries(DateTime $from = null, DateTime $to = null): Statistic
    {
        return $this->find('analytics/no-result-queries', $from, $to);
    }

    /**
     * @param  DateTime|null  $from
     * @param  DateTime|null  $to
     * @return Statistic
     * @throws GuzzleException
     * @throws NeedletailException
     */
    public function popularAggregationFilters(DateTime $from = null, DateTime $to = null): Statistic
    {
        return $this->find('analytics/popular-aggregation-filters', $from, $to);
    }

    /**
     * @param  DateTime|null  $from
     * @param  DateTime|null  $to
     * @return Statistic
     * @throws GuzzleException
     * @throws NeedletailException
     */
    public function popularAggregationValues(DateTime $from = null, DateTime $to = null): Statistic
    {
        return $this->find('analytics/popular-aggregation-values', $from, $to);
    }

    /**
     * @param  DateTime|null  $from
     * @param  DateTime|null  $to
     * @return Statistic
     * @throws GuzzleException
     * @throws NeedletailException
     */
    public function popularSearches(DateTime $from = null, DateTime $to = null): Statistic
    {
        return $this->find('analytics/popular-searches', $from, $to);
    }

    /**
     * @return string
     */
    protected function getEndpoint(): string
    {
        return $this->endPoint;
    }
}
