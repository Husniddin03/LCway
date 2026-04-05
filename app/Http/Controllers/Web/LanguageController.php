<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function switch($lang)
    {
        $availableLanguages = ['uz', 'en', 'ru', 'kaa'];
        
        if (!in_array($lang, $availableLanguages)) {
            abort(404);
        }
        
        Session::put('locale', $lang);
        
        return redirect()->back();
    }
}
