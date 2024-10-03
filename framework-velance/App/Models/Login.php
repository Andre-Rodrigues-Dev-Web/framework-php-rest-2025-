<?php
namespace App\Models;

class Login
{
    private static $table = 'login';

    private static function getConnection() {
        try {
            return new \PDO(DBDRIVE.':host='.DBHOST.';dbname='.DBNAME, DBUSER, DBPASS, [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_PERSISTENT => true
            ]);
        } catch (\PDOException $e) {
            throw new \Exception('Erro na conexão com o banco de dados: ' . $e->getMessage());
        }
    }

    public static function authenticate($email, $senha) {
        try {
            $connPdo = self::getConnection();

            $sql = 'SELECT * FROM '.self::$table.' WHERE email = :email';
            $stmt = $connPdo->prepare($sql);
            $stmt->bindValue(':email', $email);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $user = $stmt->fetch();
                
                if (password_verify($senha, $user['senha'])) {
                    unset($user['senha']);

                    return json_encode([
                        'id_usuario' => $user['id'],
                        'nome' => $user['nome'],
                        'usuario' => $user['usuario'],
                        'email' => $user['email'],
                        'foto' => $user['foto'],
                        'perfil' => $user['perfil'],
                        'status' => $user['status']
                    ]);
                } else {
                    throw new \Exception("Senha incorreta!");
                }
            } else {
                throw new \Exception("Usuário não encontrado!");
            }
        } catch (\Exception $e) {
            // Retorna a mensagem de erro no formato JSON
            return json_encode([
                'error' => true,
                'message' => $e->getMessage()
            ]);
        }
    }
}
