<?php

namespace App\Services;

use App\Models\Login;

class LoginService
{
    public function authenticate($email, $senha)
    {
        try {
            $user = Login::authenticate($email, $senha);

            $userData = json_decode($user, true);
            if (isset($userData['error'])) {
                return json_encode(['status' => 'error', 'message' => $userData['message']]);
            }

            return json_encode([$userData]);

        } catch (\Exception $e) {
            return json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function post($data)
    {
        return $this->authenticate($data['email'], $data['senha']);
    }
}
