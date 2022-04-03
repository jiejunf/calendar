<?php

namespace Jiejunf\Calendar\Components;

use DateTime;
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
    public function __construct(
        string                             $summary,
        protected DateTimeInterface|string $from,
        protected DateTimeInterface|string $to,
        protected bool                     $allDay = false
    ) {
        $this->properties['SUMMARY'] = $summary;
        $this->from = $this->parseTime($from);
        $this->to = $this->parseTime($to);
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

    protected function time(DateTimeInterface $from, DateTimeInterface $to): static
    {
        unset($this->properties['DURATION']);
        $this->properties['DTSTART'] = $this->datetimeProp($from);
        $this->properties['DTEND'] = $this->datetimeProp($to);
        return $this;
    }

    protected function timeAllDay(DateTimeInterface $from, int $days): static
    {
        unset($this->properties['DTEND']);
        $this->properties['DTSTART'] = $this->datetimeProp($from);
        $this->properties['DURATION'] = $days;
        return $this;
    }

    public function description(string $desc): static
    {
        $this->properties['DESCRIPTION'] = Property::text($desc);
        return $this;
    }

    public function createdAt(DateTimeInterface $created_at): static
    {
        $this->properties['DTSTAMP'] = $this->datetimeProp($created_at);
        return $this;
    }

    public function updatedAt(DateTimeInterface $updated_at): static
    {
        $this->properties['LAST-MODIFIED'] = $this->datetimeProp($updated_at);
        return $this;
    }

    public function setAlarm(int $beforeAtMinutes = 0): Alarm
    {
        $alarm = new Alarm($beforeAtMinutes);
        $this->components[] = $alarm;
        return $alarm;
    }

    public function toIcs(): string
    {
        if (!isset($this->properties['UID'])) {
            $this->uid($this->generateUid());
        }
        if ($this->allDay) {
            $this->timeAllDay($this->from, $this->to->diff($this->from)->d + 1);
        } else {
            $this->time($this->from, $this->to);
        }
        return parent::toIcs();
    }

    protected function generateUid(): string
    {
        return md5(sprintf('%s%s%s%s',
                           $this->from->format('YmdHis'),
                           $this->to->format('YmdHis'),
                           $this->properties['SUMMARY'],
                           $this->properties['LOCATION'] ?? 'LOCATION-EMPTY'));
    }

    protected function datetimeProp(DateTimeInterface $datetime): Property
    {
        return Property::datetime($datetime, $this->properties['TZID'] ?? null);
    }

    protected function parseTime(DateTimeInterface|string $time): DateTimeInterface
    {
        return is_string($time) ? new DateTime(date('YmdHis', strtotime($time))) : $time;
    }
}