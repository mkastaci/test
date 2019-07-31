<?php

namespace App\Http\Controllers;

class AdminController extends Controller
{
    public function adminAction()
    {
        return view(
            'admin' // nom de la vue
        );
    }
}
