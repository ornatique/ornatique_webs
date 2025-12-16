<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Faq_header;
use App\Models\Faq;
use App\Models\Term;
use App\Models\Feedback;
use App\Models\Privacy;

class ContentController extends Controller
{
    public function contact()
    {
        $data['contacts'] = Contact::first();
        $data['orders'] = Order::all();
        $data['headers'] = Faq::all();
        $data['faqs'] = Faq::get();
        return view('frontend.content.contact', $data);
    }

    public function work()
    {
        return view('frontend.content.how_it_work');
    }

    public function term()
    {
        $data['terms'] = Term::first();
        return view('frontend.content.terms_and_conditions', $data);
    }

    public function privacy()
    {
        $data['privacies'] = Privacy::first();
        return view('frontend.content.privacy_policy', $data);
    }

    public function download()
    {
        return view('frontend.content.download_app');
    }


    public function contact_form(request $request)
    {
        if ($_POST) {
            $request->validate([
                'name' => 'required|string|min:2|max:255',
                'contact' => 'required|numeric|digits:10',
                'message' => 'required|string|min:5',
                'email' => 'required|string|email|max:255|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
            ]);
            $data = new Contact;
            $data->name = $request->name;
            $data->email = $request->email;
            $data->contact = $request->contact;
            $data->message = $request->message;
            $data->save();
            return redirect()->route('contact');
        }
    }

    public function feedback(request $request)
    {
        if ($_POST) {
            $request->validate([
                'name' => 'required|string|min:2|max:255',
                'message' => 'required|string|min:5',
                'email' => 'required|string|email|max:255|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
            ]);
            $data = new Feedback;
            $data->name = $request->name;
            $data->email = $request->email;
            $data->message = $request->message;
            $data->rating = $request->rating2;
            // return $data;
            $data->save();
            return redirect()->route('contact');
        }
    }

    public function refundPolicy()
    {
        return view('frontend.content.refund_policy');
    }

    public function returnPolicy()
    {
        return view('frontend.content.return_policy');
    }

    public function sponsoredBrand()
    {
        return view('frontend.content.sponsored_brand');
    }
}