<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::paginate(10);
        return view("admin.modules.feedback.index", ["feedbacks" => $feedbacks]);
    }
}
