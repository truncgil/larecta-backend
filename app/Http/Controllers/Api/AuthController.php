<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Yeni bir kullanıcı kaydı oluşturur.
     * 
     * @param Request $request Kayıt için gerekli bilgileri içeren istek nesnesi
     * @return \Illuminate\Http\JsonResponse
     * 
     * @throws \Exception Kayıt işlemi sırasında oluşabilecek hatalar
     */
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Doğrulama hatası',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'status' => true,
                'message' => 'Kullanıcı başarıyla oluşturuldu',
                'data' => $user,
                'token' => $token
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Bir hata oluştu',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Kullanıcı girişi yapar ve token oluşturur.
     * 
     * @param Request $request Giriş bilgilerini içeren istek nesnesi
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Doğrulama hatası',
                'errors' => $validator->errors()
            ], 422);
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'status' => false,
                'message' => 'Email veya şifre hatalı'
            ], 401);
        }

        $user = Auth::user(); // Kullanıcıyı Auth ile alıyoruz
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Giriş başarılı',
            'data' => $user,
            'token' => $token
        ], 200);
    }

    /**
     * Kullanıcının çıkış yapmasını sağlar ve tüm tokenları siler.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $user = Auth::user(); // Kullanıcıyı Auth ile alıyoruz
        $user->tokens()->delete();
        
        return response()->json([
            'status' => true,
            'message' => 'Çıkış başarılı'
        ], 200);
    }

    /**
     * Giriş yapmış kullanıcının bilgilerini getirir.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function user()
    {
        $user = Auth::user();
        
        return response()->json([
            'status' => true,
            'message' => 'Kullanıcı bilgileri başarıyla getirildi',
            'data' => $user
        ], 200);
    }

    /**
     * Kullanıcı profilini günceller.
     * 
     * @param Request $request Güncellenecek profil bilgilerini içeren istek nesnesi
     * @return \Illuminate\Http\JsonResponse
     * 
     * @throws \Exception Güncelleme işlemi sırasında oluşabilecek hatalar
     */
    public function updateProfile(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'sometimes|string|max:255',
                'email' => 'sometimes|string|email|max:255|unique:users,email,' . auth()->id(),
                'password' => 'sometimes|string|min:8|confirmed',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Doğrulama hatası',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = auth()->user();
            $updateData = $request->only(['name', 'email']);
            
            if ($request->filled('password')) {
                $updateData['password'] = Hash::make($request->password);
            }
            
            $user->update($updateData);
            
            return response()->json([
                'status' => true,
                'message' => 'Profil başarıyla güncellendi',
                'data' => $user
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Profil güncellenirken bir hata oluştu',
                'error' => $e->getMessage()
            ], 500);
        }
    }
} 