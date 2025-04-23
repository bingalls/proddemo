<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * @return Factory|View|Application
     */
    public function index(): Factory|View|Application
    {
        $products = Product::all();
        $exchangeRate = $this->getExchangeRate();

        return view('products.list', compact('products', 'exchangeRate'));
    }

    /**
     * @param Request $request
     * @return Factory|View|Application
     */
    public function show(Request $request): Factory|View|Application
    {
        $id = $request->route('product_id');
        $product = Product::find($id);
        $exchangeRate = $this->getExchangeRate();

        return view('products.show', compact('product', 'exchangeRate'));
    }

    /**
     * @return float
     */
    private function getExchangeRate(): float
    {
        try {
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => 'https://open.er-api.com/v6/latest/USD',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 5,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            // Check if json_validate() is better than exception handling
            if (! $err) {
                $data = json_decode($response, true, 512, JSON_THROW_ON_ERROR);
                if (isset($data['rates']['EUR'])) {
                    return $data['rates']['EUR'];
                }
            }
        } catch (Exception $exception) {
            Log::error(__METHOD__ . $exception->getMessage());
        }

        // Need clear biz rules, if default exchange rate is allowed
        return config('EXCHANGE_RATE', 0.85);
    }
}
