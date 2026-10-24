<?php
namespace App\Security;

use App\Service\Universidad\UniversidadAuthInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\CustomCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;

final class UniversidadAuthenticator extends AbstractAuthenticator implements AuthenticationEntryPointInterface
{
    public function __construct(private UniversidadAuthInterface $universidad) {}

    public function supports(Request $request): ?bool
    {
        return $request->getPathInfo() === '/api/auth/login' && $request->isMethod('POST');
    }

    public function authenticate(Request $request): Passport
    {
        $d = json_decode($request->getContent(), true) ?? [];
        $documento = trim((string) ($d['documento'] ?? ''));
        $password  = (string) ($d['password'] ?? '');

        if ($documento === '' || $password === '') {
            throw new CustomUserMessageAuthenticationException('Documento y contraseña son obligatorios.');
        }

        return new Passport(
            new UserBadge($documento),
            new CustomCredentials(
                fn (string $pass, UserInterface $user) => $this->universidad->verificar($user->getUserIdentifier(), $pass),
                $password
            )
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null; // sigue al controlador, que responde usuario + menú
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): Response
    {
        return new JsonResponse(['error' => 'credenciales_invalidas', 'mensaje' => 'Documento o contraseña incorrectos.'], 401);
    }

    public function start(Request $request, ?AuthenticationException $authException = null): Response
    {
        return new JsonResponse(['error' => 'no_autenticado', 'mensaje' => 'Inicia sesión.'], 401);
    }
}
