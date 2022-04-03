## Install
```shell
composer require jiejunf/calendar
```
## Example
```php
        $calendar = new Calendar();
        $calendar->name('吉诺儿 Kino 直播日历');
        $calendar->color(sprintf('#%x%x%x', 225, 179, 224));
        $calendar->setTimezone('Asia/Shanghai')->parseStandard();
        $calendar->setEvent('[3D]mini party', '20220401190000', '202204012130')
                 ->uid(md5('20220401190000'))
                 ->description('[3D]mini party')
                 ->url('https://live.bilibili.com/23221095')
                 ->location('https://live.bilibili.com/23221095')
                 ->tap(fn(Event $event) => $event->setAlarm())
                 ->tap(fn(Event $event) => $event->setAlarm(10))
                 ->tap(fn(Event $event) => $event->setAlarm(15));
        // strtotime
        date_default_timezone_set('Asia/Shanghai');
        $calendar->setEvent('[2D]有一个直播', '+1 minutes', '+5 minutes')
                 ->uid(md5('+1 minutes'))
                 ->setAlarm()
                 ->action('AUDIO')
                 ->description('??:??')
                 ->attach(Property::attach('https://aliyun-01.emmmmm.top/dingdong.mp3', 'audio/mpeg'));
        $calendar->setEvent('[3D]舞蹈100连', new \DateTime('202204081800'), new \DateTime('202204082000'))
                 ->uid(md5('舞蹈 100 连'))
                 ->description(<<<DESC
马上就要挑战舞蹈 100 连啦!
加油!
DESC
                 )
                 ->setAlarm();
        $ics = $calendar->toIcs();
        echo $ics;
```