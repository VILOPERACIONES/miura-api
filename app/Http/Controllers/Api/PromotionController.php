<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use Illuminate\Http\Request;
use App\Http\Resources\PromotionResource;

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

        return PromotionResource::collection(
        $query->orderBy('created_at', 'desc')->get()
        );
    }

    /**
     * GET /api/promotions/active
     */
    public function active()
    {
        return PromotionResource::collection(
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

        return new PromotionResource($promotion);
    }

    /**
     * POST /api/promotions
     * (sin imágenes todavía)
     */
    public function store(Request $request)
    {
        $request->merge([
            'is_active' => filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN),
        ]);

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

        return response()->json(
        new PromotionResource($promotion),
        201
        )  ;
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

        return new PromotionResource($promotion);
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

        return new PromotionResource($promotion);
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
