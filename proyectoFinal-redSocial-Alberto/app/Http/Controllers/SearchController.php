<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $query = trim((string) $request->query('q', ''));
        $users = null;

        if (mb_strlen($query) >= 2) {
            $users = User::query()
                ->where(function ($builder) use ($query) {
                    $builder->where('username', 'like', "%{$query}%")
                        ->orWhere('name', 'like', "%{$query}%");
                })
                ->orderBy('username')
                ->paginate(10)
                ->withQueryString();
        }

        return view('search', [
            'query' => $query,
            'users' => $users,
        ]);
    }
}
