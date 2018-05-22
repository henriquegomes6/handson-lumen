<?php

namespace App\Http\Controllers;

use Validator;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $userRepository;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function listUsers()
    {
        try {
            return response()->json(
                $this->userRepository->listUsers()
            );
        } catch (\Exception $e) {
            return response()->json('Erro!!', 500);
        }
    }

    public function getUserById(int $id)
    {
        // try {
            return response()->json(
                $this->userRepository->getUserById($id)
            );
        // } catch (\Exception $e) {
        //     return response()->json('Erro!!', 500);
        // }
    }

    public function insertUser(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|max:255',
                'pass' => 'required|min:4',
                'name' => 'required|min:4',
            ]);

            if ($validator->fails()) {
                throw new \Exception();
            }

            return response()->json(
                $this->userRepository->insertUser($request->email, $request->pass, $request->name)
            );
        } catch (\Exception $e) {
            return response()->json($validator->messages()->toArray(), 500);
        }
    }

    public function updateUser()
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|max:255',
                'pass' => 'required|min:4',
                'name' => 'required|min:4',
            ]);
            if ($validator->fails()) {
                throw new \Exception();
            }
            return response()->json(
                $this->userRepository->updateUser()
            );
        } catch (\Exception $e) {
            return response()->json($validator->messages()->toArray(), 500);
        }
    }

    public function deleteUser()
    {
        try {
            return response()->json();
        } catch (\Exception $e) {
            return response()->json('Erro!!', 500);
        }
    }
}
