<?php

namespace Jiejunf\Calendar\Components;

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
}