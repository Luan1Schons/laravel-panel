<?php
 
namespace App\Http\Controllers\UserPortal;
 
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
 
class DashboardController extends Controller
{
    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function index()
    {

        $habbos = DB::table('habbos as hab')
        ->where('user_id', Auth::user()->id)
        ->select(DB::raw("*, (SELECT count(id) from habbo_boosts as hb WHERE hb.habbo_id = hab.id) boosts"))
        ->orderBy('boosts', 'desc')
        ->paginate(3);

        //$habbos = Habbos::where('user_id', Auth::User()->id)->first();
        return Inertia::render('Portal/Dashboard', [
            'habboData' => $habbos,
        ]);

    }
    
}
