<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Quiz;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index(): \Inertia\Response
    {
        $brands = Brand::where('is_active', true)->get();
        $quizzes = Quiz::query()
            ->where('is_active', true)
            ->with('questions')
            ->with('questions.answers')
            ->get();
        $initialBrandSlud = null;
        if($brands->where('is_active', true)->count() === 1) {
            $initialBrandSlud = $brands->where('is_active', true)->first()->slug;
        }

        return Inertia::render('Home', [
            'brands' => $brands,
            'quizzes' => $quizzes,
            'initialBrandSlug' => $initialBrandSlud
        ]);
    }
}
