<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact; // Certifique-se de que o modelo está correto
use Illuminate\Http\Request;

class ContactApiController extends Controller
{
    public function index(Request $request)
    {
        $contatos = Contact::paginate(1000); // Paginação de 1000
        return response()->json($contatos);
    }

    public function filterByCampaign($campanha)
    {
        $contatos = Contact::where('campanha', 'LIKE', '%' . $campanha . '%')->paginate(1000);
        return response()->json($contatos);
    }
}
