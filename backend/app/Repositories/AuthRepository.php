<?php

namespace App\Repositories;

use App\Models\Usuario;
use App\Traits\ValidateTrait;
use App\Exceptions\CustomException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Repositories\Contracts\AuthRepositoryIntercace;

class AuthRepository extends Usuario implements JWTSubject, AuthRepositoryIntercace, Authenticatable
{

    use Notifiable, ValidateTrait;

    private static $objUsuarioRepository;

    public function __construct()
    {
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {

        $usuario = self::getUsuarioRepositoryLogado();

        $claims = [
            'usuario' => [
                'intId' => $usuario->intId,
                'strNome' => $usuario->strNome,
            ]
        ];

        return $claims;
    }

    public function loginAsync(array $arrayData)
    {

        $data = $this->validate(
            $arrayData,
            array(
                'strEmail' => 'required',
                'strSenha' => 'required'
            )
        );

        if (!$objUsuario = $this->where('strEmail', $data['strEmail'])->first()) {
            throw new CustomException("Usuário não encontrado");
        }

        if (!Hash::check($data['strSenha'], $objUsuario->strSenha)) {
            throw new CustomException("Senha inválida");
        }

        self::setUsuarioRepositoryLogado($objUsuario);
        $token = Auth::login($objUsuario);

        return [
            'token' => $token,
            'usuario' => $objUsuario
        ];
    }

    public function logoutAsync()
    {

        Auth::logout();
        return 'Logout efetuado com sucesso';
    }

    public static function setUsuarioRepositoryLogado(AuthRepository $objUsuarioRepository)
    {
        self::$objUsuarioRepository = $objUsuarioRepository;
    }

    public static function getUsuarioRepositoryLogado()
    {
        return self::$objUsuarioRepository;
    }

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'intId';
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->intId;
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->strSenha;
    }

    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    public function getRememberToken()
    {
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string  $value
     * @return void
     */
    public function setRememberToken($value)
    {
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
    }
}
