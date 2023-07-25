<?php

namespace App\Http\Controllers;

use App\Models\SubcriptionEmail;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EmailExport;
use App\Mail\NewsletterVarification;
use App\Mail\NewsletterAdmin;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function saveEmail(Request $request)
    {
        $email = new SubcriptionEmail();
        $email->email = $request->email;
        $email->save();
        // Mail::to($email->email)->send(new NewsletterVarification($email));
        // Mail::to('imran.skylinxtech@gmail.com')->send(new NewsletterAdmin($email));
        return redirect()->back()->with('msg', 'You are subscribed successfully!');
    }
    public function allEmails()
    {
        return view('user.subscriptions');
    }
    public function allSubscriptionEmail(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->search['value'];
        $totalBrands = SubcriptionEmail::whereNotNull('email')->count();
        $brands = SubcriptionEmail::whereNotNull('email')->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('email', 'like', "%$search%");
            });
        })->skip((int) $start)->take((int) $length)->get();
        $brandsCount = SubcriptionEmail::whereNotNull('email')->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('email', 'like', "%$search%");
            });
        })->skip((int) $start)->take((int) $length)->count();
        $data = array(
            'draw' => $draw,
            'recordsTotal' => $totalBrands,
            'recordsFiltered' => $brandsCount,
            'data' => $brands,
        );
        return json_encode($data);
    }
    public function exportEmail()
    {
        return Excel::download(new EmailExport, 'Emails.xlsx');
    }

    public function sendEmailToPrevoius(Request $request)
    {
        ini_set('max_execution_time', 0);
        $emails =  SubcriptionEmail::all();
        foreach ($emails as $email) {
            Mail::to($email->email)->send(new NewsletterVarification($email));
            Mail::to(env('MAIL_FROM_NAME'))->send(new NewsletterAdmin($email));
        }
        return 'sent successfully!';
    }
}
