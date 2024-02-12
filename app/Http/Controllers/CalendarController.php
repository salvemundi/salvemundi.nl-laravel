<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\IcalItem;
use App\Models\Product;
use DateTime;
use Exception;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Spatie\IcalendarGenerator\Components\Calendar;
use Spatie\IcalendarGenerator\Components\Event;

class CalendarController extends Controller
{
    public function index(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $products = Product::where('startDate', "!=", null)->get();
        return view('agenda',['activities' => $products]);
    }

    /**
     * @throws Exception
     */
    public function generateICal(): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $calendar = Calendar::create('Salve Mundi')->refreshInterval(5);

        // Add events to the calendar
        $events = Product::where('startDate', "!=", null)->get();
        $events = $events->merge(IcalItem::all());
        foreach ($events as $event) {
            $calendar->event($this->createICalEvent($event));
        }
        $cal = $this->removeTzidUtc($calendar->get());

        return response($cal)
            ->header('Content-Type', 'text/calendar');
    }

    private function removeTzidUtc(string $icalData): string
    {
        // Define the pattern for the TZID:UTC block
        $explode = explode("\n", $icalData);
        foreach($explode as $index => $value) {
            if(str_contains($value,'TZID:UTC')){
                unset($explode[$index]);
                unset($explode[$index - 1]);
                unset($explode[$index + 1]);
                unset($explode[$index + 2]);
                unset($explode[$index + 3]);
                unset($explode[$index + 4]);
                unset($explode[$index + 5]);
                unset($explode[$index + 6]);
            }
        }
        return implode("\n",$explode);
    }

    /**
     * @throws Exception
     */
    private function createICalEvent(Model $eventData): Event
    {
        return Event::create()
            ->name($eventData->title ?: $eventData->name)
            ->description(preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n",$eventData->description))
            ->startsAt(new DateTime($eventData->startDate,new \DateTimeZone('Europe/Amsterdam')))
            ->endsAt(new DateTime($eventData->endDate,new \DateTimeZone('Europe/Amsterdam')));
    }

    public function admin(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $items = IcalItem::all();
        return view('admin.calendar',['items' => $items]);
    }

    public function adminEdit(Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $item = IcalItem::find($request->id);
        return view('admin.calendarEdit',['item' => $item]);
    }

    /**
     * @throws Exception
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title'        => 'required',
            'start'       => 'required',
            'end' => 'required',
        ]);

        $ical = IcalItem::firstOrNew(['id' => $request->id]);
        $ical->title = $request->input('title');
        $ical->description = $request->input('description');
        $ical->startDate = $request->input('start') ? new DateTime($request->input('start'), new \DateTimeZone('Europe/Amsterdam')) : null;
        $ical->endDate = $request->input('end') ? new DateTime($request->input('end'), new \DateTimeZone('Europe/Amsterdam')) : null;
        $ical->save();
        return  redirect('/admin/calendar')->with('success','Kalender item is opgeslagen!');
    }

    public function delete(Request $request): RedirectResponse
    {
        $ical = IcalItem::find($request->id);
        if($ical == null) {
            return back()->with('error','Item is niet gevonden');
        }
        $ical->delete();
        return back()->with('success','Kalender item is verwijderd');
    }
}
