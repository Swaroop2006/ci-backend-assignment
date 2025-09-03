<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Config\Services;

class JWTAuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $header = $request->getHeaderLine('Authorization');
        if (!$header || !preg_match('/Bearer\s(\S+)/', $header, $matches)) {
            return Services::response()->setJSON(['error' => 'Missing or invalid Authorization header'])->setStatusCode(401);
        }

        $token = $matches[1];
        $secret = env('JWT_SECRET');

        try {
            $decoded = JWT::decode($token, new Key($secret, 'HS256'));
            // make decoded available for controllers if needed
            $request->user = (array)$decoded;
        } catch (\Throwable $e) {
            return Services::response()->setJSON(['error' => 'Invalid/expired token', 'detail' => $e->getMessage()])->setStatusCode(401);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // no-op
    }
}
