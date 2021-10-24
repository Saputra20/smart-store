<?php

namespace App\Http\Service;

use App\Models\Category;

class CategoryService
{
    public function all($request)
    { 
        $orderBy = isValidRequest($request, 'orderBy') ? $request->orderBy : 'id';
        $sortBy = isValidRequest($request, 'sortBy') ? $request->sortBy : 'desc';

        $query = Category::orderBy($orderBy, $sortBy);

        if (isValidRequest($request, 'keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        $total = $query->count();

        if (isValidRequest($request, "limit") && isValidRequest($request, 'offset')) {
            $query->skip($request->offset)->take($request->limit);
        }

        $result = pagination($query->get(), $total, $request);

        return $result;
    }
}
