<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Habbos;
use Illuminate\Http\Request;
use App\Models\HabbosFavorites;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PortalController extends Controller
{
    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */

    public function comprarHabbo()
    {
        return Inertia::render('ComprarHabbo');
    }
    
    public function habbos(Request $request)
    {
        if ($request->filter == 'boosts') {
            $habbos = DB::table('habbos as hab')
            ->select(DB::raw("
                *, (SELECT count(id) from habbo_boosts as hb WHERE hb.habbo_id = hab.id) boosts, 
                (SELECT count(id) from habbos_favorites as hf WHERE hf.habbo_id = hab.id) favorites"))
            ->where('hab.status', '1')
            ->orderBy('boosts', 'desc')
            ->paginate(3);
        } elseif ($request->filter == 'favorite') {
            $habbos = DB::table('habbos as hab')
            ->select(DB::raw("
                *, (SELECT count(id) from habbo_boosts as hb WHERE hb.habbo_id = hab.id) boosts, 
                (SELECT count(id) from habbos_favorites as hf WHERE hf.habbo_id = hab.id) favorites"))
            ->where('hab.status', '1')
            ->orderBy('favorites', 'desc')
            ->paginate(10);
        } elseif ($request->filter == 'inactive') {
            $habbos = DB::table('habbos as hab')
            ->select(DB::raw("
                *, (SELECT count(id) from habbos_favorites as hf WHERE hf.habbo_id = hab.id) favorites"))
            ->where('hab.status', '0')
            ->paginate(10);
        } elseif ($request->filter == 'pending') {
            $habbos = DB::table('habbos as hab')
            ->select(DB::raw("
                *, (SELECT count(id) from habbos_favorites as hf WHERE hf.habbo_id = hab.id) favorites"))
            ->where('hab.status', null)
            ->paginate(10);
        } else {
            $habbos = DB::table('habbos as hab')
            ->select(DB::raw("
                *, (SELECT count(id) from habbo_boosts as hb WHERE hb.habbo_id = hab.id) boosts, 
                (SELECT count(id) from habbos_favorites as hf WHERE hf.habbo_id = hab.id) favorites"))
            ->where('hab.status', '1')
            ->paginate(10);
        }

        return response()->json($habbos, 201);
    }


    public function favoriteHabbo(Request $request)
    {
        try {
            $habbo = HabbosFavorites::where('user_id', $request->user_id)->where('habbo_id', $request->habbo_id)->first();

            if ($habbo) {
                $habbo->delete();
                return response()->json(['status' => 'Habbo removido dos favoritos com sucesso!', 'code' => 201], 201);
            }

            HabbosFavorites::create([
                'user_id' => $request->user_id,
                'habbo_id' => $request->habbo_id,
            ]);

            return response()->json(['status' => 'Habbo Favoritado com sucesso', 'code' => 201], 201);
        } catch(\Exception $e) {
            return response()->json(['status' => $e->getMessage(), 'code' => 500], 500);
        }
    }
}
