<?php

namespace Jiejunf\Calendar;

use Closure;

abstract class Calendaring implements IcsComponent
{

    protected array $components = [];
    protected array $properties = [];

    public function __call(string $name, array $arguments)
    {
        $this->properties[strtoupper($name)] = current($arguments);
        return $this;
    }

    public function with(IcsComponent $component): static
    {
        $this->components[] = $component;
        return $this;
    }

    public function toIcs(): string
    {
        $ics = [];
        foreach ($this->properties as $name => $property) {
            if ($property instanceof Property) {
                $ics[] = sprintf('%s%s', $name, $property);
            } else {
                $ics[] = sprintf('%s:%s', $name, addcslashes($property,"\n"));
            }
        }
        foreach ($this->components as $component) {
            $ics[] = $component->toIcs();
        }
        $ics = implode("\n", $ics);
        $blockName = $this->blockName();
        return <<<ICS
BEGIN:$blockName
$ics
END:$blockName
ICS;
    }

    abstract protected function blockName(): string;

    public function tap(Closure $callback): static
    {
        call_user_func_array($callback, [$this]);
        return $this;
    }
}