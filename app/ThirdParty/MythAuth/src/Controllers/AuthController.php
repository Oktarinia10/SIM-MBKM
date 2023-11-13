<?php

namespace Myth\Auth\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Session\Session;
use Myth\Auth\Config\Auth as AuthConfig;
use Myth\Auth\Entities\User;
use Myth\Auth\Models\UserModel;
use Myth\Auth\Models\GroupModel;

class AuthController extends Controller
{
    /**
     * Analysis assist; remove after CodeIgniter 4.3 release.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    protected $auth;

    /**
     * @var AuthConfig
     */
    protected $config;

    /**
     * @var Session
     */
    protected $session;

    /**
     * Constructor
     */
    public function __construct()
    {
        // Most services in this controller require
        // the session to be started - so fire it up!
        $this->session = service('session');

        $this->config = config('Auth');
        $this->auth = service('authentication');
    }

    // --------------------------------------------------------------------
    // Login/out
    // --------------------------------------------------------------------
    /**
     * Displays the login form, or redirects
     * the user to their destination/home if
     * they are already logged in.
     *
     * @return RedirectResponse|string
     */
    public function login()
    {
        /* Cek user sudah login atau belum */
        if ($this->auth->check()) {
            $redirectURL = session('redirect_url') ?? base_url('dashboard');
            unset($_SESSION['redirect_url']);

            return redirect()
                ->to($redirectURL);
        }

        /* Tetapkan URL pengembalian jika tidak ada yang ditentukan */
        $_SESSION['redirect_url'] = session('redirect_url') ?? previous_url();

        /* Menampilkan tampilan login */
        return $this->_render($this->config->views['login'], ['config' => $this->config]);
    }

    /**
     * Attempts to verify the user's credentials
     * through a POST request.
     *
     * @return RedirectResponse
     */
    public function attemptLogin()
    {
        $rules = [
            'login' => 'required',
            'password' => 'required',
        ];
        if ($this->config->validFields === ['email']) {
            $rules['login'] .= '|valid_email';
        }

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $login = $this->request->getPost('login');
        $password = $this->request->getPost('password');
        $remember = (bool) $this->request->getPost('remember');

        // Determine credential type
        $type = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Try to log them in...
        if (!$this->auth->attempt([$type => $login, 'password' => $password], $remember)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', $this->auth->error() ?? lang('Auth.badAttempt'));
        }

        // Is the user being forced to reset their password?
        if ($this->auth->user()->force_pass_reset === true) {
            $url = route_to('reset-password') . '?token=' . $this->auth->user()->reset_hash;

            return redirect()
                ->to($url)
                ->withCookies();
        }

        $groups = model(GroupModel::class)->getGroupsForUser($this->auth->user()->id);
        $is_admin = false;
        $is_pimpinan = false;
        $is_laboran = false;
        $is_mitra = false;
        $is_koor_kmm = false;
        $is_koor_mbkm = false;
        foreach ($groups as $group) {
            if ($group['name'] == 'admin') {
                $is_admin = true;
                break;
            }else if ($group['name'] == 'pimpinan') {
                $is_pimpinan = true;
                break;
            } else if ($group['name'] == 'laboran'){
                $is_laboran = true;
                break;
            } else if ($group['name'] == 'mitra') {
                $is_mitra = true;
                break;
            } else if ($group['name'] == 'koor-kmm') {
                $is_koor_kmm = true;
                break;
            } else if ($group['name'] == 'koor-mbkm') {
                $is_koor_mbkm = true;
                break;
            }
        }

        if ($is_admin) {
            return redirect()
                ->to(base_url('admin/dashboard'))
                ->withCookies()
                ->with('message', lang('Auth.loginSuccess'));
        }else if ($is_pimpinan) {
            return redirect()
                ->to(base_url('sipema'))
                ->withCookies()
                ->with('message', lang('Auth.loginSuccess'));
        } else if ($is_laboran){
            return redirect()
            ->to(base_url('simlab'))
            ->withCookies()
            ->with('message', lang('Auth.loginSuccess'));
        } elseif ($is_mitra) {
            return redirect()
            ->to(base_url('mitra/dashboard'))
            ->withCookies()
            ->with('message', lang('Auth.loginSuccess'));
        } elseif ($is_koor_kmm) {
            return redirect()
            ->to(base_url('kmm'))
            ->withCookies()
            ->with('message', lang('Auth.loginSuccess'));
        } elseif ($is_koor_mbkm) {
            return redirect()
            ->to(base_url('mbkm'))
            ->withCookies()
            ->with('message', lang('Auth.loginSuccess'));
        } else {
            return redirect()
                ->to(base_url('sistem_informasi'))
                ->withCookies()
                ->with('message', lang('Auth.loginSuccess'));
        }
        
        // return dd($user);

        // return redirect()
        //     ->to(base_url('sistem_informasi'))
        //     ->withCookies()
        //     ->with('message', lang('Auth.loginSuccess'));

        // $redirectURL = session('redirect_url') ?? base_url('/lowongan_kerja');
        // unset($_SESSION['redirect_url']);    
    }

