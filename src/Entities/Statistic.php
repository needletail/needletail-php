<?php

namespace Needletail\Entities;

use DateTime;
use Needletail\Helpers\BaseEntity;

use function method_exists;
use function ucfirst;

class Statistic extends BaseEntity
{
    public int $count;

    public DateTime $date;

    public int $dayOfWeek;

    public int $hourOfDay;

    public string $value;

    public int $weekNumber;

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @param  string  $count
     * @return Statistic
     */
    public function setCount(string $count): Statistic
    {
        $this->count = (int) $count;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDate(): DateTime
    {
        return $this->date;
    }

    /**
     * @param  string  $date
     * @return Statistic
     */
    public function setDate(string $date): Statistic
    {
        $this->date = DateTime::createFromFormat('Y-m-d', $date);
        return $this;
    }

    /**
     * @return int
     */
    public function getDayOfWeek(): int
    {
        return $this->dayOfWeek;
    }

    /**
     * @param  string  $dayOfWeek
     * @return Statistic
     */
    public function setDayOfWeek(string $dayOfWeek): Statistic
    {
        $this->dayOfWeek = (int) $dayOfWeek;
        return $this;
    }

    /**
     * @return int
     */
    public function getHourOfDay(): int
    {
        return $this->hourOfDay;
    }

    /**
     * @param  string  $hourOfDay
     * @return Statistic
     */
    public function setHourOfDay(string $hourOfDay): Statistic
    {
        $this->hourOfDay = (int) $hourOfDay;
        return $this;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param  string  $value
     * @return Statistic
     */
    public function setValue(string $value): Statistic
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return int
     */
    public function getWeekNumber(): int
    {
        return $this->weekNumber;
    }

    /**
     * @param  string  $weekNumber
     * @return Statistic
     */
    public function setWeekNumber(string $weekNumber): Statistic
    {
        $this->weekNumber = (int) $weekNumber;
        return $this;
    }

    /**
     * @return array[]
     */
    public function toArray()
    {
        $properties = [
            'value', 'date', 'dayOfWeek', 'hourOfDay', 'weekNumber', 'count',
        ];
        $responseArray = [];

        foreach ($properties as $property) {
            $function = 'get'.ucfirst($property);
            if (method_exists($this, $function) && !empty($function())) {
                $responseArray[$property] = $this->$function();
            }
        }

        return $responseArray;
    }
}
