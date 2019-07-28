<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function setCurrency(Request $request)
    {
        if (!array_key_exists($request->currency, config('currency'))) {
            return $this->error('invalid currency');
        }

        setlocale(LC_MONETARY, config('currency.' . $request->currency));
        session(['currency' => $request->currency]);

        return redirect()->back();
    }
}
