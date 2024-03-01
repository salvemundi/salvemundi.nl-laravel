<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\PizzaLocations;
use App\Enums\PizzaSizes;
use App\Models\Pizza;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PizzaController extends Controller
{
    public function index() {
        return view('pizza', ['pizzas' => Pizza::all()]);
    }

    public function store(Request $request) {

        $request->validate([
            'name'        => ['required', 'max:65', 'regex:/^[a-zA-Z á é í ó ú ý Á É Í Ó Ú Ý ç Ç â ê î ô û Â Ê Î Ô Û à è ì ò ù À È Ì Ò Ù ä ë ï ö ü ÿ Ä Ë Ï Ö Ü Ÿ ã õ ñ Ã Õ Ñ , 0-9]+$/'],
            'type'       => ['required','max:65', 'regex:/^[a-zA-Z á é í ó ú ý Á É Í Ó Ú Ý ç Ç â ê î ô û Â Ê Î Ô Û à è ì ò ù À È Ì Ò Ù ä ë ï ö ü ÿ Ä Ë Ï Ö Ü Ÿ ã õ ñ Ã Õ Ñ , 0-9+$/'],
            'description' => ['nullable', 'max:215', 'regex:/^[a-zA-Z á é í ó ú ý Á É Í Ó Ú Ý ç Ç â ê î ô û Â Ê Î Ô Û à è ì ò ù À È Ì Ò Ù ä ë ï ö ü ÿ Ä Ë Ï Ö Ü Ÿ ã õ ñ Ã Õ Ñ , 0-9]+$/'],
            'size'       => ['required','max:65', 'regex:/(^[0-9]+$)+/'],
            'location'       => ['required','max:65', 'regex:/(^[0-9]+$)+/'],
        ]);
        try {
            $pizza = new Pizza();
            $pizza->name = $request->input('name');
            $pizza->type = $request->input('type');
            $pizza->description = $request->input('description');
            $pizza->size = PizzaSizes::fromValue((int)$request->input('size'));
            $pizza->location = PizzaLocations::fromValue((int)$request->input('location'));
            $pizza->user()->associate(Auth::user())->save();

            return back()->with('success', 'Je bestelling is opgenomen!');
        } catch(\Exception $e) {
            return back()->with('error', 'Formulier niet goed ingevuld!');
        }
    }

    public function deleteAllPizzas() {
        Pizza::whereNotNull('id')->delete();
        return back()->with('success','Alle pizza bestellingen zijn verwijderd');
    }

    public function deleteOwnPizza(Request $request) {
        $user = Auth::user();
        $pizza = Pizza::find($request->id);
        if($pizza->user->id == $user->id || $user->isAdmin()) {
            $pizza->delete();
            return back()->with('success','Bestelling is verwijderd!');
        }
        return back()->with('error','Je kan alleen je eigen bestelling verwijderen!');
    }
}
