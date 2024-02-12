<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WhatsappLink;

class WhatsAppController extends Controller
{
    public function index(){
        $whatsappLinks = WhatsappLink::all();
        $discordLink = DiscordController::getLink();
        return view('admin/whatsapp',['whatsappLinks' => $whatsappLinks,'discordLink' => $discordLink]);
    }

    public function addWhatsappLinks(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:32', 'regex:/^[^(|\\]~@0-9!%^&*=};:?><’)]*$/'],
            'link' => 'required',
            'description' => 'required'
        ]);

        $products = new WhatsappLink;
        $products->name = $request->input('name');
        $products->link = $request->input('link');
        $products->description = $request->input('description');
        $products->save();

        return redirect('admin/whatsapp')->with('message', 'WhatsApp link gemaakt');
    }

    public function deleteWhatsappLinks(Request $request)
    {
        if($request->id != null) {
            $tobeDeleted = WhatsappLink::find($request->id);
            $tobeDeleted->delete();

            return redirect('admin/whatsapp')->with('information', 'Link verwijderd');
        } else {
            return redirect('admin/whatsapp');
        }
    }
}
