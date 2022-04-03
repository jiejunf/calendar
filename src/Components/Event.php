<?php

namespace Jiejunf\Calendar\Components;

use DateTimeInterface;
use Jiejunf\Calendar\Calendaring;
use Jiejunf\Calendar\Property;

/**
 * @method $this summary(string $summary)
 * @method $this sequence(int $sequence)
 * @method $this tzId(string $timezone)
 * @method $this uid(string $uid)
 * @method $this class(string $class)
 * @method $this location(string $location)
 * @method $this status(string $status)
 */
class Event extends Calendaring
{

    public function __construct(string $summary, DateTimeInterface $from, DateTimeInterface $to, bool $allDay = false)
    {
        $this->properties['SUMMARY'] = $summary;
        if ($allDay) {
            $days = $to->diff($from)->d;
            $this->timeAllDay($from, $days + 1);
        } else {
            $this->time($from, $to);
        }
    }

    public function url(Property|string $url): static
    {
        if (is_string($url)) {
            $url = Property::url($url);
        }
        $this->properties['URL'] = $url;
        return $this;
    }

    protected function blockName(): string
    {
        return 'VEVENT';
    }

    public function time(DateTimeInterface $from, DateTimeInterface $to)
    {
        unset($this->properties['DURATION']);
        $this->properties['DTSTART'] = Property::datetime($from);
        $this->properties['DTEND'] = Property::datetime($to);
    }

    public function timeAllDay(DateTimeInterface $from, int $days)
    {
        unset($this->properties['DTEND']);
        $this->properties['DTSTART'] = Property::datetime($from);
        $this->properties['DURATION'] = $days;
    }

    public function description(string $desc): static
    {
        $this->properties['DESCRIPTION'] = Property::text($desc);
        return $this;
    }

    public function createdAt(DateTimeInterface $created_at): static
    {
        $this->properties['DTSTAMP'] = Property::datetime($created_at);
        return $this;
    }

    public function updatedAt(DateTimeInterface $updated_at): static
    {
        $this->properties['LAST-MODIFIED'] = Property::datetime($updated_at);
        return $this;
    }
}