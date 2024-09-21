<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function Psy\debug;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::orderBy('id', 'desc')->get();

        return  response()->json([
            'status' => true,
            'users' => $users
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'cpf' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'cep' => 'required',
            'number' => 'required',
            'complement' => 'required',
            'district' => 'required',
            'birthday' => 'required',
            'password' => 'required',
        ]);

        if (User::where('email', $request->email)->exists()) {
            return response()->json([
                'status' => false,
                'message' => 'Email ja existe.'
            ], 409);
        }


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'cpf' => $request->cpf,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'cep' => $request->cep,
            'number' => $request->number,
            'complement' => $request->complement,
            'district' => $request->district,
            'birthday' => $request->birthday,
            'active' => $request->active == 'on' ? 1 : 0,
            'password' => bcrypt($request->password),
        ]);

        return response()->json([
            'status' => true,
            'user' => $user
        ], 201);
    }

    public function show($id)
    {
        $user = User::find($id);
        return response()->json($user, 200);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->update([
            'name' => $request->name,
            //'email' => $request->email,
            'cpf' => $request->cpf,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'cep' => $request->cep,
            'number' => $request->number,
            'complement' => $request->complement,
            'district' => $request->district,
            'birthday' => $request->birthday,
            'active' => $request->active == 'on' ? 1 : 0,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
        ]);

        return response()->json($user, 200);
    }

    public function calculeUserByState()
    {   
        $user = Auth::user();

        $usersByYear = User::selectRaw('YEAR(created_at) as year, COUNT(*) as total')
            ->groupBy('year')
            ->orderBy('year', 'asc')
            ->get();

        // Total de usuários cadastrados
        $totalUsers = User::count();

        // Agrupar usuários por estado, juntar com a tabela de estados e contar
        $usersByState = User::select('state')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('state')
            ->get();

        // Calcular a porcentagem para cada estado
        $percentages = $usersByState->map(function ($stateData) use ($totalUsers) {
            $stateData->percentage = ($stateData->total / $totalUsers) * 100;
            return $stateData;
        });

        // Contar usuários ativos (active = 1)
        $activeUsers = User::where('active', 1)->count();

        // Contar usuários inativos (active = 0)
        $inactiveUsers = User::where('active', 0)->count();

        $valuesChart = [
            'pizza' => $percentages,
            'usersByYear' => $usersByYear,
            'activeUsers' => $activeUsers,
            'inactiveUsers' => $inactiveUsers,
            'user' => $user
        ];

        return view('dashboard', compact('valuesChart'));
    }

    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();
        return response()->json(null, 204);
    }
}
