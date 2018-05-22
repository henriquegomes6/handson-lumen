<?php
namespace App\Repositories;

use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Facades\Cache;

class UserRepository
{
    private $databaseManager;

    public function __construct(DatabaseManager $databaseManager)
    {
        $this->databaseManager = $databaseManager;
    }

    public function listUsers()
    {
        $data = Cache::tags(['users'])->get('all');

        if (is_null($data)) {
            $data = $this->databaseManager
                ->select(
                    "SELECT * FROM users"
                );
            Cache::tags(['users'])->put('all', $data, 1);
        }
        return $data;

    }

    public function insertUser($email, $pass, $name)
    {
        $id = $this->databaseManager
            ->table('users')
            ->insertGetId([
                "email" => $email,
                "pass" => $pass,
                "name" => $name,
            ]);
        if ($id) {
            Cache::tags('users')->flush();
            return $id;
        }
    }

    public function getUserById(int $id)
    {
        $data = Cache::tags(['users'])->get($id);
        if (is_null($data)) {
            $data = $this->databaseManager
                ->select(
                    "SELECT * FROM users WHERE id = ?",[$id]
                );
            Cache::tags(['users'])->put($id, $data, 1);
        }
        return $data;
    }



    // return DB::table('')
    // ->where('', '=', )
    // ->update([
    // ]);
}