    /**
     * Log the user out.
     *
     * @return RedirectResponse
     */
    public function logout()
    {
        if ($this->auth->check()) {
            $this->auth->logout();
        }

        return redirect()->to(base_url('/'));
    }

    // --------------------------------------------------------------------
    // Register
    // --------------------------------------------------------------------
    /**
     * Displays the user registration page.
     *
     * @return RedirectResponse|string
     */
    public function register()
    {
        // check if already logged in.
        if ($this->auth->check()) {
            return redirect()->back();
        }

        // Check if registration is allowed
        if (!$this->config->allowRegistration) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', lang('Auth.registerDisabled'));
        }

        return $this->_render($this->config->views['register'], ['config' => $this->config]);
    }

    /**
     * Attempt to register a new user.
     *
     * @return RedirectResponse
     */
    public function attemptRegister()
    {
        // Check if registration is allowed
        if (!$this->config->allowRegistration) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', lang('Auth.registerDisabled'));
        }

        $users = model(UserModel::class);

        // Validate basics first since some password rules rely on these fields
        $rules = config('Validation')->registrationRules ?? [
            'username' => 'required|alpha_numeric_space|min_length[3]|max_length[30]|is_unique[users.username]',
            'email' => 'required|valid_email|is_unique[users.email]',
        ];

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // Validate passwords since they can only be validated properly here
        $rules = [
            'password' => 'required|strong_password',
            'pass_confirm' => 'required|matches[password]',
        ];

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // Save the user
        $allowedPostFields = array_merge(['password'], $this->config->validFields, $this->config->personalFields);
        $user = new User($this->request->getPost($allowedPostFields));

        $this->config->requireActivation === null ? $user->activate() : $user->generateActivateHash();

        // Ensure default group gets assigned if set
        if (!empty($this->config->defaultUserGroup)) {
            $users = $users->withGroup($this->config->defaultUserGroup);
        }

        if (!$users->save($user)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $users->errors());
        }

        if ($this->config->requireActivation !== null) {
            $activator = service('activator');
            $sent = $activator->send($user);

            if (!$sent) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', $activator->error() ?? lang('Auth.unknownError'));
            }

            // Success!
            return redirect()
                ->route('login')
                ->with('message', lang('Auth.activationSuccess'));
        }

        // Success!
        return redirect()
            ->route('login')
            ->with('message', lang('Auth.registerSuccess'));
    }

    // --------------------------------------------------------------------
    // Forgot Password
    // --------------------------------------------------------------------
    /**
     * Displays the forgot password form.
     *
     * @return RedirectResponse|string
     */
    public function forgotPassword()
    {
        if ($this->config->activeResetter === null) {
            return redirect()
                ->route('login')
                ->with('error', lang('Auth.forgotDisabled'));
        }

        return $this->_render($this->config->views['forgot'], ['config' => $this->config]);
    }

    /**
     * Attempts to find a user account with that password
     * and send password reset instructions to them.
     *
     * @return RedirectResponse
     */
    public function attemptForgot()
    {
        if ($this->config->activeResetter === null) {
            return redirect()
                ->route('login')
                ->with('error', lang('Auth.forgotDisabled'));
        }

        $rules = [
            'email' => [
                'label' => lang('Auth.emailAddress'),
                'rules' => 'required|valid_email',
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $users = model(UserModel::class);

        $user = $users->where('email', $this->request->getPost('email'))->first();

        if (null === $user) {
            return redirect()
                ->back()
                ->with('error', lang('Auth.forgotNoUser'));
        }

        // Save the reset hash /
        $user->generateResetHash();
        $users->save($user);

        $resetter = service('resetter');
        $sent = $resetter->send($user);

        if (!$sent) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', $resetter->error() ?? lang('Auth.unknownError'));
        }

        return redirect()
            ->route('reset-password')
            ->with('message', lang('Auth.forgotEmailSent'));
    }

    /**
     * Displays the Reset Password form.
     *
     * @return RedirectResponse|string
     */
    public function resetPassword()
    {
        if ($this->config->activeResetter === null) {
            return redirect()
                ->route('login')
                ->with('error', lang('Auth.forgotDisabled'));
        }

        $token = $this->request->getGet('token');

        return $this->_render($this->config->views['reset'], [
            'config' => $this->config,
            'token' => $token,
        ]);
    }

    /**
     * Verifies the code with the email and saves the new password,
     * if they all pass validation.
     *
     * @return RedirectResponse
     */
    public function attemptReset()
    {
        if ($this->config->activeResetter === null) {
            return redirect()
                ->route('login')
                ->with('error', lang('Auth.forgotDisabled'));
        }

        $users = model(UserModel::class);

        // First things first - log the reset attempt.
        $users->logResetAttempt(
            $this->request->getPost('email'),
            $this->request->getPost('token'),
            $this->request->getIPAddress(),
            (string) $this->request->getUserAgent()
        );

        $rules = [
            'token' => 'required',
            'email' => 'required|valid_email',
            'password' => 'required|strong_password',
            'pass_confirm' => 'required|matches[password]',
        ];

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $user = $users->where('email', $this->request->getPost('email'))
            ->where('reset_hash', $this->request->getPost('token'))
            ->first();

        if (null === $user) {
            return redirect()
                ->back()
                ->with('error', lang('Auth.forgotNoUser'));
        }

        // Reset token still valid?
        if (!empty($user->reset_expires) && time() > $user->reset_expires->getTimestamp()) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', lang('Auth.resetTokenExpired'));
        }

        // Success! Save the new password, and cleanup the reset hash.
        $user->password = $this->request->getPost('password');
        $user->reset_hash = null;
        $user->reset_at = date('Y-m-d H:i:s');
        $user->reset_expires = null;
        $user->force_pass_reset = false;
        $users->save($user);

        return redirect()
            ->route('login')
            ->with('message', lang('Auth.resetSuccess'));
    }

    /**
     * Activate account.
     *
     * @return mixed
     */
    public function activateAccount()
    {
        $users = model(UserModel::class);

        // First things first - log the activation attempt.
        $users->logActivationAttempt(
            $this->request->getGet('token'),
            $this->request->getIPAddress(),
            (string) $this->request->getUserAgent()
        );

        $throttler = service('throttler');

        if ($throttler->check(md5($this->request->getIPAddress()), 2, MINUTE) === false) {
            return service('response')
                ->setStatusCode(429)
                ->setBody(lang('Auth.tooManyRequests', [$throttler->getTokentime()]));
        }

        $user = $users->where('activate_hash', $this->request->getGet('token'))
            ->where('active', 0)
            ->first();

        if (null === $user) {
            return redirect()
                ->route('login')
                ->with('error', lang('Auth.activationNoUser'));
        }

        $user->activate();

        $users->save($user);

        return redirect()
            ->route('login')
            ->with('message', lang('Auth.registerSuccess'));
    }

    /**
     * Resend activation account.
     *
     * @return mixed
     */
    public function resendActivateAccount()
    {
        if ($this->config->requireActivation === null) {
            return redirect()
                ->route('login');
        }

        $throttler = service('throttler');

        if ($throttler->check(md5($this->request->getIPAddress()), 2, MINUTE) === false) {
            return service('response')
                ->setStatusCode(429)
                ->setBody(lang('Auth.tooManyRequests', [$throttler->getTokentime()]));
        }

        $login = urldecode($this->request->getGet('login'));
        $type = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $users = model(UserModel::class);

        $user = $users->where($type, $login)
            ->where('active', 0)
            ->first();

        if (null === $user) {
            return redirect()
                ->route('login')
                ->with('error', lang('Auth.activationNoUser'));
        }

        $activator = service('activator');
        $sent = $activator->send($user);

        if (!$sent) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', $activator->error() ?? lang('Auth.unknownError'));
        }

        // Success!
        return redirect()
            ->route('login')
            ->with('message', lang('Auth.activationSuccess'));
    }

    /**
     * Render the view.
     *
     * @return string
     */
    protected function _render(string $view, array $data = [])
    {
        return view($view, $data);
    }
}