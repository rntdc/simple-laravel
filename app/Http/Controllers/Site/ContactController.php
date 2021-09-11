<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactFormRequest;
use App\Models\Contact;
use App\Notifications\NewContact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('site.contact.index');
    }

    /**
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function form(ContactFormRequest $request)
    {
        $contact = Contact::create($request->all());
        \Illuminate\Support\Facades\Notification::route('mail', config('mail.from.address'))
            ->notify(new NewContact($contact));

        return redirect()->route('site.contact')->with([
            'success' => true,
            'message' => 'O contato foi enviado!',
        ]);
    }

}
