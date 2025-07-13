<?php

class WebController extends Controller
{
    public function index()
    {
        $this->view('home', [
            'title' => 'Welcome Home',
            'message' => 'This is the homepage.'
        ]);
    }

    public function about()
    {
        $this->view('web/about', [
            'title' => 'About Us',
            'message' => 'We are building a custom MVC framework.'
        ]);
    }

    public function contact()
    {
        $this->view('web/contact', [
            'title' => 'Contact Us',
            'email' => 'support@example.com'
        ]);
    }
}
