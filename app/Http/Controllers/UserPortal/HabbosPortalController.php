<?php

namespace App\Http\Controllers\UserPortal;

use App\Models\Habbos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HabbosPortalController extends Controller
{
    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|unique:habbos|max:255',
            'domain' => 'required|unique:habbos',
            'description' => 'required',
            'players' => 'required',
            'events_time' => 'required',
            'staff_vacancy' => 'required',
        ]);

        if($validated){
            
            $habbo = new Habbos();
            $habbo->name = $request->input('name');
            $habbo->domain = $request->input('domain');
            $habbo->description = $request->input('description');
            $habbo->players = $request->input('players');
            $habbo->events_time = $request->input('events_time');
            $habbo->staff_vacancy = $request->input('staff_vacancy');
            $habbo->inauguration_date = now();
            $habbo->user_id = Auth::User()->id;
            $habbo->save();

            return redirect()->route('dashboard')->with('success', 'Habbo adicionado com sucesso!');
        }
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'id'  => 'required',
            'name' => 'required|max:255',
            'domain' => 'required',
            'description' => 'required',
            'players' => 'required',
            'events_time' => 'required',
            'staff_vacancy' => 'required',
        ]);

        if($validated){
            $habbo = new Habbos();
            $habbo->where('id', $request->input('id'))->update([
                'name' => $request->input('name'),
                'domain' => $request->input('domain'),
                'description' => $request->input('description'),
                'players' => $request->input('players'),
                'events_time' => $request->input('events_time'),
                'staff_vacancy' => $request->input('staff_vacancy'),
                'inauguration_date' => now()
            ]);

            return redirect()->route('user.dashboard')->with('success', 'Habbo atualizado com sucesso!');
        }
    }
}
