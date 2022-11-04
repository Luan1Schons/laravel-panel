<?php
 
namespace App\Http\Controllers;
 
use App\Models\User;
use App\Models\Habbos;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
 
class HabboActionsController extends Controller
{
    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function emuladorStop()
    {
        $process = new Process(['wsl', '-e', 'bash', '-c', "cd /home/nitro-docker;just stop-all"]);
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            //throw new ProcessFailedException($process);
            return response()->json(['status' => 0, 'message' => 'Ocorreu um erro ao parar o emulador.']);
        }

        try {
            $process->mustRun();
            return response()->json(['status' => 1, 'message' => 'Emulador parado com sucesso!']);
        } catch (ProcessFailedException $exception) {
            return response()->json(['status' => 0, 'message' => 'Ocorreu um erro ao parar o emulador.']);
        }
    }

    public function emuladorStart()
    {
        $process = new Process(['wsl', '-e', 'bash', '-c', "cd /home/nitro-docker;just start-arcturus"]);
        $process->run();
        
        // executes after the command finishes
        if (!$process->isSuccessful()) {
            //throw new ProcessFailedException($process);
            return response()->json(['status' => 0, 'message' => 'Emulador desligado ou ocorreu um erro ao iniciar o emulador.']);
        }

        try {
            $process->mustRun();
            return response()->json(['status' => 1, 'message' => 'Emulador iniciado com sucesso!']);
        } catch (ProcessFailedException $exception) {
            return response()->json(['status' => 0, 'message' => 'Ocorreu um erro ao iniciar o emulador.']);
        }
    }

    public function emuladorRestart()
    {
        $process = new Process(['wsl', '-e', 'bash', '-c', "cd /home/nitro-docker;just restart-arcturus"]);
        $process->run();
        
        // executes after the command finishes
        if (!$process->isSuccessful()) {
            //throw new ProcessFailedException($process);
            return response()->json(['status' => 0, 'message' => 'Ocorreu um erro ao reiniciar o emulador.']);
        }

        try {
            $process->mustRun();
            return response()->json(['status' => 1, 'message' => 'Emulador reiniciado com sucesso!']);
        } catch (ProcessFailedException $exception) {
            return response()->json(['status' => 0, 'message' => 'Ocorreu um erro ao reiniciar o emulador.']);
        }
    }

    public function emuladorRecompile()
    {
        $process = new Process(['wsl', '-e', 'bash', '-c', "cd /home/nitro-docker;just recompile-arcturus"]);
        $process->run();
        
        // executes after the command finishes
        if (!$process->isSuccessful()) {
            //throw new ProcessFailedException($process);
            return response()->json(['status' => 0, 'message' => 'Ocorreu um erro ao recompilar o emulador.']);
        }

        try {
            $process->mustRun();
            return response()->json(['status' => 1, 'message' => 'Emulador recompilado com sucesso!']);
        } catch (ProcessFailedException $exception) {
            return response()->json(['status' => 0, 'message' => 'Ocorreu um erro ao recompilar o emulador.']);
        }
    }

    public function emuladorLog()
    {
        $process = new Process(['wsl', '-e', 'bash', '-c', "cd /home/nitro-docker;just watch-arcturus-last-log"]);
        $process->run();
        
        // executes after the command finishes
        if (!$process->isSuccessful()) {
            //throw new ProcessFailedException($process);
            return response()->json(['status' => 0, 'message' => 'Ocorreu um erro ao recompilar o emulador.']);
        }

        try {
            $process->mustRun();
            return response()->json(['status' => 1, 'message' => $process->getOutput()]);
        } catch (ProcessFailedException $exception) {
            return response()->json(['status' => 0, 'message' => 'Ocorreu um erro ao recompilar o emulador.']);
        }
    }

    public function instanceStart()
    {
        $userModel = Auth::User()->with('habbos')->first();

        $process = new Process(['wsl', '-e', 'bash', '-c', "cd /home/nitro-docker;just start-all"]);
        $process->run();
        // executes after the command finishes
        if (!$process->isSuccessful()) {
            //throw new ProcessFailedException($process);
            return response()->json(['status' => 0, 'message' => 'Ocorreu um erro ao iniciar a instância.']);
        }
        try {
            $process->mustRun();
            $habbosModel = Habbos::where('user_id', $userModel->id)->update(['instance_status' => 'online']);
            return response()->json(['status' => 1, 'message' => 'Instância iniciada com sucesso.']);
        } catch (ProcessFailedException $exception) {
            return response()->json(['status' => 0, 'message' => 'Ocorreu um erro ao iniciar a instância.']);
        }
    }

    public function instanceStop()
    {
        $userModel = Auth::User()->with('habbos')->first();

        $process = new Process(['wsl', '-e', 'bash', '-c', "cd /home/nitro-docker;just stop-all"]);
        $process->run();
        // executes after the command finishes
        if (!$process->isSuccessful()) {
            //throw new ProcessFailedException($process);
            return response()->json(['status' => 0, 'message' => 'Ocorreu um erro ao parar a instância.']);
        }
        try {
            $process->mustRun();
            $habbosModel = Habbos::where('user_id', $userModel->id)->update(['instance_status' => 'offline']);
            return response()->json(['status' => 1, 'message' => 'Instância parada com sucesso.']);
        } catch (ProcessFailedException $exception) {
            return response()->json(['status' => 0, 'message' => 'Ocorreu um erro ao parar a instância.']);
        }
    }

    public function listContainers()
    {
        $process = new Process(['wsl', '-e', 'bash', '-c', "cd /home/nitro-docker;docker container ls --format='{{json .}}'"]);
        $process->run();
        
        // executes after the command finishes
        if (!$process->isSuccessful()) {
            //throw new ProcessFailedException($process);
            return response()->json(['status' => 0, 'message' => 'Ocorreu um erro ao listar os containers.']);
        }

        try {
            $process->mustRun();
            $processData = preg_split('/\r\n|\r|\n/', $process->getOutput());
            $processData = array_filter($processData);

            return response()->json(['status' => 1, 'message' => $processData]);
        } catch (ProcessFailedException $exception) {
            return response()->json(['status' => 0, 'message' => 'Ocorreu um erro ao listar os containers.']);
        }
    }
    

}