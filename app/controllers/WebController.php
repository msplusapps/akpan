<?php

class WebController extends Controller
{
    public function index()
    {
        $this->view('web/home', [
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

    public function documentation(){
        $this->view('web/documentation', [
            'title' => 'Documentation',
            'message' => 'We are building a custom MVC framework.'
        ]);
    }

    public function download()
    {
        $this->view('web/download', [
            'title' => 'download',
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
