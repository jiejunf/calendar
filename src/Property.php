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
        return new static($datetime->format('Ymd\THis'), empty($timezone) ? [] : [
            'TZID' => $timezone ?? $datetime->getTimezone()->getName(),
        ]);
    }

    public static function text(string $str)
    {
        return new static($str, [
            'CHARSET' => 'utf-8',
        ]);
    }

    public static function attach(string $url, string $file_type)
    {
        return new static(sprintf('FMTTYPE=%s:%s', $file_type, $url));
    }

    public function __toString(): string
    {
        $param = [];
        foreach ($this->params as $name => $value) {
            $param[] = sprintf(';%s=%s', $name, addcslashes($value, "\n"));
        }
        $param = implode('', $param);
        return sprintf('%s:%s', $param, addcslashes($this->data, "\n"));
    }
}