<?php
 
namespace App\Http\Controllers;
 
use App\Models\User;
use Inertia\Inertia;
use App\Models\Habbos;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
 
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
        $userService = Auth::User()->with('habbos')->first();
        return Inertia::render('Dashboard', [
            'habboData' => $userService->habbos,
        ]);
    }

     /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function manage()
    {
        $userService = Auth::User()->with('habbos')->first();
        return Inertia::render('Dashboard', [
            'habboData' => $userService->habbos,
        ]);
    }

    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function filemanager()
    {
        $userService = Auth::User()->with('habbos')->first();
        return Inertia::render('Filemanager', [
            'habboData' => $userService->habbos,
        ]);
    }

    public function file_manager()
    {
        $userService = Auth::User()->with('habbos')->first();
        return view('vendor/file-manager/ckeditor');
    }
    
    
}
