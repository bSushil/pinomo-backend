<?php
declare(strict_types=1);

namespace Core\Packages\ForgotPassword;

use Core\ValueObject\EmailAddress;
use Illuminate\Support\Facades\Password;

class PasswordReset
{
    /**
     * sendPassword.
     *
     * @param  EmailAddress $email
     * @return bool
     */
    public function sendPassword(EmailAddress $email)
    {
        $response = Password::broker()->sendResetLink(['email' => $email->get()]);

        if ($response === 'passwords.sent') {
            return true;
        }

        return false;
    }

    /**
     * Reset Password.
     *
     * @param  array $data
     * @return bool
     */
    public function resetPassword(array $data)
    {
        $response = Password::broker()->reset(
            $data, function ($user, $password) {
                $user->password = $password;
                $user->save();
            }
        );

        if ($response === 'passwords.reset') {
            return true;
        }

        return false;
    }

}