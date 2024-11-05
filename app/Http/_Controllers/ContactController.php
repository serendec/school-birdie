<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormMail;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    // お問い合わせフォーム
    public function create()
    {
        return view('contact.create');
    }

    // お問い合わせフォーム送信
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        if (Auth::user()->role == 'student'){
            $personDetails = Student::getStudentInfoFromId(Auth::id(), Auth::user()->school_id);
            $mailTo = Auth::user()->school->email;
        } else {
            $personDetails = Teacher::getTeacherInfoFromId(Auth::id(), Auth::user()->school_id);
            $mailTo = config('mail.admin');
        }

        $data = [
            'school_name'    => Auth::user()->school->name,
            'person_details' => $personDetails,
            'content'        => $request->content
        ];

        // メール送信
        Mail::to($mailTo)->send(new ContactFormMail($data));
        // キューで送信した方が良いかも
        // Mail::to($mailTo)->queue(new ContactFormMail($data));

        return redirect(route('contact.create'))->with([
            'result' => 'success',
            'msg'    => __('messages.mail_success')
        ]);
    }
}
