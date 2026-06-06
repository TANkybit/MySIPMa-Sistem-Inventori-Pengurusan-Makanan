<?php

$users = App\Models\User::whereHas('position', function($q) {
    $q->whereIn('code', ['ADN', 'P007'])
      ->orWhere('name', 'like', '%pengarah negeri%')
      ->orWhere('name', 'like', '%admin negeri%');
})->select('email', 'id', 'name')->limit(3)->get()->toArray();

echo json_encode($users, JSON_PRETTY_PRINT);
