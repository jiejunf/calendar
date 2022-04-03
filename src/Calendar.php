<?php

namespace Jiejunf\Calendar;


use DateTimeInterface;
use Jiejunf\Calendar\Components\Event;
use Jiejunf\Calendar\Components\Timezone;

/**
 * @method $this version(float $version = 2.0)
 * @method $this method(string $method = 'PUBLIC')
 * @method $this class(string $class = 'PUBLIC')
 * @method $this calScale(string $calScale = 'GREGORIAN')
 */
class Calendar extends Calendaring
{
    protected array $properties = [
        'VERSION'  => '2.0',
        'METHOD'   => 'PUBLIC',
        'CLASS'    => 'PUBLIC',
        'CALSCALE' => 'GREGORIAN',
    ];
    protected string $timezone;

    public function name(string $name): static
    {
        $this->properties['X-WR-CALNAME'] = $name;
        return $this;
    }

    public function color(string $color): static
    {
        $this->properties['X-APPLE-CALENDAR-COLOR'] = $color;
        return $this;
    }

    protected function blockName(): string
    {
        return "VCALENDAR";
    }

    public function setTimezone(string $timezone): Timezone
    {
        $timezoneComponent = new Timezone($timezone);
        $this->timezone = $timezone;
        $this->components['timezone'] = $timezoneComponent;
        return $timezoneComponent;
    }

    public function setEvent(
        string                   $summary,
        DateTimeInterface|string $from,
        DateTimeInterface|string $to,
        bool                     $allDays = false
    ): Event {
        $event = new Event($summary, $from, $to, $allDays);
        $this->components[] = $event;
        return $event;
    }

    public function setEventAllDay(string $summary, DateTimeInterface|string $from, DateTimeInterface|string $to): Event
    {
        return $this->setEvent($summary, $from, $to, true);
    }
}