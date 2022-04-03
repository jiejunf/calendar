<?php

namespace Jiejunf\Calendar;

use DateTimeInterface;

class Property
{
    public function __construct(protected string $data, protected array $params = []) { }

    public static function url(string $url): static
    {
        return new static($url, ['VALUE' => 'uri']);
    }

    public static function datetime(DateTimeInterface $datetime, string $timezone = null): static
    {
        return new static($datetime->format('Ymd\This'), [
            'TZID' => $timezone ?? $datetime->getTimezone()->getName(),
        ]);
    }

    public static function text(string $str)
    {
        return new static($str, [
            'CHARSET' => 'utf-8',
        ]);
    }

    public function __toString(): string
    {
        $param = [];
        foreach ($this->params as $name => $value) {
            $param[] = sprintf('%s=%s', $name, $value);
        }
        $param = implode(';', $param);
        return sprintf('%s:%s', $param, $this->data);
    }
}