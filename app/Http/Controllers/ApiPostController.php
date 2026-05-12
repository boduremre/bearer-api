<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Support\Facades\Gate;

class ApiPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Tüm postları, onları yazan kullanıcı bilgisiyle (user) birlikte getir
        return response()->json(Post::with('user')->latest()->get());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        // Doğrulanmış verileri al
        $validated = $request->validated();

        // Postu mevcut kullanıcıya bağlayarak oluştur
        $post = $request->user()->posts()->create($validated);

        //mesaj ve oluşturulan postu JSON olarak döndür
        return response()->json([
            'message' => 'Post başarıyla oluşturuldu',
            'data' => $post
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        // İlişkili kullanıcı bilgisiyle birlikte tek bir post döner
        return response()->json($post->load('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        // Policy'deki 'update' kuralını kontrol et
        Gate::authorize('update', $post);

        $post->update($request->validated());

        return response()->json(['message' => 'Güncellendi', 'data' => $post]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        // Policy'deki 'delete' kuralını kontrol et
        Gate::authorize('delete', $post);

        $post->delete();

        return response()->json(['message' => 'Post silindi.']);
    }
}
