<?php

namespace Jiejunf\Calendar\Components;

use DateTimeZone;
use Jiejunf\Calendar\Calendaring;

/**
 * @method $this tzId(string $tz)
 * @method $this tzUrl(string $url)
 */
class Timezone extends Calendaring
{
    public function __construct(string $timezone)
    {
        $this->properties['TZID'] = $timezone;
        if (str_contains($timezone, '/')) {
            $this->properties['TZURL'] = 'http://tzurl.org/zoneinfo-outlook/' . $timezone;
            $this->properties['X-LIC-LOCATION'] = $timezone;
        }
    }

    public function location(string $location = 'Asia/Shanghai'): static
    {
        $this->properties['X-LIC-LOCATION'] = $location;
        return $this;
    }

    protected function blockName(): string
    {
        return 'VTIMEZONE';
    }

    public function parseStandard(): Standard
    {
        $timezone = new DateTimeZone($this->properties['TZID']);
        $now = time();
        $transition = current($timezone->getTransitions($now, $now));
        $offset = date('+Hi', $transition['offset']);
        $abbr = $transition['abbr'];
        $standard = new Standard($offset, $offset, $abbr);
        $this->components['standard'] = $standard;
        return $standard;
    }
}