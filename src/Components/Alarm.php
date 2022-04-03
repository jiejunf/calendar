<?php

namespace Jiejunf\Calendar\Components;

use Jiejunf\Calendar\Calendaring;
use Jiejunf\Calendar\Property;

/**
 * @method $this action(string $action)
 * @method $this description(string $desc)
 * @method $this trigger(string $trigger)
 * @method $this attach(Property $attach)
 */
class Alarm extends Calendaring
{
    protected array $properties = [
        'ACTION' => 'AUDIO',
    ];

    public function __construct(string $trigger)
    {
        if (is_numeric($trigger)) {
            $this->beforeAtMinutes(intval($trigger));
        } else {
            $this->properties['TRIGGER'] = $trigger;
        }
    }

    public function beforeAtMinutes(int $minutes): static
    {
        $this->properties['TRIGGER'] = "-PT${minutes}M";
        return $this;
    }

    protected function blockName(): string
    {
        return 'VALARM';
    }
}