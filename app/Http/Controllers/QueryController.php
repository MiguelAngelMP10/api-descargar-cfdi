<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQueryRequest;
use App\Models\Query;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class QueryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response|ResponseFactory
    {
        $queries = Query::query()->when($request->search, function ($query, $search) {
            $query->where('rfc', 'like', '%' . $search . '%')
                ->orWhere('endPoint', 'like', '%' . $search . '%')
                ->orWhere('downloadType', 'like', '%' . $search . '%')
                ->orWhere('requestType', 'like', '%' . $search . '%');
        })->paginate(10)->withQueryString();
        return Inertia('Queries/Index', [
            'queries' => $queries,
            'search' => $request->search,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQueryRequest $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(Query $query)
    {
    }
}
