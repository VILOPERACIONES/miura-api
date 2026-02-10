<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PromotionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'title' => $this->title,
            'link' => $this->link,
            'is_active' => $this->is_active,

            // Raw paths (por si los necesitas internamente)
            'image_desktop' => $this->image_desktop,
            'image_mobile' => $this->image_mobile,

            // Public URLs (lo que usará React)
            'image_desktop_url' => $this->image_desktop
                ? Storage::disk('public')->url($this->image_desktop)
                : null,

            'image_mobile_url' => $this->image_mobile
                ? Storage::disk('public')->url($this->image_mobile)
                : null,

            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
