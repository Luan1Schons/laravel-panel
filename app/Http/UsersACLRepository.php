<?php

namespace App\Http;

use Alexusmai\LaravelFileManager\Services\ACLService\ACLRepository;

class UsersACLRepository implements ACLRepository
{
    /**
     * Get user ID
     *
     * @return mixed
     */
    public function getUserID()
    {
        return \Auth::id();
    }

    /**
     * Get ACL rules list for user
     *
     * @return array
     */
    public function getRules(): array
    {
        if (\Auth::id() === 2) {
            return [
                ['disk' => 'public', 'path' => '*', 'access' => 2],
            ];
        }
        
        return [
            ['disk' => 'public', 'path' => '/', 'access' => 1],
            ['disk' => 'public', 'path' => 'files', 'access' => 1],
            ['disk' => 'public', 'path' => 'files/'.\Auth::id(), 'access' => 1],
            ['disk' => 'public', 'path' => 'files/'.\Auth::id().'/*', 'access' => 2],  // read and write
        ];
    }
}