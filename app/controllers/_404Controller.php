<?php
class _404Controller extends Controller{
    public function index($data = []){
        $this->view('404', [
            'message' => $data[0] ?? 'Page Not Found',
            'file' => $data[1] ?? 'Unknown File'
        ]);
    }
}
