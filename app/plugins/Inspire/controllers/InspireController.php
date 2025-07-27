<?php
namespace App\Plugins\Inspire\Controllers;
use Core\Controller;
use App\Plugins\Inspire\Models\Inspire;

class InspireController extends Controller
{
    public function index() {
        $model = new Inspire();
        $quote = $model->getRandomQuote();

        $this->view("Inspire@index", ["quote" => $quote]);
    }
}