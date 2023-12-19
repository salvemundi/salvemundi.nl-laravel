<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Spatie\IcalendarGenerator\Components\Calendar;

class CalendarController extends Controller
{
    public function generateICal()
    {
        $calendar = Calendar::create('Your Calendar');

        // Add events to the calendar
        $events = Product::all();

        foreach ($events as $event) {
            $calendar->event($this->createICalEvent($event));
        }

        return response($calendar->get())
            ->header('Content-Type', 'text/calendar');
    }

    private function createICalEvent($eventData)
    {
        // Create and return an iCalendar event using Spatie\IcalendarGenerator
        // Refer to the library's documentation for details

        return Event::create()
            ->name($eventData->name)
            ->description($eventData->description)
            ->startsAt($eventData['start_date'])
            ->endsAt($eventData['end_date']);
    }
}
