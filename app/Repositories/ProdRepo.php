<?php

namespace App\Repositories;

use App\Http\Requests\ProductRequest;
use App\Jobs\SendPriceChangeNotification;
use App\Models\Product;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;

/**
 * Repository access to Products model
 */
class ProdRepo
{
    /**
     * @param array $prodList
     * @param UploadedFile|null $file
     * @return bool
     */
    public function addProduct(array $prodList, ?UploadedFile $file = null): bool
    {
        $product = Product::create($prodList);

        if ($file) {
            $product->image = $file->store(storage_path('app/public'));
        } else {
            $product->image = 'product-placeholder.jpg';
        }

        return $product->save();
    }

    /**
     * Use Request validation for cli args
     *
     * @param array $options
     * @return array
     */
    public function chkUpdateOpts(array $options): array
    {
        $rules = (new ProductRequest())->rules();
        $validator = Validator::make($options, $rules);

        $validated = [];
        if ($validator->fails()) {
            $validated['error'] = implode(PHP_EOL, $validator->errors()->all());
            return $validated;
        }
        try {
            $validated = $validator->validated();
        } catch (Exception $exception) {
            $validated['error'] = $exception->getMessage();
        } finally {
            return $validated;
        }
    }

    /**
     * @param int $id
     * @param array $prodList [description, name, price, (optional 'error')]
     * @param UploadedFile|null $file
     * @return string
     */
    public function updateProduct(int $id, array $prodList, ?UploadedFile $file = null): string
    {
        $product = Product::find($id);

        // Store the old price before updating
        $oldPrice = $product->price;

        $product->update($prodList);

        if ($file) {    // not (default) null
            $filename = $file->hashName('uploads');
            $file->move(public_path('uploads'), $filename);
            $product->image = $filename;
        }

        $product->save();

        $errMsg = '';

        // Check if price has changed
        if ($oldPrice !== $product->price) {
            // Get notification email from env
            $notificationEmail = env('PRICE_NOTIFICATION_EMAIL', 'admin@example.com');

            try {
                SendPriceChangeNotification::dispatch(
                    $product,
                    $oldPrice,
                    $product->price,
                    $notificationEmail
                );
            } catch (Exception $exc) {
                $errMsg = 'Failed to dispatch price change notification: ' . $exc->getMessage();
            } finally {
                return $errMsg;
            }
        }
        return $errMsg;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function deleteProduct(int $id): bool
    {
        return (bool)(Product::find($id)?->delete());
    }

}
