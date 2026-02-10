<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    /**
     * GET /api/promotions
     * Filtros opcionales: ?active=true, ?type=promo
     */
    public function index(Request $request)
    {
        $query = Promotion::query();

        if ($request->has('active')) {
            $query->where('is_active', filter_var($request->active, FILTER_VALIDATE_BOOLEAN));
        }

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        return response()->json(
            $query->orderBy('created_at', 'desc')->get()
        );
    }

    /**
     * GET /api/promotions/active
     */
    public function active()
    {
        return response()->json(
            Promotion::where('is_active', true)
                ->orderBy('created_at', 'desc')
                ->get()
        );
    }

    /**
     * GET /api/promotions/{id}
     */
    public function show($id)
    {
        $promotion = Promotion::findOrFail($id);
        return response()->json($promotion);
    }

    /**
     * POST /api/promotions
     * (sin imágenes todavía)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:promo,evento',
            'title' => 'required|string|max:100',
            'link' => 'nullable|url',

            'image_desktop' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'image_mobile'  => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',

            'is_active' => 'boolean',
        ]);

        // Guardar imágenes
        $desktopPath = $request->file('image_desktop')
            ->store('promotions/desktop', 'public');

        $mobilePath = $request->file('image_mobile')
            ->store('promotions/mobile', 'public');

        $promotion = Promotion::create([
            'type' => $validated['type'],
            'title' => $validated['title'],
            'link' => $validated['link'] ?? null,
            'image_desktop' => $desktopPath,
            'image_mobile' => $mobilePath,
            'is_active' => $validated['is_active'] ?? true,
        ]);

        return response()->json($promotion, 201);
    }

    /**
     * PUT /api/promotions/{id}
     */
    public function update(Request $request, $id)
    {
        $promotion = Promotion::findOrFail($id);

        $validated = $request->validate([
            'type' => 'required|in:promo,evento',
            'title' => 'required|string|max:100',
            'link' => 'nullable|url',
            'is_active' => 'boolean',
        ]);

        $promotion->update($validated);

        return response()->json($promotion);
    }

    /**
     * PATCH /api/promotions/{id}/toggle
     */
    public function toggle(Request $request, $id)
    {
        $promotion = Promotion::findOrFail($id);

        $request->validate([
            'is_active' => 'required|boolean',
        ]);

        $promotion->update([
            'is_active' => $request->is_active,
        ]);

        return response()->json($promotion);
    }

    /**
     * DELETE /api/promotions/{id}
     */
    public function destroy($id)
    {
        Promotion::findOrFail($id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Promoción eliminada correctamente',
        ]);
    }
}
