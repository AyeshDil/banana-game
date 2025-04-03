<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function login() {
        return view('auth.login');
    }


    /**
     * Handle an incoming authentication request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function loginProcess(Request $request) 
    {
        $validatedData = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        
        // Find user using email or username
        $user = User::where('email', $validatedData['email'])->orWhere('username', $validatedData['email'])->first();

        // Set credentials
        $credentials = [
            'email' => $user->email,
            'password' => $validatedData['password'],
        ];

        // Check if user exists
        if (!$user) {
            return redirect()->route('login')->with('error', 'User not found');
        }

        // Check if password is correct
        if (Auth::attempt($credentials)) {
            // Redirect to dashboard
            return redirect()->route('dashboard')->with('success', 'Login successfully');

        } else {

            // Redirect to login
            return redirect()->route('login')->with('error', 'Invalid credentials');
        }

    }

    public function logout(Request $request) 
    {
        Auth::logout();

        return redirect()->route('login')->with('success', 'Logout successfully');    
    }


    /**
     * Display the registration view.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function register() {
        return view('auth.register');
    }


    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function registerProcess(Request $request) 
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'username' => 'required|unique:users,username',
            'contact' => 'required',
            'password' => 'required',
        ]);

        // Hash password
        $validatedData['password'] = Hash::make($validatedData['password']);

        // Generate 4 digit otp
        $otp = rand(1000, 9999);

        $validatedData['otp'] = $otp;
        $validatedData['contact'] = $this->formatContact($request->contact);

        // Send otp
        $isSend = $this->sendOtp($validatedData['contact'], $otp);

        if (!$isSend) {
            return redirect()->route('register')->with('error', 'Failed to send OTP');
        }
        
        // Create user
        $user = User::create($validatedData);

        // Redirect to otp
        return redirect()->route('otp', ['user' => $user]);
    }


    /**
     * Display the OTP verification view.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Contracts\View\View
     */
    public function otp(User $user) {
        return view('auth.otp', compact('user'));
    }


    /**
     * Handle an incoming OTP verification request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verifyProcess(Request $request)
    {
        $validatedData = $request->validate([
            'otp1' => 'required',
            'otp2' => 'required',
            'otp3' => 'required',
            'otp4' => 'required',
            'email' => 'required|email',
        ]);

        // Set otp
        $otp = $validatedData['otp1'] . $validatedData['otp2'] . $validatedData['otp3'] . $validatedData['otp4'];

        // Find user
        $user = User::where('email', $validatedData['email'])->first();

        // Check if user exists
        if (!$user) {
            return redirect()->route('login')->with('error', 'User not found');
        }

        // Check if otp is correct
        if ($user->otp != $otp) {
            return redirect()->route('otp')->with('error', 'Invalid OTP');
        }

        // Verify otp
        $user->otp_verified = true;
        
        // Save user
        $user->save();

        return redirect()->route('login')->with('success', 'OTP verified successfully');
    }





    /**
     * Sends an OTP to a user.
     * 
     * @param string $contact The phone number or email of the user.
     * @param string $otp The OTP to be sent.
     * 
     * @return bool True if the OTP was sent successfully, otherwise false.
     */
    private function sendOtp($contact, $otp) 
    {
        $endpoint =  env('OTP_ENDPOINT');
        $method = env('OTP_METHOD');
        $user_id = env('OTP_USER_ID');
        $api_key = env('OTP_API_KEY');
        $sender_id = env('OTP_SENDER_ID');
        $to = $contact;
        $message = 'OTP(One Time Password) for Banana Game. Your OTP is ' . $otp;

        try {

            // Build query
            $query = http_build_query([
                'user_id' => $user_id,
                'api_key' => $api_key,
                'sender_id' => $sender_id,
                'to' => $to,
                'message' => $message,
            ]);
            
            // Send request
            $ch = curl_init($endpoint . '?' . $query);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
            
            $response = curl_exec($ch);
            curl_close($ch);

            if ($response == true) {
                return true;
            }
        
            return false;

        } catch (\Exception $e) {
            return false;
        }
    }


    /**
     * Formats a contact number by removing the leading '+' or '0' and adding the country code '94'.
     * 
     * @param string $contact The contact number to be formatted.
     * 
     * @return string The formatted contact number.
     */
    private function formatContact($contact) 
    {
        // Remove the leading '+' if it exists.
        if (substr($contact, 0, 1) == '+') {
            $contact = substr($contact, 1);
        }

        // Replace the leading '0' with the country code '94' if it exists.
        if (substr($contact, 0, 1) == '0') {
            $contact = substr($contact, 1);
            $contact = '94' . $contact;

        }

        // Return the formatted contact number.
        return $contact;

    }
}
