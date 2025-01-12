<?php
require_once ROOT_PATH . "/Model/Database.php";

class UserModel extends Database
{
    public function getUsers($limit)
    {  
        return $this->select($limit);
    }

    public function getUser($id)
    {
        try {
            $users = json_decode(file_get_contents(DATABASE_FILE), true);
            foreach ($users as $user) {
                if ($user['user_id'] == $id) {
                    return $user;
                }
            }
            throw new Exception("User not found");
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }
        return false;
    }

    public function updateUser($id, $data)
    {
        try {
            $users = json_decode(file_get_contents(DATABASE_FILE), true);
            foreach ($users as &$user) {
                if ($user['user_id'] == $id) {
                    $user = array_merge($user, $data);
                    file_put_contents(DATABASE_FILE, json_encode($users));
                    return true;
                }
            }
            throw new Exception("User not found");
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }
        return false;
    }

    public function deleteUser($id)
    {
        try {
            $users = json_decode(file_get_contents(DATABASE_FILE), true);
            foreach ($users as $index => $user) {
                if ($user['user_id'] == $id) {
                    unset($users[$index]);
                    file_put_contents(DATABASE_FILE, json_encode(array_values($users)));
                    return true;
                }
            }
            throw new Exception("User not found");
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }
        return false;
    }

    public function generateUsers($quantity)
    {
        $users = [];
        for ($i = 1; $i <= $quantity; $i++) {
            $users[] = [
                'user_id' => $i,
                'username' => 'User' . $i,
                'user_email' => 'user' . $i . '@example.com',
                'user_status' => rand(0, 1)
            ];
        }
        file_put_contents(DATABASE_FILE, json_encode($users));
    }
}