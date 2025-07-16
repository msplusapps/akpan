<?php

namespace App\Plugins\Song\Controllers;

use Core\Controller;
use App\Plugins\Song\Models\Song;

class SongController extends Controller {

    public function index() {
        // echo "songController is connected";
        // $songs = Song::all(); // Fetch all songs
        $this->view('Song@index');
    }

    public function create() {
        $this->view('Song/create');
    }

    public function store() {
        if ($this->isPost()) {
            $song = new Song();
            $song->title = $this->input('title');
            $song->artist = $this->input('artist');
            $song->album = $this->input('album');
            $song->save();

            $this->redirect('/songs');
        }
    }

    public function delete($id) {
        $song = Song::find($id);
        if ($song) {
            $song->delete();
        }
        $this->redirect('/songs');
    }
}
