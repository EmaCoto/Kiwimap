<?php

namespace App\Livewire\Qr;

use App\Models\QrCode as QrCodeModel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

#[Title('QR Code Manager')]
class Manager extends Component
{
    use WithFileUploads;
    use WithPagination;

    public string $name = '';
    public string $type = 'text';

    public ?string $text = null;
    public ?string $url = null;
    public ?string $phone = null;
    public ?string $whatsapp = null;
    public ?string $whatsapp_message = null;

    public ?string $wifi_ssid = null;
    public ?string $wifi_password = null;
    public string $wifi_security = 'WPA';
    public bool $wifi_hidden = false;

    public string $foreground_color = '#000000';
    public string $background_color = '#FFFFFF';
    public int $size = 600;

    // Sin wire:model en el blade — se asigna via $wire.upload() desde Alpine
    public $logo = null;

    protected $paginationTheme = 'tailwind';

    public function rules(): array
    {
        $rules = [
            'name'             => ['required', 'string', 'max:255'],
            'type'             => ['required', 'in:text,url,phone,whatsapp,wifi'],
            'foreground_color' => ['required', 'regex:/^#([A-Fa-f0-9]{6})$/'],
            'background_color' => ['required', 'regex:/^#([A-Fa-f0-9]{6})$/'],
            'size'             => ['required', 'integer', 'min:300', 'max:1200'],
            'logo'             => ['nullable', 'image', 'mimes:png', 'max:2048'],
        ];

        match ($this->type) {
            'text'     => $rules['text']      = ['required', 'string'],
            'url'      => $rules['url']       = ['required', 'url'],
            'phone'    => $rules['phone']     = ['required', 'string', 'max:30'],
            'whatsapp' => $rules['whatsapp']  = ['required', 'string', 'max:30'],
            'wifi'     => $rules['wifi_ssid'] = ['required', 'string', 'max:255'],
        };

        return $rules;
    }

    public function save(): void
    {
        $this->validate();

        $content = $this->buildQrContent();
        $payload = $this->buildPayload();

        // Guardar logo si viene
        $logoPath = null;
        if ($this->logo) {
            $logoPath = $this->logo->store('qrs/logos', 'public');
        }

        // Preparar ruta de salida
        $fileName = 'qrs/generated/' . now()->format('Y/m') . '/' . Str::uuid() . '.png';
        Storage::disk('public')->makeDirectory(dirname($fileName));
        $absoluteQrPath = Storage::disk('public')->path($fileName);

        // Generar QR como binario
        $qrBinary = QrCode::format('png')
            ->size($this->size)
            ->margin(2)
            ->errorCorrection('H')
            ->color(...$this->hexToRgb($this->foreground_color))
            ->backgroundColor(...$this->hexToRgb($this->background_color))
            ->generate($content);

        if ($logoPath) {
            $this->mergeLogoIntoQr(
                $qrBinary,
                Storage::disk('public')->path($logoPath),
                $absoluteQrPath
            );
        } else {
            file_put_contents($absoluteQrPath, $qrBinary);
        }

        QrCodeModel::create([
            'name'             => $this->name,
            'type'             => $this->type,
            'payload'          => $payload,
            'content'          => $content,
            'foreground_color' => $this->foreground_color,
            'background_color' => $this->background_color,
            'size'             => $this->size,
            'logo_path'        => $logoPath,
            'qr_path'          => $fileName,
        ]);

        $this->resetForm();

        // Avisar a Alpine que resetee el input file
        $this->dispatch('qr-saved');

        session()->flash('success', 'QR creado y guardado correctamente.');
        $this->resetPage();
    }

    public function download(int $id)
    {
        $qr = QrCodeModel::findOrFail($id);

        return response()->download(
            Storage::disk('public')->path($qr->qr_path),
            Str::slug($qr->name) . '.png'
        );
    }

