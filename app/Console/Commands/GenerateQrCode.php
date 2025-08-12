<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Intervention\Image\Facades\Image;

class GenerateQrCode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'qrcode:generate {url} {output} {logo?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate QR code with optional logo';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $url = $this->argument('url');
        $output = $this->argument('output');
        $logoPath = $this->argument('logo');

        // Ensure output directory exists
        $outputDir = dirname($output);
        if (!is_dir($outputDir)) {
            mkdir($outputDir, 0755, true);
        }

        try {
            // Create QR code with basic settings
            $qrCode = new QrCode($url);

            // Create writer
            $writer = new PngWriter();

            // Generate QR code image
            $result = $writer->write($qrCode);

            // Save QR code
            $result->saveToFile($output);

            // Add logo if provided
            if ($logoPath && file_exists($logoPath)) {
                $image = Image::make($output);
                $logo = Image::make($logoPath);

                // Calculate logo size (20% of QR code width)
                $logoSize = $image->width() * 0.2;

                // Resize logo
                $logo->resize($logoSize, null, function ($constraint) {
                    $constraint->aspectRatio();
                });

                // Insert logo in center
                $image->insert($logo, 'center');
                $image->save($output);
            }

            $this->info('QR code generated successfully: ' . $output);
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Error generating QR code: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
