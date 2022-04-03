<?php

namespace Jiejunf\Calendar;


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
}