<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Routing\Controller;
use Spatie\Browsershot\Browsershot;
use Intervention\Image\Facades\Image;

class OrderReceiptController extends Controller
{
    public function downloadPdfReceipt(Order $order)
    {
        $pdf = Pdf::loadView('order_receipt.order-receipt', compact('order'));
        return $pdf->download('receipt-order-' . $order->id . '.pdf');
    }
    public function downloadReceiptImage($orderId)
    {
        $order = Order::with('orderItems.product')->findOrFail($orderId);

        // Save temporary HTML output
        $html = view('order_receipt.order-receipt', compact('order'))->render();

        // Generate JPG from the HTML using Browsershot
        $fileName = 'order_receipt_' . $order->id . '.jpg';
        $path = storage_path('app/public/receipts/' . $fileName);

        Browsershot::html($html)
            ->windowSize(800, 1200)
            ->waitUntilNetworkIdle()
            ->deviceScaleFactor(2)
            ->save($path);

        // Return download response
        return response()->download($path)->deleteFileAfterSend(true);
    }
}
