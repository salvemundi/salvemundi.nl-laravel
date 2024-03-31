<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\AzureController;
use App\Jobs\AzureSync;
use App\Jobs\DisableAzure;
use App\Jobs\EnableAzure;
use App\Mail\MembershipExpiry;
use App\Models\Commissie;
use App\Models\Inschrijving;
use App\Models\Intro;
use App\Models\IntroData;
use App\Models\Pizza;
use App\Models\Product;
use App\Models\Sponsor;
use App\Models\Sticker;
use App\Models\Transaction;
use App\Models\WhatsappLink;
use App\Models\User;
use App\Models\AdminSetting;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use App\Enums\paymentType;
use App\Enums\paymentStatus;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{

    private AzureController $azureController;
    public function __construct()
    {
        $this->azureController = new AzureController();
    }

    public function index()
    {
        $whatsappLinks = WhatsappLink::all();
        return view('admin/admin',['whatsappLinks' => $whatsappLinks]);
    }
    public function Sync(Request $request)
    {
        $response = array();
        echo $response['status'] = 'success';
        AzureSync::dispatch();
    }
    public function dashboard(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $getAllUsers = User::all()->count();
        $usersWithActiveMembership = $this->getUsersThatHavePaid();
        $activities = Product::where('index', null)
            ->latest() // Order by the default "created_at" timestamp in descending order
            ->limit(4) // Limit the result to 4 records
            ->get();
        $usersInCommittees = $this->countMembersInCommittees();
        $newMembersSinceLastMonth = $this->newMembersSinceLastMonth();
        $latestSticker = Sticker::latest()->first();
        $pizzas = Pizza::all()->count();
        return view('admin/admin',['pizzas'=> $pizzas, 'nextBirthdays' => $this->nextBirthday(),'userCount' => $getAllUsers, 'userCountPaid' => $usersWithActiveMembership,'activities' => $activities, 'membersInCommittees' => $usersInCommittees, 'newMembersSinceLastMonth' => $newMembersSinceLastMonth, 'latestSticker' => $latestSticker]);
    }

    private function nextBirthday(): Collection
    {
        return User::select('*')
            ->selectRaw("DATE_FORMAT(birthday, '%m-%d') as formatted_birthday")
            ->whereRaw("DATE_FORMAT(birthday, '%m-%d') >= ?", [now()->format('m-d')])
            ->whereRaw("DATE_FORMAT(birthday, '%m-%d') <= ?", [now()->addDays(30)->format('m-d')])
            ->orderByRaw("DATE_FORMAT(birthday, '%m-%d') ASC")
            ->orderBy('birthday')
            ->limit(3)
            ->get();
    }
    private function newMembersSinceLastMonth(): int {
        $startDate = Carbon::now()->subMonth(); // Get the date one month ago
        $endDate = Carbon::now(); // Get the current date

        return Inschrijving::whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->latest()
            ->count();
    }
    private function countMembersInCommittees(): int
    {
        $users = User::all();
        $count = 0;
        foreach($users as $user) {
            if($user->commission()->count() > 0) {
                $count += 1;
            }
        }
        return $count;
    }

    private function getUsersThatHavePaid(): int
    {
        $plan = paymentType::fromValue(2);
        $planCommissieLid = paymentType::fromValue(1);
        $name = ucfirst(strval($plan)) . ' membership';
        $nameCommissieLid = ucfirst(strval($planCommissieLid)) . ' membership';
        $count = 0;
        foreach(User::all() as $user)
        {
            if($user->subscribed($name, $plan->key) || $user->subscribed($nameCommissieLid, $planCommissieLid->key))
            {
                $count += 1;
            }
        }
        return $count;
    }

    public function getIntro()
    {
        $allIntro = Intro::orderBy('firstName')->with('payment')->whereHas('payment', function (Builder $query) {
            return $query->where('paymentStatus', PaymentStatus::paid);
        })->get();
        $IntroSetting = AdminSetting::where('settingName','intro')->first();
        $IntroConfirmSetting = AdminSetting::where('settingName','introConfirm')->first();
        $introSignup = IntroData::all();
        $emailsFirstYear = IntroController::sendMailFirstYear();
        $emailsSecondYear = IntroController::sendMailSecondYear();
        $emailNonPaid = IntroController::sendMailNonPaid();
        $emailPaid = IntroController::sendMailPaid();
        $allEmails = IntroController::sendMailToAll();
        //dd($emailsFirstYear, $emailsSecondYear);
        return view('admin/intro', ['allEmails' => $allEmails, 'emailNonPaid' => $emailNonPaid, 'emailPaid' => $emailPaid,'introObjects' => $allIntro,'introSetting' => $IntroSetting,'introConfirmSetting' => $IntroConfirmSetting,'introSignUp' => $introSignup, 'emailsFirstYear' => $emailsFirstYear, 'emailsSecondYear' => $emailsSecondYear]);
    }

    public static function getSponsors()
    {
        return view('admin/sponsors', ['sponsors' => SponsorController::getSponsors()]);
    }

    public function storeIntro(Request $request)
    {
        $adminSetting = AdminSetting::where('settingName', 'intro')->first();
        if($request->input('cbx'))
        {
            $adminSetting->settingValue = 1;
            $message = 'De intro inschrijving staat nu aan';
        } else {
            $adminSetting->settingValue = 0;
            $message = 'De intro inschrijving staat nu uit';
        }
        $adminSetting->save();
        return redirect('/admin/intro')->with('information', $message);
    }

    public function storeIntroConfirm(Request $request) {
        $adminConfirmSetting = AdminSetting::where('settingName', 'introConfirm')->first();
        if($request->input('cdx'))
        {
            $adminConfirmSetting->settingValue = 1;
            $message = 'De intro inschrijving met betaling staat nu aan';
        } else {
            $adminConfirmSetting->settingValue = 0;
            $message = 'De intro inschrijving met betaling staat nu uit';
        }
        $adminConfirmSetting->save();
        return redirect('/admin/intro')->with('information', $message);
    }

    public function indexTransaction(){
        $transaction = Transaction::all();
        return view('admin/transaction', ['transactions' => $transaction]);
    }

    public function groupIndex(Request $request)
    {
        $groupUser = User::find($request->userId);
        $id = $groupUser->id;
        $groupUsers = $groupUser->commission()->get();
        $groups = Commissie::with('users')->whereDoesntHave('users', function($query) use ($id) {
            $query->where('users.id', $id);
        })->get();
        return view('admin/ledenGroups', ['groupUser' => $groupUsers, 'groups' => $groups, 'userName' => $groupUser]);
    }

    public function groupStore(Request $request)
    {
        $groupUser = User::find($request->input('userId'));
        $groupObject = Commissie::find($request->input('groupId'));
        if($this->azureController->addUserToGroup($groupUser, $groupObject))
        {
            $groupUser->commission()->attach($groupObject);
            $groupUser->save();
            return redirect('/admin/leden/'.$groupUser->id.'/groepen')->with('message', 'Lid is toegevoegd aan de commissie');

        }
        else {
            return redirect('/admin/leden/'.$groupUser->id.'/groepen')->with('message', 'Er is iets mis gegaan probeer het opnieuw of meld het de ICT commissie');
        }
    }

    public function groupDelete(Request $request)
    {
        $user = User::find($request->input('userId'));
        $committee = Commissie::find($request->input('groupId'));
        $user->commission()->detach($committee);
        $user->save();
        if($this->azureController->removeUserFromGroup($user, $committee)) {
            return redirect('/admin/leden/'.$user->id.'/groepen')->with('message', 'Lid is verwijderd van de commissie');
        } else {
            return redirect('/admin/leden/'.$user->id.'/groepen')->with('message', 'Er is iets mis gegaan probeer het opnieuw of meld het de ICT commissie');
        }
    }

    public function viewRemoveLeden(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $userCollectionPaid = Collection::make();
        $userCollectionUnPaid = Collection::make();
        $userObjectList = User::all();
        foreach($userObjectList as $userObject)
        {
            $planCommissieLid = paymentType::fromValue(1);
            $plan = paymentType::fromValue(2);
            $name = ucfirst(strval($plan)) . ' membership';
            $nameCommissieLid = ucfirst(strval($planCommissieLid)) . ' membership';
            if($userObject->subscribed($name,$plan->key) || $userObject->subscribed($nameCommissieLid,$planCommissieLid->key))
            {
                $userCollectionPaid->push($userObject);
            } else{
                $userCollectionUnPaid->push($userObject);
            }
        }
        return view('admin/leden',['usersPaid' => $userCollectionPaid, 'usersUnPaid' => $userCollectionUnPaid]);
    }
    public function disableAzureAcc(Request $request) {
        $user = User::find($request->input("id"));
        if($request->input("mode") == "true") {
            AzureController::accountEnabled(true, $user);
        } else{
            AzureController::accountEnabled(false, $user);
        }
        return redirect("/admin/leden");
    }
    public function DisableAllAzureAcc(Request $request){
        $userCollectionPaid = Collection::make();
        $userCollectionUnPaid = Collection::make();
        $userObjectList = User::all();
        foreach($userObjectList as $userObject)
        {
            $planCommissieLid = paymentType::fromValue(1);
            $plan = paymentType::fromValue(2);
            $name = ucfirst(strval($plan)) . ' membership';
            $nameCommissieLid = ucfirst(strval($planCommissieLid)) . ' membership';
            if($userObject->subscribed($name,$plan->key) || $userObject->subscribed($nameCommissieLid,$planCommissieLid->key))
            {
                $userCollectionPaid->push($userObject);
            } else{
                $userCollectionUnPaid->push($userObject);
            }
        }
        if($request->input("mode") == "true"){
            EnableAzure::dispatch($userCollectionUnPaid);
        } else {
            DisableAzure::dispatch($userCollectionUnPaid);
        }
        return redirect('/admin/leden');
    }

    public function sendEmailToUnpaidMembers(): void
    {
        $userCollection = new Collection();
        foreach (User::all() as $user) {
            if(!$user->hasActiveSubscription()) {
                $userCollection->push($user->email);
                if($user->inschrijving !== null) {
                    $userCollection->push($user->inschrijving->email);
                }
            }
        }
        Mail::bcc($userCollection)->send(new MembershipExpiry());
    }
}