    public function delete(int $id): void
    {
        $qr = QrCodeModel::findOrFail($id);

        if ($qr->qr_path && Storage::disk('public')->exists($qr->qr_path)) {
            Storage::disk('public')->delete($qr->qr_path);
        }

        if ($qr->logo_path && Storage::disk('public')->exists($qr->logo_path)) {
            Storage::disk('public')->delete($qr->logo_path);
        }

        $qr->delete();

        session()->flash('success', 'QR eliminado correctamente.');
        $this->resetPage();
    }

    // ────────────────────────────────────────────────────────────────
    // Merge logo sobre QR usando GD puro (sin Imagick)
    // FIX: el problema original era que imagecopy no respeta
    //      la transparencia del PNG. Hay que usar imagecopymerge
    //      o mejor aún, hacer el composite manualmente pixel a pixel
    //      para respetar el canal alpha del logo.
    // ────────────────────────────────────────────────────────────────
    protected function mergeLogoIntoQr(
        string $qrBinary,
        string $logoAbsolutePath,
        string $outputAbsolutePath
    ): void {
        // Crear imagen QR desde binario
        $qrImage = imagecreatefromstring($qrBinary);

        if (! $qrImage || ! file_exists($logoAbsolutePath)) {
            file_put_contents($outputAbsolutePath, $qrBinary);
            return;
        }

        // Cargar logo PNG (debe soportar alpha)
        $logoImage = imagecreatefrompng($logoAbsolutePath);

        if (! $logoImage) {
            file_put_contents($outputAbsolutePath, $qrBinary);
            return;
        }

        $qrWidth  = imagesx($qrImage);
        $qrHeight = imagesy($qrImage);
        $logoW    = imagesx($logoImage);
        $logoH    = imagesy($logoImage);

        // Tamaño objetivo del logo: 22% del ancho del QR
        $targetW = (int) round($qrWidth * 0.22);
        $targetH = (int) round(($logoH / $logoW) * $targetW);

        // Redimensionar logo preservando alpha
        $resized = imagecreatetruecolor($targetW, $targetH);
        imagealphablending($resized, false);
        imagesavealpha($resized, true);
        $transparent = imagecolorallocatealpha($resized, 0, 0, 0, 127);
        imagefill($resized, 0, 0, $transparent);

        imagecopyresampled(
            $resized, $logoImage,
            0, 0, 0, 0,
            $targetW, $targetH,
            $logoW, $logoH
        );

        // Padding del fondo blanco detrás del logo
        $padding = (int) round($qrWidth * 0.03); // 3% del QR como padding

        $bgW = $targetW + ($padding * 2);
        $bgH = $targetH + ($padding * 2);

        // Fondo blanco redondeado centrado en el QR
        $bgX = (int) round(($qrWidth  - $bgW) / 2);
        $bgY = (int) round(($qrHeight - $bgH) / 2);

        // Activar alpha blending en el QR para dibujar encima
        imagealphablending($qrImage, true);
        imagesavealpha($qrImage, true);

        [$r, $g, $b] = $this->hexToRgb($this->background_color);
        $bgColor = imagecolorallocate($qrImage, $r, $g, $b);

        // Dibujar rectángulo redondeado con el color de fondo del QR
        $this->imageFilledRoundedRect(
            $qrImage,
            $bgX, $bgY,
            $bgX + $bgW, $bgY + $bgH,
            (int) round($padding * 0.8), // radio de esquinas
            $bgColor
        );

        // Posición del logo sobre el fondo blanco
        $logoX = $bgX + $padding;
        $logoY = $bgY + $padding;

        // FIX PRINCIPAL: usar imagecopy con alpha blending habilitado
        // en la imagen de destino para que el PNG transparente se vea bien
        imagecopy(
            $qrImage,
            $resized,
            $logoX, $logoY,
            0, 0,
            $targetW, $targetH
        );

        // Guardar como PNG
        imagepng($qrImage, $outputAbsolutePath, 0); // 0 = sin compresión extra

        // Liberar memoria
        imagedestroy($qrImage);
        imagedestroy($logoImage);
        imagedestroy($resized);
    }

