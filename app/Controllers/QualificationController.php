<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Services\QualificationService;

class QualificationController extends Controller
{
    public function generate(): void
    {
        $categoryId = (int) ($_POST['category_id'] ?? 0);
        $service = new QualificationService();
        $service->generate($categoryId);

        $this->redirect('/brackets?category_id=' . $categoryId);
    }
}
