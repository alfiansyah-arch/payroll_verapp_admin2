<?php
  
namespace App\Http\Controllers\Auth;
  
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Models\User;
use App\Models\RoleStatus;
use App\Models\AccountStatus;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

  
class AuthController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index(): View
    {
        return view('auth.login');
    }  
      
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function registration(): View
    {
        $role_status_name = RoleStatus::All();
        $account_status_name = AccountStatus::All();
        return view('auth.registration', compact('role_status_name', 'account_status_name'));
    }
      
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postLogin(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken("API_TOKEN");

            session(['accessToken' => $token->plainTextToken]);

            return redirect()->intended('dashboard')
                ->withSuccess('You have Successfully loggedin with token');
        }

        return redirect("login")->withSuccess('Oops! You have entered invalid credentials');
    }

    public function __invoke(Request $request)
    {
        Auth::logout();
        
        return redirect('login');
    }

      
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postRegistration(Request $request): RedirectResponse
    {  
        // dd($request);
        $request->validate([
            'username' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role_name' => 'required|in:Super Admin, Admin, Employee',
        ]);
           
        $data = $request->all();
        // dd($data);
        $check = $this->create($data);
         
        return redirect("dashboard")->withSuccess('Great! You have Successfully loggedin');
    }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function dashboard(Request $request)
    {
        if(Auth::check()){
            $avatar = $request->user()->avatar;
            $title = "Dashboard Admin";
            return view('dashboard', compact('title','avatar'));
        }
        return redirect("login")->withSuccess('Opps! You do not have access');
    }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function create(array $data)
    {
      return User::create([
        'user_id' => $data['user_id'],
        'username' => $data['username'],
        'email' => $data['email'],
        'join_date' => $data['join_date'],
        'role_name' => $data['role_name'],
        'avatar' => $data['avatar'],
        'department' => $data['department'],
        'position' => $data['position'],
        'status' => $data['status'],
        'password' => Hash::make($data['password']),
        'role_name' =>$data['role_name']
      ]);
    }

    public function handleLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|username',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::where("username", $request->username)->first();
        if (empty($user)) {
            return response(["message" => 'Email Not Found'], 400);
        }

        if (empty($user) || !Hash::check($request->password, $user->password)) {
             return response()->json(['error' => 'Unauthorized'], 401);
        }

        // if (empty($user->email_verified_at)) {
        //     return response([
        //         "message" => "Important: Account Access Pending Email Verification. Please note that your account login is currently restricted until you verify your email address. To activate your account and access all the features, it's essential to complete the email verification process."
        //     ], 400);
        // }

        $token = $user->createToken("API_TOKEN");
        $user = $user->toArray();
        return response([
            "user" => $user,
            "accessToken" => $token->plainTextToken,
        ]);
    }

    public function handleRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:Super Admin, Admin, Employee',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        DB::beginTransaction();
        try {
            $user = User::create([                
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_name' => $request->role,
            ]);

            DB::commit();
            return response([
                "message" => "User registered successfully"
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response($th);
        }
    }

    public function handleGetMe(Request $request)
    {
        $user = User::find($request->user()->id);

        return response([
            "user" => $user,
            "abilities" => $user->abilities
        ]);
    }
}