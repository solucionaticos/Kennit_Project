<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Contracts\JsonResponseServiceInterface;
use App\Contracts\UserRepositoryInterface;

class UserController extends Controller
{
    private $jsonResponseService;
    private $userRepository;

    public function __construct(JsonResponseServiceInterface $jsonResponseService, UserRepositoryInterface $userRepository)
    {
        $this->jsonResponseService = $jsonResponseService;
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $users = $this->userRepository->all();
        return $this->jsonResponseService->success($users);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8'
        ]);

        $validatedData['password'] = bcrypt($validatedData['password']);

        $user = $this->userRepository->create($validatedData);
        return $this->jsonResponseService->success($user, 'User created successfully', 201);
    }
}
