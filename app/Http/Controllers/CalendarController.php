<?php

namespace App\Http\Controllers;

use App\Models\Product;
use DateTime;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\IcalendarGenerator\Components\Calendar;
use Spatie\IcalendarGenerator\Components\Event;
use Spatie\IcalendarGenerator\Components\Timezone;
use Spatie\IcalendarGenerator\Components\TimezoneEntry;
use Spatie\IcalendarGenerator\Enums\TimezoneEntryType;

class CalendarController extends Controller
{
    public function generateICal(): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $calendar = Calendar::create('Salve Mundi');

        // Add events to the calendar
        $events = Product::where('startDate', "!=", null)->get();

        foreach ($events as $event) {
            $calendar->event($this->createICalEvent($event));
        }

        return response($calendar->get())
            ->header('Content-Type', 'text/calendar');
    }

    private function createICalEvent(Product $eventData): Event
    {
        // Create and return an iCalendar event using Spatie\IcalendarGenerator
        // Refer to the library's documentation for details
        return Event::create()
            ->name($eventData->name)
            ->description($eventData->description)
            ->startsAt(new DateTime($eventData->startDate,new \DateTimeZone('Europe/Amsterdam')))
            ->endsAt(new DateTime($eventData->endDate,new \DateTimeZone('Europe/Amsterdam')));
    }
}
