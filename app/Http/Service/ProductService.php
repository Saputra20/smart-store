<?php

namespace App\Http\Service;

use App\Models\Product;

class ProductService
{
    public function all($request)
    {
        $orderBy = isValidRequest($request, 'orderBy') ? $request->orderBy : 'id';
        $sortBy = isValidRequest($request, 'sortBy') ? $request->sortBy : 'desc';

        $query = Product::with('category')->orderBy($orderBy, $sortBy);

        if (isValidRequest($request, 'keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        if(isValidRequest($request, 'category') && $request->category !== 'null'){
            $query->where('category_id', $request->category);
        }

        $total = $query->count();

        if (isValidRequest($request, "limit") && isValidRequest($request, 'offset')) {
            $query->skip($request->offset)->take($request->limit);
        }

        $result = pagination($query->get(), $total, $request);

        return $result;
    }
}
