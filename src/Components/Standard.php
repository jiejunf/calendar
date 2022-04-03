<?php

namespace Jiejunf\Calendar\Components;

use Jiejunf\Calendar\Calendaring;

/**
 * @method $this tzOffsetFrom(string $from) = '+0800'
 * @method $this tzOffsetTo(string $to) = '+0800'
 * @method $this tzName(string $name) = 'CST'
 * @method $this dtStart(string $dt) = '19700101T000000'
 */
class Standard extends Calendaring
{
    public function __construct($from, $to, $name, $start)
    {
        $this->properties = [
            'TZOFFSETFROM' => $from,
            'TZOFFSETTO'   => $to,
            'TZNAME'       => $name,
            'DTSTART'      => $start,
        ];
    }

    protected function blockName(): string
    {
        return 'STANDARD';
    }
}