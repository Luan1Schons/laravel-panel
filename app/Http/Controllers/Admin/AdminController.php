<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Inertia\Inertia;
use App\Models\Habbos;
use App\Models\User;
use App\Models\ChatBans;
use App\Models\HabboBoosts;
use Illuminate\Http\Request;
use App\Models\MessagesReport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return Inertia::render('Admin/Dashboard');
    }

    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function portal()
    {
        return Inertia::render('Admin/Portal');
    }

    public function manageHabbo()
    {
        return Inertia::render('Admin/Habbos');
    }

    public function createHabbo()
    {
        return Inertia::render('Admin/CreateHabbo');
    }

    public function manageChat()
    {
        $reportData = MessagesReport::with('user', 'userReported', 'message')->whereHas('message')->get();
        $banData = ChatBans::with('user', 'bannedUser')->groupBy('user_id', 'banned_by')->get();
        return Inertia::render('Admin/Chat', [
            'reportData' => $reportData,
            'banData'    => $banData
        ]);
    }

    public function manageUsers()
    {
        $usersData = User::with('roles')->get();
        return Inertia::render('Admin/Users', [
            'usersData' => $usersData,
        ]);
    }

    public function deleteReport(Request $request)
    {
        $reportData = MessagesReport::where('id', $request->reportId)->delete();
        $validated = $request->validate([
            'reportId' => 'required'
        ]);

        return redirect()->back();
    }

    public function banUser(Request $request)
    {
        $user = Auth::user();
            ChatBans::create([
                'banned_by' => $user->id,
                'user_id' => $request->input('userId')
            ]);

        $reportData = MessagesReport::where('user_reported_id', $request->input('userId'))->delete();
        return redirect()->back();
    }

    public function unbanUser(Request $request)
    {
        $user = Auth::user();
        $unban = ChatBans::where('user_id', $request->input('userId'))->delete();
        $reportData = MessagesReport::where('user_reported_id', $request->input('userId'))->delete();
        return redirect()->back();
    }

    public function editHabbo(Request $request)
    {
        $habboData = Habbos::find($request->id);
        return Inertia::render('Admin/EditHabbo', ['habboData' => $habboData]);
    }

    public function updateHabbo(Request $request)
    {
        $habboData = Habbos::find($request->id);
        if (!empty($habboData)) {
            $validated = $request->validate([
                'name' => 'required|max:255',
                'domain' => 'required',
                'description' => 'required',
                'players' => 'required',
                'events_time' => 'required',
                'status' => 'required',
                'staff_vacancy' => 'required',
            ]);

            $habbo = new Habbos();
            $habbo->where('id', $request->input('id'))->update([
                'name' => $request->input('name'),
                'domain' => $request->input('domain'),
                'description' => $request->input('description'),
                'players' => $request->input('players'),
                'events_time' => $request->input('events_time'),
                'staff_vacancy' => $request->input('staff_vacancy'),
                'status' => $request->input('status'),
                'inauguration_date' => now()
            ]);

            return redirect()->back();
        }
    }

    public function addBoosts(Request $request)
    {
        try {
            $habboData = Habbos::find($request->id);
            if (!empty($habboData)) {
                $validated = $request->validate([
                    'id' => 'required',
                    'qtdBoosts' => 'required|min:0|max:100',
                ]);

                $habbo = new HabboBoosts();
                $boosts = (int)$request->input('qtdBoosts');
                while ($boosts > 0) {
                    $habbo->create([
                        'user_id' => $habboData->user_id,
                        'habbo_id' => $habboData->id,
                    ]);
                    $boosts--;
                }
                return response()->json(['status' => 'Boosts adicionados com sucesso!', 'code' => 201]);
            }else{
                return response()->json(['status' => 'Habbo não encontrado.', 'code' => 500]);
            }
        }catch(Exception $e){
            return response()->json(['status' => 'Ocorreu um erro ao adicionar os boosts!', 'exception' => $e->getMessage(), 'code' => 500]);
        }
    }
}