    protected function imageFilledRoundedRect(
        $image,
        int $x1, int $y1,
        int $x2, int $y2,
        int $radius,
        int $color
    ): void {
        // Rectángulo central horizontal
        imagefilledrectangle($image, $x1 + $radius, $y1, $x2 - $radius, $y2, $color);
        // Rectángulo central vertical
        imagefilledrectangle($image, $x1, $y1 + $radius, $x2, $y2 - $radius, $color);
        // Las 4 esquinas redondeadas
        imagefilledellipse($image, $x1 + $radius, $y1 + $radius, $radius * 2, $radius * 2, $color);
        imagefilledellipse($image, $x2 - $radius, $y1 + $radius, $radius * 2, $radius * 2, $color);
        imagefilledellipse($image, $x1 + $radius, $y2 - $radius, $radius * 2, $radius * 2, $color);
        imagefilledellipse($image, $x2 - $radius, $y2 - $radius, $radius * 2, $radius * 2, $color);
    }

    // ────────────────────────────────────────────────────────────────
    // Helpers
    // ────────────────────────────────────────────────────────────────

    protected function buildQrContent(): string
    {
        return match ($this->type) {
            'text'     => $this->text ?? '',
            'url'      => $this->url ?? '',
            'phone'    => 'tel:' . preg_replace('/\s+/', '', $this->phone ?? ''),
            'whatsapp' => 'https://wa.me/' . preg_replace('/\D+/', '', $this->whatsapp ?? '')
                . $this->buildQueryString(['text' => $this->whatsapp_message]),
            'wifi'     => sprintf(
                'WIFI:T:%s;S:%s;P:%s;H:%s;;',
                $this->wifi_security,
                $this->escapeWifi($this->wifi_ssid ?? ''),
                $this->escapeWifi($this->wifi_password ?? ''),
                $this->wifi_hidden ? 'true' : 'false'
            ),
            default => '',
        };
    }

    protected function buildPayload(): array
    {
        return match ($this->type) {
            'text'     => ['text'     => $this->text],
            'url'      => ['url'      => $this->url],
            'phone'    => ['phone'    => $this->phone],
            'whatsapp' => ['whatsapp' => $this->whatsapp, 'message' => $this->whatsapp_message],
            'wifi'     => [
                'ssid'     => $this->wifi_ssid,
                'password' => $this->wifi_password,
                'security' => $this->wifi_security,
                'hidden'   => $this->wifi_hidden,
            ],
            default => [],
        };
    }

    protected function buildQueryString(array $params): string
    {
        $filtered = array_filter($params, fn ($value) => filled($value));

        return empty($filtered) ? '' : '?' . http_build_query($filtered);
    }

    protected function escapeWifi(string $value): string
    {
        return addcslashes($value, '\;,:\"');
    }

    protected function hexToRgb(string $hex): array
    {
        $hex = ltrim($hex, '#');

        return [
            hexdec(substr($hex, 0, 2)),
            hexdec(substr($hex, 2, 2)),
            hexdec(substr($hex, 4, 2)),
        ];
    }

    protected function resetForm(): void
    {
        $this->reset([
            'name', 'text', 'url', 'phone',
            'whatsapp', 'whatsapp_message',
            'wifi_ssid', 'wifi_password', 'logo',
        ]);

        $this->type             = 'text';
        $this->wifi_security    = 'WPA';
        $this->wifi_hidden      = false;
        $this->foreground_color = '#000000';
        $this->background_color = '#FFFFFF';
        $this->size             = 600;
    }

    public function render()
    {
        return view('livewire.qr.manager', [
            'qrs' => QrCodeModel::latest()->paginate(10),
        ]);
    }
}
